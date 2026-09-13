<?php
include 'it_running_db.php';

$row = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keyword = $_POST['keyword'];
    $sql = "SELECT * FROM competitors WHERE competitor_email = :keyword OR competitor_phone = :keyword OR competitor_id = :keyword";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':keyword' => $keyword]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
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
    .container { max-width:700px; margin:30px auto; padding:20px; }
    .card { background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    h2 { color:#007bff; text-align:center; }
    label { display:block; margin-top:10px; font-weight:bold; }
    input { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:5px; }
    button { margin-top:15px; width:100%; padding:10px; background:#007bff; color:#fff; border:none; border-radius:5px; cursor:pointer; }
    button:hover { background:#0056b3; }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    td { padding:8px; border-bottom:1px solid #ddd; text-align:left; }
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

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
      <?php if ($row): ?>
        <h2 style="color:#28a745;">ข้อมูลผู้สมัคร</h2>
        <table>
          <tr><td>รหัสผู้สมัคร:</td><td><?= htmlspecialchars($row['competitor_id'] ?? $row['Competitor_id'] ?? '') ?></td></tr>
          <tr><td>คำนำหน้า:</td><td><?= htmlspecialchars($row['competitor_prefix'] ?? $row['Competitor_prefix'] ?? '') ?></td></tr>
          <tr><td>ชื่อ-นามสกุล:</td><td><?= htmlspecialchars(($row['competitor_firstname'] ?? $row['Competitor_firstname'] ?? '') . ' ' . ($row['competitor_lastname'] ?? $row['Competitor_lastname'] ?? '')) ?></td></tr>
          <tr><td>อีเมล:</td><td><?= htmlspecialchars($row['competitor_email'] ?? $row['Competitor_email'] ?? '') ?></td></tr>
          <tr><td>เบอร์โทร:</td><td><?= htmlspecialchars($row['competitor_phone'] ?? $row['Competitor_phone'] ?? '') ?></td></tr>
          <tr><td>คณะ:</td><td><?= htmlspecialchars($row['faculty'] ?? '-') ?></td></tr>
          <tr><td>สาขา:</td><td><?= htmlspecialchars($row['major'] ?? '-') ?></td></tr>
          <tr><td>ชั้นปี:</td><td><?= htmlspecialchars($row['study_year'] ?? '-') ?></td></tr>
          <tr><td>ไซส์เสื้อ:</td><td><?= htmlspecialchars($row['shirt_size'] ?? '') ?></td></tr>
          <tr><td>วันที่สมัคร:</td><td><?= htmlspecialchars($row['register_date'] ?? '') ?></td></tr>
        </table>
      <?php else: ?>
        <h2 style="color:red;">❌ ไม่พบข้อมูล</h2>
        <p>กรุณาตรวจสอบอีเมลหรือเบอร์โทรอีกครั้ง</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
