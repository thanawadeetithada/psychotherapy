<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
if ($_SESSION['user_role'] !== 'doctor') {
  echo "คุณไม่ได้รับสิทธิ์เข้าถึงหน้านี้";
  exit;
}

$stmt = $conn->prepare("SELECT availability_status FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($availability_status);
$stmt->fetch();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ลูกค้าที่ติดต่อ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
    .navbar-brand-centered {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    .card-custom {
        background-color: #0F75BD;
        opacity: 0.5;
        color: white;
        border-radius: 12px;
        padding: 16px;
        margin: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        max-width: 650px;
        width: 80%;
    }

    .back-button {
        font-size: 18px;
        color: black;
        text-decoration: none;
        visibility: hidden;
    }

    .back-button:hover {
        text-decoration: underline;
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

    .status-toogle {
        margin-right: 1.5rem;
        float: right;
        font-size: 1.2rem;
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
    <h2 style="text-align: center;">ลูกค้าที่ติดต่อ</h2>
    <div class="status-toogle">
        <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="doctorStatusSwitch" <?php if ($availability_status == 'available') echo 'checked'; ?>>
        <label class="form-check-label" for="doctorStatusSwitch" id="doctorStatusLabel">ว่าง</label>
        </div>
    </div>
    <br>
    <div class="container py-4 pt-0 d-flex flex-column align-items-center">

        <div class="card-custom">
            <p><strong>ชื่อลูกค้า : </strong>xxxxxxxxxxxxxxx</p>
            <p><strong>สถานะ : </strong>ชำระเงินแล้ว</p>
            <p>ราคา <strong>300</strong> บาท/<strong>30</strong> นาที</p>
        </div>

        <div class="card-custom">
            <p><strong>ชื่อลูกค้า : </strong>xxxxxxxxxxxxxxx</p>
            <p><strong>สถานะ : </strong>ชำระเงินแล้ว</p>
            <p>ราคา <strong>300</strong> บาท/<strong>30</strong> นาที</p>
        </div>

        <div class="card-custom">
            <p><strong>ชื่อลูกค้า : </strong>xxxxxxxxxxxxxxx</p>
            <p><strong>สถานะ : </strong>ชำระเงินแล้ว</p>
            <p>ราคา <strong>300</strong> บาท/<strong>30</strong> นาที</p>
        </div>

        <div class="card-custom">
            <p><strong>ชื่อลูกค้า : </strong>xxxxxxxxxxxxxxx</p>
            <p><strong>สถานะ : </strong>รอชำระเงิน</p>
            <p>ราคา <strong>300</strong> บาท/<strong>30</strong> นาที</p>
        </div>

        <div class="card-custom">
            <p><strong>ชื่อลูกค้า : </strong>xxxxxxxxxxxxxxx</p>
            <p><strong>สถานะ : </strong>ชำระเงินแล้ว</p>
            <p>ราคา <strong>300</strong> บาท/<strong>30</strong> นาที</p>
        </div>

        <div class="card-custom">
            <p><strong>ชื่อลูกค้า : </strong>xxxxxxxxxxxxxxx</p>
            <p><strong>สถานะ : </strong>ชำระเงินแล้ว</p>
            <p>ราคา <strong>300</strong> บาท/<strong>30</strong> นาที</p>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('doctorStatusSwitch').addEventListener('change', function() {
        const label = document.getElementById('doctorStatusLabel');
        const isChecked = this.checked;

        // เปลี่ยนข้อความ
        label.textContent = isChecked ? 'ว่าง' : 'ไม่ว่าง';

        // ส่งข้อมูลไป update_status.php
        fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    status: isChecked ? 'available' : 'unavailable'
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
            })
            .catch(error => {
                console.error('Error updating status:', error);
            });
    });
    </script>


</body>

</html>