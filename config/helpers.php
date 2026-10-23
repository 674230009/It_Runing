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
