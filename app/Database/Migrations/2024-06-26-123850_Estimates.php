<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Estimates extends Migration
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
            'estimate_no' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'client_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'comment' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'payment_instruction' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'invoice_date' => [
                'type' => 'VARCHAR',
                'constraint' => 12,
                'null' => true,
            ],
            'terms' => [
                'type' => 'VARCHAR',
                'constraint' => 8,
                'null' => true,
            ],
            'due_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'subtotal' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'discount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'paid' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'payment_method' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
            ],
            'balance' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'netprice' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'profit_loss' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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
        $this->forge->createTable('estimates');
    }

    public function down()
    {
        $this->forge->dropTable('estimates');
    }
}
