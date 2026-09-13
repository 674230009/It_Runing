<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ตรวจสอบสถานะการสมัคร</title>
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

    .container { max-width:600px; margin:30px auto; padding:20px; }

    .card { background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }

    h2 { color:#007bff; text-align:center; }

    label { display:block; margin-top:10px; font-weight:bold; }

    input { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:5px; }

    button { margin-top:15px; width:100%; padding:10px; background:#007bff; color:#fff; border:none; border-radius:5px; cursor:pointer; }

    button:hover { background:#0056b3; }

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
  ตรวจสอบสถานะการสมัคร
</div>

<div class="container">
  <div class="card">
    <h2>กรอกข้อมูลเพื่อตรวจสอบ</h2>
    <form action="status.php" method="POST">
      <label>กรอกเบอร์โทร อีเมล หรือรหัสผู้สมัคร:</label>
      <input type="text" name="keyword" required>
      <button type="submit">ตรวจสอบ</button>
    </form>
  </div>
</div>

</body>
</html>
