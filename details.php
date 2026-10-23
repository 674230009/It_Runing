<?php
include 'config/it_running_db.php';
include 'config/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;
$event = get_event($conn, $id);

$distances = [];
if ($event) {
    $distances = event_distances($conn, $id);
    if (!$distances) {
        $distances = [['distance_label' => 'ระยะทางตามงาน', 'price' => (int) $event['price_min']]];
    }
}

function distance_benefits($label)
{
    if (preg_match('/(40|42|25|21|11|10\.5)/', $label)) {
        return 'เสื้อ, Bib, เหรียญ, เสื้อ Finisher';
    }

    return 'เสื้อ, Bib, เหรียญ';
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>รายละเอียดการแข่งขัน <?= $event ? e($event['title']) : 'IT RUN 2026' ?></title>
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
    .container { max-width:900px; margin:30px auto; padding:20px; }
    .card { background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); margin-bottom:20px; }
    h2 { color:#ff6600; margin-bottom:10px; }
    table { width:100%; border-collapse:collapse; margin-top:10px; }
    th, td { border:1px solid #ddd; padding:8px; text-align:center; }
    th { background:#ff6600; color:#fff; }
    .btn { display:inline-block; margin-top:15px; padding:10px 15px; background:#007bff; color:#fff; border-radius:5px; text-decoration:none; }
    .btn-green { background:#28a745; }
    .btn-orange { background:#ff6600; }
    .section-img { width:100%; border-radius:8px; margin-bottom:15px; box-shadow:0 2px 6px rgba(0,0,0,0.2); }
    .meta { color:#555; margin:6px 0; }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:bold; color:#fff; margin-bottom:10px; }
    .badge-open { background:#28a745; }
    .badge-closed { background:#dc3545; }
    .badge-upcoming { background:#007bff; }
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
  รายละเอียดการแข่งขัน
</div>

<div class="container">
<?php if ($event): ?>
  <div class="card">
    <span class="badge badge-<?= e($event['status']) ?>"><?= e(event_status_label($event['status'])) ?></span>
    <h2><?= e($event['title']) ?></h2>
    <p class="meta">📅 <strong>วันที่:</strong> <?= e(thai_date($event['event_date'])) ?></p>
    <p class="meta">📍 <strong>สถานที่:</strong> <?= e($event['location']) ?> จังหวัด<?= e($event['province']) ?></p>
    <p class="meta">🏃 <strong>ประเภท:</strong> <?= e($event['distances']) ?></p>
    <?php if (!empty($event['description'])): ?>
      <p class="meta"><?= nl2br(e($event['description'])) ?></p>
    <?php endif; ?>
    <a href="event.php?id=<?= (int) $event['id'] ?>" class="btn">ดูหน้างานวิ่ง</a>
  </div>

  <div class="card">
    <h2>🏃 ระยะทางและค่าสมัคร</h2>
    <img src="assets/images/race-info.jpg" alt="Race Information" class="section-img" onerror="this.style.display='none'">
    <table>
      <tr><th>ระยะทาง</th><th>ค่าสมัคร</th><th>สิ่งที่ได้รับ</th></tr>
      <?php foreach ($distances as $d): ?>
        <tr>
          <td><?= e($d['distance_label']) ?></td>
          <td>฿<?= number_format((int) $d['price']) ?></td>
          <td><?= e(distance_benefits($d['distance_label'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <div class="card">
    <h2>🎁 สิ่งที่ผู้สมัครได้รับ</h2>
    <img src="assets/images/gift-set.jpg" alt="Runner Kit" class="section-img" onerror="this.style.display='none'">
    <ul>
      <li>เสื้อวิ่ง<?= e($event['title']) ?></li>
      <li>Bib หมายเลขประจำตัว</li>
      <li>เหรียญที่ระลึก</li>
      <li>เสื้อ Finisher (ตามระยะทางที่กำหนด)</li>
    </ul>
  </div>

  <div class="card">
    <h2>🏆 รางวัลการแข่งขัน</h2>
    <img src="assets/images/prizes.jpg" alt="Prizes" class="section-img" onerror="this.style.display='none'">
    <p>ถ้วยรางวัลแบ่งตามกลุ่มอายุ และประเภทชาย/หญิง</p>
    <ul>
      <li>ระยะไกล (ฮาล์ฟมาราธอนขึ้นไป) → แบ่งอายุ 29-, 30-39, 40-49, 50+</li>
      <li>ฟันรัน → แบ่งอายุไม่เกิน 15 ปี และ 16 ปีขึ้นไป</li>
    </ul>
  </div>

  <div class="card">
    <h2>📍 สถานที่จัดงาน</h2>
    <img src="assets/images/location.jpg" alt="Event Location" class="section-img" onerror="this.style.display='none'">
    <p>ณ <?= e($event['location']) ?> จังหวัด<?= e($event['province']) ?></p>
    <p>วันที่ <?= e(thai_date($event['event_date'])) ?></p>
  </div>

  <div class="card" style="text-align:center;">
    <?php if ($event['status'] === 'open'): ?>
      <a href="register.php?event_id=<?= (int) $event['id'] ?>" class="btn btn-green">สมัครเลย!</a>
    <?php else: ?>
      <span class="btn" style="background:#6c757d;"><?= e(event_status_label($event['status'])) ?></span>
    <?php endif; ?>
    <a href="calendar.php" class="btn btn-orange">ดูงานวิ่งอื่น</a>
    <a href="status.php" class="btn">ตรวจสอบสถานะ</a>
  </div>
<?php else: ?>
  <div class="card" style="text-align:center;">
    <h2 style="color:#c00;">ไม่พบงานวิ่งนี้</h2>
    <p>งานวิ่งที่คุณกำลังค้นหาอาจถูกลบหรือไม่มีอยู่ในระบบ</p>
    <a href="calendar.php" class="btn btn-orange">กลับปฏิทินงานวิ่ง</a>
  </div>
<?php endif; ?>
</div>

</body>
</html>
