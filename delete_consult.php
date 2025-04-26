<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $consult_id = intval($_POST['consult_id']);
    $user_id = $_SESSION['user_id'];

    // ป้องกันไม่ให้ลบของคนอื่น
    $stmt = $conn->prepare("DELETE FROM consultations WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $consult_id, $user_id);

    if ($stmt->execute()) {
        header("Location: data_doc.php"); // กลับไปหน้าเดิมหลังลบเสร็จ
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }
}
?>
