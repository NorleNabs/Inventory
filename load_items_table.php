<?php
require 'server.php';

$itemsPerPage = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$sql = "
    SELECT ai.*, c.category_name
    FROM all_items ai
    LEFT JOIN category c ON ai.category_id = c.category_id
    ORDER BY ai.date
    LIMIT $itemsPerPage OFFSET $offset
";

$result = $conn->query($sql);

$totalItemsResult = $conn->query("SELECT COUNT(*) AS count FROM all_items");
$totalItems = $totalItemsResult->fetch_assoc()['count'];
$totalPages = ceil($totalItems / $itemsPerPage);
?>

<link rel="stylesheet" href="idex.css">

<table class="table inventory-table shadow-md">
    <thead class="table-light">
        <tr>
            <th>Item</th>
            <th>Brand</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="itemsTableBody">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td data-label="Item">
                        <div>
                            <span class="item-id"><?php echo htmlspecialchars($row['item_name']); ?></span>
                        </div>
                    </td>
                    <td data-label="Brand"><?php echo htmlspecialchars($row['item_brand']); ?></td>
                    <td>
                        <?php if (!empty($row['item_img'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($row['item_img']) ?>" alt="Item Image"
                                style="width: 100px; height: 70px; object-fit: cover; border-radius: 5px;">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td data-label="Quantity"><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td data-label="Price"><span class="price">$<?php echo number_format($row['price'], 2); ?></span></td>
                    <td data-label="Status">
                        <?php
                        $status = $row['status'];
                        $statusClass = match ($status) {
                            'In Stock' => 'status-badge-in-stock',
                            'Low Stock' => 'status-badge-low-stock',
                            'Out of Stock' => 'status-badge-out-stock',
                            default => 'status-badge',
                        };
                        ?>
                        <span class="status-badge <?php echo $statusClass; ?>"><?php echo $status; ?></span>
                    </td>
                    <td data-label="Category">
                        <span class="category-pill"><?= htmlspecialchars($row['category_name'] ?? ''); ?></span>
                    </td>
                    <td data-label="">
                        <div class="d-flex gap-2">
                            <button class="action-icon edit-button" title="Edit" data-bs-toggle="modal"
                                data-bs-target="#editItemModal" data-id="<?= htmlspecialchars($row['itemID']) ?>"
                                data-name="<?= htmlspecialchars($row['item_name']) ?>"
                                data-brand="<?= htmlspecialchars($row['item_brand']) ?>"
                                data-image="<?= $row['item_img'] ? base64_encode($row['item_img']) : '' ?>"
                                data-quantity="<?= htmlspecialchars($row['quantity']) ?>"
                                data-price="<?= htmlspecialchars($row['price']) ?>"
                                data-category="<?= htmlspecialchars($row['category_name']) ?>"
                                data-status="<?= htmlspecialchars($row['status']) ?>">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button class="btn  view-details-button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                data-id="<?= htmlspecialchars($row['itemID']) ?>"
                                data-name="<?= htmlspecialchars($row['item_name']) ?>"
                                data-brand="<?= htmlspecialchars($row['item_brand']) ?>"
                                data-category="<?= htmlspecialchars($row['category_name']) ?>"
                                data-quantity="<?= htmlspecialchars($row['quantity']) ?>"
                                data-price="<?= htmlspecialchars($row['price']) ?>"
                                data-status="<?= htmlspecialchars($row['status']) ?>"
                                data-date="<?= date('M d, Y', strtotime($row['date'])) ?>"
                                data-description="<?= htmlspecialchars($row['description']) ?>"
                                data-image="<?= base64_encode($row['item_img']) ?>">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan=" 8" class="text-center">No items found.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="table-footer mt-3">
    <div class="table-info">
        Showing <?php echo $page; ?> out of <?php echo $totalPages; ?> page<?php echo $totalPages > 1 ? 's' : ''; ?>
    </div>
    <div class="pagination" id="pagination">
        <?php if ($page > 1): ?>
            <a href="#" class="pagination-item" data-page="<?php echo $page - 1; ?>">
                <i class="fas fa-chevron-left"></i>
            </a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="#" class="pagination-item <?php echo $i === $page ? 'active' : ''; ?>" data-page="<?php echo $i; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="#" class="pagination-item" data-page="<?php echo $page + 1; ?>">
                <i class="fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
</div>

<?php $conn->close(); ?>