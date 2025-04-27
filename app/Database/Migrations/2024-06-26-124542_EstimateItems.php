<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EstimateItems extends Migration
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
            'itemname' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'totalprice' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'costprice' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'invoice_id' => [
                'type' => 'INT',
                'constraint' => 11,
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
        $this->forge->addKey('invoice_id');
        $this->forge->createTable('estimate_items');
    }

    public function down()
    {
        $this->forge->dropTable('estimate_items');
    }
}
