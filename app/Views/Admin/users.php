<?php
/** @var array $teachers */
/** @var array $students */
/** @var array $admins */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container d-flex align-items-center">
            <div class="d-flex align-items-center gap-2">
                <span class="navbar-brand mb-0 h1 text-white">EA Portal</span>
                <a class="btn btn-outline-light btn-sm" href="<?= base_url('dashboard') ?>">Dashboard</a>
            </div>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a class="btn btn-dark btn-sm" href="<?= base_url('logout') ?>">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
            <div>
                <h1 class="h4 mb-1">Manage Users</h1>
                <p class="text-muted mb-0">Add, edit, or remove users. Lists are grouped by role.</p>
            </div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="addUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Add User
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 320px;">
                    <form action="<?= base_url('admin/users') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-2">
                            <label class="form-label mb-1" for="add-name">Name</label>
                            <input type="text" class="form-control form-control-sm" id="add-name" name="name" value="<?= esc(old('name')) ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label mb-1" for="add-email">Email</label>
                            <input type="email" class="form-control form-control-sm" id="add-email" name="email" value="<?= esc(old('email')) ?>" maxlength="50" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label mb-1" for="add-role">Role</label>
                            <select class="form-select form-select-sm" id="add-role" name="role" required>
                                <option value="teacher" <?= old('role') === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                <option value="student" <?= old('role') === 'student' ? 'selected' : '' ?>>Student</option>
                                <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-1" for="add-password">Password</label>
                            <input type="password" class="form-control form-control-sm" id="add-password" name="password" required minlength="8" aria-describedby="add-password-help">
                            <div id="add-password-help" class="form-text text-danger small d-none">Password must be at least 8 characters.</div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="dropdown" aria-expanded="false">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if ($message = session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert"><?= esc($message) ?></div>
        <?php endif; ?>
        <?php if ($message = session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert"><?= esc($message) ?></div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Admins</h5>
                            <span class="badge text-bg-secondary"><?= count($admins) ?></span>
                        </div>
                        <?php if (empty($admins)): ?>
                            <p class="text-muted mb-0">No admins found.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>User ID</th>
                                            <th>Role</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($admins as $user): ?>
                                            <tr>
                                                <td><?= esc($user['name']) ?></td>
                                                <td><?= esc($user['email']) ?></td>
                                                <td><?= esc($user['user_id']) ?></td>
                                                <td><span class="badge text-bg-secondary">Admin</span></td>
                                                <td class="text-end">
                                                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-<?= $user['id'] ?>" aria-expanded="false" aria-controls="edit-<?= $user['id'] ?>">Edit</button>
                                                    <?php if (session('email') !== $user['email']): ?>
                                                        <form action="<?= base_url('admin/users/' . $user['id'] . '/delete') ?>" method="post" class="d-inline">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this admin?')">Delete</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr class="collapse" id="edit-<?= $user['id'] ?>">
                                                <td colspan="5">
                                                    <form action="<?= base_url('admin/users/' . $user['id'] . '/update') ?>" method="post" class="border rounded p-3 bg-light">
                                                        <?= csrf_field() ?>
                                                        <div class="row g-2">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-1 small" for="name-<?= $user['id'] ?>">Name</label>
                                                                <input type="text" class="form-control form-control-sm" id="name-<?= $user['id'] ?>" name="name" value="<?= esc($user['name']) ?>">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-1 small" for="email-<?= $user['id'] ?>">Email</label>
                                                                <input type="email" class="form-control form-control-sm" id="email-<?= $user['id'] ?>" name="email" value="<?= esc($user['email']) ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label mb-1 small" for="role-<?= $user['id'] ?>">Role</label>
                                                                <select class="form-select form-select-sm" id="role-<?= $user['id'] ?>" name="role">
                                                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                                    <option value="teacher" <?= $user['role'] === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                                                    <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label mb-1 small" for="password-<?= $user['id'] ?>">Password</label>
                                                                <input type="password" class="form-control form-control-sm" id="password-<?= $user['id'] ?>" name="password" placeholder="Leave blank to keep">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label mb-1 small">User ID</label>
                                                                <input type="text" class="form-control form-control-sm" value="<?= esc($user['user_id']) ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex gap-2 justify-content-end mt-3">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#edit-<?= $user['id'] ?>" aria-expanded="false" aria-controls="edit-<?= $user['id'] ?>">Cancel</button>
                                                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Teachers</h5>
                            <span class="badge text-bg-info text-dark"><?= count($teachers) ?></span>
                        </div>
                        <?php if (empty($teachers)): ?>
                            <p class="text-muted mb-0">No teachers found.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>User ID</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($teachers as $user): ?>
                                            <tr>
                                                <td><?= esc($user['name']) ?></td>
                                                <td><?= esc($user['email']) ?></td>
                                                <td><?= esc($user['user_id']) ?></td>
                                                <td class="text-end">
                                                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-<?= $user['id'] ?>" aria-expanded="false" aria-controls="edit-<?= $user['id'] ?>">Edit</button>
                                                    <form action="<?= base_url('admin/users/' . $user['id'] . '/delete') ?>" method="post" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this teacher?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <tr class="collapse" id="edit-<?= $user['id'] ?>">
                                                <td colspan="4">
                                                    <form action="<?= base_url('admin/users/' . $user['id'] . '/update') ?>" method="post" class="border rounded p-3 bg-light">
                                                        <?= csrf_field() ?>
                                                        <div class="row g-2">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-1 small" for="name-<?= $user['id'] ?>">Name</label>
                                                                <input type="text" class="form-control form-control-sm" id="name-<?= $user['id'] ?>" name="name" value="<?= esc($user['name']) ?>">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-1 small" for="email-<?= $user['id'] ?>">Email</label>
                                                                <input type="email" class="form-control form-control-sm" id="email-<?= $user['id'] ?>" name="email" value="<?= esc($user['email']) ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label mb-1 small" for="role-<?= $user['id'] ?>">Role</label>
                                                                <select class="form-select form-select-sm" id="role-<?= $user['id'] ?>" name="role">
                                                                    <option value="teacher" <?= $user['role'] === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                                    <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label mb-1 small" for="password-<?= $user['id'] ?>">Password</label>
                                                                <input type="password" class="form-control form-control-sm" id="password-<?= $user['id'] ?>" name="password" placeholder="Leave blank to keep">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label mb-1 small">User ID</label>
                                                                <input type="text" class="form-control form-control-sm" value="<?= esc($user['user_id']) ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex gap-2 justify-content-end mt-3">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#edit-<?= $user['id'] ?>" aria-expanded="false" aria-controls="edit-<?= $user['id'] ?>">Cancel</button>
                                                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Students</h5>
                            <span class="badge text-bg-success"><?= count($students) ?></span>
                        </div>
                        <?php if (empty($students)): ?>
                            <p class="text-muted mb-0">No students found.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>User ID</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $user): ?>
                                            <tr>
                                                <td><?= esc($user['name']) ?></td>
                                                <td><?= esc($user['email']) ?></td>
                                                <td><?= esc($user['user_id']) ?></td>
                                                <td class="text-end">
                                                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#edit-<?= $user['id'] ?>" aria-expanded="false" aria-controls="edit-<?= $user['id'] ?>">Edit</button>
                                                    <form action="<?= base_url('admin/users/' . $user['id'] . '/delete') ?>" method="post" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this student?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <tr class="collapse" id="edit-<?= $user['id'] ?>">
                                                <td colspan="4">
                                                    <form action="<?= base_url('admin/users/' . $user['id'] . '/update') ?>" method="post" class="border rounded p-3 bg-light">
                                                        <?= csrf_field() ?>
                                                        <div class="row g-2">
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-1 small" for="name-<?= $user['id'] ?>">Name</label>
                                                                <input type="text" class="form-control form-control-sm" id="name-<?= $user['id'] ?>" name="name" value="<?= esc($user['name']) ?>">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label mb-1 small" for="email-<?= $user['id'] ?>">Email</label>
                                                                <input type="email" class="form-control form-control-sm" id="email-<?= $user['id'] ?>" name="email" value="<?= esc($user['email']) ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label mb-1 small" for="role-<?= $user['id'] ?>">Role</label>
                                                                <select class="form-select form-select-sm" id="role-<?= $user['id'] ?>" name="role">
                                                                    <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                                                                    <option value="teacher" <?= $user['role'] === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label mb-1 small" for="password-<?= $user['id'] ?>">Password</label>
                                                                <input type="password" class="form-control form-control-sm" id="password-<?= $user['id'] ?>" name="password" placeholder="Leave blank to keep">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="form-label mb-1 small">User ID</label>
                                                                <input type="text" class="form-control form-control-sm" value="<?= esc($user['user_id']) ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex gap-2 justify-content-end mt-3">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#edit-<?= $user['id'] ?>" aria-expanded="false" aria-controls="edit-<?= $user['id'] ?>">Cancel</button>
                                                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const nameInput = document.getElementById('add-name');
            const emailInput = document.getElementById('add-email');
            const passwordInput = document.getElementById('add-password');
            const emailSpecialLimit = 5;
            const emailDigitLimit = 5;
            const passwordHelp = document.getElementById('add-password-help');

            const nameHelp = document.createElement('div');
            nameHelp.className = 'form-text text-danger small d-none';
            nameHelp.id = 'name-help';
            nameInput?.parentNode?.appendChild(nameHelp);

            const emailHelp = document.createElement('div');
            emailHelp.className = 'form-text text-danger small d-none';
            emailHelp.id = 'email-special-help';
            emailInput?.parentNode?.appendChild(emailHelp);

            function countSpecial(str) {
                return (str.match(/[^A-Za-z0-9]/g) || []).length;
            }

            function countDigits(str) {
                return (str.match(/[0-9]/g) || []).length;
            }

            nameInput?.addEventListener('input', () => {
                const valid = /^[A-Za-z ]+$/.test(nameInput.value || '');
                if (!valid && nameInput.value !== '') {
                    nameHelp.textContent = 'Letters and spaces only.';
                    nameHelp.classList.remove('d-none');
                } else {
                    nameHelp.classList.add('d-none');
                }
            });

            emailInput?.addEventListener('input', () => {
                const specialCount = countSpecial(emailInput.value);
                const digitCount = countDigits(emailInput.value);
                if (specialCount > emailSpecialLimit) {
                    emailHelp.textContent = `Too many special characters (max ${emailSpecialLimit}).`;
                    emailHelp.classList.remove('d-none');
                } else if (digitCount > emailDigitLimit) {
                    emailHelp.textContent = `Too many numbers (max ${emailDigitLimit}).`;
                    emailHelp.classList.remove('d-none');
                } else {
                    emailHelp.classList.add('d-none');
                }
            });

            passwordInput?.addEventListener('input', () => {
                if ((passwordInput.value || '').length < 8) {
                    passwordHelp.classList.remove('d-none');
                } else {
                    passwordHelp.classList.add('d-none');
                }
            });
        })();
    </script>
</body>
</html>
