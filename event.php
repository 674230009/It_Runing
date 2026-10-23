<?php
include 'config/it_running_db.php';
include 'config/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$event = null;
$distances = [];

if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        $distances = event_distances($conn, $id);
        if (!$distances) {
            $distances = [['distance_label' => 'ระยะทางตามงาน', 'price' => (int) $event['price_min']]];
        }
    }
}

$related = [];
if ($event) {
    $stmt = $conn->prepare("SELECT * FROM events WHERE id <> :id AND status <> 'closed' ORDER BY event_date ASC LIMIT 3");
    $stmt->execute([':id' => $id]);
    $related = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $event ? e($event['title']) : 'ไม่พบงานวิ่ง' ?> | IT RUN 2026</title>
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
    h2 { color:#ff6600; margin-top:0; }
    .event-hero { width:100%; max-height:320px; object-fit:cover; border-radius:8px; display:block; margin-bottom:20px; }
    .meta { color:#555; margin:6px 0; }
    table { width:100%; border-collapse:collapse; margin-top:10px; }
    th, td { border:1px solid #ddd; padding:10px; text-align:center; }
    th { background:#ff6600; color:#fff; }
    .btn {
      display:inline-block; padding:10px 18px; border-radius:5px;
      text-decoration:none; color:#fff; font-weight:bold; border:none; cursor:pointer;
    }
    .btn-orange { background:#ff6600; }
    .btn-blue { background:#007bff; }
    .btn-green { background:#28a745; }
    .btn-gray { background:#6c757d; }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:bold; color:#fff; }
    .badge-open { background:#28a745; }
    .badge-closed { background:#dc3545; }
    .badge-upcoming { background:#007bff; }
    .actions { margin-top:20px; text-align:center; }
    .related-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(240px, 1fr)); gap:15px; }
    .related-card { background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    .related-card img { width:100%; height:110px; object-fit:cover; display:block; }
    .related-card .body { padding:12px; }
    .related-card h3 { font-size:1em; margin:0 0 8px; }
    .related-card p { margin:4px 0; color:#666; font-size:13px; }
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
  รายละเอียดงานวิ่ง
</div>

<div class="container">
  <?php if ($event): ?>
    <div class="card">
      <img class="event-hero" src="<?= e(event_banner($event['banner'])) ?>" alt="<?= e($event['title']) ?>">
      <span class="badge badge-<?= e($event['status']) ?>"><?= e(event_status_label($event['status'])) ?></span>
      <h2><?= e($event['title']) ?></h2>
      <p class="meta">📅 <strong>วันที่:</strong> <?= e(thai_date($event['event_date'])) ?></p>
      <p class="meta">📍 <strong>สถานที่:</strong> <?= e($event['location']) ?> จังหวัด<?= e($event['province']) ?></p>
      <p class="meta">🏃 <strong>ประเภท:</strong> <?= e($event['distances']) ?></p>
      <p class="meta">💰 <strong>ค่าสมัคร:</strong> ฿<?= number_format((int) $event['price_min']) ?> - ฿<?= number_format((int) $event['price_max']) ?></p>
      <?php if (!empty($event['description'])): ?>
        <p class="meta"><?= nl2br(e($event['description'])) ?></p>
      <?php endif; ?>

      <h2>ระยะทางและค่าสมัคร</h2>
      <table>
        <tr><th>ระยะทาง</th><th>ค่าสมัคร</th></tr>
        <?php foreach ($distances as $d): ?>
          <tr>
            <td><?= e($d['distance_label']) ?></td>
            <td>฿<?= number_format((int) $d['price']) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>

      <div class="actions">
        <?php if ($event['status'] === 'closed'): ?>
          <span class="btn btn-gray">ปิดรับสมัครแล้ว</span>
        <?php else: ?>
          <a href="register.php?event_id=<?= (int) $event['id'] ?>" class="btn btn-green">สมัครงานนี้</a>
        <?php endif; ?>
        <a href="calendar.php" class="btn btn-orange">กลับปฏิทินงานวิ่ง</a>
      </div>
    </div>

    <?php if ($related): ?>
      <div class="card">
        <h2>งานวิ่งอื่นที่น่าสนใจ</h2>
        <div class="related-grid">
          <?php foreach ($related as $r): ?>
            <div class="related-card">
              <img src="<?= e(event_banner($r['banner'])) ?>" alt="<?= e($r['title']) ?>">
              <div class="body">
                <h3><?= e($r['title']) ?></h3>
                <p>📅 <?= e(thai_date($r['event_date'])) ?></p>
                <p>📍 <?= e($r['province']) ?></p>
                <a href="event.php?id=<?= (int) $r['id'] ?>" class="btn btn-blue" style="padding:6px 12px;">ดูรายละเอียด</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
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
