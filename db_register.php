<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "รหัสผ่านไม่ตรงกัน!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, user_role) VALUES (?, ?, ?, ?, 'user')");
            $stmt->bind_param("ssss", $fullname, $username, $email, $hashed_password);
            $stmt->execute();

            $message = "ลงทะเบียนเรียบร้อยแล้ว!";
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $message = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
    }
}
?>
