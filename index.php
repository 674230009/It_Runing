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
      background:url('img/week.jpeg') center/cover no-repeat;
      height:300px; display:flex; align-items:center; justify-content:center;
      color:#fff; font-size:2em; font-weight:bold;
      text-shadow:2px 2px 6px rgba(0,0,0,0.7);
    }
    .container { 
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
  </style>
</head>
<body>

<header>
  <!-- โลโก้ + ชื่อเว็บ -->
  <div class="logo-area">
    <img src="img/it logo พื้นขาว.png" alt="IT RUN Logo">
    <h1>IT RUN 2026</h1>
  </div>
  <!-- เมนูนำทาง -->
  <nav>
    <a href="index.php">หน้าหลัก</a>
    <a href="details.php">รายละเอียด</a>
    <a href="register.php">สมัครวิ่ง</a>
    <a href="status.php">ตรวจสอบสถานะ</a>
  </nav>
</header>

<!-- Banner พร้อมข้อความ overlay -->
<div class="banner"></div>

<div class="container">
  <div class="card">
    <h2>📅 รายละเอียดงาน</h2>
    <p>วันที่จัด: 20 ธันวาคม 2026</p>
    <p>สถานที่: มหาวิทยาลัย IT</p>
    <p>ระยะทาง: Fun Run 5 km, Mini Marathon 10 km, Half Marathon 21 km</p>
    <p>ราคา: 300 / 500 / 700 บาท</p>
    <p>เปิดรับสมัครถึง 1 ธันวาคม 2026</p>
    <div>
      <a href="details.php" class="btn btn-blue">รายละเอียดและกติกา</a>
      <a href="register.php" class="btn btn-green">สมัครวิ่ง</a>
      <a href="status.php" class="btn btn-orange">ตรวจสอบสถานะ</a>
    </div>
  </div>
</div>

</body>
</html>
