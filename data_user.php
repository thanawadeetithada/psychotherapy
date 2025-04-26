<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT fullname, username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $username, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ข้อมูลผู้ใช้</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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

    h2 {
        text-align: center;
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
    }

    .login-box input {
        width: 90%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 10px;
        border: none;
        font-size: 1rem;
    }

    .login-box a {
        color: white;
        display: block;
        margin-top: 15px;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .dropdown {
        button {
            background-color: white;
            border: none;

            i {
                font-size: 1.5rem;
            }
        }
    }

    .btn:hover {
        background-color: white !important;
        border: none !important;
        box-shadow: none !important;
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
            <div class="dropdown">
                <button class="btn btn-light" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="contact_cus.php">ติดต่อแพทย์</a></li>
                    <li><a class="dropdown-item" href="data_user.php">แก้ไขข้อมูล</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <h2>ข้อมูลผู้ใช้</h2>
    <div class="container">
        <div class="login-box">
            <form method="POST" action="">
                <div class="text">
                    <strong>ชื่อผู้ใช้ : <?php echo htmlspecialchars($username); ?></strong><br><br>
                    <strong>ชื่อ-นามสกุล : <?php echo htmlspecialchars($fullname); ?></strong><br><br>
                    <strong>อีเมลล์ : <?php echo htmlspecialchars($email); ?></strong><br><br>
                    <strong>รหัสผ่าน : *****</strong><br>

                </div>
                <div style="text-align: end;">
                    <button type="button" class="btn btn-light"
                        onclick="window.location.href='edit_user.php'">แก้ไข</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    <script>
    var modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
    modal.show();

    document.getElementById('closeModalButton').addEventListener('click', function() {
        window.location.href = 'data_user.php';
    });
    </script>
    <?php unset($_SESSION['success'], $_SESSION['error']); ?>
    <?php endif; ?>

</body>

</html>