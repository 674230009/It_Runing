<?php
include 'config/it_running_db.php';
include 'config/helpers.php';

$eventId = isset($_GET['event_id']) ? (int) $_GET['event_id'] : 1;

$stmt = $conn->prepare("SELECT * FROM events WHERE id = :id");
$stmt->execute([':id' => $eventId]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    header("Location: calendar.php");
    exit();
}

if ($event['status'] === 'closed') {
    header("Location: event.php?id=" . $eventId);
    exit();
}

$distances = event_distances($conn, $eventId);
if (!$distances) {
    $distances = [['distance_label' => 'ระยะทางตามงาน', 'price' => (int) $event['price_min']]];
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>สมัครวิ่ง <?= e($event['title']) ?></title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
        }

        header {
            background: #ff6600;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-area {
            display: flex;
            align-items: center;
        }

        .logo-area img {
            height: 50px;
            margin-right: 10px;
        }

        .logo-area h1 {
            margin: 0;
            font-size: 1.5em;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .banner {
            background: url('assets/images/week.jpeg') center/cover no-repeat;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 2em;
            font-weight: bold;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
        }

        .container {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #ff6600;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            background: #ff6600;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #e65c00;
        }
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
        สมัครเข้าร่วมการแข่งขัน
    </div>

    <div class="container">
        <div class="card">
            <h2>สมัคร: <?= e($event['title']) ?></h2>
            <p style="text-align:center; color:#555;">
                📅 <?= e(thai_date($event['event_date'])) ?> &nbsp;|&nbsp;
                📍 <?= e($event['location']) ?> จ.<?= e($event['province']) ?>
            </p>
            <?php if (isset($_GET['error'])): ?>
                <p style="color:#c00; text-align:center;">ไม่สามารถบันทึกข้อมูลได้ อาจมีรหัสผู้สมัครนี้อยู่แล้ว กรุณาลองใหม่</p>
            <?php endif; ?>
            <p style="text-align:center;">
                <a href="event.php?id=<?= (int) $event['id'] ?>" style="color:#007bff;">ดูรายละเอียดงานนี้</a>
                &nbsp;|&nbsp;
                <a href="calendar.php" style="color:#007bff;">เลือกงานอื่น</a>
            </p>
            <form action="save_register.php" method="POST">
                <input type="hidden" name="event_id" value="<?= (int) $event['id'] ?>">
                <label>รหัสผู้สมัคร:</label>
                <input type="text" name="Competitor_id" required>

                <label>คำนำหน้า:</label>
                <input type="text" name="Competitor_prefix" required>

                <label>ชื่อ:</label>
                <input type="text" name="Competitor_firstname" required>

                <label>นามสกุล:</label>
                <input type="text" name="Competitor_lastname" required>

                <label>อีเมล:</label>
                <input type="email" name="Competitor_email" required>

                <label>เบอร์โทร:</label>
                <input type="text" name="Competitor_phone" required>

                <label>สาขา / คณะ:</label>
                <input type="text" name="major">

                <label>ระยะทาง:</label>
                <select name="distance_type" required>
                    <?php foreach ($distances as $d): ?>
                        <option value="<?= e($d['distance_label']) ?>"><?= e($d['distance_label']) ?> - <?= number_format((int) $d['price']) ?> บาท</option>
                    <?php endforeach; ?>
                </select>

                <label>ไซส์เสื้อ:</label>
                <select name="shirt_size" required>
                    <option value="None">None (ไม่รับเสื้อ)</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>

                <button type="submit">ยืนยันการสมัคร</button>
            </form>
            <p style="text-align:center; margin-top:15px;">
                สมัครแล้วต้องการตรวจสอบ? <a href="status.php" style="color:#007bff;">ตรวจสอบสถานะการสมัคร</a>
            </p>
        </div>
    </div>

</body>

</html>