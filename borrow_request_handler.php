<?php
include 'server.php'; // this should set up $conn (mysqli connection)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['borrowerName'] ?? '';
    $email = $_POST['email'] ?? '';
    $contactNo = $_POST['phone'] ?? '';
    $department = $_POST['department'] ?? '';
    $item_name = $_POST['itemName'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $category = $_POST['category'] ?? '';
    $borrow_date = $_POST['borrowDate'] ?? '';
    $return_date = $_POST['returnDate'] ?? '';
    $extension = isset($_POST['extendable']) ? 1 : 0;
    $purpose = $_POST['purpose'] ?? '';
    $urgent = isset($_POST['urgentRequest']) ? 1 : 0;
    $action = 'Pending';
    $remarks = $_POST['remarks'] ?? '';
    $date = date('Y-m-d H:i:s');

    // Prepare the SQL insert statement
    $sql = "INSERT INTO borrow_request 
    (fullname, email, contactNo, departmentID, item_name, quantity, category, borrow_date, return_date, extension, purpose, urgent, action, remarks, date) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssisisssssisss",
        $fullname,
        $email,
        $contactNo,
        $department,
        $item_name,
        $quantity,
        $category,
        $borrow_date,
        $return_date,
        $extension,
        $purpose,
        $urgent,
        $action,
        $remarks,
        $date
    );

    // Execute and check result
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();

}
?>