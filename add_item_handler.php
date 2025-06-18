<?php
include 'server.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item_name'];
    $item_type = $_POST['item_type'];
    $item_brand = $_POST['item_brand'];
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $status = $_POST['status'];
    $category_id = intval($_POST['category']); // category_id from select
    $description = $_POST['description'];
    $date = date('Y-m-d H:i:s');

    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] == 0) {
        $imageData = file_get_contents($_FILES['item_image']['tmp_name']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Image upload failed.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO all_items (item_name, item_type, item_brand, item_img, quantity, price, status, category_id, date, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    //                           s      s       b     i    d    s     i     s     s
    $stmt->bind_param("sssbississ", $item_name, $item_type, $item_brand, $null, $quantity, $price, $status, $category_id, $date, $description);

    // Bind image as long data (index 3rd parameter, which is index 2 in 0-based)
    $stmt->send_long_data(3, $imageData);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>