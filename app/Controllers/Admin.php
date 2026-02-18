<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Admin extends BaseController
{
    public function dashboard(): string
    {
        $role = session('role') ?? 'guest';

        return view('Dashboard', [
            'role' => $role,
        ]);
    }

    public function users()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $users     = new UserModel();
        $teachers  = $users->where('role', 'teacher')->orderBy('name', 'ASC')->findAll();
        $students  = $users->where('role', 'student')->orderBy('name', 'ASC')->findAll();
        $admins    = $users->where('role', 'admin')->orderBy('name', 'ASC')->findAll();

        return view('Admin/users', [
            'teachers' => $teachers,
            'students' => $students,
            'admins'   => $admins,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $roleParam = $this->request->getGet('role');
        $roleDefault = in_array($roleParam, ['admin', 'teacher', 'student'], true) ? $roleParam : 'teacher';

        return view('Admin/user_form', [
            'mode' => 'create',
            'user' => [
                'name'    => old('name'),
                'email'   => old('email'),
                'user_id' => '',
                'role'    => old('role') ?? $roleDefault,
            ],
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'name'     => 'required|min_length[2]|regex_match[/^[A-Za-z ]+$/]',
            'email'    => 'required|valid_email|max_length[50]|is_unique[users.email]',
            'role'     => 'required|in_list[admin,teacher,student]',
            'password' => 'required|min_length[8]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('admin/users'))
                ->withInput()
                ->with('error', implode(' ', $this->validator->getErrors()));
        }

        if ($this->exceedsSpecialCharLimit((string) $this->request->getPost('email'), 5)) {
            return redirect()->to(base_url('admin/users'))
                ->withInput()
                ->with('error', 'Email has too many special characters (max 5).');
        }

        if ($this->exceedsDigitLimit((string) $this->request->getPost('email'), 5)) {
            return redirect()->to(base_url('admin/users'))
                ->withInput()
                ->with('error', 'Email has too many numbers (max 5).');
        }

        $role = $this->request->getPost('role');
        $nextUserId = $this->generateNextUserId($role);

        $users = new UserModel();

        try {
            $users->insert([
                'name'          => $this->request->getPost('name'),
                'email'         => $this->request->getPost('email'),
                'user_id'       => $nextUserId,
                'role'          => $this->request->getPost('role'),
                'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            ]);
        } catch (DatabaseException $e) {
            log_message('error', 'User creation failed: {message}', ['message' => $e->getMessage()]);
            $message = str_contains($e->getMessage(), 'Duplicate entry')
                ? 'A user with this generated ID or email already exists. Please try again.'
                : 'Could not create user. Please try again.';

            return redirect()->to(base_url('admin/users'))
                ->withInput()
                ->with('error', $message);
        }

        return redirect()->to(base_url('admin/users'))->with('success', 'User created.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $users = new UserModel();
        $user  = $users->find($id);

        if (! $user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        return view('Admin/user_form', [
            'mode' => 'edit',
            'user' => [
                'id'      => $user['id'],
                'name'    => old('name') ?: $user['name'],
                'email'   => old('email') ?: $user['email'],
                'user_id' => old('user_id') ?: $user['user_id'],
                'role'    => old('role') ?: $user['role'],
            ],
        ]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $users = new UserModel();
        $user  = $users->find($id);

        if (! $user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        $name     = trim((string) $this->request->getPost('name'));
        $email    = trim((string) $this->request->getPost('email'));
        $role     = trim((string) $this->request->getPost('role'));
        $password = (string) $this->request->getPost('password');

        $rules = [];
        if ($name !== '') {
            $rules['name'] = 'min_length[2]|regex_match[/^[A-Za-z ]+$/]';
        }

        if ($email !== '') {
            $rules['email'] = 'valid_email|max_length[50]|is_unique[users.email,id,' . $id . ']';
        }

        if ($role !== '') {
            $rules['role'] = 'in_list[admin,teacher,student]';
        }

        if ($password !== '') {
            $rules['password'] = 'min_length[8]';
        }

        if ($rules !== [] && ! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        if ($email !== '') {
            if ($this->exceedsSpecialCharLimit($email, 5)) {
                return redirect()->back()->withInput()->with('error', 'Email has too many special characters (max 5).');
            }

            if ($this->exceedsDigitLimit($email, 5)) {
                return redirect()->back()->withInput()->with('error', 'Email has too many numbers (max 5).');
            }
        }

        $updateData = [];
        if ($name !== '') {
            $updateData['name'] = $name;
        }
        if ($email !== '') {
            $updateData['email'] = $email;
        }
        if ($role !== '') {
            $updateData['role'] = $role;
        }
        if ($password !== '') {
            $updateData['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($updateData === []) {
            return redirect()->back()->with('error', 'No changes provided.');
        }

        $users->update($id, $updateData);

        return redirect()->to(base_url('admin/users'))->with('success', 'User updated.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $users = new UserModel();
        $user  = $users->find($id);

        if (! $user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        $users->delete($id, true);

        return redirect()->to(base_url('admin/users'))->with('success', 'User removed.');
    }

    private function generateNextUserId(string $role): string
    {
        $users = new UserModel();

        $roleMax = $users
            ->select('MAX(CAST(user_id AS UNSIGNED)) AS max_user_id')
            ->where('role', $role)
            ->where("user_id REGEXP '^[0-9]+$'")
            ->first();

        $base = [
            'admin'   => 2000,
            'teacher' => 2001,
            'student' => 2002,
        ];

        $start = max(
            isset($roleMax['max_user_id']) ? (int) $roleMax['max_user_id'] : 0,
            $base[$role] ?? 1999
        );

        $candidate = $start + 1;

        // Ensure global uniqueness even across roles by skipping any existing user_id
        while ($users->where('user_id', (string) $candidate)->countAllResults() > 0) {
            $candidate++;
        }

        return (string) $candidate;
    }

    private function requireAdmin()
    {
        if (session('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Admin access only.');
        }

        return null;
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
}
