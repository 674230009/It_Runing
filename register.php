<?php include 'it_running_db.php'; ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>สมัครวิ่ง IT RUN 2026</title>
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
            background: url('img/week.jpeg') center/cover no-repeat;
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
        สมัครเข้าร่วมการแข่งขัน
    </div>

    <div class="container">
        <div class="card">
            <h2>กรอกข้อมูลผู้สมัคร</h2>
            <form action="save_register.php" method="POST">
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

                <label>คณะ:</label>
                <input type="text" name="faculty" required>

                <label>สาขา:</label>
                <input type="text" name="major">

                <label>ชั้นปี:</label>
                <input type="number" name="study_year" min="1" max="8" required>

                <label>ไซส์เสื้อ:</label>
                <select name="shirt_size" required>
                    <option value="None">None (ไม่รับเสื้อ)</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>

                <!-- เพิ่มวันที่สมัคร -->
                <input type="hidden" name="register_date" value="<?= date('Y-m-d H:i:s'); ?>">

                <button type="submit">ยืนยันการสมัคร</button>
            </form>
        </div>
    </div>

</body>

</html>