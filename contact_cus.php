<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
if ($_SESSION['user_role'] !== 'user') {
    echo "คุณไม่ได้รับสิทธิ์เข้าถึงหน้านี้";
    exit;
}

$sql = "SELECT id, fullname, availability_status FROM users WHERE user_role = 'doctor'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ติดต่อแพทย์</title>
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

    <h2 style="text-align: center;">ติดต่อแพทย์</h2>

    <div class="container py-4 d-flex flex-column align-items-center">

        <?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $fullname = htmlspecialchars($row['fullname']);
        $status = $row['availability_status'];

        if ($status == 'available') {
            $status_text = 'ว่าง';
        } else {
            $status_text = 'ไม่ว่าง';
        }
        ?>
        <a href="select_consult.php?doctor_id=<?php echo $row['id']; ?>" class="card-custom text-decoration-none">
            <p><strong>ชื่อแพทย์ : </strong><?php echo $fullname; ?></p>
            <p><strong>สถานะ : </strong><?php echo $status_text; ?></p>

        </a>
        <?php
    }
} else {
    echo "<p>ไม่พบข้อมูลแพทย์</p>";
}
$conn->close();
?>


    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>