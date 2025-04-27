<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SystemRentPaymentMigration extends Migration
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
            'company_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2', // Total 10 digits, 2 after the decimal
                'null' => false,
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 3, // e.g., GBP, USD
                'null' => false,
            ],
            'payment_method' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'transaction_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['completed', 'failed', 'pending'],
                'default' => 'completed',
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('system_rent_subscriptions_payment');
    }

    public function down()
    {
        $this->forge->dropTable('system_rent_subscriptions_payment');
    }
}
