<?php
// Role-based dashboard (Admin/Teacher/Student) using current session role.
$role = $role ?? session('role') ?? 'guest';
$isAdmin = $role === 'admin';
$isTeacher = $role === 'teacher';
$isStudent = $role === 'student';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand text-white fw-bold" href="#">EA Portal</a>
			<div class="ms-auto d-flex align-items-center gap-2">
				<span class="badge text-bg-light text-uppercase">Role: <?= esc($role) ?></span>
				<a class="btn btn-sm btn-primary" href="<?= base_url('logout') ?>">Logout</a>
			</div>
		</div>
	</nav>

	<div class="container py-4">
		<div class="mb-4">
			<h1 class="h4 mb-1">Dashboard</h1>
			<p class="mb-0 text-muted">Unified view for Admin, Teacher, and Student roles.</p>
		</div>

		<div class="row g-3 mb-4">
			<div class="col-md-4">
				<div class="card h-100">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-2">
							<h6 class="mb-0">Events</h6>
							<span class="badge text-bg-warning text-dark">Live</span>
						</div>
						<p class="mb-1 fw-semibold">Upcoming campus events</p>
						<p class="mb-0 text-muted small">Create, edit, schedule events.</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card h-100">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-2">
							<h6 class="mb-0">Announcements</h6>
							<span class="badge text-bg-info">New</span>
						</div>
						<p class="mb-1 fw-semibold">All-school updates</p>
						<p class="mb-0 text-muted small">Publish and track visibility.</p>
					</div>
				</div>
			</div>
			<?php if ($isAdmin): ?>
			<div class="col-md-4">
				<div class="card h-100">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-2">
							<h6 class="mb-0">Users</h6>
							<span class="badge text-bg-secondary">Admin</span>
						</div>
						<p class="mb-1 fw-semibold">Teachers &amp; Students</p>
						<p class="mb-0 text-muted small">Add, edit, or remove accounts.</p>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>

		<?php if ($isAdmin): ?>
		<div class="card mb-4">
			<div class="card-header">Admin Controls</div>
			<div class="card-body">
				<div class="row g-3">
					<div class="col-md-6">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Manage Users</h6>
							<p class="text-muted small mb-3">Add, edit, or remove teacher and student accounts.</p>
							<div class="d-flex gap-2">
								<button class="btn btn-primary btn-sm">Add User</button>
								<button class="btn btn-outline-secondary btn-sm">User List</button>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Manage Events &amp; Announcements</h6>
							<p class="text-muted small mb-3">Create, edit, delete, and schedule items.</p>
							<div class="d-flex gap-2">
								<button class="btn btn-primary btn-sm">New Event</button>
								<button class="btn btn-outline-secondary btn-sm">New Announcement</button>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Send Notifications</h6>
							<p class="text-muted small mb-3">Push updates to teachers or students.</p>
							<div class="d-flex gap-2">
								<button class="btn btn-primary btn-sm">Notify Teachers</button>
								<button class="btn btn-outline-secondary btn-sm">Notify Students</button>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Reports &amp; Analytics</h6>
							<p class="text-muted small mb-3">Track popularity and views of events and announcements.</p>
							<button class="btn btn-primary btn-sm">View Reports</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if ($isTeacher): ?>
		<div class="card mb-4">
			<div class="card-header">Teacher Workspace</div>
			<div class="card-body">
				<div class="row g-3">
					<div class="col-md-4">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Post Event</h6>
							<p class="text-muted small mb-3">Add title, description, date/time for class or school events.</p>
							<button class="btn btn-primary btn-sm">New Event</button>
							<button class="btn btn-outline-secondary btn-sm mt-2">My Events</button>
						</div>
					</div>
					<div class="col-md-4">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Post Announcement</h6>
							<p class="text-muted small mb-3">Share updates; edit or delete your own posts.</p>
							<button class="btn btn-primary btn-sm">New Announcement</button>
							<button class="btn btn-outline-secondary btn-sm mt-2">My Posts</button>
						</div>
					</div>
					<div class="col-md-4">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Notify Students</h6>
							<p class="text-muted small mb-3">Send targeted reminders to classes or groups.</p>
							<button class="btn btn-primary btn-sm">Send Notification</button>
						</div>
					</div>
					<div class="col-md-6">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Engagement</h6>
							<p class="text-muted small mb-3">View who read or responded to your posts.</p>
							<ul class="list-group list-group-flush">
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Announcement views
									<span class="badge text-bg-primary">—</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Event RSVPs
									<span class="badge text-bg-primary">—</span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
									Comments/replies
									<span class="badge text-bg-primary">—</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Student Interactions</h6>
							<p class="text-muted small mb-3">Review responses or comments (if enabled).</p>
							<button class="btn btn-outline-secondary btn-sm">View Responses</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if ($isStudent): ?>
		<div class="card mb-4">
			<div class="card-header">Student View</div>
			<div class="card-body">
				<div class="row g-3">
					<div class="col-md-6">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Events</h6>
							<p class="text-muted small mb-2">See title, description, date/time, and any attachments.</p>
							<div class="d-flex flex-wrap gap-2">
								<button class="btn btn-primary btn-sm">View Events</button>
								<button class="btn btn-outline-secondary btn-sm">View Details</button>
								<button class="btn btn-outline-success btn-sm">Mark Attending</button>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Announcements</h6>
							<p class="text-muted small mb-2">Read updates; view description and attachments.</p>
							<div class="d-flex flex-wrap gap-2">
								<button class="btn btn-primary btn-sm">View Announcements</button>
								<button class="btn btn-outline-secondary btn-sm">View Details</button>
								<button class="btn btn-outline-primary btn-sm">Comment / React</button>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Notifications</h6>
							<p class="text-muted small mb-2">Receive alerts for new events and announcements.</p>
							<button class="btn btn-outline-info btn-sm">Notification Settings</button>
						</div>
					</div>
					<div class="col-md-6">
						<div class="border rounded p-3 h-100 bg-white">
							<h6 class="fw-semibold">Responses</h6>
							<p class="text-muted small mb-2">Review your RSVPs or comments.</p>
							<button class="btn btn-outline-secondary btn-sm">My Responses</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if (!$isAdmin && !$isTeacher && !$isStudent): ?>
		<div class="alert alert-warning d-flex align-items-center" role="alert">
			<span class="me-2">⚠️</span>
			<div>Role not recognized. Please contact an administrator.</div>
		</div>
		<?php endif; ?>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
