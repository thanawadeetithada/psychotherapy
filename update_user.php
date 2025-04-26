<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$fullname = trim($_POST['fullname']);
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$_SESSION['form_data'] = [
    'username' => $username,
    'fullname' => $fullname,
    'email'    => $email
];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'อีเมลไม่ถูกต้อง';
    header("Location: edit_user.php");
    exit();
}

$stmt1 = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
$stmt1->bind_param("si", $username, $user_id);
$stmt1->execute();
$stmt1->store_result();
$username_exists = $stmt1->num_rows > 0;

$stmt2 = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
$stmt2->bind_param("si", $email, $user_id);
$stmt2->execute();
$stmt2->store_result();
$email_exists = $stmt2->num_rows > 0;

if ($username_exists && $email_exists) {
    $_SESSION['error'] = "ชื่อผู้ใช้และอีเมลมีอยู่แล้ว!";
    header("Location: edit_user.php");
    exit();
} elseif ($username_exists) {
    $_SESSION['error'] = "ชื่อผู้ใช้นี้มีอยู่แล้ว!";
    header("Location: edit_user.php");
    exit();
} elseif ($email_exists) {
    $_SESSION['error'] = "อีเมลนี้มีอยู่แล้ว!";
    header("Location: edit_user.php");
    exit();
}

if (!empty($password)) {
    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
        header("Location: edit_user.php");
        exit();
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET fullname = ?, username = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $fullname, $username, $email, $hashed_password, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET fullname = ?, username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $fullname, $username, $email, $user_id);
}

if ($stmt->execute()) {
    $_SESSION['success'] = 'อัปเดตข้อมูลสำเร็จ';
    unset($_SESSION['form_data']);
    header("Location: edit_user.php");
    exit();

} else {
    $_SESSION['error'] = 'เกิดข้อผิดพลาด: ' . $stmt->error;
    header("Location: edit_user.php");
    exit();
}
?>