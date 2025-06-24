<?php
require 'server.php';

if (isset($_GET['category'])) {
    $category = (int) $_GET['category'];

    $stmt = $conn->prepare("
        SELECT ai.item_name, ai.quantity 
        FROM all_items ai
        LEFT JOIN category c ON ai.category_id = c.category_id
        WHERE c.category_id = ?
    ");
    $stmt->bind_param("i", $category);
    $stmt->execute();

    $result = $stmt->get_result();
    $items = [];

    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($items);
}

?>