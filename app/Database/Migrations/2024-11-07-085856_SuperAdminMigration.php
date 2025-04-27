<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SuperAdminMigration extends Migration
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
            'super_admin_username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'user_id' => [
                'type'      => 'INT',
                'null'       => false,
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
        $this->forge->createTable('super_admin');
    }

    public function down()
    {
        $this->forge->dropTable('super_admin');
    }
}
