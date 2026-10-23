<?php
include 'config/it_running_db.php';
include 'config/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit();
}

$eventId = isset($_POST['event_id']) ? (int) $_POST['event_id'] : 1;

$event = get_event($conn, $eventId);
if (!$event) {
    header('Location: calendar.php');
    exit();
}

if ($event['status'] !== 'open') {
    header('Location: event.php?id=' . $eventId);
    exit();
}

$sessionKey = 'competitor_id_' . $eventId;
$competitorId = $_SESSION[$sessionKey] ?? '';
if ($competitorId === '') {
    $competitorId = generate_competitor_id($conn);
    $_SESSION[$sessionKey] = $competitorId;
}

$prefix = trim($_POST['Competitor_prefix'] ?? '');
$firstName = trim($_POST['Competitor_firstname'] ?? '');
$lastName = trim($_POST['Competitor_lastname'] ?? '');
$email = trim($_POST['Competitor_email'] ?? '');
$phone = trim($_POST['Competitor_phone'] ?? '');
$major = trim($_POST['major'] ?? '');
$distance = trim($_POST['distance_type'] ?? '');
$shirtSize = trim($_POST['shirt_size'] ?? '');

$validShirtSizes = ['None', 'S', 'M', 'L', 'XL'];

if (
    $prefix === '' || $firstName === '' || $lastName === '' ||
    $email === '' || $phone === '' || $distance === '' || !in_array($shirtSize, $validShirtSizes, true) ||
    mb_strlen($prefix) > 10 ||
    mb_strlen($firstName) > 50 || mb_strlen($lastName) > 50 ||
    mb_strlen($email) > 100 || mb_strlen($phone) > 20 || mb_strlen($major) > 100
) {
    header('Location: register.php?event_id=' . $eventId . '&error=invalid');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: register.php?event_id=' . $eventId . '&error=email');
    exit();
}

$distances = event_distances($conn, $eventId);
$price = false;

foreach ($distances as $row) {
    if ($row['distance_label'] === $distance) {
        $price = (int) $row['price'];
        break;
    }
}

if ($price === false) {
    if (!$distances) {
        $price = (int) $event['price_min'];
    } else {
        header('Location: register.php?event_id=' . $eventId . '&error=distance');
        exit();
    }
}

$stmt = $conn->prepare("SELECT COUNT(*) FROM competitors WHERE Competitor_id = :id");
$stmt->execute([':id' => $competitorId]);
if ((int) $stmt->fetchColumn() > 0) {
    unset($_SESSION[$sessionKey]);
    header('Location: register.php?event_id=' . $eventId . '&error=duplicate');
    exit();
}

try {
    $sql = "INSERT INTO competitors
            (Competitor_id, Competitor_prefix, Competitor_firstname, Competitor_lastname, Competitor_email, Competitor_phone, major, shirt_size, distance_type, amount, event_id)
            VALUES (:id, :prefix, :firstname, :lastname, :email, :phone, :major, :shirt_size, :distance_type, :amount, :event_id)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $competitorId,
        ':prefix' => $prefix,
        ':firstname' => $firstName,
        ':lastname' => $lastName,
        ':email' => $email,
        ':phone' => $phone,
        ':major' => $major,
        ':shirt_size' => $shirtSize,
        ':distance_type' => $distance,
        ':amount' => $price,
        ':event_id' => $eventId,
    ]);

    unset($_SESSION[$sessionKey]);

    header('Location: payment.php?id=' . urlencode($competitorId));
    exit();
} catch (PDOException $e) {
    error_log('[REGISTER] ' . $e->getMessage());
    header('Location: register.php?event_id=' . $eventId . '&error=save');
    exit();
}
