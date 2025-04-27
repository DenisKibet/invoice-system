<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ClientDetails extends Migration
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
            'ClientName' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'MobileNumber' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'EmailAddress' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'ad_email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'l_no' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'e_no' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'ad_address' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
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
        $this->forge->createTable('clients');
    }

    public function down()
    {
        $this->forge->dropTable('clients');
    }
}
