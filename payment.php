<?php
$id = $_GET['id'] ?? null;
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ชำระเงิน IT RUN 2026</title>
  <style>
    body { margin:0; font-family: Arial, sans-serif; background:#f9f9f9; }
    header {
      background:#ff6600; color:#fff; padding:10px 20px;
      display:flex; justify-content:space-between; align-items:center;
    }
    .logo-area { display:flex; align-items:center; }
    .logo-area img { height:50px; margin-right:10px; }
    .logo-area h1 { margin:0; font-size:1.5em; }
    nav a { color:#fff; text-decoration:none; margin:0 10px; font-weight:bold; }
    nav a:hover { text-decoration:underline; }
    .banner {
      background:url('img/week.jpeg') center/cover no-repeat;
      height:200px; display:flex; align-items:center; justify-content:center;
      color:#fff; font-size:2em; font-weight:bold;
      text-shadow:2px 2px 6px rgba(0,0,0,0.7);
    }
    .container { max-width:700px; margin:30px auto; padding:20px; }
    .card { background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); text-align:center; }
    h2 { color:#ff6600; margin-bottom:15px; }
    img.qr {
      width:250px; height:auto; margin:20px 0;
      border:1px solid #ddd; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.2);
    }
    a.btn {
      display:inline-block; padding:10px 15px; border-radius:5px;
      text-decoration:none; color:#fff; margin-top:15px;
    }
    .btn-green { background:#28a745; }
    .btn-orange { background:#ff6600; }
  </style>
</head>
<body>

<header>
  <div class="logo-area">
    <img src="img/it logo พื้นขาว.png" alt="IT RUN Logo">
    <h1>IT RUN 2026</h1>
  </div>
  <nav>
    <a href="index.php">หน้าหลัก</a>
    <a href="details.php">รายละเอียด</a>
    <a href="register.php">สมัครวิ่ง</a>
    <a href="status.php">ตรวจสอบสถานะ</a>
  </nav>
</header>

<div class="banner">
  ชำระเงิน
</div>

<div class="container">
  <div class="card">
    <h2>💳 กรุณาสแกน QR Code เพื่อชำระเงิน</h2>
    <!-- ใส่รูป QR Code ที่คุณมี -->
    <img src="img/ดาวน์โหลด.jpg" alt="QR Code สำหรับชำระเงิน" class="qr">
    <p>หลังจากชำระเงินแล้ว กดปุ่มด้านล่างเพื่อยืนยันการสมัคร</p>
    <a href="confirm.php?id=<?= urlencode($id) ?>" class="btn btn-green">ยืนยันการชำระเงิน</a>
    <br><br>
    <a href="index.php" class="btn btn-orange">กลับหน้าหลัก</a>
  </div>
</div>

</body>
</html>
