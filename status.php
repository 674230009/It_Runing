<?php
include 'config/it_running_db.php';
include 'config/helpers.php';

$keyword = trim($_POST['keyword'] ?? $_GET['keyword'] ?? '');
$rows = [];
$searched = $keyword !== '';

if ($searched) {
    $sql = "SELECT c.*, e.title AS event_title, e.event_date, e.location, e.province
            FROM competitors c
            LEFT JOIN events e ON e.id = c.event_id
            WHERE c.Competitor_id = :id
               OR c.Competitor_email = :email
               OR c.Competitor_phone = :phone
            ORDER BY c.register_date DESC
            LIMIT 50";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $keyword,
        ':email' => $keyword,
        ':phone' => $keyword,
    ]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ตรวจสอบสถานะการสมัคร | IT RUN 2026</title>
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
    .container { max-width:760px; margin:30px auto; padding:20px; }
    .card { background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); margin-bottom:20px; }
    h2 { color:#007bff; text-align:center; }
    label { display:block; margin-top:10px; font-weight:bold; }
    input { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:5px; box-sizing:border-box; }
    button { margin-top:15px; width:100%; padding:10px; background:#007bff; color:#fff; border:none; border-radius:5px; cursor:pointer; font-weight:bold; }
    button:hover { background:#0056b3; }
    table { width:100%; border-collapse:collapse; margin-top:10px; }
    td { padding:8px; border-bottom:1px solid #ddd; text-align:left; }
    td:first-child { width:42%; color:#555; }
    .btn {
      display:inline-block; padding:8px 14px; border-radius:5px; text-decoration:none;
      color:#fff; font-weight:bold; margin:4px 4px 0 0; font-size:14px;
    }
    .btn-blue { background:#007bff; }
    .btn-green { background:#28a745; }
    .btn-orange { background:#ff6600; }
    .badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:13px; font-weight:bold; color:#fff; }
    .badge-paid { background:#28a745; }
    .badge-pending { background:#ffc107; color:#333; }
    .result-head { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; }
    .notice { padding:10px; border-radius:5px; margin-bottom:15px; text-align:center; }
    .notice-warn { background:#fff3cd; color:#856404; border:1px solid #ffeeba; }
    .empty { text-align:center; color:#c00; }
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
  ตรวจสอบสถานะการสมัคร
</div>

<div class="container">
  <?php if (isset($_GET['not_found'])): ?>
    <div class="card"><p class="notice notice-warn">ไม่พบข้อมูลผู้สมัครที่ต้องการ กรุณาตรวจสอบรหัสอีกครั้ง</p></div>
  <?php endif; ?>

  <div class="card">
    <h2>กรอกข้อมูลเพื่อตรวจสอบ</h2>
    <form action="status.php" method="POST">
      <label>กรอกเบอร์โทร อีเมล หรือรหัสผู้สมัคร:</label>
      <input type="text" name="keyword" value="<?= e($keyword) ?>" required>
      <button type="submit">ตรวจสอบ</button>
    </form>
  </div>

  <?php if ($searched): ?>
    <?php if ($rows): ?>
      <p style="color:#555;">พบข้อมูลทั้งหมด <?= count($rows) ?> รายการ</p>
      <?php foreach ($rows as $row): ?>
        <?php $isPaid = ($row['payment_status'] ?? '') === 'paid'; ?>
        <div class="card">
          <div class="result-head">
            <h2 style="text-align:left; margin:0;"><?= e($row['event_title'] ?? '-') ?></h2>
            <span class="badge <?= $isPaid ? 'badge-paid' : 'badge-pending' ?>">
              <?= e(payment_status_label($row['payment_status'] ?? '')) ?>
            </span>
          </div>
          <table>
            <tr><td>วันที่จัดงาน:</td><td><?= e(thai_date($row['event_date'] ?? '')) ?></td></tr>
            <tr><td>สถานที่:</td><td><?= e($row['location'] ?? '-') ?> จ.<?= e($row['province'] ?? '-') ?></td></tr>
            <tr><td>รหัสผู้สมัคร:</td><td><?= e($row['Competitor_id'] ?? '') ?></td></tr>
            <tr><td>คำนำหน้า:</td><td><?= e($row['Competitor_prefix'] ?? '') ?></td></tr>
            <tr><td>ชื่อ-นามสกุล:</td><td><?= e(trim(($row['Competitor_firstname'] ?? '') . ' ' . ($row['Competitor_lastname'] ?? ''))) ?></td></tr>
            <tr><td>อีเมล:</td><td><?= e($row['Competitor_email'] ?? '') ?></td></tr>
            <tr><td>เบอร์โทร:</td><td><?= e($row['Competitor_phone'] ?? '') ?></td></tr>
            <tr><td>สาขา / คณะ:</td><td><?= e($row['major'] ?? '-') ?></td></tr>
            <tr><td>ระยะทาง:</td><td><?= e($row['distance_type'] ?? '-') ?></td></tr>
            <tr><td>ยอดชำระ:</td><td><?= number_format((int) ($row['amount'] ?? 0)) ?> บาท</td></tr>
            <tr><td>ไซส์เสื้อ:</td><td><?= e($row['shirt_size'] ?? '') ?></td></tr>
            <tr><td>สถานะการชำระเงิน:</td><td><?= e(payment_status_label($row['payment_status'] ?? '')) ?></td></tr>
            <?php if (!empty($row['bib_number'])): ?>
            <tr><td>หมายเลข Bib:</td><td><?= e($row['bib_number']) ?></td></tr>
            <?php endif; ?>
            <tr><td>วันที่สมัคร:</td><td><?= e($row['register_date'] ?? '') ?></td></tr>
          </table>
          <div style="margin-top:12px;">
            <?php if ($isPaid): ?>
              <a href="confirm.php?id=<?= urlencode($row['Competitor_id']) ?>" class="btn btn-blue">ดูใบยืนยันการสมัคร</a>
            <?php else: ?>
              <a href="payment.php?id=<?= urlencode($row['Competitor_id']) ?>" class="btn btn-green">ชำระเงิน</a>
              <a href="confirm.php?id=<?= urlencode($row['Competitor_id']) ?>" class="btn btn-blue">ดูรายละเอียด</a>
            <?php endif; ?>
            <a href="event.php?id=<?= (int) $row['event_id'] ?>" class="btn btn-orange">ดูงานวิ่ง</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="card empty">
        <h2 style="color:red;">❌ ไม่พบข้อมูล</h2>
        <p>กรุณาตรวจสอบอีเมล เบอร์โทร หรือรหัสผู้สมัครอีกครั้ง หรือสมัครวิ่งใหม่</p>
      </div>
    <?php endif; ?>
  <?php endif; ?>

  <div style="margin-top: 20px; text-align: center;">
    <a href="register.php" class="btn btn-green">สมัครวิ่ง</a>
    <a href="calendar.php" class="btn btn-blue">ปฏิทินงานวิ่ง</a>
    <a href="index.php" class="btn btn-orange">กลับหน้าหลัก</a>
  </div>
</div>

</body>
</html>
