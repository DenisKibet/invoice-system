<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NewInvoicePayment extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'invoiceid' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'paymentdate' => [
                'type'       => 'DATE',
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'method' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'details' => [
                'type'       => 'TEXT',
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
        $this->forge->createTable('new_invoice_payment');
    }

    public function down()
    {
        $this->forge->dropTable('new_invoice_payment');
    }
}
