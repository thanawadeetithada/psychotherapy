<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยืนยันการลงทะเบียน</title>
    <style>
        body {
            font-family: sans-serif;
            background: #fff;
            padding: 13rem 1.5rem;
            text-align: center;
        }

        h2 {
            margin-bottom: 30px;
            font-size: 2rem;
            margin-top: 0px;
        }

        .login-box {
            background: #3498db;
            padding: 30px;
            border-radius: 15px;
            color: white;
            margin: 0 auto;
            display: block;
            max-width: 650px;
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2>ยืนยันการลงทะเบียน</h2>
            <h4>กรุณายืนยันข้อมูลของคุณ:</h4>
            <p>ชื่อ: <?php echo htmlspecialchars($_GET['fullname']); ?></p>
            <p>ชื่อผู้ใช้: <?php echo htmlspecialchars($_GET['username']); ?></p>
            <p>อีเมล: <?php echo htmlspecialchars($_GET['email']); ?></p>

            <!-- สร้างฟอร์มเพื่อส่งข้อมูลไปยัง db_register.php -->
            <form method="POST" action="db_register.php">
                <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($_GET['fullname']); ?>">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($_GET['username']); ?>">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
                <input type="hidden" name="password" value="<?php echo htmlspecialchars($_GET['password']); ?>">
                <input type="hidden" name="confirm_password" value="<?php echo htmlspecialchars($_GET['confirm_password']); ?>">

                <div>
                    <button style="margin-right: 20px;" type="submit">ตกลง</button>
                    <button type="button" onclick="window.location.href='index.php'">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
