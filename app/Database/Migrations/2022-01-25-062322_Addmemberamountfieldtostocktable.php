<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addmemberamountfieldtostocktable extends Migration
{
 
	public function up()
    {
        $fields = array(
			'membership_amount' => array(
				'type' => 'FLOAT',
				'null' => true,
			),
		);
		$this->forge->addColumn('tbl_stocks',$fields);
    }

    public function down()
    {
        $this->forge->removeColumn('tbl_stocks','membership_amount');
    }
}
