<?php
include 'server.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'] ?? '';
    $fullname = $_POST['borrowerName'] ?? '';
    $email = $_POST['email'] ?? '';
    $contactNo = $_POST['phone'] ?? '';
    $department = $_POST['departmentID'] ?? '';
    $itemID = $_POST['itemID'] ?? '';
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

    
    
    $base64 = $_POST['imageSrc'];

    // Remove the prefix (data:image/jpeg;base64,)
    $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64);

    $imageData = base64_decode($base64);

    if ($imageData === false) {
        echo json_encode(['success' => false, 'error' => 'Invalid image data']);
        exit;
    }


    // Prepare the SQL insert statement
    $sql = "INSERT INTO borrow_request 
    (userID, fullname, email, contactNo, departmentID, itemID, item_img,  quantity, category_id, borrow_date, return_date, extension, purpose, urgent, action, remarks, date) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $imagePlaceholder = null;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssiibisssssisss",
        $userID,
        $fullname,
        $email,
        $contactNo,
        $department,
        $itemID,
        $imagePlaceholder, 
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

    $stmt->send_long_data(6, $imageData); 
   
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();

}
?>