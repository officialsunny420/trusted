<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblAdmin extends Migration
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
			'status' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
			
			'created_at datetime default current_timestamp',
			'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tbl_admin');
    }

    public function down()
    {
       $this->forge->createTable('tbl_admin');
    }
}
