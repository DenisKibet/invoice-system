<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CompanyDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'company_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'registration_no' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'mobile_no' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'additional_no' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'street' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'post_code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'logo_path' => [  // Added logo_path field
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => null, // MySQL will handle this
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => null, // MySQL will handle this
                'on update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('companies');
    }

    public function down()
    {
        $this->forge->dropTable('companies');
    }
}
