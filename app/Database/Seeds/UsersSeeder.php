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
                'name'          => 'Admin',
                'email'         => 'admin@example.com',
                'user_id'       => '2000',
                'role'          => 'admin',
                'password_hash' => $password,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'name'          => 'Teacher',
                'email'         => 'teacher@example.com',
                'user_id'       => '2001',
                'role'          => 'teacher',
                'password_hash' => $password,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'name'          => 'Student',
                'email'         => 'student@example.com',
                'user_id'       => '2002',
                'role'          => 'student',
                'password_hash' => $password,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
