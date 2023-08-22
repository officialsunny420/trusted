<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRetailValueFieldToTblProducts extends Migration
{
    public function up()
    {
        $fields = array(
			'retail_value' => array(
				'type' => 'FLOAT',
				'null' => false,
				'after' =>'brand_name',
			),
		);
		$this->forge->addColumn('tbl_products',$fields);
    }

    public function down()
    {
        $this->forge->removeColumn('tbl_products','retail_value');
    }
}
