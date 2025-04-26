<?php
session_start();

// รับ doctor_id จาก URL
if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];

    // คุณสามารถใช้ $doctor_id นี้ไป query ข้อมูลหมอต่อได้
    // หรือเอาไปขึ้นหน้าเลือกเวลาปรึกษา ฯลฯ
} else {
    echo "ไม่พบข้อมูลแพทย์ที่เลือก";
    exit;
}
?>
