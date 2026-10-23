<?php
// db.php : เชื่อมต่อฐานข้อมูล
$host = "localhost";
$user = "root";   // ปรับตาม phpMyAdmin ของคุณ
$pass = "";       // ใส่รหัสผ่านถ้ามี
$dbname = "it_running_db"; // ใช้ชื่อฐานข้อมูลจริง

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('[DB] Connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ กรุณาเปิด MySQL/MariaDB แล้วลองใหม่อีกครั้ง');
}
?>
