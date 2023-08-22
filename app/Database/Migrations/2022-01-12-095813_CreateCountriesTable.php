<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCountriesTable extends Migration
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
                'constraint' => '191',
                'null' => false
            ],
			'sortname' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => false
            ],
			'phonecode' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => false
            ],
			'currency' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => false
            ],
			'currency_code' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => false
            ],
			'currency_symbol' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => false
            ],
			'banner_image' => [
                'type' => 'VARCHAR',
                'constraint' => '191',
                'null' => false
            ],
			'status' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => false
            ],
            'created_at datetime default current_timestamp',
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tbl_countries');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_countries');
    }
}
