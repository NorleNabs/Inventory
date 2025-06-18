<?php
session_start();
require_once 'server.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users_account WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // ✅ Use password_verify to check hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['users_role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['contactNo'] = $user['contactNo'];
            $_SESSION['department'] = $user['department'];
            $_SESSION['position'] = $user['position'];

            header("Location: index.php");
            exit;
        } else {
            echo "❌ Incorrect password.";
        }
    } else {
        echo "❌ No account found with that username.";
    }

    $stmt->close();
    $conn->close();
}
?>