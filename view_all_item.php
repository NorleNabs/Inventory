<?php
require 'server.php';

$itemsPerPage = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$sql = "SELECT * FROM all_items LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

$totalItemsResult = $conn->query("SELECT COUNT(*) as count FROM all_items");
$totalItems = $totalItemsResult->fetch_assoc()['count'];
$totalPages = ceil($totalItems / $itemsPerPage);

?>

<div class="container">
  <div class="table-container" id="itemsTableContainer">
    <table class="table inventory-table shadow-lg">
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
                <span class="category-pill"><?php echo htmlspecialchars($row['category']); ?></span>
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
                    data-category="<?= htmlspecialchars($row['category']) ?>"
                    data-status="<?= htmlspecialchars($row['status']) ?>">
                    <i class="fas fa-edit"></i>
                  </button>

                  <button class="btn view-details-button action-icon" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight" data-id="<?= htmlspecialchars($row['itemID']) ?>"
                    data-name="<?= htmlspecialchars($row['item_name']) ?>"
                    data-brand="<?= htmlspecialchars($row['item_brand']) ?>"
                    data-category="<?= htmlspecialchars($row['category']) ?>"
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
            <input type="text" class="form-control" id="editItemCategory" name="category">
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





<style>
  :root {
    --primary-color: #4361ee;
    --bg-light: #f8f9fa;
    --bg-light-hover: #f1f3f9;
    --text-dark: #1a1f36;
    --text-muted: #6b7280;
    --border-color: rgba(0, 0, 0, 0.05);
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
    --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
  }

  .inventory-table {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4 12px rgba(0, 0, 0, 0.01);
  }

  .inventory-table th,
  .inventory-table td {
    vertical-align: middle;
    padding: 0.75rem;
  }

  .item-id {
    font-weight: 600;
    color: #0d6efd;
  }

  .item-name {
    color: #6c757d;
    font-size: 0.9rem;
  }

  .status-badge {
    display: inline-block;
    padding: 0.35rem 0.65rem;
    font-size: 0.75rem;
    border-radius: 20px;
    font-weight: 600;
    text-align: center;
  }

  .status-badge-in-stock {
    background-color: #d1e7dd;
    color: #0f5132;
  }

  .status-badge-low-stock {
    background-color: #fff3cd;
    color: #664d03;
  }

  .status-badge-out-stock {
    background-color: #f8d7da;
    color: #842029;
  }

  .category-pill {
    padding: 0.35rem 0.75rem;
    background-color: #e2e3e5;
    color: #495057;
    border-radius: 20px;
    font-size: 0.8rem;
  }

  .price {
    font-weight: 500;
    color: #198754;
  }

  .action-icon {
    border: none;
    background: none;
    cursor: pointer;
    color: #6c757d;
  }

  .action-icon:hover {
    color: #0d6efd;
  }

  .table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
    flex-wrap: wrap;
  }

  .pagination {
    display: flex;
    gap: 0.5rem;
  }

  .pagination-item {
    border: none;
    background-color: #e9ecef;
    color: #212529;
    padding: 0.5rem 0.75rem;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.875rem;
  }

  .pagination-item.active,
  .pagination-item:hover {
    background-color: #0d6efd;
    color: white;
  }

  @media (max-width: 768px) {
    .inventory-table thead {
      display: none;
    }

    .inventory-table tbody tr {
      display: block;
      margin-bottom: 1rem;
      background: white;
      border: 1px solid #dee2e6;
      border-radius: 5px;
      padding: 1rem;
    }

    .inventory-table td {
      display: flex;
      justify-content: space-between;
      padding: 0.5rem 0;
    }

    .inventory-table td::before {
      content: attr(data-label);
      font-weight: 600;
      color: #495057;
    }
  }

  .offcanvas {
    border-radius: var(--radius-lg) 0 0 var(--radius-lg);
    box-shadow: -8px 0 24px rgba(0, 0, 0, 0.12);
    border: none;
    max-width: 450px;
  }

  .offcanvas-header {
    border-bottom: 1px solid var(--border-color);
    padding: 1.25rem 1.5rem;
  }

  .offcanvas-title {
    font-weight: 700;
    font-size: 1.25rem;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .offcanvas-title:before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 20px;
    background: var(--primary-color);
    border-radius: 3px;
  }

  .btn-close {
    background-color: var(--bg-light);
    opacity: 1;
    padding: 0.5rem;
    border-radius: var(--radius-sm);
    transition: all 0.2s ease;
  }

  .btn-close:hover {
    background-color: var(--bg-light-hover);
    transform: rotate(90deg);
  }

  .offcanvas-body {
    padding: 1.5rem;
  }

  /* Image container styling */
  .item-image-wrapper {
    width: 100%;
    text-align: center;
    margin-bottom: 1.75rem;
  }

  .item-image {
    max-width: 85%;
    height: auto;
    max-height: 240px;
    object-fit: contain;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
    transition: transform 0.2s ease;
  }

  .item-image:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  /* Item details grid */
  .item-details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.875rem;
  }

  /* Field styling */
  .detail-card {
    background-color: var(--bg-light);
    border-radius: var(--radius-sm);
    padding: 0.875rem;
    transition: all 0.2s ease;
    box-shadow: var(--shadow-sm);
  }

  .detail-card:hover {
    background-color: var(--bg-light-hover);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }

  .detail-card.full-width {
    grid-column: 1 / -1;
  }

  .detail-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    margin-bottom: 0.25rem;
  }

  .detail-value {
    font-size: 0.95rem;
    color: var(--text-dark);
    word-break: break-word;
  }

  .detail-value.price {
    color: var(--primary-color);
    font-size: 1.15rem;
    font-weight: 600;
  }

  .description-text {
    margin-top: 0.5rem;
    line-height: 1.6;
  }

  /* Demo button (for preview only) */
  .demo-trigger {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-sm);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .demo-trigger:hover {
    background-color: #3651c9;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }
</style>



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>