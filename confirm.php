<?php
include 'config/it_running_db.php';

$id = $_GET['id'] ?? null;
$competitor = null;

if ($id) {
    if (isset($_GET['paid'])) {
        $upd = $conn->prepare("UPDATE competitors SET payment_status = 'paid' WHERE Competitor_id = :id");
        $upd->execute([':id' => $id]);
    }

    $stmt = $conn->prepare("SELECT c.*, e.title AS event_title, e.event_date, e.location, e.province
                           FROM competitors c
                           LEFT JOIN events e ON e.id = c.event_id
                           WHERE c.Competitor_id = :id");
    $stmt->execute([':id' => $id]);
    $competitor = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ยืนยันการสมัคร IT RUN 2026</title>
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
      background:url('assets/images/week.jpeg') center/cover no-repeat;
      height:200px; display:flex; align-items:center; justify-content:center;
      color:#fff; font-size:2em; font-weight:bold;
      text-shadow:2px 2px 6px rgba(0,0,0,0.7);
    }
    .container { max-width:650px; margin:30px auto; padding:20px; }
    .card { background:#fff; padding:25px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); text-align:center; }
    h2 { color:#28a745; margin-bottom:15px; }
    .info-table { width:100%; border-collapse:collapse; margin:20px 0; text-align:left; }
    .info-table td { padding:8px; border-bottom:1px solid #eee; }
    .btn {
      display:inline-block; padding:10px 18px; border-radius:5px;
      text-decoration:none; color:#fff; margin:5px; font-weight:bold;
    }
    .btn-green { background:#28a745; }
    .btn-orange { background:#ff6600; }
    .btn-blue { background:#007bff; }
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
  ยืนยันการสมัคร
</div>

<div class="container">
  <div class="card">
    <?php if ($competitor): ?>
      <h2>🎉 ยินดีด้วย! การลงทะเบียนเสร็จสมบูรณ์</h2>
      <p>ระบบบันทึกข้อมูลการสมัครของคุณเรียบร้อยแล้ว</p>

      <table class="info-table">
        <tr><td><strong>งานวิ่ง:</strong></td><td><?= htmlspecialchars($competitor['event_title'] ?? '-') ?></td></tr>
        <tr><td><strong>รหัสผู้สมัคร:</strong></td><td><?= htmlspecialchars($competitor['Competitor_id'] ?? '') ?></td></tr>
        <tr><td><strong>ชื่อ-นามสกุล:</strong></td><td><?= htmlspecialchars(($competitor['Competitor_prefix'] ?? '') . ' ' . ($competitor['Competitor_firstname'] ?? '') . ' ' . ($competitor['Competitor_lastname'] ?? '')) ?></td></tr>
        <tr><td><strong>อีเมล:</strong></td><td><?= htmlspecialchars($competitor['Competitor_email'] ?? '') ?></td></tr>
        <tr><td><strong>เบอร์โทรศัพท์:</strong></td><td><?= htmlspecialchars($competitor['Competitor_phone'] ?? '') ?></td></tr>
        <tr><td><strong>สาขา / คณะ:</strong></td><td><?= htmlspecialchars($competitor['major'] ?? '-') ?></td></tr>
        <tr><td><strong>ระยะทาง:</strong></td><td><?= htmlspecialchars($competitor['distance_type'] ?? '-') ?></td></tr>
        <tr><td><strong>ยอดชำระ:</strong></td><td><?= number_format((int)($competitor['amount'] ?? 0)) ?> บาท</td></tr>
        <tr><td><strong>ไซส์เสื้อ:</strong></td><td><?= htmlspecialchars($competitor['shirt_size']) ?></td></tr>
        <tr><td><strong>สถานะการชำระเงิน:</strong></td><td><?= ($competitor['payment_status'] ?? '') === 'paid' ? 'ชำระแล้ว' : 'รอชำระเงิน' ?></td></tr>
        <?php if (!empty($competitor['bib_number'])): ?>
        <tr><td><strong>หมายเลข Bib:</strong></td><td><?= htmlspecialchars($competitor['bib_number']) ?></td></tr>
        <?php endif; ?>
      </table>

      <div style="margin-top: 20px;">
        <a href="status.php" class="btn btn-blue">ตรวจสอบสถานะ</a>
        <a href="index.php" class="btn btn-orange">กลับหน้าหลัก</a>
      </div>
    <?php else: ?>
      <h2 style="color:#c00;">❌ ไม่พบข้อมูลการสมัคร</h2>
      <p>ไม่พบรหัสผู้สมัครนี้ กรุณาสมัครใหม่หรือตรวจสอบสถานะอีกครั้ง</p>

      <div style="margin-top: 20px;">
        <a href="register.php" class="btn btn-green">สมัครวิ่ง</a>
        <a href="status.php" class="btn btn-blue">ตรวจสอบสถานะ</a>
        <a href="index.php" class="btn btn-orange">กลับหน้าหลัก</a>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
