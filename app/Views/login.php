<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Portal Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-4 text-center">
                            <h1 class="h4 mb-2">Sign in</h1>
                            <p class="mb-0 text-secondary">Choose your role and enter your school ID.</p>
                        </div>
                        <form method="post">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="" selected disabled>Select role</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="user_id" class="form-label">School/Employee ID</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" placeholder="e.g., 90000001" pattern="[0-9]{5,}" inputmode="numeric" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember this device</label>
                                </div>
                                <a class="link-primary" href="#">Forgot password?</a>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </form>
                        <div class="mt-4 text-center text-secondary small">School accounts only. Contact the registrar for help.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
