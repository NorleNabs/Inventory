<?php
require 'server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['category_name']);
    $description = trim($_POST['category_description']);

    if ($name === '') {
        echo json_encode(['success' => false, 'error' => 'Category name is required.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO category (category_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $description);

    if ($stmt->execute()) {
        $newCategoryId = $stmt->insert_id;
        echo json_encode(['success' => true, 'id' => $newCategoryId, 'name' => $name]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }


    $stmt->close();
    $conn->close();
}
