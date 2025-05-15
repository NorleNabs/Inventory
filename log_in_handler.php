<?php
session_start();
require_once 'server.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare SQL query
    $stmt = $conn->prepare("SELECT * FROM users_account WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // 🔓 Plaintext password comparison (NOT recommended long-term)
        if ($password === $user['password']) {
            // Successful login
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['users_role'];
            $_SESSION['department'] = $user['department'];
            $_SESSION['position'] = $user['position'];

            header("Location: index.php");
            exit;
        } else {
            echo "Entered password: $password <br>";
            echo "Stored password: " . $user['password'] . "<br>";
            echo "❌ Incorrect password.";
        }
    } else {
        echo "❌ No account found with that username.";
    }

    $stmt->close();
    $conn->close();
}
?>