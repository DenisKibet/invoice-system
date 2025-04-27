<?php

namespace App\Services;

use Config\Database;
use CodeIgniter\Database\Config;
use RuntimeException;
use App\Services\MigrationService;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TenantService
{
    public function createTenantDatabase($tenantDatabase)
    {
        $tenantDatabase = preg_replace('/[^a-zA-Z0-9_]/', '', $tenantDatabase);

        $defaultDB = Database::connect();

        $existingDBCheck = $defaultDB->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$tenantDatabase]);
        if ($existingDBCheck->getRow()) {
            return "Database '{$tenantDatabase}' already exists, please use another name.";
        }
        try {
            $query = "CREATE DATABASE {$tenantDatabase}";

            $defaultDB->query($query);
            $defaultDB->close();
            $this->initializeTenantDatabase($tenantDatabase);
            $this->runMigrations($tenantDatabase);
            return true;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function initializeTenantDatabase($tenantDatabase)
    {
        try {
            $config = config('Database');
            $config->tenant['database'] = $tenantDatabase;

            $db = Database::connect($config->tenant);

            if ($db) {
                echo $tenantDatabase.' connected successfully';
                $this->runMigrations($tenantDatabase);
                $this->runShieldMigrations($db);
                $this->verifyMigrations($db);
        }
        } catch (\Exception $e) {
            log_message('error', 'Failed to connect to tenant database: ' . $e->getMessage());
            throw new RuntimeException("Failed to initialize tenant database: " . $e->getMessage());
        } finally {
            if (isset($db)) {
                $db->close();
            }
        }
    } 
    private function runMigrations($tenantDatabase): void
    {
        $config = config('Database');
        $config->tenant['database'] = $tenantDatabase;

        try {
            $previousDefaultGroup = $config->defaultGroup;
            $config->defaultGroup = 'tenant';

            echo "Starting migrations for " . $tenantDatabase . "\n";

            $migrationPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR .'Migrations' . DIRECTORY_SEPARATOR;
            echo "Migration path: " . $migrationPath . "\n";

            if (!is_dir($migrationPath)) {
                throw new RuntimeException("Migration directory does not exist: " . $migrationPath);
            }

            if (!is_readable($migrationPath)) {
                throw new RuntimeException("Migration directory is not readable: " . $migrationPath);
            }
            $migrate = \Config\Services::migrations();

            //   Run custom migrations
              $migrate->setNamespace('App');

              $migrate->setGroup('tenant');
              $migrate->latest();

        } catch (\Exception $e) {
            echo "Error running migrations: " . $e->getMessage() . "\n";
            log_message('error', "Failed to run migrations for {$tenantDatabase}. Error: " . $e->getMessage());
            throw new RuntimeException("Failed to run migrations for tenant database. Error: " . $e->getMessage());
        }
    }


    private function runShieldMigrations($db)
{
    $migrate = \Config\Services::migrations();
    
    try {
        // Run Shield migrations
        $migrate->setNamespace('CodeIgniter\Shield');
        $migrate->latest();
        echo "Shield migrations completed successfully.\n";

        // Run Settings migrations
        $migrate->setNamespace('CodeIgniter\Settings');
        $migrate->latest();
        echo "Settings migrations completed successfully.\n";
    } catch (\Exception $e) {
        echo "Error running Shield or Settings migrations: " . $e->getMessage() . "\n";
        throw $e;
    }
}
    private function verifyMigrations($db)
    {
        $query = $db->query("SELECT * FROM migrations");
        $executedMigrations = $query->getResultArray();

        if (empty($executedMigrations)) {
            echo "No migrations have been executed.\n";
        } else {
            echo "Executed migrations:\n";
            foreach ($executedMigrations as $migration) {
                echo "- " . $migration['version'] . "\n";
            }
        }

        // You can also check for specific tables if needed
        $tables = $db->listTables();
        echo "Tables in the database:\n";
        foreach ($tables as $table) {
            echo "- " . $table . "\n";
        }
    }
}
