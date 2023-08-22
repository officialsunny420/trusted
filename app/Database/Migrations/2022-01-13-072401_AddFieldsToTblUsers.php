<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToTblUsers extends Migration
{
    public function up()
    {
       $fields = array(
			'company_name' => array(
			   'type' => 'VARCHAR',
			   'constraint' => 255,
			   'null' => false,
			   'after' => 'media_id'
			),
			'company_address' => array(
				'type' =>'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'after' => 'company_name'
			),
			'iban' => array(
				'type' =>'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'after' => 'company_address'
			)
		);
		
		$this->forge->addColumn('tbl_users', $fields);
    }

    public function down()
    {
        $this->forge->removeColumn('tbl_users','company_name');
        $this->forge->removeColumn('tbl_users','company_address');
        $this->forge->removeColumn('tbl_users','iban');
    }
}
