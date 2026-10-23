<?php
include 'config/it_running_db.php';
include 'config/helpers.php';

$province = trim($_GET['province'] ?? '');
$month = trim($_GET['month'] ?? '');
$type = trim($_GET['type'] ?? '');

$where = [];
$params = [];

if ($province !== '') {
    $where[] = "province = :province";
    $params[':province'] = $province;
}
if ($month !== '') {
    $where[] = "DATE_FORMAT(event_date, '%Y-%m') = :month";
    $params[':month'] = $month;
}
if ($type !== '') {
    $where[] = "distances LIKE :type";
    $params[':type'] = '%' . $type . '%';
}

$sql = "SELECT * FROM events";
if ($where) {
    $sql .= " WHERE " . implode(' AND ', $where);
}
$sql .= " ORDER BY event_date ASC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$provinces = $conn->query("SELECT DISTINCT province FROM events WHERE province IS NOT NULL AND province <> '' ORDER BY province")->fetchAll(PDO::FETCH_COLUMN);
$months = $conn->query("SELECT DISTINCT DATE_FORMAT(event_date, '%Y-%m') AS ym FROM events ORDER BY ym")->fetchAll(PDO::FETCH_COLUMN);

$types = ['ฟันรัน', 'มินิมาราธอน', 'ฮาล์ฟมาราธอน', 'ฟูลมาราธอน'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ปฏิทินงานวิ่ง IT RUN 2026</title>
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
    .container { max-width:1100px; margin:30px auto; padding:20px; }
    .card { background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); margin-bottom:20px; }
    h2 { color:#ff6600; margin-top:0; }
    .filter-form { display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end; }
    .filter-form label { display:block; font-weight:bold; margin-bottom:5px; font-size:14px; }
    .filter-form select { padding:8px 10px; border:1px solid #ccc; border-radius:5px; min-width:180px; }
    .btn {
      display:inline-block; padding:10px 18px; border-radius:5px; border:none; cursor:pointer;
      text-decoration:none; color:#fff; font-weight:bold;
    }
    .btn-orange { background:#ff6600; }
    .btn-blue { background:#007bff; }
    .btn-green { background:#28a745; }
    .btn-gray { background:#6c757d; }
    .result-count { color:#666; margin:0 0 15px; }
    .event-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:20px; }
    .event-card { background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1); display:flex; flex-direction:column; }
    .event-card img { width:100%; height:160px; object-fit:cover; display:block; }
    .event-body { padding:15px; display:flex; flex-direction:column; flex:1; }
    .event-body h3 { margin:0 0 10px; font-size:1.1em; color:#222; }
    .event-meta { color:#555; font-size:14px; margin:3px 0; }
    .event-price { color:#ff6600; font-weight:bold; margin:10px 0; }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:bold; color:#fff; }
    .badge-open { background:#28a745; }
    .badge-closed { background:#dc3545; }
    .badge-upcoming { background:#007bff; }
    .event-body .btn { margin-top:auto; text-align:center; }
    .empty { text-align:center; color:#777; padding:30px 10px; }
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
  ปฏิทินงานวิ่ง
</div>

<div class="container">
  <div class="card">
    <h2>ค้นหางานวิ่ง</h2>
    <form class="filter-form" method="GET" action="calendar.php">
      <div>
        <label>จังหวัด</label>
        <select name="province">
          <option value="">ทุกจังหวัด</option>
          <?php foreach ($provinces as $p): ?>
            <option value="<?= e($p) ?>" <?= $province === $p ? 'selected' : '' ?>><?= e($p) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label>เดือน</label>
        <select name="month">
          <option value="">ทุกเดือน</option>
          <?php foreach ($months as $ym): ?>
            <option value="<?= e($ym) ?>" <?= $month === $ym ? 'selected' : '' ?>><?= e(preg_replace('/^\d+\s+/u', '', thai_date($ym . '-01'))) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label>ประเภท</label>
        <select name="type">
          <option value="">ทุกประเภท</option>
          <?php foreach ($types as $t): ?>
            <option value="<?= e($t) ?>" <?= $type === $t ? 'selected' : '' ?>><?= e($t) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-orange">ค้นหา</button>
      <a href="calendar.php" class="btn btn-gray">ล้างตัวกรอง</a>
    </form>
  </div>

  <p class="result-count">พบทั้งหมด <?= count($events) ?> งาน</p>

  <?php if ($events): ?>
    <div class="event-grid">
      <?php foreach ($events as $ev): ?>
        <div class="event-card">
          <img src="<?= e(event_banner($ev['banner'])) ?>" alt="<?= e($ev['title']) ?>">
          <div class="event-body">
            <span class="badge badge-<?= e($ev['status']) ?>"><?= e(event_status_label($ev['status'])) ?></span>
            <h3><?= e($ev['title']) ?></h3>
            <p class="event-meta">📅 <?= e(thai_date($ev['event_date'])) ?></p>
            <p class="event-meta">📍 <?= e($ev['location']) ?> จ.<?= e($ev['province']) ?></p>
            <p class="event-meta">🏃 <?= e($ev['distances']) ?></p>
            <p class="event-price">฿<?= number_format((int) $ev['price_min']) ?> - ฿<?= number_format((int) $ev['price_max']) ?></p>
            <a href="event.php?id=<?= (int) $ev['id'] ?>" class="btn btn-blue">ดูรายละเอียด</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="card empty">ไม่พบงานวิ่งที่ตรงกับเงื่อนไข ลองล้างตัวกรองแล้วค้นหาใหม่</div>
  <?php endif; ?>
</div>

</body>
</html>
