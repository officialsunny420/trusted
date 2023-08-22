<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblDocuments extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
			'type' => [
               'type' => 'INT',
                'constraint' => '11',
                'null' => false
            ],
			 'media_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
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
        $this->forge->createTable('tbl_documents');
    }

    public function down()
    {
        $this->forge->createTable('tbl_documents');
    }
}
