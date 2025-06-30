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

        if (password_verify($password, $user['password'])) {
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['users_role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['contactNo'] = $user['contactNo'];
            $_SESSION['departmentID'] = $user['departmentID'];
            $_SESSION['positionId'] = $user['positionId'];

            $stmt->close();
            $conn->close();

            header("Location: index.php");
            exit;
        } else {
            $_SESSION['login_error'] = "Incorrect password.";
        }
    } else {
        $_SESSION['login_error'] = "No account found with that username.";
    }

    $stmt->close();
    $conn->close();

    header("Location: log_in.php");
    exit;
}
?>