<?php
header('Content-Type: application/json');
require 'server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemID = intval($_POST['itemID']);
    $itemName = $_POST['item_name'];
    $brand = $_POST['item_brand'];
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category']);
    $status = $_POST['status'];

    $hasImage = isset($_FILES['item_image']) && $_FILES['item_image']['error'] === 0;

    if ($hasImage) {
        if ($_FILES['item_image']['size'] > 5 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'Image exceeds 5MB limit.']);
            exit;
        }

        $imageData = file_get_contents($_FILES['item_image']['tmp_name']);

        $stmt = $conn->prepare("
            UPDATE all_items 
            SET item_name = ?, item_brand = ?, quantity = ?, price = ?, category_id = ?, status = ?, item_img = ? 
            WHERE itemID = ?
        ");
        $stmt->bind_param("ssiddsbi", $itemName, $brand, $quantity, $price, $category_id, $status, $null, $itemID);
        $stmt->send_long_data(6, $imageData);
    } else {
        $stmt = $conn->prepare("
            UPDATE all_items 
            SET item_name = ?, item_brand = ?, quantity = ?, price = ?, category_id = ?, status = ? 
            WHERE itemID = ?
        ");
        $stmt->bind_param("ssiddsi", $itemName, $brand, $quantity, $price, $category_id, $status, $itemID);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>