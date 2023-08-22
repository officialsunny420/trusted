<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToTblCategories extends Migration
{
    public function up()
    {
		$fields = array(
			'slug' => array(
			   'type' => 'VARCHAR',
			   'constraint' => 255,
			   'null' => false,
			   'after' => 'status'
			),
			'media_id' => array(
				'type' =>'INT',
				'constraint' => 11,
				'null' => false,
				'after' => 'slug'
			)
		);
		
		$this->forge->addColumn('tbl_categories', $fields);
    }

    public function down()
    {
        $this->forge->removeColumn('tbl_categories','slug');
        $this->forge->removeColumn('tbl_categories','media_id');
    }
}
