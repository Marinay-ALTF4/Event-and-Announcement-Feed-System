<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');
        $password = password_hash('password123', PASSWORD_DEFAULT);

        $data = [
            [
                'name'          => 'Admin User',
                'user_id'       => '2112020100',
                'role'          => 'admin',
                'password_hash' => $password,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'name'          => 'Teacher One',
                'user_id'       => '2112020101',
                'role'          => 'teacher',
                'password_hash' => $password,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'name'          => 'Student One',
                'user_id'       => '2112020102',
                'role'          => 'student',
                'password_hash' => $password,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
