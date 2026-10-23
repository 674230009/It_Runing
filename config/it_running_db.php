<?php
// db.php : เชื่อมต่อฐานข้อมูล
$host = "localhost";
$user = "root";   // ปรับตาม phpMyAdmin ของคุณ
$pass = "";       // ใส่รหัสผ่านถ้ามี
$dbname = "it_running_db"; // ใช้ชื่อฐานข้อมูลจริง

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
    exit;
}
?>
