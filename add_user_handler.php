<?php
require 'server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['users_role']);
    $department = (int) $_POST['department'];   // cast to int
    $position = (int) $_POST['position'];       // cast to int

    if ($username === '' || $password === '' || $role === '' || $department === '' || $position === '') {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    // Hash password before saving
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users_account (username, password, users_role, departmentID, positionId) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $username, $hashedPassword, $role, $department, $position);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>