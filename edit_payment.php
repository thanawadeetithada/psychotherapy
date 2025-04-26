<?php
session_start();
require_once 'db.php';

$user_id = $_SESSION['user_id'];
$bank_name = "";
$account_number = "";
$qr_code_path = "";

$sql = "SELECT * FROM bank_accounts WHERE user_id = $user_id LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $bank_name = $row['bank_name'];
    $account_number = $row['account_number'];
    $qr_code_path = $row['qr_code_path'];
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>แก้ไขบัญชีธนาคาร</title>
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

    .login-box input,
    .login-box select {
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

    <h2>แก้ไขบัญชีธนาคาร</h2>
    <div class="container">
        <div class="login-box">
            <form method="POST" action="save_bank.php" enctype="multipart/form-data">
                <select name="bank_account" class="form-control" required>
                    <option value="">-- เลือกธนาคาร --</option>
                    <option value="ธนาคารกรุงเทพ" <?php if($bank_name == "ธนาคารกรุงเทพ") echo "selected"; ?>>
                        ธนาคารกรุงเทพ</option>
                    <option value="ธนาคารกสิกรไทย" <?php if($bank_name == "ธนาคารกสิกรไทย") echo "selected"; ?>>
                        ธนาคารกสิกรไทย</option>
                    <option value="ธนาคารไทยพาณิชย์" <?php if($bank_name == "ธนาคารไทยพาณิชย์") echo "selected"; ?>>
                        ธนาคารไทยพาณิชย์</option>
                    <option value="ธนาคารกรุงไทย" <?php if($bank_name == "ธนาคารกรุงไทย") echo "selected"; ?>>
                        ธนาคารกรุงไทย</option>
                    <option value="ธนาคารกรุงศรีอยุธยา"
                        <?php if($bank_name == "ธนาคารกรุงศรีอยุธยา") echo "selected"; ?>>ธนาคารกรุงศรีอยุธยา</option>
                    <option value="ธนาคารทหารไทยธนชาต" <?php if($bank_name == "ธนาคารทหารไทยธนชาต") echo "selected"; ?>>
                        ธนาคารทหารไทยธนชาต (TTB)</option>
                    <option value="ธนาคารยูโอบี" <?php if($bank_name == "ธนาคารยูโอบี") echo "selected"; ?>>ธนาคารยูโอบี
                        (UOB)</option>
                    <option value="ธนาคารซีไอเอ็มบีไทย"
                        <?php if($bank_name == "ธนาคารซีไอเอ็มบีไทย") echo "selected"; ?>>ธนาคารซีไอเอ็มบีไทย (CIMB)
                    </option>
                    <option value="ธนาคารเกียรตินาคินภัทร"
                        <?php if($bank_name == "ธนาคารเกียรตินาคินภัทร") echo "selected"; ?>>ธนาคารเกียรตินาคินภัทร
                        (KKP)</option>
                    <option value="ธนาคารไทยเครดิตเพื่อรายย่อย"
                        <?php if($bank_name == "ธนาคารไทยเครดิตเพื่อรายย่อย") echo "selected"; ?>>
                        ธนาคารไทยเครดิตเพื่อรายย่อย</option>
                    <option value="ธนาคารแลนด์ แอนด์ เฮ้าส์"
                        <?php if($bank_name == "ธนาคารแลนด์ แอนด์ เฮ้าส์") echo "selected"; ?>>ธนาคารแลนด์ แอนด์ เฮ้าส์
                        (LH Bank)</option>
                    <option value="ธนาคารออมสิน" <?php if($bank_name == "ธนาคารออมสิน") echo "selected"; ?>>ธนาคารออมสิน
                    </option>
                    <option value="ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร"
                        <?php if($bank_name == "ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร") echo "selected"; ?>>ธ.ก.ส.
                        (ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร)</option>
                    <option value="ธนาคารอิสลามแห่งประเทศไทย"
                        <?php if($bank_name == "ธนาคารอิสลามแห่งประเทศไทย") echo "selected"; ?>>
                        ธนาคารอิสลามแห่งประเทศไทย</option>
                </select><br>

                <input type="text" name="number_account" class="form-control" placeholder="เลขบัญชีธนาคาร"
                    value="<?php echo htmlspecialchars($account_number); ?>" required><br>

                <?php if (!empty($qr_code_path)) { ?>
                <div class="mb-3">
                    <img src="<?php echo $qr_code_path; ?>" alt="QR พร้อมเพย์"
                        style="max-width: 200px; margin-bottom: 10px;">
                </div>
                <?php } ?>
                <input type="file" name="qr_code" class="form-control" accept="image/*"><br>

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