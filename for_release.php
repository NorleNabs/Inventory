<?php
include 'server.php';

$sql = "
  SELECT br.*, c.category_name,  d.department_name, ai.item_name
    FROM borrow_request br
    LEFT JOIN category c ON br.category_id = c.category_id
    LEFT JOIN department d ON br.departmentID = d.departmentID
    LEFT JOIN all_items ai ON br.itemID = ai.itemID
    ORDER BY 
    CASE 
        WHEN br.action = 'Pending' AND br.urgent = 1 THEN 1
        WHEN br.action = 'Pending' THEN 2
        WHEN br.action = 'Approved' THEN 3
        WHEN br.action = 'Rejected' THEN 4
        ELSE 5
    END
";
$result = $conn->query($sql);



?>
<div class="table-container">
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>Requester</th>
                        <th>Item Details</th>
                        <th>Borrow Range</th>
                        <th>Urgent</th>
                        <th>Extended</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($result) && $result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()):
                            $borrowDate = date('d M', strtotime($row['borrow_date']));
                            $returnDate = date('d M', strtotime($row['return_date']));
                            ?>
                            <tr data-status="<?= strtolower($row['action']) ?>" id="<?= $row['borrow_requestId'] ?>">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            <?= strtoupper(substr($row['fullname'], 0, 1)) ?>
                                        </div>
                                        <div class="user-details">
                                            <p class="user-name"><?= htmlspecialchars($row['fullname']) ?></p>
                                            <p class="user-email"><?= htmlspecialchars($row['email']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="item-details">
                                        <span class="item-name"><?= htmlspecialchars($row['item_name']) ?></span>
                                        <div>
                                            <span class="item-category"><?= htmlspecialchars($row['category_name']) ?></span>
                                            <span class="ms-1">x<?= $row['quantity'] ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div>
                                            <span class="date-badge">
                                                <i class="bi bi-calendar-check me-1"></i> <?= $borrowDate ?>
                                            </span>
                                        </div>
                                        <div>
                                            <span>to</span>
                                        </div>
                                        <div class="mt-1">
                                            <span class="date-badge">
                                                <i class="bi bi-calendar-x me-1"></i> <?= $returnDate ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($row['urgent'] == 1): ?>
                                        <span class="status-badge status-urgent"><i class="bi bi-check-lg"></i></span>
                                    <?php else: ?>
                                        <span class="status-badge status-normal"><i class="bi bi-x-lg"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['extension'] == 1): ?>
                                        <span class="status-badge status-extension"><i class="bi bi-check-lg"></i></span>
                                    <?php else: ?>
                                        <span class="status-badge status-normal"><i class="bi bi-x-lg"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="purpose-tooltip" data-bs-toggle="tooltip"
                                        title="<?= htmlspecialchars($row['purpose']) ?>">
                                        <span
                                            class="purpose-text"><?= htmlspecialchars(substr($row['purpose'], 0, 20)) ?>...</span>
                                    </div>
                                </td>
                                <td id="status-<?php echo $row['borrow_requestId']; ?>">
                                    <?php if ($row['action'] == 'Pending'): ?>
                                        <span class="status-badge status-extension">
                                            <?= htmlspecialchars($row['action']) ?>
                                        </span>
                                    <?php elseif ($row['action'] == 'Approved'): ?>
                                        <span class="status-badge status-success">
                                            <?= htmlspecialchars($row['action']) ?>
                                        </span>
                                    <?php elseif ($row['action'] == 'Disapproved'): ?>
                                        <span class="status-badge status-urgent">
                                            <?= htmlspecialchars($row['action']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
             
         </div>
        </div>  