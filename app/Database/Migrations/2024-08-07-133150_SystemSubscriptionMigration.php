<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SystemSubscriptionMigration extends Migration
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
            'payment_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'company_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'plan_name' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                // 'unsigned' => true,
            ],
           'subscription_duration' => [
                'type' => 'ENUM',
                'constraint' => ['monthly', 'yearly'],
                'default' => 'yearly',
            ],
            'start_date' => [
                'type' => 'DATE',
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'subscription_status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'cancelled', 'expired', 'pending', 'suspended', 'archived'],
                'default' => 'active',
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
        $this->forge->createTable('system_subscriptions');
    }

    public function down()
    {
        $this->forge->dropTable('system_subscriptions');
    }
}