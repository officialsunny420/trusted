<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Createnewfieldcatgory extends Migration
{
    public function up()
    {
        $fields = array(
			'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
				'after' => 'id',
                'default' => '0',
            ],
		);
		
		$this->forge->addColumn('tbl_categories', $fields);
    }

    public function down()
    {
        $this->forge->removeColumn('tbl_categories','parent_id');
    }
}
