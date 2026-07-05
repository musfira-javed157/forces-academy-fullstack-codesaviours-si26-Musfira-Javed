<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
$student_name = $_SESSION['student_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | Forces Academy LMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .navbar-brand-custom { font-weight: 700; color: #2b529a; }
        .hero-banner { background: linear-gradient(135deg, #2b529a 0%, #1e3a8a 100%); color: white; border-radius: 16px; }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-white bg-white shadow-sm sticky-top mb-4">
        <div class="container">
            <span class="navbar-brand navbar-brand-custom">Forces Academy <span class="text-muted fw-light">LMS</span></span>
            <div class="d-flex align-items-center">
                <span class="text-muted me-3 d-none d-sm-inline small">Logged in as: <strong><?php echo htmlspecialchars($student_name); ?></strong></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm px-3 rounded-2">Logout</a>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="hero-banner p-5 mb-4 shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="display-6 fw-bold mb-2">Welcome Back, <?php echo htmlspecialchars($student_name); ?>!</h2>
                    <p class="fs-5 text-white-50 mb-0">Track your courses, access notices, and review assignment marks right here.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>