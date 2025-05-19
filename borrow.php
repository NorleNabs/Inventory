<?php
require 'server.php';

// Fetch unique categories
$sql = "SELECT DISTINCT category FROM all_items ORDER BY category ASC";
$result = $conn->query($sql);
?>


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
            <div class="step">
                <div class="circle">5</div>
                <div class="label">Submited</div>
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
                            <label for="borrowerName" class="form-label">Full Name<span
                                    class="required">*</span></label>
                            <div class="input-with-icon">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" class="form-control has-icon" name="borrowerName" id="borrowerName"
                                    placeholder="Enter your name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address<span class="required">*</span></label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" class="form-control has-icon" id="email" name="email"
                                    placeholder="example@email.com" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <div class="input-with-icon">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="tel" class="form-control has-icon" id="phone" name="phone"
                                    placeholder="(123) 456-7890" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" required>
                                <option selected disabled>Select department</option>
                                <option value="admin">Administration</option>
                                <option value="it">IT</option>
                                <option value="hr">Human Resources</option>
                                <option value="marketing">Marketing</option>
                                <option value="other">Other</option>
                            </select>
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
                                        $cat = htmlspecialchars($row['category']);
                                        echo "<option value=\"$cat\">$cat</option>";
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
                                <label class="form-label">Available Quantity: <span
                                        id="availableQuantity">N/A</span></label>
                                <span></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="itemName" class="form-label">Item Name<span
                                        class="required">*</span></label>
                                <select class="form-select" id="itemName" name="itemName" required>
                                    <option selected disabled>Select Item</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="urgentRequest" name="urgentRequest">
                            <label class="form-check-label" for="urgentRequest">Mark as urgent request</label>
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
                            placeholder="Any additional details or special requirements..."></textarea>
                        <div class="form-text">Please include any special handling instructions or other relevant
                            information.</div>
                    </div>
                </div>
            </div>

            <div class="carousel-step">
                <div class="form-panel text-center">
                    <div class="panel-icon mb-3">
                        <i class="fas fa-check-circle fa-3x text-success"></i>
                    </div>
                    <h3 class="panel-title">Request Submitted!</h3>
                    <p class="mt-3">Your borrow request has been successfully submitted. You will receive a confirmation
                        shortly.</p>
                    <a href="#" class="btn btn-primary mt-3" onclick="location.reload()">Return to Dashboard</a>
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
                    <button type="submit" class="btn btn-primary borrow-btn" id="nextBtn">
                        Next
                    </button>
                </div>
            </div>
    </form>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close borrow-btn" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Request Submited successfully
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success borrow-btn" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #f8faff;
        --accent-color: #3a0ca3;
        --text-color: #2b2d42;
        --light-gray: #e9ecef;
        --border-color: #dee2e6;
    }

    .main-container {
        width: 100%;
        max-width: 1200px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(149, 157, 165, 0.15);
        overflow: hidden;
        margin: 0 auto;
    }

    .form-header {
        background-color: var(--primary-color);
        color: white;
        padding: 20px 30px;
        display: flex;
        align-items: center;
    }

    .form-logo {
        width: 48px;
        height: 48px;
        background-color: white;
        color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        margin: 0;
        font-weight: 600;
    }

    .form-subtitle {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .form-content {
        display: flex;
        padding: 30px;
        gap: 30px;
    }

    .form-column {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .form-panel {
        background-color: var(--secondary-color);
        border-radius: 8px;
        padding: 20px;
        border: 1px solid var(--border-color);
    }

    .panel-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }

    .panel-icon {
        color: white;
        background-color: var(--primary-color);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        font-size: 14px;
    }

    .panel-title {
        margin: 0;
        font-weight: 500;
        font-size: 1.1rem;
        color: var(--accent-color);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-color);
        margin-bottom: 6px;
        display: block;
    }

    .form-control,
    .form-select {
        border-radius: 6px;
        padding: 10px;
        border: 1px solid var(--border-color);
        font-size: 0.95rem;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        outline: none;
    }

    .input-with-icon {
        position: relative;
    }

    .input-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 10px;
        color: #adb5bd;
    }

    .has-icon {
        padding-left: 35px;
    }

    .required {
        color: #dc3545;
        margin-left: 3px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .row>* {
        flex: 1;
        min-width: 0;
    }

    .form-footer {
        background-color: var(--light-gray);
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border-color);
    }

    .borrow-btn {
        padding: 10px 20px;
        border-radius: 6px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .borrow-btn {
        background-color: var(--primary-color);
        color: white;
    }

    .borrow-btn:hover {
        background-color: var(--accent-color);
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.25);
    }

    .btn-outline {
        background-color: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-color);
    }

    .btn-outline:hover {
        background-color: var(--light-gray);
    }

    .form-switch {
        padding-left: 2.5em;
    }

    .form-switch .form-check-input {
        width: 2em;
        height: 1em;
        background-color: #e9ecef;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
        background-position: left center;
        border-radius: 2em;
        transition: background-position 0.15s ease-in-out;
    }

    .form-switch .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        background-position: right center;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.8rem;
        margin-top: 5px;
    }

    .alert {
        padding: 8px 12px;
        border-radius: 6px;
        margin-top: 10px;
        font-size: 0.85rem;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    @media (max-width: 992px) {
        .form-content {
            flex-direction: column;
        }

        .row {
            flex-direction: column;
        }

        .row>* {
            width: 100%;
        }

        .form-footer {
            flex-direction: column-reverse;
            gap: 15px;
        }

        .form-footer>* {
            width: 100%;
        }
    }

    .stepper {
        display: flex;
        justify-content: space-between;
        margin: 40px auto;
        max-width: 600px;
        position: relative;
        padding: 0 20px;
    }

    .stepper::before {
        content: "";
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        height: 4px;
        background-color: #dcdcdc;
        z-index: 0;
    }

    .step {
        position: relative;
        z-index: 1;
        text-align: center;
        flex: 1;
    }

    .step .circle {
        width: 40px;
        height: 40px;
        margin: 0 auto 10px;
        background-color: #dcdcdc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #555;
    }

    .step.active .circle {
        background-color: #0d6efd;
        color: #fff;
    }

    .step.completed .circle {
        background-color: rgb(41, 84, 183);
        color: #fff;
    }

    .step .label {
        font-size: 14px;
    }

    .carousel-step {
        display: none;
    }

    .carousel-step.active {
        display: block;
    }

    .carousel-nav {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
</style>