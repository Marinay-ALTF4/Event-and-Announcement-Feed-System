<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login');
    }

    public function login()
    {
        $identifier = trim((string) $this->request->getPost('identifier'));
        $password   = (string) $this->request->getPost('password');

        if (! $identifier || ! $password) {
            return redirect()->back()->withInput()->with('error', 'Please provide email/name and password.');
        }

        // Validate identifier: if email, enforce length and special char limits; if name, forbid special characters.
        $isEmail = str_contains($identifier, '@');
        if ($isEmail) {
            if (strlen($identifier) > 50) {
                return redirect()->back()->withInput()->with('error', 'Email must be 50 characters or fewer.');
            }
            if ($this->exceedsSpecialCharLimit($identifier, 5)) {
                return redirect()->back()->withInput()->with('error', 'Email has too many special characters (max 5).');
            }
            if ($this->exceedsDigitLimit($identifier, 5)) {
                return redirect()->back()->withInput()->with('error', 'Email has too many numbers (max 5).');
            }
        } else {
            if (! preg_match('/^[A-Za-z ]+$/', $identifier)) {
                return redirect()->back()->withInput()->with('error', 'Name cannot contain numbers or special characters.');
            }
        }

        $users = new UserModel();
        $user  = $users->findByIdentifier($identifier);

        if (! $user || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid credentials.');
        }

        session()->set([
            'email' => $user['email'],
            'role'  => $user['role'],
            'name'  => $user['name'] ?? $user['email'],
        ]);

        // Redirect to the unified dashboard; the view adjusts based on the stored role.
        return redirect()->to(base_url('dashboard'));
    }

    private function exceedsSpecialCharLimit(string $value, int $limit): bool
    {
        $count = preg_match_all('/[^A-Za-z0-9]/', $value);
        return $count > $limit;
    }

    private function exceedsDigitLimit(string $value, int $limit): bool
    {
        $count = preg_match_all('/[0-9]/', $value);
        return $count > $limit;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
