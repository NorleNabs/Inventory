<?php
session_start();
include 'server.php';

$sql = "SELECT * FROM all_items ORDER BY date DESC";
$result = $conn->query($sql);


$sumSql = "SELECT SUM(quantity) AS total_quantity, SUM(price * quantity) AS total_value FROM all_items";
$sumResult = $conn->query($sumSql);

$totalQuantity = 0;
$totalValue = 0.00;

if ($sumResult && $row = $sumResult->fetch_assoc()) {
    $totalQuantity = $row['total_quantity'];
    $totalValue = $row['total_value'];
}


$lowStockSql = "
    SELECT ai.*, c.category_name
    FROM all_items ai
    JOIN category c ON ai.category_id = c.category_id
    WHERE ai.quantity <= 2
    ORDER BY ai.quantity ASC
";

$lowStockResult = $conn->query($lowStockSql);

$lowStockItems = [];
$lowStockCount = 0;

if ($lowStockResult && $lowStockResult->num_rows > 0) {
    while ($item = $lowStockResult->fetch_assoc()) {
        $lowStockItems[] = $item;
    }
    $lowStockCount = count($lowStockItems);
}

$categoryCount = 0;
$categorySql = "
    SELECT COUNT(DISTINCT c.category_name) AS total_categories
    FROM all_items ai
    JOIN category c ON ai.category_id = c.category_id
    WHERE ai.category_id IS NOT NULL
";
$categoryResult = $conn->query($categorySql);

if ($categoryResult && $row = $categoryResult->fetch_assoc()) {
    $categoryCount = $row['total_categories'];
}

$requestSql = "SELECT br.*, ai.item_name, c.category_name FROM borrow_request br
JOIN all_items ai ON br.itemID = ai.itemID
LEFT JOIN category c ON ai.category_id = c.category_id
WHERE action = 'Pending' ORDER BY date DESC LIMIT 7";
$requestResult = $conn->query($requestSql);

$userID = $_SESSION['userID'];


?>


<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card border-1 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                    <i class="bi bi-box text-primary fs-4"></i>
                </div>
                <div>
                    <h6 class="card-title mb-0">Total Items</h6>
                    <h3 class="mb-0"><?php echo $totalQuantity; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-1 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                    <i class="bi bi-arrow-down-up text-success fs-4"></i>
                </div>
                <div>
                    <h6 class="card-title mb-0">Stock Value</h6>
                    <h3 class="mb-0">$<?php echo number_format($totalValue, 2); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-1 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                    <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                </div>
                <div>
                    <h6 class="card-title mb-0">Low Stock</h6>
                    <h3 class="mb-0"><?= $lowStockCount ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-1 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                    <i class="bi bi-tags text-danger fs-4"></i>
                </div>
                <div>
                    <h6 class="card-title mb-0">Total Category</h6>
                    <h3 class="mb-0"><?= $categoryCount ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-1 shadow-sm">
            <div class="card-header bg-white border-0">
               <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'User'): ?>
                    <h5 class="card-title mb-0">Pending Request</h5>
                <?php else: ?>
                    <h5 class="card-title mb-0">Your Requests</h5>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'User'): ?>
                                    <th>User</th>
                                <?php else: ?>
                                    <th>Category</th>
                                <?php endif; ?>
                                <th>Quantity</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'User'): ?>
                            <tbody>
                                <?php
                                $hasUserRequests = false;
                                while ($row = $requestResult->fetch_assoc()):
                                    if ($row['userID'] == $_SESSION['userID']):
                                        $hasUserRequests = true;
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                                        <td>
                                            <span class="badge bg-warning"><?php echo htmlspecialchars($row['action']); ?></span>
                                        </td>
                                    </tr>
                                <?php
                                    endif;
                                endwhile;
                                
                                if (!$hasUserRequests):
                                ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No requests found for your account.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        <?php else: ?>
                            <tbody>
                                <?php while ($row = $requestResult->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                                        <td>
                                            <span class="badge bg-warning"><?php echo htmlspecialchars($row['action']); ?></span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
            <div class="card border-1 shadow-sm">
                <div class="card-header bg-white border-0">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'User'): ?>
                        <h5 class="card-title mb-0">Low Stock Items</h5>
                    <?php else: ?>
                        <h5 class="card-title mb-0">In Your Possession</h5>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <?php if ($lowStockCount > 0): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($lowStockItems as $item): ?>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <!-- Item Name (left) -->
                                        <div class="flex-grow-1" style="min-width: 100px;">
                                            <strong><?php echo htmlspecialchars($item['item_name']); ?></strong>
                                        </div>

                                        <!-- Category (middle) -->
                                        <div class="text-muted text-center" style="width: 150px;">
                                            <?= htmlspecialchars($item['category_name']) ?>
                                        </div>

                                        <!-- Quantity (right) -->
                                        <div style="width: 100px;" class="text-end">
                                            <span class="badge bg-danger rounded-pill">
                                                <?php echo htmlspecialchars($item['quantity']); ?> left
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                    <?php else: ?>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'User'): ?>
                            <div class="p-3 text-muted">All items are in stock.</div>
                        <?php else: ?>
                            <div class="p-3 text-muted">You have no items in your possession.</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'User'): ?>
                    <div class="card-footer bg-white">
                        <a href="#" class="btn btn-sm btn-primary">View All Low Stock Items</a>
                    </div>
                <?php else: ?>
                    <div class="card-footer bg-white">
                        <a href="#" class="btn btn-sm btn-primary">View All Your Items</a>
                    </div>
                <?php endif; ?>
            </div>
    </div>

</div>
</div>
</div>