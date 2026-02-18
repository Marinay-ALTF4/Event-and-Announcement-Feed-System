<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['name', 'email', 'user_id', 'role', 'password_hash'];
    protected $useTimestamps    = true;

    /**
     * Fetch a user by email or name (case-insensitive lookup for name).
     */
    public function findByIdentifier(string $identifier): ?array
    {
        return $this->where('email', $identifier)
            ->orWhere('LOWER(name)', strtolower($identifier))
            ->first();
    }
}
