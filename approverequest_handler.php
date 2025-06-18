<?php
include 'server.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
    $id = intval($_POST['request_id']);

    $stmt = $conn->prepare("UPDATE borrow_request SET action = 'Approved' WHERE borrow_requestId = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Database error.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Prepare failed.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
?>