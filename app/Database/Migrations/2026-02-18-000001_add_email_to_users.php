<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
/**
 * @property \CodeIgniter\Database\BaseConnection $db
 * @property \CodeIgniter\Database\Forge            $forge
 */
class AddEmailToUsers extends Migration
{
    public function up(): void
    {
        if ($this->db->fieldExists('email', 'users')) {
            return;
        }

        $fields = [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'unique'     => true,
                'null'       => true,
                'after'      => 'name',
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down(): void
    {
        if ($this->db->fieldExists('email', 'users')) {
            $this->forge->dropColumn('users', 'email');
        }
    }
}
