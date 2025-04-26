<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $consultation_item = trim($_POST['consultation_item']);
    $consultation_time = trim($_POST['consultation_time']);
    $consultation_price = trim($_POST['consultation_price']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO consultations (user_id, consultation_item, consultation_time, consultation_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $consultation_item, $consultation_time, $consultation_price);

    if ($stmt->execute()) {
        header("Location: data_doc.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }
}
?>
