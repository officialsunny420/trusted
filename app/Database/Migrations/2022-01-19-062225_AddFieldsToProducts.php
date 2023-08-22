<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToProducts extends Migration
{
    public function up()
    {
        $fields = array(
			'warehouse_arrival_date' => array(
				'type' => 'INT',
				'null' => false,
				'after' =>'media_id',
			),
		);
		
		$this->forge->addColumn('tbl_products', $fields);
    }

    public function down()
    {
        $this->forge->removeColumn('tbl_products','warehouse_arrival_date');
    }
}
