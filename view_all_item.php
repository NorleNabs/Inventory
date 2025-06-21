<?php
session_start();
if (!isset($_SESSION['userID'])) {
  header("Location: log_in.php");
  exit;
}
require 'server.php';

$itemsPerPage = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// SQL to retrieve all item fields and the category_name
$sql = "
    SELECT ai.*, c.category_name
    FROM all_items ai
    LEFT JOIN category c ON ai.category_id = c.category_id
    ORDER BY ai.date
    LIMIT $itemsPerPage OFFSET $offset
";

$result = $conn->query($sql);

// Get total count of all items for pagination
$totalItemsResult = $conn->query("SELECT COUNT(*) AS count FROM all_items");
$totalItems = $totalItemsResult->fetch_assoc()['count'];
$totalPages = ceil($totalItems / $itemsPerPage);
?>

<link rel="stylesheet" href="subcontent_inventory.css">

<div class="container">
  <div class="table-container border shadow-sm" id="itemsTableContainer">
    <table class="table inventory-table">
      <thead class="table-light">
        <tr>
          <th>Item</th>
          <th>Brand</th>
          <th>Image</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Status</th>
          <th>Category</th>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'User'): ?>
            <th>Actions</th>
          <?php endif; ?>
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
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'User'): ?>
              <td data-label="">
                  <button class="action-icon edit-button" title="Edit" data-bs-toggle="modal" data-bs-target="#editItemModal"
                    data-id="<?= htmlspecialchars($row['itemID']) ?>" data-name="<?= htmlspecialchars($row['item_name']) ?>"
                    data-brand="<?= htmlspecialchars($row['item_brand']) ?>"
                    data-image="<?= $row['item_img'] ? base64_encode($row['item_img']) : '' ?>"
                    data-quantity="<?= htmlspecialchars($row['quantity']) ?>"
                    data-price="<?= htmlspecialchars($row['price']) ?>"
                    data-category-id="<?= htmlspecialchars($row['category_id']) ?>"
                    data-category-name="<?= htmlspecialchars($row['category_name']) ?>"
                    data-status="<?= htmlspecialchars($row['status']) ?>">
                    <i class="fas fa-edit"></i>
                  </button>
                

                <button class="btn view-details-button action-icon" data-bs-toggle="offcanvas"
                  data-bs-target="#offcanvasRight" data-id="<?= htmlspecialchars($row['itemID']) ?>"
                  data-name="<?= htmlspecialchars($row['item_name']) ?>"
                  data-brand="<?= htmlspecialchars($row['item_brand']) ?>"
                  data-category="<?= htmlspecialchars($row['category_name']) ?>"
                  data-quantity="<?= htmlspecialchars($row['quantity']) ?>"
                  data-price="<?= htmlspecialchars($row['price']) ?>" data-status="<?= htmlspecialchars($row['status']) ?>"
                  data-date="<?= date('M d, Y', strtotime($row['date'])) ?>"
                  data-description="<?= htmlspecialchars($row['description']) ?>"
                  data-image="<?= base64_encode($row['item_img']) ?>">
                  <i class="fas fa-info-circle"></i>
                </button>
      
      </td>
      <?php endif; ?>
      </tr>
    <?php endwhile; ?>
  <?php else: ?>
    <tr>
      <td colspan="7" class="text-center">No items found.</td>
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
</div>
</div>



<div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editItemForm" method="POST" enctype="multipart/form-data" novalidate>
        <div class="modal-header">
          <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="itemID" id="editItemID">

          <div class="mb-3 text-center">
            <label class="form-label d-block">Current Image</label>
            <img id="editItemImagePreview" src="#" alt="Item Image" class="d-block mx-auto"
              style="max-width: 100%; height: auto; display: none; border: 1px solid #ddd; padding: 5px;">
          </div>

          <div class="mb-3">
            <label for="editItemImage" class="form-label">Update Image</label>
            <input type="file" class="form-control" id="editItemImage" name="item_image" accept="image/*" required
              onchange="validateFileSize(this)">
          </div>

          <div class="mb-3">
            <label for="editItemName" class="form-label">Item Name</label>
            <input type="text" class="form-control" id="editItemName" name="item_name" required>
          </div>

          <div class="mb-3">
            <label for="editItemBrand" class="form-label">Brand</label>
            <input type="text" class="form-control" id="editItemBrand" name="item_brand">
          </div>

          <div class="mb-3">
            <label for="editItemQuantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="editItemQuantity" name="quantity">
          </div>

          <div class="mb-3">
            <label for="editItemPrice" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="editItemPrice" name="price">
          </div>

          <div class="mb-3">
            <label for="editItemCategory" class="form-label">Category</label>
            <select class="form-select" id="editItemCategory" name="category" required>
              <option value="" disabled selected>Select a category</option>
              <?php
              include 'server.php';

              $categoryQuery = "SELECT category_id, category_name FROM category ORDER BY category_name ASC";
              $categoryResult = $conn->query($categoryQuery);

              if ($categoryResult && $categoryResult->num_rows > 0):
                while ($cat = $categoryResult->fetch_assoc()):
                  ?>
                  <option value="<?= htmlspecialchars($cat['category_id']) ?>">
                    <?= htmlspecialchars($cat['category_name']) ?>
                  </option>
                  <?php
                endwhile;
              endif;
              ?>
            </select>
          </div>


          <div class="mb-3">
            <label for="editItemStatus" class="form-label">Status</label>
            <select class="form-select" id="editItemStatus" name="status">
              <option>In Stock</option>
              <option>Low Stock</option>
              <option>Out of Stock</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Item</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasBottomLabel">Item Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body small" id="offcanvasContent">

  </div>
</div>