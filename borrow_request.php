<?php
require_once 'server.php'; // Your database connection

// Fetch all borrow requests
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

$disapprovedQuery = "SELECT COUNT(*) AS total FROM borrow_request WHERE action = 'Disapproved'";
$disapprovedResult = $conn->query($disapprovedQuery);
if ($disapprovedResult && $disapprovedResult->num_rows > 0) {
    $row = $disapprovedResult->fetch_assoc();
    $disapprovedRequests = $row['total'];
}

$pendingQuery = "SELECT COUNT(*) AS total FROM borrow_request WHERE action = 'Pending'";
$pendingResult = $conn->query($pendingQuery);
if ($pendingResult && $pendingResult->num_rows > 0) {
    $row = $pendingResult->fetch_assoc();
    $pendingRequests = $row['total'];
}

?>



<!-- Summary Stats -->
<div class="row summary-stats">
    <div class="col-md-3 mb-4">
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
        <div class="col-md-3 mb-4">
        <div class="stat-card p-3">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-warning-soft me-3">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <h3 class="stat-value"><?= $pendingRequests ?></h3>
                    <p class="stat-label">Pending Request</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
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
    <div class="col-md-3 mb-4">
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
                                    <button class="table-action-btn view-request-details" title="View Details" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                    data-requestid="<?php echo $row['borrow_requestId']; ?>" data-requesterid="<?php echo $row['userID']; ?>"
                                    data-requestername="<?php echo htmlspecialchars($row['fullname']); ?>"
                                    data-requesteremail="<?php echo htmlspecialchars($row['email']); ?>"
                                    data-contact="<?php echo htmlspecialchars($row['contactNo']); ?>" 
                                    data-department="<?php echo htmlspecialchars($row['department_name']); ?>" 
                                    data-itemname="<?php echo htmlspecialchars($row['item_name']); ?>" data-quantity="<?php echo $row['quantity']; ?>"
                                    data-action="<?php echo htmlspecialchars($row['action']); ?>"
                                    data-borroweddate="<?php echo date('d M Y', strtotime($row['borrow_date'])); ?>"
                                    data-returneddate="<?php echo date('d M Y', strtotime($row['return_date'])); ?>" 
                                    data-requestremarks="<?php echo htmlspecialchars($row['remarks']); ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <?php if ($row['action'] === 'Pending'): ?>
                                        <button class="table-action-btn approve-btn"
                                            data-id="<?php echo $row['borrow_requestId']; ?>"
                                            data-quantity="<?php echo $row['quantity']; ?>"
                                            data-bs-toggle="tooltip"
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel">
                <i class="fas fa-file-alt me-2"></i>Borrow Request Details
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
  <div class="offcanvas-body small" id="offcanvasContentRequest">

  </div>
</div>

<style>
    

    
</style>