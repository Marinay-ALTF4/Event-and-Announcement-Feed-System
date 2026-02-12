<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function dashboard(): string
    {
        // Replace the default role with your auth/session role value.
        $role = session('role') ?? 'admin';

        return view('Dashboard', [
            'role' => $role,
        ]);
    }
}
