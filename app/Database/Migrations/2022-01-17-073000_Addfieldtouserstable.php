<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addfieldtouserstable extends Migration
{
    public function up()
    {
          $fields = array(
			'vat' => array(
			   'type' => 'VARCHAR',
			   'constraint' => 255,
			   'null' => false,
			   'after' => 'iban'
			), 
			'chamber_of_commerce' => array(
				'type' =>'VARCHAR',
				'constraint' => 255,
				'null' => false,
				'after' => 'iban'
			),
		);
		
		$this->forge->addColumn('tbl_users', $fields);
    }

    public function down()
    {
		 $this->forge->removeColumn('tbl_users','vat');
         $this->forge->removeColumn('tbl_users','chamber_of_commerce');
    }
}
