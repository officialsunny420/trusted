<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductsTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => false
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
            'sku' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'category_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'size' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'media_id' => [
                'type' =>'INT',
				'constraint' => 11,
				'null' => false,
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
        $this->forge->createTable('tbl_products');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_products');
    }
}
