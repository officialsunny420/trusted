<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            'country_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
             'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'password' => [
                'type' => 'VARCHAR',
				'constraint' => '100',
                'null' => true
			],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'description' => [
                'type' => 'LONGTEXT',
                'null' => true
			],
			'status' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
            ],
			'media_id' => [
                'type' =>'INT',
				'constraint' => 11,
				'null' => false,
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
        $this->forge->createTable('tbl_users');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_users');
    }
}
