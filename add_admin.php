<?php
require 'server.php'; // your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = 'superadmin';
    $password = 'adminnabos'; // change this!
    $role = 'Admin';
    $department = 0; // use a valid departmentID
    $position = 0;   // use a valid positionId

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if admin already exists
    $checkStmt = $conn->prepare("SELECT * FROM users_account WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo "❗ Admin account already exists.";
    } else {
        // Insert new admin
        $stmt = $conn->prepare("INSERT INTO users_account (username, password, users_role, departmentID, positionId) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $username, $hashedPassword, $role, $department, $position);

        if ($stmt->execute()) {
            echo "✅ Admin account added successfully.";
        } else {
            echo "❌ Failed to add admin: " . $stmt->error;
        }

        $stmt->close();
    }
    $checkStmt->close();
    $conn->close();
}

?>