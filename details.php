<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>รายละเอียดการแข่งขัน IT RUN 2026</title>
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
    .container { max-width:900px; margin:30px auto; padding:20px; }
    .card { background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); margin-bottom:20px; }
    h2 { color:#ff6600; margin-bottom:10px; }
    table { width:100%; border-collapse:collapse; margin-top:10px; }
    th, td { border:1px solid #ddd; padding:8px; text-align:center; }
    th { background:#ff6600; color:#fff; }
    .btn { display:inline-block; margin-top:15px; padding:10px 15px; background:#007bff; color:#fff; border-radius:5px; text-decoration:none; }
    .section-img { width:100%; border-radius:8px; margin-bottom:15px; box-shadow:0 2px 6px rgba(0,0,0,0.2); }
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
  รายละเอียดการแข่งขัน
</div>

<div class="container">

  <!-- หมวดค่าสมัคร -->
  <div class="card">
    <h2>🏃 ระยะทางและค่าสมัคร</h2>
    <img src="img/race-info.jpg" alt="Race Information" class="section-img">
    <table>
      <tr>
        <th>ระยะทาง</th><th>Early Bird</th><th>ปกติ</th><th>สิ่งที่ได้รับ</th>
      </tr>
      <tr><td>40 กม.</td><td>฿1,800</td><td>฿2,000</td><td>เสื้อ, Bib, เหรียญ, เสื้อ Finisher</td></tr>
      <tr><td>25 กม.</td><td>฿1,400</td><td>฿1,600</td><td>เสื้อ, Bib, เหรียญ, เสื้อ Finisher</td></tr>
      <tr><td>11 กม.</td><td>฿800</td><td>฿1,000</td><td>เสื้อ, Bib, เหรียญ, เสื้อ Finisher</td></tr>
      <tr><td>5 กม.</td><td>฿500</td><td>฿600</td><td>เสื้อ, Bib, เหรียญ</td></tr>
    </table>
  </div>

  <!-- หมวดสิ่งที่ได้รับ -->
  <div class="card">
    <h2>🎁 สิ่งที่ผู้สมัครได้รับ</h2>
    <img src="img/gift-set.jpg" alt="Runner Kit" class="section-img">
    <ul>
      <li>เสื้อวิ่ง IT RUN 2026</li>
      <li>Bib หมายเลขประจำตัว</li>
      <li>เหรียญที่ระลึก</li>
      <li>เสื้อ Finisher (เฉพาะผู้เข้าเส้นชัยในระยะ 40, 25, 11 กม.)</li>
    </ul>
  </div>

  <!-- หมวดรางวัล -->
  <div class="card">
    <h2>🏆 รางวัลการแข่งขัน</h2>
    <img src="img/prizes.jpg" alt="Prizes" class="section-img">
    <p>ถ้วยรางวัลแบ่งตามกลุ่มอายุ และประเภทชาย/หญิง</p>
    <ul>
      <li>40 กม. / 25 กม. / 11 กม. → แบ่งอายุ 29-, 30-39, 40-49, 50+</li>
      <li>5 กม. → แบ่งอายุไม่เกิน 15 ปี และ 16 ปีขึ้นไป</li>
    </ul>
  </div>

  <!-- หมวดสถานที่ -->
  <div class="card">
    <h2>📍 สถานที่จัดงาน</h2>
    <img src="img/location.jpg" alt="Event Location" class="section-img">
    <p>ณ วัดเขารังจันทร์ราม อำเภอเมือง จังหวัดนครสวรรค์</p>
    <p>วันที่ 22 พฤศจิกายน 2569</p>
  </div>

  <!-- ปุ่มสมัคร -->
  <div class="card" style="text-align:center;">
    <a href="register.php" class="btn">สมัครเลย!</a>
  </div>

</div>

</body>
</html>
