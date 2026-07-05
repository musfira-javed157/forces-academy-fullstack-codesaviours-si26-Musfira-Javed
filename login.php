<?php
require_once 'config/db.php';
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Humne yahan query mein roll_no bhi select kar liya hai taake future mein kaam aaye
    $sql = "SELECT id, full_name, password, roll_no FROM students WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student = mysqli_fetch_assoc($result);

    if ($student && password_verify($password, $student['password'])) {
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['full_name'];
        $_SESSION['roll_no'] = $student['roll_no']; // Session mein roll_no save kar liya
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal Login | Forces Academy LMS</title>
    <meta name="description" content="Access your student courses and academy announcements.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .bg-gradient-primary { background: linear-gradient(135deg, #2b529a 0%, #1e3a8a 100%); }
        .btn-primary-custom { background-color: #2b529a; color: #fff; border: none; font-weight: 500; }
        .btn-primary-custom:hover { background-color: #1e3a8a; }
        .card { border: none; border-radius: 12px; }
        .form-control:focus { border-color: #2b529a; box-shadow: 0 0 0 0.25rem rgba(43, 82, 154, 0.15); }
    </style>
</head>
<body>
    <main class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row w-100 justify-content-center">
            <div class="col-10 col-sm-7 col-md-5 col-lg-4 col-xl-3">
                <div class="card shadow-lg">
                    <div class="card-header bg-gradient-primary text-white text-center py-4 rounded-top-4">
                        <h1 class="h4 mb-1 fw-bold">Forces Academy</h1>
                        <p class="mb-0 small text-white-50">Sign in to your dashboard</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($_GET['registered'])): ?>
                            <div class="alert alert-success small text-center" role="alert">Registration successful! Please log in.</div>
                        <?php endif; ?>
                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger small text-center" role="alert"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-100 py-2 rounded-2">Sign In</button>
                        </form>
                    </div>
                    <div class="card-footer bg-transparent text-center border-0 pb-4">
                        <p class="small text-muted mb-0">New student? <a href="register.php" class="text-decoration-none fw-semibold" style="color: #2b529a;">Create an account</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>