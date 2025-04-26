<?php
    require_once 'db.php';

    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname         = $_POST['fullname'];
        $username         = $_POST['username'];
        $email            = $_POST['email'];
        $password         = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password !== $confirm_password) {
            $message = "รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน!";
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            $username_exists = $stmt->num_rows > 0;

            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $email_exists = $stmt->num_rows > 0;

            if ($username_exists && $email_exists) {
                $message = "ชื่อผู้ใช้และอีเมลมีอยู่แล้ว!";
            } elseif ($username_exists) {
                $message = "ชื่อผู้ใช้มีอยู่แล้ว!";
            } elseif ($email_exists) {
                $message = "อีเมลมีอยู่แล้ว!";
            } else {
                header("Location: confirm_register.php?fullname=" . urlencode($fullname) . "&username=" . urlencode($username) . "&email=" . urlencode($email) . "&password=" . urlencode($password) . "&confirm_password=" . urlencode($confirm_password));
                exit;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    body {
        font-family: sans-serif;
        background: #fff;
        padding: 3.5rem 1.5rem;
        text-align: center;
    }

    .login-box {
        background: #3498db;
        padding: 30px;
        border-radius: 15px;
        color: white;
        margin: 0 auto;
        display: block;
        max-width: 650px;
        margin-top: 30px;
    }

    .login-box input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 15px;
        border: none;
    }

    .login-box input:focus {
        outline: none;
    }

    .login-box a {
        color: white;
        display: block;
        margin-top: 15px;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .btn-light {
        margin-top: 15px;
        border-radius: 15px;
    }

    .alert-danger {
        margin-top: 20px;
        width: 70%;
        max-width: 650px;
        margin-bottom: 0px;
    }

    .error-alert {
        display: flex;
        justify-content: center;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>สมัครสมาชิก</h2>
        <div class="error-alert">
            <?php if (! empty($message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($message)?>
            </div>
            <?php endif; ?>
        </div>
        <div class="login-box">
            <form method="POST" action="">
                <div class="mt-3 mb-3">
                    <input type="text" name="fullname" placeholder="ชื่อ-นามสกุล" class="form-control" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="username" placeholder="ชื่อผู้ใช้" class="form-control" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" placeholder="อีเมล" class="form-control" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" placeholder="รหัสผ่าน" class="form-control" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่าน" class="form-control"
                        required>
                </div>
                <button type="submit" class="btn btn-light">ลงทะเบียน</button>
                <a href="index.php">เข้าสู่ระบบ</a>
            </form>
        </div>
    </div>
</body>

</html>