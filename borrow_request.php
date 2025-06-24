<?php
require_once 'server.php'; // Your database connection

// Fetch all borrow requests
$sql = "
  SELECT br.*, c.category_name
    FROM borrow_request br
    LEFT JOIN category c ON br.category_id = c.category_id
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


$countQuery = "SELECT COUNT(*) AS total FROM borrow_request";
$countResult = $conn->query($countQuery);
$totalRequests = 0;
$approvedRequests = 0;
$disapprovedRequests = 0;

if ($countResult && $countResult->num_rows > 0) {
    $row = $countResult->fetch_assoc();
    $totalRequests = $row['total'];
}

$approvedQuery = "SELECT COUNT(*) AS total FROM borrow_request WHERE action = 'Approved'";
$approvedResult = $conn->query($approvedQuery);
if ($approvedResult && $approvedResult->num_rows > 0) {
    $row = $approvedResult->fetch_assoc();
    $approvedRequests = $row['total'];
}

$disapprovedQuery = "SELECT COUNT(*) AS total FROM borrow_request WHERE action = 'Rejected'";
$disapprovedResult = $conn->query($disapprovedQuery);
if ($disapprovedResult && $disapprovedResult->num_rows > 0) {
    $row = $disapprovedResult->fetch_assoc();
    $disapprovedRequests = $row['total'];
}

?>

<!-- Summary Stats -->
<div class="row summary-stats">
    <div class="col-md-4 mb-3">
        <div class="stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-primary-soft me-3">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <h3 class="stat-value"><?= $totalRequests ?></h3>
                    <p class="stat-label">Total Requests</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-success-soft me-3">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <h3 class="stat-value"><?= $approvedRequests ?></h3>
                    <p class="stat-label">Approved Request</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-danger-soft me-3">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div>
                    <h3 class="stat-value"><?= $disapprovedRequests ?></h3>
                    <p class="stat-label">Disapproved Request</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card table-card">
    <div class="table-header d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <h5 class="mb-0 me-3">All Requests</h5>
            <div class="filter-buttons">
                <button class="table-filter-btn active" data-filter="all">All</button>
                <button class="table-filter-btn" data-filter="pending">Pending</button>
                <button class="table-filter-btn" data-filter="approved">Approved</button>
                <button class="table-filter-btn" data-filter="disapproved">Disapproved</button>
            </div>

        </div>
        <div class="d-flex">
            <div class="input-group">
                <input type="text" class="form-control border-end-0" placeholder="Search..." aria-label="Search">
                <span class="input-group-text bg-white border-start-0">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
    </div>

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
                                <td>
                                    <button class="table-action-btn" data-bs-toggle="tooltip" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <?php if ($row['action'] === 'Pending'): ?>
                                        <button class="table-action-btn approve-btn"
                                            data-id="<?php echo $row['borrow_requestId']; ?>" data-bs-toggle="tooltip"
                                            title="Approve">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                        <button class="table-action-btn disapprove-btn" data-id="<?= $row['borrow_requestId'] ?>" data-bs-toggle="tooltip" title="Reject">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>


                    <?php if (!isset($result) || !$result || $result->num_rows === 0): ?>
                        <tr>
                            <td colspan="7">
                                <div class="no-data">
                                    <i class="bi bi-inbox"></i>
                                    <h5>No Borrow Requests Found</h5>
                                    <p class="text-muted">There are no borrow requests at the moment.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>


        <div class="loading-spinner"></div>


        <div class="custom-pagination">
            <div class="page-info">
                Showing <span>1</span> to <span>10</span> of <span>42</span> entries
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --success-color: #4cc9f0;
        --light-bg: #f8f9fa;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --table-header-bg: #4361ee;
        --urgent-bg: #ff5a5f;
        --extension-bg: #ffaa5a;
    }

    .page-title {
        color: var(--primary-color);
        font-weight: 600;
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 4px;
        background-color: var(--primary-color);
        border-radius: 10px;
    }

    .summary-stats {
        margin-bottom: 2rem;
    }

    .stat-card {
        background-color: white;
        border-radius: 10px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .bg-primary-soft {
        background-color: rgba(67, 97, 238, 0.15);
        color: var(--primary-color);
    }

    .bg-success-soft {
        background-color: rgba(57, 240, 133, 0.15);
        color: var(--success-color);
    }

    .bg-danger-soft {
        background-color: rgba(241, 71, 77, 0.15);
        color: var(--urgent-bg);
    }

    .bg-warning-soft {
        background-color: rgba(255, 170, 90, 0.15);
        color: var(--extension-bg);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0;
        color: #333;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .table-card {
        background-color: white;
        border-radius: 10px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    .table-header {
        background-color: white;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #edf2f9;
    }

    .table-filter-btn {
        border-radius: 50px;
        padding: 0.375rem 1rem;
        font-size: 0.875rem;
        background-color: #f1f3fa;
        color: #6c757d;
        border: none;
        margin-right: 0.5rem;
    }

    .table-filter-btn.active {
        background-color: var(--primary-color);
        color: white;
    }

    .table-container {
        padding: 0;
    }

    .custom-table {
        margin-bottom: 0;

    }

    .custom-table thead th {
        background-color: var(--table-header-bg);
        color: black;
        font-weight: 600;
        border: none;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .custom-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-color: #edf2f9;
        color: #495057;
        font-size: 0.875rem;
    }

    .custom-table tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.03);
    }

    .table-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        background-color: #f1f3fa;
        border: none;
        margin-right: 0.25rem;
        transition: all 0.2s;
    }

    .table-action-btn:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #e0e8ff;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 0.75rem;
        font-size: 0.875rem;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0;
    }

    .user-email {
        font-size: 0.75rem;
        color: #6c757d;
        margin-bottom: 0;
    }

    .item-details {
        display: flex;
        flex-direction: column;
    }

    .item-name {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 2px;
    }

    .item-category {
        font-size: 0.75rem;
        color: #6c757d;
        background-color: #f1f3fa;
        border-radius: 50px;
        padding: 2px 8px;
        display: inline-block;
    }

    .date-badge {
        background-color: #e0e8ff;
        color: var(--primary-color);
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }

    .status-urgent {
        background-color: rgba(255, 90, 95, 0.15);
        color: black;
    }

    .status-extension {
        background-color: rgba(255, 170, 90, 0.15);
        color: black;
    }

    .status-success {
        background-color: rgba(76, 240, 169, 0.15);
        color: black;
    }

    .no-data {
        padding: 3rem 0;
        text-align: center;
        color: #6c757d;
    }

    .no-data i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d3e2;
    }

    /* Pagination styling */
    .custom-pagination {
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #edf2f9;
    }

    .page-info {
        color: #6c757d;
        font-size: 0.875rem;
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        border: none;
        color: #6c757d;
        padding: 0.375rem 0.75rem;
        margin: 0 0.125rem;
        border-radius: 4px;
    }

    .page-link:hover {
        background-color: #f1f3fa;
        color: var(--primary-color);
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        color: white;
    }

    /* Responsive optimizations */
    @media (max-width: 992px) {
        .custom-table {
            min-width: 1200px;
        }
    }

    /* Tooltip styling */
    .purpose-tooltip {
        position: relative;
        cursor: pointer;
    }

    .purpose-text {
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
    }

    /* Loading spinner */
    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid rgba(67, 97, 238, 0.1);
        border-radius: 50%;
        border-top-color: var(--primary-color);
        animation: spin 1s linear infinite;
        margin: 2rem auto;
        display: none;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>