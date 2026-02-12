<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login');
    }

    public function login()
    {
        $userId = $this->request->getPost('user_id');
        $role   = $this->request->getPost('role');

        // TODO: Replace with real authentication against users table.
        if (! $userId || ! $role) {
            return redirect()->back()->with('error', 'Please provide ID and role.');
        }

        session()->set([
            'user_id' => $userId,
            'role'    => $role,
        ]);

        // Use base_url so it respects subfolder (/EAFS/) and index.php if enabled.
        return redirect()->to(base_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
