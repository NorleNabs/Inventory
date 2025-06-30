<?php
include 'server.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'], $_POST['quantity'])) {
    $id = intval($_POST['request_id']);
    $quantity = intval($_POST['quantity']);

    
    $stmt = $conn->prepare("SELECT itemID FROM borrow_request WHERE borrow_requestId = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($itemId);
    
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'error' => 'Request not found.']);
        $stmt->close();
        exit;
    }
    $stmt->close();

    
    $stmt = $conn->prepare("UPDATE all_items SET quantity = quantity - ? WHERE itemID = ?");
    $stmt->bind_param("ii", $quantity, $itemId);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => 'Failed to update item quantity.']);
        $stmt->close();
        exit;
    }
    $stmt->close();

    
    $stmt = $conn->prepare("UPDATE borrow_request SET action = 'Approved' WHERE borrow_requestId = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update request status.']);
    }
    $stmt->close();

} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
?>
