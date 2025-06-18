<?php
include 'server.php';
header('Content-Type: application/json');

if (isset($_POST['department_id'])) {
    $deptId = intval($_POST['department_id']);

    $stmt = $conn->prepare("SELECT positionId, position_name FROM position WHERE departmentID = ?");
    $stmt->bind_param("i", $deptId);
    $stmt->execute();
    $result = $stmt->get_result();

    $positions = [];
    while ($row = $result->fetch_assoc()) {
        $positions[] = $row;
    }

    echo json_encode(['success' => true, 'positions' => $positions]);
} else {
    echo json_encode(['success' => false, 'error' => 'Missing department ID']);
}
