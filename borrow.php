<?php

session_start();
require 'server.php';

// Fetch unique category names from the category table
$sql = "
   SELECT DISTINCT c.category_id, c.category_name
    FROM all_items ai
    LEFT JOIN category c ON ai.category_id = c.category_id
    WHERE c.category_name IS NOT NULL
    ORDER BY c.category_name ASC

";

$result = $conn->query($sql);

$deptResult = $conn->query("SELECT * FROM department");

// Fetch department name based on session department ID
$departmentName = '';

if (isset($_SESSION['departmentID'])) {
    $departmentID = intval($_SESSION['departmentID']);
    $query = "SELECT department_name FROM department WHERE departmentID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $departmentID);
    $stmt->execute();
    $stmt->bind_result($departmentName);
    $stmt->fetch();
    $stmt->close();
}
?>


<link rel="stylesheet" href="subcontent_inventory.css">

<div class="main-container">
    <div class="form-header">
        <div class="form-logo">
            <i class="fas fa-exchange-alt fa-lg"></i>
        </div>
        <div>
            <h2 class="form-title">Borrowing Request</h2>
        </div>
    </div>


    <form id="borrowingForm" method="POST" action="borrow_request_handler.php">

        <div class="stepper">
            <div class="step completed">
                <div class="circle">1</div>
                <div class="label">Borrower Info</div>
            </div>
            <div class="step">
                <div class="circle">2</div>
                <div class="label">Borrowing Period</div>
            </div>
            <div class="step">
                <div class="circle">3</div>
                <div class="label">Item Details</div>
            </div>
            <div class="step">
                <div class="circle">4</div>
                <div class="label">Additional Info</div>
            </div>
            
        </div>
        <div class="carousel-container">
            <!-- Left Column -->
            <div class="carousel-step active">
                <div class="form-panel">
                    <div class="panel-header">
                        <div class="panel-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="panel-title">Borrower Information</h3>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="borrowerName" class="form-label">Full Name</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control has-icon" 
                                    name="borrowerName" 
                                    id="borrowerName"
                                    placeholder="Enter your name" 
                                    value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>"
                                    readonly
                                >
                                <input type="hidden"
                                name="userID" 
                                value="<?php echo isset($_SESSION['userID']) ? intval($_SESSION['userID']) : ''; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control has-icon" 
                                    name="email" 
                                    id="email"
                                    placeholder="Enter your email" 
                                    value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>"
                                    readonly
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <div class="input-with-icon">
                                <i class="fas fa-phone input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control has-icon" 
                                    name="phone" 
                                    id="phone"
                                    placeholder="Enter your Contact Number" 
                                    value="<?php echo isset($_SESSION['contactNo']) ? htmlspecialchars($_SESSION['contactNo']) : ''; ?>"
                                    readonly
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="department" class="form-label">Department</label>
                            <div class="input-with-icon">
                                <i class="fas fa-building input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control has-icon" 
                                    name="department" 
                                    id="department"
                                    placeholder="Enter your department" 
                                    value="<?php echo htmlspecialchars($departmentName); ?>"
                                    readonly
                                >
                                <input 
                                    type="hidden" 
                                    name="departmentID" 
                                    value="<?php echo isset($_SESSION['departmentID']) ? intval($_SESSION['departmentID']) : ''; ?>"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-step">
                <div class="form-panel">
                    <div class="panel-header">
                        <div class="panel-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3 class="panel-title">Borrowing Period</h3>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="borrowDate" class="form-label">Borrow Date<span
                                    class="required">*</span></label>
                            <div class="input-with-icon">
                                <i class="fas fa-calendar-plus input-icon"></i>
                                <input type="date" class="form-control has-icon" id="borrowDate" name="borrowDate"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="returnDate" class="form-label">Return Date<span
                                    class="required">*</span></label>
                            <div class="input-with-icon">
                                <i class="fas fa-calendar-check input-icon"></i>
                                <input type="date" class="form-control has-icon" id="returnDate" name="returnDate"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div id="dateWarning" class="alert alert-warning d-none">
                        <i class="fas fa-exclamation-triangle me-2"></i>Return date must be after borrowing date
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="extendable" name="extendable">
                        <label class="form-check-label" for="extendable">Extension possible if needed</label>
                    </div>
                </div>
            </div>
            <div class="carousel-step">
                <div class="form-column">
                    <!-- Item Details -->
                    <div class="form-panel">
                        <div class="panel-header">
                            <div class="panel-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <h3 class="panel-title">Item Details</h3>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category" required
                                    onchange="loadItemsByCategory(this.value)">
                                    <option selected disabled>Select a category</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        $catname = htmlspecialchars($row['category_name']);
                                        $catid = intval($row['category_id']);
                                        echo "<option value=\"$catid\">$catname</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="quantity" class="form-label">Quantity<span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fas fa-sort-numeric-up input-icon"></i>
                                    <input type="number" class="form-control has-icon" id="quantity" name="quantity"
                                        placeholder="1" min="1" value="1" required>
                                </div>
                                <label class="form-label" style="font-size: 12px;">Available Quantity: <span
                                        id="availableQuantity"></span></label>
                                <span></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="itemName" class="form-label">Item Name<span
                                        class="required">*</span></label>
                                <select class="form-select" id="itemName" name="itemID" required>
                                    <option selected disabled>Select Item</option>
                                </select>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="urgentRequest" name="urgentRequest">
                                    <label class="form-check-label" for="urgentRequest">Mark as urgent request</label>
                                 </div>
                                
                            </div>

                            

                            <div class="form-group">
                                <div class="item-image-form">
                                    <div id="imageCanvas" class="image-canvas">
                                        <span id="noImageText">No Image</span>
                                        <img id="itemImage" class="form-image" src="" alt="Item Image" style="display: none;">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="carousel-step">
                <div class=" form-panel">
                    <div class="panel-header">
                        <div class="panel-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h3 class="panel-title">Additional Information</h3>
                    </div>

                    <div class="form-group">
                        <label for="purpose" class="form-label">Purpose of Borrowing</label>
                        <select class="form-select" id="purpose" name="purpose" required>
                            <option selected disabled>Select purpose</option>
                            <option value="personal">Personal Use</option>
                            <option value="project">Project Work</option>
                            <option value="event">Event</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="remarks" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="remarks" rows="3" name="remarks"
                            placeholder="Remarks, N/A if none"></textarea>
                        <div class="form-text">Please include any special handling instructions or other relevant
                            information.</div>
                    </div>
                </div>
            </div>

            



            <!-- Form Footer -->
            <div class="form-footer">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                    <label class="form-check-label" for="agreeTerms">
                        I agree to return the item(s) in their original condition<span class="required">*</span>
                    </label>
                </div>

                <div>
                    <button type="reset" class="btn btn-outline borrow-btn me-2" id="prevBtn">
                        Back
                    </button>
                    <button  class="btn btn-primary borrow-btn" id="nextBtn">
                        Next
                    </button>
                </div>
            </div>
    </form>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Borrow Request</h5>
                    <button type="button" class="btn-close borrow-btn" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success borrow-btn" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>