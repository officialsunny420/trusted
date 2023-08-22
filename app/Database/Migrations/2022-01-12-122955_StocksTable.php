<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StocksTable extends Migration
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
            'product_id' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => false
            ],
            'membership_id' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => false
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => false
            ],
            'rented_items' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => false
            ],
            'number_of_rotations' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => false
            ],
            'item_rented_by_males' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => true
			],
            'item_rented_by_females' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => true
			],
            'item_rented_by_others' => [
                'type' => 'INT',
                'constraint' => '11',
                'null' => true
			],
            'commission_paid' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'gross_margin' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'rented_on' => [
                'type' => 'int',
                'constraint' => '11',
                'null' => false
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
        $this->forge->createTable('tbl_stocks');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_products');
    }
}
