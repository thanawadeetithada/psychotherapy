<?php
session_start();
require_once 'db.php'; // ไฟล์เชื่อมฐานข้อมูล

if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["message" => "Unauthorized"]);
    exit;
}

if ($_SESSION['user_role'] !== 'doctor') {
    http_response_code(403); // Forbidden
    echo json_encode(["message" => "Forbidden"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$status = $data['status'] ?? '';

if (!in_array($status, ['available', 'unavailable'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Invalid status"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE users SET availability_status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $user_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Status updated successfully"]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(["message" => "Failed to update status"]);
}

$stmt->close();
?>
