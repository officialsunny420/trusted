<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
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
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
				'null' => false
            ],
            'value' => [
                'type' => 'longtext',
                'null' => false
            ],
            'created_at datetime default current_timestamp',
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
			
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tbl_settings');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_settings');
    }
}
