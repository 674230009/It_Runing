<?php
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function thai_date($date)
{
    if (!$date) {
        return '-';
    }

    $time = strtotime($date);
    if (!$time) {
        return '-';
    }

    $months = [
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม',
    ];

    return date('j', $time) . ' ' . $months[(int) date('n', $time)] . ' ' . (date('Y', $time) + 543);
}

function event_banner($banner)
{
    $banner = trim((string) $banner);
    $root = dirname(__DIR__);

    if ($banner !== '') {
        if (is_file($root . '/assets/images/events/' . $banner)) {
            return 'assets/images/events/' . $banner;
        }
        if (is_file($root . '/assets/images/' . $banner)) {
            return 'assets/images/' . $banner;
        }
    }

    return 'assets/images/week.jpeg';
}

function event_distances($conn, $eventId)
{
    $stmt = $conn->prepare("SELECT distance_label, price FROM event_distances WHERE event_id = :event_id ORDER BY price ASC");
    $stmt->execute([':event_id' => $eventId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function event_status_label($status)
{
    switch ($status) {
        case 'open':
            return 'เปิดรับสมัคร';
        case 'closed':
            return 'ปิดรับสมัคร';
        default:
            return 'เร็วๆ นี้';
    }
}

function payment_status_label($status)
{
    return $status === 'paid' ? 'ชำระแล้ว' : 'รอชำระเงิน';
}

function generate_competitor_id($conn)
{
    do {
        $id = 'IT' . date('y') . strtoupper(substr(bin2hex(random_bytes(4)), 0, 5));
        $stmt = $conn->prepare("SELECT COUNT(*) FROM competitors WHERE Competitor_id = :id");
        $stmt->execute([':id' => $id]);
    } while ((int) $stmt->fetchColumn() > 0);

    return $id;
}

function generate_bib_number($conn, $eventId)
{
    $stmt = $conn->prepare("SELECT COUNT(*) FROM competitors WHERE event_id = :event_id");
    $stmt->execute([':event_id' => $eventId]);
    $next = (int) $stmt->fetchColumn() + 1;

    return 'E' . (int) $eventId . '-' . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
}

function get_event($conn, $eventId)
{
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = :id");
    $stmt->execute([':id' => $eventId]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_competitor($conn, $competitorId)
{
    $stmt = $conn->prepare("SELECT c.*, e.title AS event_title, e.event_date, e.location, e.province
                           FROM competitors c
                           LEFT JOIN events e ON e.id = c.event_id
                           WHERE c.Competitor_id = :id");
    $stmt->execute([':id' => $competitorId]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
