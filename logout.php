<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page (change to your actual login page)
header("Location: login.php");
exit();
