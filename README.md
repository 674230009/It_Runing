# IT RUN 2026

เว็บไซต์รับสมัครงานวิ่งออนไลน์สำหรับงาน IT RUN 2026 และงานวิ่งอื่น ๆ โดยผู้ใช้สามารถดูปฏิทินงานวิ่ง เลือกงานที่สนใจ สมัครวิ่ง ชำระเงิน และตรวจสอบสถานะการสมัครได้ในระบบเดียว

## คุณสมบัติหลัก

- หน้าหลักแสดงข้อมูลงาน IT RUN 2026 และงานวิ่งแนะนำ
- ปฏิทินงานวิ่ง แสดงรายการงานทั้งหมด พร้อมตัวกรองจังหวัด เดือน และประเภท
- หน้ารายละเอียดงาน แสดงวันที่ สถานที่ ระยะทาง และราคาแต่ละระยะ
- ระบบสมัครวิ่ง เลือกระยะทางและไซส์เสื้อได้
- คำนวณค่าสมัครตามระยะทางจากฐานข้อมูลอัตโนมัติ
- หน้าชำระเงินแสดงชื่องาน ระยะทาง และยอดเงิน
- ยืนยันการชำระเงินและบันทึกสถานะเป็นชำระแล้ว
- ตรวจสอบสถานะการสมัครด้วยรหัสผู้สมัคร อีเมล หรือเบอร์โทร
- รองรับหลายงานวิ่งผ่าน `event_id`
- ใช้ PDO Prepared Statements และ `htmlspecialchars` เพื่อความปลอดภัย

## เทคโนโลยีที่ใช้

- HTML และ CSS
- PHP
- MySQL / MariaDB
- XAMPP (Apache + MySQL)
- PDO สำหรับเชื่อมต่อฐานข้อมูล

## โครงสร้างโปรเจกต์

```text
It_Runing-main/
├─ assets/
│  └─ images/                  รูปภาพของเว็บไซต์
│     └─ events/               รูปแบนเนอร์งานวิ่ง (ถ้ามี)
├─ config/
│  ├─ it_running_db.php        ตั้งค่าการเชื่อมต่อฐานข้อมูล
│  └─ helpers.php              ฟังก์ชันช่วยเหลือ เช่น วันที่ไทยและ path รูป
├─ database/
│  └─ it_runing.sql            สคริปต์สร้างตารางและข้อมูลตัวอย่าง
├─ calendar.php                ปฏิทินและรายการงานวิ่ง
├─ check_status.php            redirect ไป status.php
├─ confirm.php                 ยืนยันการสมัครและสถานะการชำระเงิน
├─ details.php                 รายละเอียดงาน IT RUN 2026
├─ event.php                   รายละเอียดงานวิ่งแบบ dynamic
├─ index.html                  redirect ไป index.php
├─ index.php                   หน้าหลัก
├─ payment.php                 หน้าชำระเงิน
├─ register.php                หน้าสมัครวิ่ง
├─ save_register.php           บันทึกข้อมูลผู้สมัคร
└─ status.php                  ตรวจสอบสถานะการสมัคร
```

## การติดตั้ง

### สิ่งที่ต้องมี

- XAMPP หรือ Apache + PHP + MySQL
- PHP 7.4 ขึ้นไป (แนะนำ PHP 8)

### ขั้นตอน

1. วางโฟลเดอร์โปรเจกต์ไว้ใน `C:\xampp\htdocs\` เช่น

   ```text
   C:\xampp\htdocs\web_db\It_Runing-main
   ```

2. เปิด Apache และ MySQL จาก XAMPP Control Panel

3. สร้างฐานข้อมูลชื่อ `it_running_db` แล้ว import ไฟล์

   ```text
   database/it_runing.sql
   ```

   สามารถ import ผ่าน phpMyAdmin หรือใช้คำสั่ง

   ```bash
   mysql -u root it_running_db < database/it_runing.sql
   ```

4. ตรวจสอบการเชื่อมต่อฐานข้อมูลในไฟล์ `config/it_running_db.php`

   ```php
   $host = "localhost";
   $user = "root";
   $pass = "";
   $dbname = "it_running_db";
   ```

5. เปิดเว็บไซต์ที่

   ```text
   http://localhost/web_db/It_Runing-main/
   ```

## ฐานข้อมูล

### ตาราง events

เก็บข้อมูลงานวิ่ง

| คอลัมน์ | รายละเอียด |
|---|---|
| id | รหัสงานวิ่ง |
| title | ชื่องาน |
| event_date | วันที่จัดงาน |
| location | สถานที่ |
| province | จังหวัด |
| distances | ประเภทระยะทาง |
| price_min | ราคาต่ำสุด |
| price_max | ราคาสูงสุด |
| banner | ชื่อไฟล์แบนเนอร์ |
| description | รายละเอียดงาน |
| status | สถานะ open, closed, upcoming |

### ตาราง event_distances

เก็บระยะทางและราคาของแต่ละงาน

| คอลัมน์ | รายละเอียด |
|---|---|
| id | รหัสระยะทาง |
| event_id | รหัสงานวิ่ง |
| distance_label | ชื่อระยะทาง |
| price | ราคา |

### ตาราง competitors

เก็บข้อมูลผู้สมัคร

| คอลัมน์ | รายละเอียด |
|---|---|
| Competitor_id | รหัสผู้สมัคร (Primary Key) |
| Competitor_prefix | คำนำหน้า |
| Competitor_firstname | ชื่อ |
| Competitor_lastname | นามสกุล |
| Competitor_email | อีเมล |
| Competitor_phone | เบอร์โทร |
| major | สาขา / คณะ |
| shirt_size | ไซส์เสื้อ |
| register_date | วันที่สมัคร |
| payment_status | สถานะการชำระเงิน pending, paid |
| bib_number | หมายเลข Bib |
| amount | ยอดชำระ |
| distance_type | ระยะทางที่เลือก |
| event_id | รหัสงานวิ่ง |

### ตาราง admins

เตรียมไว้สำหรับระบบหลังบ้าน

| คอลัมน์ | รายละเอียด |
|---|---|
| id | รหัสผู้ดูแล |
| username | ชื่อผู้ใช้ |
| password | รหัสผ่าน |
| name | ชื่อผู้ดูแล |
| created_at | วันที่สร้าง |

## ขั้นตอนการใช้งาน

```text
index.php
   ↓
calendar.php  →  event.php?id=...
   ↓
register.php?event_id=...
   ↓
save_register.php
   ↓
payment.php?id=...
   ↓
confirm.php?id=...&paid=1
   ↓
status.php
```

1. ผู้ใช้เปิดหน้าหลักและเลือกดูปฏิทินงานวิ่ง
2. เลือกงานที่สนใจและดูรายละเอียด
3. กรอกข้อมูลสมัครและเลือกระยะทาง
4. ระบบบันทึกข้อมูลและพาไปหน้าชำระเงิน
5. ผู้ใช้ชำระเงินและกดยืนยันการชำระเงิน
6. ผู้ใช้ตรวจสอบสถานะได้จากรหัสผู้สมัคร อีเมล หรือเบอร์โทร

## หน้าหลักของระบบ

| ไฟล์ | หน้าที่ |
|---|---|
| `index.php` | หน้าหลัก แสดงงาน IT RUN และงานแนะนำ |
| `calendar.php` | ปฏิทินงานวิ่งพร้อมตัวกรอง |
| `event.php` | รายละเอียดงานวิ่งแบบ dynamic |
| `details.php` | รายละเอียดงาน IT RUN 2026 |
| `register.php` | ฟอร์มสมัครวิ่ง |
| `save_register.php` | บันทึกข้อมูลผู้สมัคร |
| `payment.php` | หน้าชำระเงิน |
| `confirm.php` | ยืนยันการสมัคร |
| `status.php` | ตรวจสอบสถานะ |

## การเพิ่มงานวิ่งใหม่

1. เพิ่มข้อมูลในตาราง `events`
2. เพิ่มระยะทางและราคาในตาราง `event_distances` โดยอ้างอิง `event_id`
3. วางรูปแบนเนอร์ใน `assets/images/events/` ตามชื่อไฟล์ในคอลัมน์ `banner`
4. หากไม่มีรูป ระบบจะใช้ `assets/images/week.jpeg` แทนให้อัตโนมัติ

## หมายเหตุ

- หน้า `payment.php` ใช้รูป QR Code เป็นตัวอย่าง ยังไม่ได้เชื่อมต่อผู้ให้บริการชำระเงินจริง
- การกดยืนยันการชำระเงินจะอัปเดตสถานะในฐานข้อมูลเป็น `paid` ทันที
- ระบบหลังบ้านสำหรับผู้ดูแลยังไม่ได้พัฒนา แต่มีตาราง `admins` เตรียมไว้แล้ว
- ต้องเปิด MySQL ก่อนใช้งานทุกครั้ง มิฉะนั้นหน้าที่เชื่อมต่อฐานข้อมูลจะแสดงข้อความเชื่อมต่อไม่สำเร็จ
- รูปประกอบบางส่วนของ `details.php` เป็นภาพประกอบที่รอเพิ่มไฟล์จริง

## การทดสอบ

ตรวจสอบ syntax ของ PHP ทุกไฟล์

```bash
php -l index.php
php -l calendar.php
php -l event.php
php -l register.php
php -l save_register.php
php -l payment.php
php -l confirm.php
php -l status.php
```
