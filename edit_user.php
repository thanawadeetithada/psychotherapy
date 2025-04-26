<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$redirectPage = 'data_user.php';
if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] == 'doctor') {
        $redirectPage = 'data_doc.php';
    } elseif ($_SESSION['user_role'] == 'admin') {
        $redirectPage = 'data_admin.php';
    }
}

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['error'])) {
    $stmt = $conn->prepare("SELECT fullname, username, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    $user = [
        'username' => $_SESSION['form_data']['username'] ?? '',
        'fullname' => $_SESSION['form_data']['fullname'] ?? '',
        'email'    => $_SESSION['form_data']['email'] ?? ''
    ];
    unset($_SESSION['form_data']);
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>แก้ไขข้อมูลผู้ใช้</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <style>
    .navbar-brand-centered {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    .back-button {
        font-size: 18px;
        color: black;
        text-decoration: none;
    }

    .back-button:hover {
        text-decoration: underline;
    }

    .container {
        display: flex;
        justify-content: center;
    }

    .login-box {
        width: 80%;
        background: #3498db;
        padding: 30px;
        border-radius: 15px;
        color: white;
        margin: 1.5rem;
        display: block;
        max-width: 650px;
        text-align: center;
    }

    .login-box input {
        border-radius: 15px;
        padding: 10px;
    }

    .login-box a {
        color: white;
        display: block;
        margin-top: 15px;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .alert {
        width: 70%;
        margin-bottom: 0px;
        margin-top: 30px;
        padding-top: 16px;
        max-width: 650px;
    }

    .btn-light {
        margin-bottom: 10px;
        border-radius: 15px;
    }

    @media (max-width: 480px) {
        .navbar-title {
            font-size: 1rem;
        }
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-white position-relative">
        <div class="container-fluid">
            <a class="btn btn-link back-button" href="javascript:history.back()">
                <i class="fa-solid fa-arrow-left me-1"></i>
            </a>
        </div>
    </nav>

    <h2 style="text-align: center;">แก้ไขข้อมูลผู้ใช้</h2>

    <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center mx-auto mt-6">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="container">
        <div class="login-box">
            <form method="POST" action="update_user.php">
                <div class="mb-3">
                    <input type="text" name="username" placeholder="ชื่อผู้ใช้" class="form-control"
                        value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="fullname" placeholder="ชื่อ-นามสกุล" class="form-control"
                        value="<?= htmlspecialchars($user['fullname']) ?>" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" placeholder="อีเมล" class="form-control"
                        value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" placeholder="รหัสผ่าน" class="form-control">
                </div>
                <div class="mb-3">
                    <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่าน" class="form-control">
                </div>

                <div>
                    <button class="btn btn-light me-3" type="submit">ตกลง</button>
                    <button class="btn btn-light" type="button"
                        onclick="window.location.href='<?= $redirectPage ?>'">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <?= htmlspecialchars($_SESSION['success'] ?? $_SESSION['error']) ?>
                </div>
                <div class="modal-footer justify-content-center">
                    <?php if (isset($_SESSION['success'])): ?>
                    <button type="button" class="btn btn-primary" id="goToRedirectPage">ตกลง</button>
                    <?php else: ?>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    var modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
    modal.show();
    <?php if (isset($_SESSION['success'])): ?>
    document.getElementById('goToRedirectPage').addEventListener('click', function() {
        window.location.href = '<?= $redirectPage ?>';
    });
    <?php else: ?>
    <?php
        $error = $_SESSION['error'] ?? '';

        if (strpos($error, 'ชื่อผู้ใช้นี้มีอยู่แล้ว') !== false) {
            echo "document.querySelector('input[name=\"username\"]').value = '';";
        }
        if (strpos($error, 'อีเมลนี้มีอยู่แล้ว') !== false) {
            echo "document.querySelector('input[name=\"email\"]').value = '';";
        }
        if (strpos($error, 'รหัสผ่านไม่ตรงกัน') !== false) {
            echo "document.querySelector('input[name=\"password\"]').value = '';";
            echo "document.querySelector('input[name=\"confirm_password\"]').value = '';";
        }
    ?>
    <?php endif; ?>
    <?php unset($_SESSION['success'], $_SESSION['error']); ?>
    <?php endif; ?>
    </script>

</body>

</html>