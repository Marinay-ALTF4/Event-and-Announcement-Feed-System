<?php
/** @var string $mode */
/** @var array $user */

$isEdit = $mode === 'edit';
$formAction = $isEdit
    ? base_url('admin/users/' . $user['id'] . '/update')
    : base_url('admin/users');
$title = $isEdit ? 'Edit User' : 'Add User';
$button = $isEdit ? 'Update User' : 'Create User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('dashboard') ?>">EA Portal</a>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a class="btn btn-outline-light btn-sm" href="<?= base_url('admin/users') ?>">User List</a>
                <a class="btn btn-dark btn-sm" href="<?= base_url('logout') ?>">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h4 mb-3"><?= esc($title) ?></h1>
                        <p class="text-muted">Fill out the user details. Password is required when creating and optional when editing.</p>

                        <?php if ($message = session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger" role="alert"><?= esc($message) ?></div>
                        <?php endif; ?>

                        <form action="<?= $formAction ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= esc($user['name']) ?>" <?= $isEdit ? 'disabled' : 'required' ?>>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" maxlength="50" <?= $isEdit ? 'disabled' : 'required' ?>>
                            </div>
                            <?php if ($isEdit): ?>
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">User ID</label>
                                    <input type="text" class="form-control" id="user_id" value="<?= esc($user['user_id']) ?>" disabled>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="teacher" <?= $user['role'] === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                    <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                                </select>
                            </div>
                            <?php if (! $isEdit): ?>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required minlength="8" aria-describedby="password-help">
                                    <div id="password-help" class="form-text text-danger small d-none">Password must be at least 8 characters.</div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-secondary small" role="alert">
                                    Editing only allows changing the role. Name, email, and password stay the same.
                                </div>
                            <?php endif; ?>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary"><?= esc($button) ?></button>
                                <a class="btn btn-outline-secondary" href="<?= base_url('admin/users') ?>">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const emailSpecialLimit = 5;
            const emailDigitLimit = 5;
            const passwordHelp = document.getElementById('password-help');

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
                const tooShort = (passwordInput.value || '').length < 8;
                passwordHelp?.classList.toggle('d-none', !tooShort);
            });
        })();
    </script>
</body>
</html>
