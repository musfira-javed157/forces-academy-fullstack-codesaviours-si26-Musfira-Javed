<?php
require_once 'config/db.php';
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $roll_no = trim($_POST['roll_no']); // Fixed: matching the HTML input name
    $class = trim($_POST['class']);

    if (empty($full_name) || empty($email) || empty($password) || empty($roll_no) || empty($class)) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO students (full_name, email, password, roll_no, class) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        // Fixed: Using $roll_no instead of $roll_number here
        mysqli_stmt_bind_param($stmt, 'sssss', $full_name, $email, $hashed, $roll_no, $class);
        
        if (mysqli_stmt_execute($stmt)) {
            header('Location: login.php?registered=1');
            exit;
        } else {
            $error = 'Registration failed. Email or roll number may already exist.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | Forces Academy LMS</title>
    <meta name="description" content="Secure student portal registration for Forces Academy LMS.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .bg-gradient-primary { background: linear-gradient(135deg, #2b529a 0%, #1e3a8a 100%); }
        .btn-accent { background-color: #10b981; color: #fff; border: none; font-weight: 500; }
        .btn-accent:hover { background-color: #059669; color: #fff; }
        .card { border: none; border-radius: 12px; }
        .form-control:focus { border-color: #2b529a; box-shadow: 0 0 0 0.25rem rgba(43, 82, 154, 0.15); }
    </style>
</head>
<body>
    <main class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row w-100 justify-content-center">
            <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-gradient-primary text-white text-center py-4 rounded-top-4">
                        <h1 class="h4 mb-1 fw-bold">Forces Academy</h1>
                        <p class="mb-0 small text-white-50">Create your student account</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger d-flex align-items-center small" role="alert"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form action="register.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Full Name</label>
                                <input type="text" name="full_name" class="form-control" placeholder="e.g. Musfira Javed" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-semibold">Roll Number</label>
                                    <input type="text" name="roll_no" class="form-control" placeholder="FA23-001" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-semibold">Class / Degree</label>
                                    <input type="text" name="class" class="form-control" placeholder="BS-CS" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-semibold">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                            </div>
                            <button type="submit" class="btn btn-accent w-100 py-2 rounded-2">Register Account</button>
                        </form>
                    </div>
                    <div class="card-footer bg-transparent text-center border-0 pb-4">
                        <p class="small text-muted mb-0">Already registered? <a href="login.php" class="text-decoration-none fw-semibold" style="color: #2b529a;">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>