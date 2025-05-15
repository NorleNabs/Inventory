<?php
require 'server.php';

$result = $conn->query("SELECT * FROM all_items ORDER BY itemID");

if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()): ?>
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
                        style="width: 100px; height: auto;">
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
                <span class="category-pill"><?php echo htmlspecialchars($row['category']); ?></span>
            </td>
            <td data-label="">
                <div class="d-flex gap-2">
                    <button class="action-icon edit-button" title="Edit" data-bs-toggle="modal" data-bs-target="#editItemModal"
                        data-id="<?= htmlspecialchars($row['itemID']) ?>" data-name="<?= htmlspecialchars($row['item_name']) ?>"
                        data-brand="<?= htmlspecialchars($row['item_brand']) ?>"
                        data-image="<?= $row['item_img'] ? base64_encode($row['item_img']) : '' ?>"
                        data-quantity="<?= htmlspecialchars($row['quantity']) ?>"
                        data-price="<?= htmlspecialchars($row['price']) ?>"
                        data-category="<?= htmlspecialchars($row['category']) ?>"
                        data-status="<?= htmlspecialchars($row['status']) ?>">
                        <i class="fas fa-edit"></i>
                    </button>

                    <button type="button" class="btn action-icon" title="Other Details" data-bs-container="body"
                        data-bs-toggle="popover" data-bs-placement="bottom" data-bs-html="true" data-bs-content="
                            <div><strong>Item ID:</strong> <?= htmlspecialchars($row['itemID']) ?></div>
                            <div><strong>Date Added:</strong> <?= date('M d, Y', strtotime($row['date'])) ?></div>
                            <div><strong>Description:</strong> <?= htmlspecialchars($row['description']) ?></div>">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            </td>
        </tr>
    <?php endwhile;
else: ?>
    <tr>
        <td colspan="8" class="text-center">No items found.</td>
    </tr>
<?php endif;

$conn->close();
?>