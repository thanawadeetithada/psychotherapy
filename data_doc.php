<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT bank_name, account_number, qr_code_path FROM bank_accounts WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($bank_name, $account_number, $qr_code_path);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT fullname, username, email, user_role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $username, $email, $user_role);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT id, consultation_item, consultation_time, consultation_price FROM consultations WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$consultations = [];
while ($row = $result->fetch_assoc()) {
    $consultations[] = $row;
}
$stmt->close();

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ข้อมูลผู้ใช้</title>
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
    }

    .login-box a {
        color: white;
        display: block;
        margin-top: 15px;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .img-QR {
        text-align: center;
    }

    img {
        margin: 10px 40px;
        width: -webkit-fill-available;
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
        border-radius: 15px;
    }

    .fa-trash-can {
        margin-right: 1rem;
        color: red;
    }

    .btn-no-bg {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
    }

    .btn-no-bg:focus,
    .btn-no-bg:active {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
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
                    <li><a class="dropdown-item" href="contact_doc.php">ลูกค้าที่ติดต่อ</a></li>
                    <li><a class="dropdown-item" href="data_doc.php">แก้ไขข้อมูล</a></li>
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

    <div class="container">
        <div class="login-box">
            <form method="POST" action="">
                <div class="text">
                    <strong>บัญชีธนาคาร</strong><br>

                    <?php if (!empty($bank_name) && !empty($account_number)) : ?>
                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;ธนาคาร : </strong><?php echo htmlspecialchars($bank_name); ?><br>
                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;เลขบัญชี :</strong>
                        <?php echo htmlspecialchars($account_number); ?><br>

                    <?php if (!empty($qr_code_path)) : ?>
                    <div class="img-QR">
                        <img src="<?php echo htmlspecialchars($qr_code_path); ?>" alt="QR พร้อมเพย์">
                    </div>
                    <?php endif; ?>

                    <?php else : ?>
                    <strong>ยังไม่มีข้อมูลบัญชีธนาคาร</strong><br><br>
                    <?php endif; ?>

                </div>

                <div style="text-align: end;">
                    <button type="button" class="btn btn-light"
                        onclick="window.location.href='edit_payment.php'">แก้ไข</button>
                </div>
            </form>
        </div>
    </div>


    <div class="container">
        <div class="login-box">
            <form method="POST" action="">
                <div class="text">
                    <strong>เพิ่มรายการการปรึกษา</strong><br><br>

                    <?php if (!empty($consultations)) : ?>
                    <?php foreach ($consultations as $consult) : ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <?php echo htmlspecialchars($consult['consultation_item']) . " " . htmlspecialchars($consult['consultation_time']) . " " . htmlspecialchars($consult['consultation_price']); ?>
                        </div>
                        <button type="button" class="btn-no-bg text-danger p-0"
                            onclick="confirmDelete(<?php echo $consult['id']; ?>)">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <strong>ยังไม่มีรายการการปรึกษา</strong><br><br>
                    <?php endif; ?>
                </div>

                <div style="text-align: end;">
                    <button type="button" class="btn btn-light"
                        onclick="window.location.href='add_consult.php'">เพิ่ม</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Modal ยืนยันการลบ -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">ยืนยันการลบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                </div>
                <div class="modal-body">
                    คุณต้องการลบรายการนี้จริงหรือไม่?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <form method="POST" action="delete_consult.php" id="deleteForm">
                        <input type="hidden" name="consult_id" id="consult_id">
                        <button type="submit" class="btn btn-danger">ยืนยันลบ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function confirmDelete(id) {
        document.getElementById('consult_id').value = id;
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'))
        deleteModal.show();
    }
    </script>

</body>

</html>