<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToTblStocks extends Migration
{
    public function up()
    {
        $fields= array(
			'retail_value' => array(
				'type' => 'FLOAT',
				'null' => false,
				'after' =>'category_id',
			),
			'rental_income_for_partner' => array(
				'type' => 'FLOAT',
				'null' => false,
				'after' =>'retail_value',
			),
			'rental_income_for_admin' => array(
				'type' => 'FLOAT',
				'null' => false,
				'after' =>'rental_income_for_partner',
			),
			'expiry_date' => array(
				'type' => 'INT',
                'null' => false,
				'after' =>'rental_income_for_partner',
			),
			'currently_rented' => array(
				'type' => 'INT',
                'null' => false,
				'after' =>'expiry_date',
			),
		);
		$this->forge->addColumn('tbl_stocks',$fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_stocks','retail_value');
        $this->forge->dropColumn('tbl_stocks','rental_income_for_partner');
        $this->forge->dropColumn('tbl_stocks','rental_income_for_admin');
        $this->forge->dropColumn('tbl_stocks','expiry_date');
        $this->forge->dropColumn('tbl_stocks','currently_rented');
    }
}
