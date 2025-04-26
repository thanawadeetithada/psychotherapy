<?php
session_start();
require_once 'db.php';

$user_id = $_SESSION['user_id'];

$bank_account = trim($_POST['bank_account']);
$number_account = trim($_POST['number_account']);
$has_qr_upload = !empty($_FILES['qr_code']['name']);

if (empty($bank_account) || empty($number_account)) {
    echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
    exit();
}

$sql_check = "SELECT * FROM bank_accounts WHERE user_id = $user_id";
$result_check = $conn->query($sql_check);

$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($result_check && $result_check->num_rows > 0) {
    $row = $result_check->fetch_assoc();
    $qr_code_path = $row['qr_code_path'];

    if ($has_qr_upload) {
        $qr_code_name = basename($_FILES['qr_code']['name']);
        $qr_code_tmp = $_FILES['qr_code']['tmp_name'];
        $qr_code_path_new = $upload_dir . $qr_code_name;

        if (!move_uploaded_file($qr_code_tmp, $qr_code_path_new)) {
            echo "<script>alert('อัปโหลดไฟล์ QR ไม่สำเร็จ'); window.history.back();</script>";
            exit();
        }

        $qr_code_path = $qr_code_path_new;
    }

    $sql_update = "UPDATE bank_accounts 
                   SET bank_name = '$bank_account', account_number = '$number_account', qr_code_path = '$qr_code_path'
                   WHERE user_id = $user_id";

    $query = $conn->query($sql_update);

} else {
    if (!$has_qr_upload) {
        echo "<script>alert('กรุณาเลือกไฟล์ QR Code ด้วย'); window.history.back();</script>";
        exit();
    }

    $qr_code_name = basename($_FILES['qr_code']['name']);
    $qr_code_tmp = $_FILES['qr_code']['tmp_name'];
    $qr_code_path = $upload_dir . $qr_code_name;

    if (!move_uploaded_file($qr_code_tmp, $qr_code_path)) {
        echo "<script>alert('อัปโหลดไฟล์ QR ไม่สำเร็จ'); window.history.back();</script>";
        exit();
    }

    $sql_insert = "INSERT INTO bank_accounts (bank_name, account_number, qr_code_path, user_id)
                   VALUES ('$bank_account', '$number_account', '$qr_code_path', '$user_id')";

    $query = $conn->query($sql_insert);
}

if ($query) {
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="modal fade" id="successModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header" style="justify-content: center;">
            <h5 class="modal-title">สำเร็จ</h5>
          </div>
          <div class="modal-body text-center">
            ✅ บันทึกข้อมูลเรียบร้อยแล้ว!
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-primary" onclick="window.location.href='data_doc.php'">ตกลง</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      new bootstrap.Modal(document.getElementById('successModal')).show();
    </script>
<?php
} else {
    echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล'); window.history.back();</script>";
}

$conn->close();
?>
