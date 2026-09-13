<?php
include 'it_running_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO competitors 
            (competitor_id, competitor_prefix, competitor_firstname, competitor_lastname, competitor_email, competitor_phone, faculty, major, study_year, shirt_size) 
            VALUES (:Competitor_id, :Competitor_prefix, :Competitor_firstname, :Competitor_lastname, :Competitor_email, :Competitor_phone, :faculty, :major, :study_year, :shirt_size)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':Competitor_id' => $_POST['Competitor_id'],
        ':Competitor_prefix' => $_POST['Competitor_prefix'],
        ':Competitor_firstname' => $_POST['Competitor_firstname'],
        ':Competitor_lastname' => $_POST['Competitor_lastname'],
        ':Competitor_email' => $_POST['Competitor_email'],
        ':Competitor_phone' => $_POST['Competitor_phone'],
        ':faculty' => $_POST['faculty'],
        ':major' => $_POST['major'],
        ':study_year' => $_POST['study_year'],
        ':shirt_size' => $_POST['shirt_size']
    ]);

    // ตรวจสอบว่าเลือกเสื้อหรือไม่
    if ($_POST['shirt_size'] != "None") {
        // ถ้าเลือกเสื้อ → ไปหน้าชำระเงิน
        header("Location: payment.php?id=" . urlencode($_POST['Competitor_id']));
        exit();
    } else {
        // ถ้าไม่เลือกเสื้อ → ไปหน้ายืนยันการสมัครทันที
        header("Location: confirm.php?id=" . urlencode($_POST['Competitor_id']));
        exit();
    }
}
?>
