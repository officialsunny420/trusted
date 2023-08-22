<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToTblProducts extends Migration
{
    public function up()
    {
        $fields = array(
			'brand_name' => array(
				'type' =>'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'after' => 'title'
			)
		);
		$this->forge->addColumn('tbl_products',$fields);
    }

    public function down()
    {
        $this->forge->removeColumn('tbl_products','brand_name');
    }
}
