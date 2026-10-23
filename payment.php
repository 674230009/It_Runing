<?php
include 'config/it_running_db.php';
include 'config/helpers.php';

$id = trim($_GET['id'] ?? '');

if ($id === '') {
    header('Location: register.php');
    exit();
}

$competitor = get_competitor($conn, $id);

if (!$competitor) {
    header('Location: status.php?not_found=1');
    exit();
}

$isPaid = ($competitor['payment_status'] ?? '') === 'paid';
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ชำระเงิน <?= e($competitor['event_title'] ?? 'IT RUN 2026') ?></title>
  <style>
    body { margin:0; font-family: Arial, sans-serif; background:#f9f9f9; }
    header {
      background:#ff6600; color:#fff; padding:10px 20px;
      display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;
    }
    .logo-area { display:flex; align-items:center; }
    .logo-area img { height:50px; margin-right:10px; }
    .logo-area h1 { margin:0; font-size:1.5em; }
    nav a { color:#fff; text-decoration:none; margin:0 10px; font-weight:bold; }
    nav a:hover { text-decoration:underline; }
    .banner {
      background:url('assets/images/week.jpeg') center/cover no-repeat;
      height:200px; display:flex; align-items:center; justify-content:center;
      color:#fff; font-size:2em; font-weight:bold;
      text-shadow:2px 2px 6px rgba(0,0,0,0.7);
    }
    .container { max-width:700px; margin:30px auto; padding:20px; }
    .card { background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); text-align:center; }
    h2 { color:#ff6600; margin-bottom:15px; }
    .info { text-align:left; max-width:420px; margin:0 auto 10px; }
    .info p { margin:8px 0; }
    img.qr {
      width:250px; height:auto; margin:20px 0;
      border:1px solid #ddd; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.2);
    }
    .btn {
      display:inline-block; padding:10px 15px; border-radius:5px;
      text-decoration:none; color:#fff; margin:5px 3px 0; font-weight:bold;
    }
    .btn-green { background:#28a745; }
    .btn-orange { background:#ff6600; }
    .btn-blue { background:#007bff; }
    .notice { padding:10px; border-radius:5px; margin-bottom:15px; }
    .notice-paid { background:#e8f7ec; color:#1e7e34; border:1px solid #b7e4c7; }
  </style>
</head>
<body>

<header>
  <div class="logo-area">
    <img src="assets/images/it logo พื้นขาว.png" alt="IT RUN Logo">
    <h1>IT RUN 2026</h1>
  </div>
  <nav>
    <a href="index.php">หน้าหลัก</a>
    <a href="calendar.php">ปฏิทินงานวิ่ง</a>
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
    <?php if ($isPaid): ?>
      <p class="notice notice-paid">การสมัครนี้ชำระเงินเรียบร้อยแล้ว</p>
    <?php endif; ?>

    <h2>💳 กรุณาสแกน QR Code เพื่อชำระเงิน</h2>

    <div class="info">
      <p><strong>งานวิ่ง:</strong> <?= e($competitor['event_title'] ?? '-') ?></p>
      <p><strong>รหัสผู้สมัคร:</strong> <?= e($competitor['Competitor_id']) ?></p>
      <p><strong>ผู้สมัคร:</strong> <?= e(trim(($competitor['Competitor_prefix'] ?? '') . ' ' . ($competitor['Competitor_firstname'] ?? '') . ' ' . ($competitor['Competitor_lastname'] ?? ''))) ?></p>
      <p><strong>ระยะทาง:</strong> <?= e($competitor['distance_type']) ?></p>
      <p><strong>ยอดชำระ:</strong> <?= number_format((int) $competitor['amount']) ?> บาท</p>
      <p><strong>สถานะ:</strong> <?= e(payment_status_label($competitor['payment_status'] ?? '')) ?></p>
    </div>

    <img src="assets/images/ดาวน์โหลด.jpg" alt="QR Code สำหรับชำระเงิน" class="qr">

    <?php if ($isPaid): ?>
      <a href="confirm.php?id=<?= urlencode($competitor['Competitor_id']) ?>" class="btn btn-blue">ดูรายละเอียดการสมัคร</a>
    <?php else: ?>
      <p>หลังจากชำระเงินแล้ว กดปุ่มด้านล่างเพื่อยืนยันการชำระเงิน</p>
      <a href="confirm.php?id=<?= urlencode($competitor['Competitor_id']) ?>&paid=1" class="btn btn-green">ยืนยันการชำระเงิน</a>
    <?php endif; ?>
    <br>
    <a href="event.php?id=<?= (int) $competitor['event_id'] ?>" class="btn btn-orange">กลับไปยังงานวิ่ง</a>
    <a href="status.php" class="btn btn-blue">ตรวจสอบสถานะ</a>
  </div>
</div>

</body>
</html>
