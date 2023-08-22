<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Media extends Migration
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
            'original_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'mime_types' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
			'used' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
                'comment' => '1 = used, 0 = unused',
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
        $this->forge->createTable('tbl_media');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_media');
    }
}
