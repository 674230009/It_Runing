<?php
include 'config/it_running_db.php';
include 'config/helpers.php';

$id = trim($_GET['id'] ?? '');
$competitor = null;

if ($id !== '') {
    $current = get_competitor($conn, $id);

    if ($current && isset($_GET['paid'])) {
        $bib = $current['bib_number'];

        if (!$bib) {
            $bib = generate_bib_number($conn, (int) $current['event_id']);
        }

        $upd = $conn->prepare("UPDATE competitors
                               SET payment_status = 'paid', bib_number = :bib
                               WHERE Competitor_id = :id");
        $upd->execute([':bib' => $bib, ':id' => $id]);
    }

    $competitor = get_competitor($conn, $id);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ยืนยันการสมัคร <?= e($competitor['event_title'] ?? 'IT RUN 2026') ?></title>
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
    .badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:13px; font-weight:bold; color:#fff; }
    .badge-paid { background:#28a745; }
    .badge-pending { background:#ffc107; color:#333; }
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
      <?php $isPaid = ($competitor['payment_status'] ?? '') === 'paid'; ?>
      <h2><?= $isPaid ? '🎉 ยินดีด้วย! การลงทะเบียนเสร็จสมบูรณ์' : '📝 ข้อมูลการสมัคร' ?></h2>
      <p>
        สถานะการชำระเงิน:
        <span class="badge <?= $isPaid ? 'badge-paid' : 'badge-pending' ?>">
          <?= e(payment_status_label($competitor['payment_status'] ?? '')) ?>
        </span>
      </p>

      <table class="info-table">
        <tr><td><strong>งานวิ่ง:</strong></td><td><?= e($competitor['event_title'] ?? '-') ?></td></tr>
        <tr><td><strong>วันที่จัดงาน:</strong></td><td><?= e(thai_date($competitor['event_date'] ?? '')) ?></td></tr>
        <tr><td><strong>สถานที่:</strong></td><td><?= e($competitor['location'] ?? '-') ?> จ.<?= e($competitor['province'] ?? '-') ?></td></tr>
        <tr><td><strong>รหัสผู้สมัคร:</strong></td><td><?= e($competitor['Competitor_id'] ?? '') ?></td></tr>
        <tr><td><strong>ชื่อ-นามสกุล:</strong></td><td><?= e(trim(($competitor['Competitor_prefix'] ?? '') . ' ' . ($competitor['Competitor_firstname'] ?? '') . ' ' . ($competitor['Competitor_lastname'] ?? ''))) ?></td></tr>
        <tr><td><strong>อีเมล:</strong></td><td><?= e($competitor['Competitor_email'] ?? '') ?></td></tr>
        <tr><td><strong>เบอร์โทรศัพท์:</strong></td><td><?= e($competitor['Competitor_phone'] ?? '') ?></td></tr>
        <tr><td><strong>สาขา / คณะ:</strong></td><td><?= e($competitor['major'] ?? '-') ?></td></tr>
        <tr><td><strong>ระยะทาง:</strong></td><td><?= e($competitor['distance_type'] ?? '-') ?></td></tr>
        <tr><td><strong>ยอดชำระ:</strong></td><td><?= number_format((int) ($competitor['amount'] ?? 0)) ?> บาท</td></tr>
        <tr><td><strong>ไซส์เสื้อ:</strong></td><td><?= e($competitor['shirt_size']) ?></td></tr>
        <tr><td><strong>สถานะการชำระเงิน:</strong></td><td><?= e(payment_status_label($competitor['payment_status'] ?? '')) ?></td></tr>
        <?php if (!empty($competitor['bib_number'])): ?>
        <tr><td><strong>หมายเลข Bib:</strong></td><td><?= e($competitor['bib_number']) ?></td></tr>
        <?php endif; ?>
      </table>

      <div style="margin-top: 20px;">
        <?php if (!$isPaid): ?>
          <a href="payment.php?id=<?= urlencode($competitor['Competitor_id']) ?>" class="btn btn-green">ไปหน้าชำระเงิน</a>
        <?php endif; ?>
        <a href="status.php" class="btn btn-blue">ตรวจสอบสถานะ</a>
        <a href="event.php?id=<?= (int) $competitor['event_id'] ?>" class="btn btn-orange">กลับไปยังงานวิ่ง</a>
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
