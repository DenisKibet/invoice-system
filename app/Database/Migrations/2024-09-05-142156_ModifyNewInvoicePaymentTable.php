<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyNewInvoicePaymentTable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('new_invoice_payment', [
            'username' => [
                'name' => 'user_id',
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('new_invoice_payment', [
            'user_id' => [
                'name' => 'username',
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ]
        ]);
    }
}
