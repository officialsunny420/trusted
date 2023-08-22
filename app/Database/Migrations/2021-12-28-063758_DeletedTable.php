<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DeletedTable extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tbl'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
				'null' => false,
            ],
            'data' => [
                'type' => 'LONGTEXT',
                'null' => false,
            ],
			'created_at' => [
                'type' => 'INT',
				'constraint'     => 11,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_deleted_data');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_deleted_data');
    }
}
