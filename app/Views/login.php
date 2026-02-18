<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Portal Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f6f7fb 0%, #eef1f7 100%);
        }

        .card-soft {
            border-radius: 18px;
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.08);
        }

        .rounded-control {
            border-radius: 12px;
        }

        .rounded-button {
            border-radius: 14px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5 min-vh-100 d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-md-7 col-lg-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center gap-2">
                        <span class="badge text-bg-primary fs-6">EA</span>
                        <span class="fw-bold text-primary">Event &amp; Announcement Feed</span>
                    </div>
                </div>
                <div class="card card-soft border-0">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-4 text-center">
                            <h1 class="h4 mb-2">Sign in</h1>
                            <p class="mb-0 text-secondary">Enter your email or name with your password to continue.</p>
                        </div>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger rounded-3" role="alert">
                                <?= esc(session()->getFlashdata('error')) ?>
                            </div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="mb-3">
                                <label for="identifier" class="form-label">Email or Name</label>
                                <input type="text" class="form-control rounded-control" id="identifier" name="identifier" placeholder="e.g., admin@example.com" value="<?= esc(old('identifier')) ?>" autocomplete="username" maxlength="50" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control rounded-control" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember this device</label>
                                </div>
                                <a class="link-primary" href="#">Forgot password?</a>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary rounded-button">Sign In</button>
                            </div>
                        </form>
                        <div class="mt-4 text-center text-secondary small">School accounts only. Contact the registrar for help.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const identifierInput = document.getElementById('identifier');
            const specialLimit = 5;
            const digitLimit = 5;

            const help = document.createElement('div');
            help.className = 'form-text text-danger small d-none';
            help.id = 'identifier-special-help';
            identifierInput?.parentNode?.appendChild(help);

            function countSpecial(str) {
                return (str.match(/[^A-Za-z0-9]/g) || []).length;
            }

            identifierInput?.addEventListener('input', () => {
                const value = identifierInput.value;
                if (value.includes('@')) {
                    const specialCount = countSpecial(value);
                    const digitCount = (value.match(/[0-9]/g) || []).length;
                    if (specialCount > specialLimit) {
                        help.textContent = `Too many special characters (max ${specialLimit}).`;
                        help.classList.remove('d-none');
                    } else if (digitCount > digitLimit) {
                        help.textContent = `Too many numbers (max ${digitLimit}).`;
                        help.classList.remove('d-none');
                    } else {
                        help.classList.add('d-none');
                    }
                } else {
                    const valid = /^[A-Za-z ]+$/.test(value || '');
                    if (!valid && value !== '') {
                        help.textContent = 'Name cannot contain numbers or special characters.';
                        help.classList.remove('d-none');
                    } else {
                        help.classList.add('d-none');
                    }
                }
            });
        })();
    </script>
</body>
</html>
