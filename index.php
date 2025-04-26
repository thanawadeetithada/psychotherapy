<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT id, fullname, password, user_role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['user_role'] = $user['user_role'];

            switch ($user['user_role']) {
                case 'admin':
                    header("Location: contact_admin.php");
                    break;
                case 'doctor':
                    header("Location: contact_doc.php");
                    break;
                case 'user':
                default:
                    header("Location: contact_cus.php");
                    break;
            }
            exit;
        } else {
            $error = "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "ไม่พบชื่อผู้ใช้นี้";
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Mind App</title>
    <style>
    body {
        font-family: sans-serif;
        background: #fff;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    .container {
        padding: 30px 20px;
    }

    .logo img {
        max-width: 100px;
        width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    .intro-box {
        background: #3498db;
        color: white;
        border-radius: 30px;
        padding: 20px;
        margin: 20px auto;
        max-width: 650px;
    }

    .intro-box p {
        margin-bottom: 0;
    }

    .review {
        text-align: left;
        max-width: 650px;
        margin: 20px auto;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 10px 20px;
    }

    .review img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        flex-shrink: 0;
        object-fit: cover;
    }


    .login-box {
        background: #3498db;
        color: white;
        padding: 20px 30px 30px;
        border-radius: 30px;
        max-width: 650px;
        margin: 20px auto;
    }

    .login-box input {
        border-radius: 15px;
        padding: 10px;
    }

    .login-box a {
        color: white;
        text-decoration: none;
    }

    .forgotpassword-text {
        padding-right: 15px;
    }

    .footer {
        margin: 20px auto;
        max-width: 650px;
        text-align: justify;
    }

    .forgot-password {
        text-align: right;
        margin-bottom: 10px;
    }

    .btn-light {
        margin-bottom: 10px;
        border-radius: 15px;
    }

    @media (max-width: 768px) {
        .review .avatar {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo"><br>
            <img src="img/logo.png" alt="Mind Logo">
        </div>
        <br>
        <div class="intro-box">
            <p><strong>เพราะปัญหาทุกอย่าง...ไม่จำเป็นต้องแก้คนเดียว</strong><br>
                เมื่อคุณได้พูดคุย ปรึกษา<br>
                และระบายกับนักจิตวิทยาที่เข้าใจ คุณจะเริ่มเห็นแสงสว่าง<br>
                และค้นพบความหมายของตัวเองอีกครั้ง<br>
                เราพร้อมเป็นพื้นที่ปลอดภัย ให้คุณได้พูดทุกเรื่องที่อัดอั้น<br>
                เพราะความสุข ความสำเร็จ และการเยียวยา...<br>
                เริ่มต้นที่ “การฟัง”</p>
        </div>

        <div class="review">
            <img src="img/review1.jpg" alt="Mind Logo">
            <div class="text">
                <!-- <p><strong>ชื่อ xxx</strong></p> -->
                <p style="margin-bottom: 0px;">
                    <strong>รีวิว :</strong> ใช้ง่าย คุยกับจิตแพทย์ได้ทันใจ รู้สึกสบายใจขึ้นเยอะ
                </p>
            </div>
        </div>

        <div class="review">
            <img src="img/review2.jpg" alt="Mind Logo">
            <div class="text">
                <!-- <p><strong>ชื่อ xxx</strong></p> -->
                <p style="margin-bottom: 0px;">
                    <strong>รีวิว :</strong> แอปดีมาก สะดวก รวดเร็ว ได้รับคำปรึกษาที่เข้าใจจริง ๆ
                </p>
            </div>
        </div>

        <div class="login-box">
            <form method="POST" action="" autocomplete="off">
                <div class="mt-3 mb-3">
                    <input type="text" name="username" placeholder="ชื่อผู้ใช้" class="form-control"
                        id="exampleFormControlInput1" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" placeholder="รหัสผ่าน" class="form-control"
                        id="exampleFormControlInput1" required>
                </div>
                <div class="forgot-password">
                    <a class="forgotpassword-text" href="forgotpassword.php">ลืมรหัสผ่าน</a>
                </div>

                <button type="submit" class="btn btn-light">เข้าสู่ระบบ</button><br>
                <a class="register-text" href="register.php">สมัครสมาชิก</a>
            </form>
        </div>

        <div class="footer"><strong>
                แจ้งปัญหาการใช้งาน<br>
                Line : @672fchez</strong>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">เกิดข้อผิดพลาด</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <?= isset($error) ? htmlspecialchars($error) : '' ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (!empty($error)): ?>
    <script>
    window.addEventListener("DOMContentLoaded", function() {
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    });
    </script>
    <?php endif; ?>
</body>

</html>