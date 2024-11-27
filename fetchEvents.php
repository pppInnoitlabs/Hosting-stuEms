<?php
require_once 'database.php';

// Assuming you have a table 'events' with columns 'title', 'start', 'end'
$sql = "SELECT title, start, end FROM events";

try {
    $stmt = $pdo->query($sql);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format events for FullCalendar
    $formattedEvents = [];
    foreach ($events as $event) {
        $formattedEvents[] = [
            'title' => $event['title'],
            'start' => $event['start'],
            'end' => $event['end']
        ];
    }

    echo json_encode($formattedEvents);
} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}