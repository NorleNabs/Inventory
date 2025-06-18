<?php
require 'server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['department_name']);

    if ($name === '') {
        echo json_encode(['success' => false, 'error' => 'Department name is required.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO department (department_name) VALUES (?)");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        $newDepartmentId = $stmt->insert_id;
        echo json_encode(['success' => true, 'id' => $newDepartmentId, 'name' => $name]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>