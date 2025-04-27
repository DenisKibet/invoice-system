<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AgentMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'agent_username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'agent_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                // 'unique'     => true,
            ],
            'agent_mobile' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'emergency_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            // 'password' => [
            //     'type'       => 'VARCHAR',
            //     'constraint' => '255',
            // ],
            'address' => [
                'type'       => 'TEXT',
                'null'       => true,
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
        $this->forge->createTable('agents');
    }

    public function down()
    {
        $this->forge->dropTable('agents');
    }
}
