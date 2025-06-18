<?php
require 'server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['position_name']);
    $departmentID = intval($_POST['position_department']);

    if ($name === '' || $departmentID <= 0) {
        echo json_encode(['success' => false, 'error' => 'Position name and department are required.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO position (position_name, departmentID) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $departmentID);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'id' => $stmt->insert_id,
            'name' => $name
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
