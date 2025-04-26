<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>ลืมรหัสผ่าน</title>
    <style>
    body {
        font-family: sans-serif;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        margin: 0;
        height: 100vh;
    }

    .container {
        width: 80%;
        max-width: 650px;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
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

    .login-box input {
        border-radius: 15px;
    }

    .login-box a {
        color: white;
        display: block;
        margin-top: 15px;
        text-decoration: none;
    }

    .btn-button {
        text-align: center;
    }

    .btn-light {

        border-radius: 15px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>ลืมรหัสผ่าน</h2>
        <div class="login-box">
            <form method="POST" action="">
                <div class="mb-3">
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="อีเมล" required>
                </div>
                <div class="btn-button">
                    <button style="margin-right: 20px;" class="btn btn-light" type="submit">ตกลง</button>
                    <button type="button" class="btn btn-light"
                        onclick="window.location.href='index.php'">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>