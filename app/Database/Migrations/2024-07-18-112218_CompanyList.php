<?php 

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CompanyList extends Migration
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
            'tenant_company_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'tenant_database_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
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
        // $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('companylists');
    }

    public function down()
    {
        $this->forge->dropTable('companylists');
    }
}
