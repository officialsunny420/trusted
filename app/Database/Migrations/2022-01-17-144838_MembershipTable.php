<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MembershipTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true
			],
            'discount' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false
            ],
			'status' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
            ],
            'created_at datetime default current_timestamp',
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
			'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tbl_memberships');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_memberships');
    }
}
