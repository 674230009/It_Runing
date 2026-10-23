<?php
include 'config/it_running_db.php';
include 'config/helpers.php';

$upcoming = $conn->query("SELECT * FROM events WHERE status <> 'closed' ORDER BY event_date ASC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>IT RUN 2026</title>
  <style>
    body { 
        margin:0 auto; 
        font-family: Arial, sans-serif; 
        background:#f9f9f9; 
                  
    }

    header {
      background:#ff6600;
      color:#fff; 
      padding:10px 20px;
      display:flex; 
      justify-content:space-between; 
      align-items:center;
    }

    .logo-area { display:flex; align-items:center; }
    .logo-area img { height:50px; margin-right:10px; }
    .logo-area h1 { margin:0; font-size:1.5em; }
    nav a {
      color:#fff; text-decoration:none; margin:0 10px; font-weight:bold;
    }
    nav a:hover { text-decoration:underline; }
    .banner {
      background:url('assets/images/week.jpeg') center/cover no-repeat;
      height:300px; display:flex; align-items:center; justify-content:center;
      color:#fff; font-size:2.5em; font-weight:bold;
      text-shadow:2px 2px 6px rgba(0,0,0,0.7);
    }
    .container { 
        max-width:900px;
        margin:30px auto; 
        padding:20px; 
    }

    .card {
      background:#fff; 
      padding:20px; 
      border-radius:8px;
      box-shadow:0 2px 6px rgba(0,0,0,0.1);
      margin-bottom:20px;
    }
    .btn {
      display:inline-block; padding:10px 15px; border-radius:5px;
      text-decoration:none; color:#fff; margin:5px;
    }
    .btn-orange { background:#ff6600; }
    .btn-blue { background:#007bff; }
    .btn-green { background:#28a745; }
    .event-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(240px, 1fr)); gap:15px; }
    .event-card { background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    .event-card img { width:100%; height:120px; object-fit:cover; display:block; }
    .event-card .body { padding:12px; }
    .event-card h3 { font-size:1em; margin:0 0 8px; }
    .event-card p { margin:4px 0; color:#666; font-size:13px; }
  </style>
</head>
<body>

<header>
  <!-- โลโก้ + ชื่อเว็บ -->
  <div class="logo-area">
    <img src="assets/images/it logo พื้นขาว.png" alt="IT RUN Logo">
    <h1>IT RUN 2026</h1>
  </div>
  <!-- เมนูนำทาง -->
  <nav>
    <a href="index.php">หน้าหลัก</a>
    <a href="calendar.php">ปฏิทินงานวิ่ง</a>
    <a href="details.php">รายละเอียด</a>
    <a href="register.php">สมัครวิ่ง</a>
    <a href="status.php">ตรวจสอบสถานะ</a>
  </nav>
</header>

<!-- Banner พร้อมข้อความ overlay -->
<div class="banner">
  IT RUN 2026
</div>

<div class="container">
  <div class="card">
    <h2>📅 รายละเอียดงาน IT RUN 2026</h2>
    <p><strong>วันที่จัดงาน:</strong> 22 พฤศจิกายน 2026</p>
    <p><strong>สถานที่:</strong> ณ วัดเขารังจันทร์ราม อำเภอเมือง จังหวัดนครสวรรค์</p>
    <p><strong>ระยะทาง:</strong> 5 km / 11 km / 25 km / 40 km</p>
    <p><strong>อัตราค่าสมัคร (Early Bird):</strong> ฿500 / ฿800 / ฿1,400 / ฿1,800</p>
    <p><strong>เปิดรับสมัครถึง:</strong> 1 พฤศจิกายน 2026</p>
    <div style="margin-top: 15px;">
      <a href="details.php" class="btn btn-blue">รายละเอียดและกติกา</a>
      <a href="register.php" class="btn btn-green">สมัครวิ่ง</a>
      <a href="calendar.php" class="btn btn-orange">ปฏิทินงานวิ่ง</a>
      <a href="status.php" class="btn btn-blue">ตรวจสอบสถานะ</a>
    </div>
  </div>

  <?php if ($upcoming): ?>
  <div class="card">
    <h2>🏁 งานวิ่งที่น่าสนใจ</h2>
    <div class="event-grid">
      <?php foreach ($upcoming as $ev): ?>
        <div class="event-card">
          <img src="<?= e(event_banner($ev['banner'])) ?>" alt="<?= e($ev['title']) ?>">
          <div class="body">
            <h3><?= e($ev['title']) ?></h3>
            <p>📅 <?= e(thai_date($ev['event_date'])) ?></p>
            <p>📍 <?= e($ev['province']) ?></p>
            <a href="event.php?id=<?= (int) $ev['id'] ?>" class="btn btn-blue" style="padding:6px 12px;">ดูรายละเอียด</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <p style="margin-top:15px; text-align:center;">
      <a href="calendar.php" class="btn btn-orange">ดูปฏิทินทั้งหมด</a>
    </p>
  </div>
  <?php endif; ?>
</div>

</body>
</html>
