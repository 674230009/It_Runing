<?php
include 'config/it_running_db.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: register.php");
    exit();
}

$eventId = isset($_POST['event_id']) ? (int) $_POST['event_id'] : 1;

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

$distance = $_POST['distance_type'] ?? '';

$stmt = $conn->prepare("SELECT price FROM event_distances WHERE event_id = :event_id AND distance_label = :label");
$stmt->execute([':event_id' => $eventId, ':label' => $distance]);
$price = $stmt->fetchColumn();

if ($price === false) {
    $distance = $distance !== '' ? $distance : 'ระยะทางตามงาน';
    $price = (int) $event['price_min'];
}

try {
    $sql = "INSERT INTO competitors
            (Competitor_id, Competitor_prefix, Competitor_firstname, Competitor_lastname, Competitor_email, Competitor_phone, major, shirt_size, distance_type, amount, event_id)
            VALUES (:id, :prefix, :firstname, :lastname, :email, :phone, :major, :shirt_size, :distance_type, :amount, :event_id)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $_POST['Competitor_id'],
        ':prefix' => $_POST['Competitor_prefix'],
        ':firstname' => $_POST['Competitor_firstname'],
        ':lastname' => $_POST['Competitor_lastname'],
        ':email' => $_POST['Competitor_email'],
        ':phone' => $_POST['Competitor_phone'],
        ':major' => $_POST['major'],
        ':shirt_size' => $_POST['shirt_size'],
        ':distance_type' => $distance,
        ':amount' => (int) $price,
        ':event_id' => $eventId
    ]);

    header("Location: payment.php?id=" . urlencode($_POST['Competitor_id']));
    exit();
} catch (PDOException $e) {
    header("Location: register.php?event_id=" . $eventId . "&error=1");
    exit();
}
?>
