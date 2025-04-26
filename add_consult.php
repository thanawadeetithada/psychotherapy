<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>เพิ่มรายการปรึกษา</title>
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

    .btn-light {
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

    <h2>เพิ่มรายการปรึกษา</h2>
    <div class="container">
        <div class="login-box">
            <form method="POST" action="add_consultation.php">
                <input type="text" name="consultation_item" class="form-control" placeholder="รายการปรึกษา"
                    required><br>
                <input type="text" name="consultation_time" class="form-control" placeholder="เวลา นาที / ชั่วโมง"
                    required><br>
                <input type="text" name="consultation_price" class="form-control" placeholder="ราคา" required><br>
                <div>
                    <button class="btn btn-light me-3" type="submit">ตกลง</button>
                    <button class="btn btn-light" type="button"
                        onclick="window.location.href='index.php'">ยกเลิก</button>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>