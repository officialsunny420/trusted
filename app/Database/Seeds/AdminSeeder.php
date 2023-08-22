<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('tbl_admin')->insert($this->generateUsers());
    }
	
	private function generateUsers(): array
    {
        return [
            'name' => 'Nexus Techies',
            'email' => 'provider.nexus@gmail.com',
            'password' => md5(123456),
        ];
    }
}
