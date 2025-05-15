<?php
// Database connection
include 'server.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item_name'];
    $item_brand = $_POST['item_brand'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $date = date('Y-m-d');

    // Check and read uploaded image
    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] == 0) {
        $imageData = file_get_contents($_FILES['item_image']['tmp_name']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Image upload failed.']);
        exit;
    }

    // Prepare SQL with image
    $stmt = $conn->prepare("INSERT INTO all_items (item_name, item_brand, quantity, price, status, category, description, date, item_img) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssssb", $item_name, $item_brand, $quantity, $price, $status, $category, $description, $date, $imageData);

    // To use a BLOB, bind as 'b' and send the data with send_long_data()
    $stmt->send_long_data(8, $imageData); // 8 is the index of the item_image parameter

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>