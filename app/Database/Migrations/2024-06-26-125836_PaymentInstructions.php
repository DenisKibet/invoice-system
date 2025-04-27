<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentInstructions extends Migration
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
            'payment_instruction' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('payment_instructions');
    }

    public function down()
    {
        $this->forge->dropTable('payment_instructions');
    }
}
