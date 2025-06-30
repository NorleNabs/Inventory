<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: log_in.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InVex</title>
    <link rel="icon" href="anong-context-nung-nakadila-si-alden-v0-q630lpmhcj0f1.png" type="image/png">
    <link rel="stylesheet" href="idex.css">
    <link rel="stylesheet" href="subcontent_management.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header d-flex align-items-center">
                <i class="bi bi-box-seam fs-2 me-2"></i>
                <span class="logo-text">InVex</span>
            </div>

            <ul class="list-unstyled components">
                <li class="nav-item">
                    <a href="dashboard.php" class="load-content">
                        <i class="bi bi-house-door fs-5"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="a" class="has-submenu" data-bs-toggle="collapse" data-bs-target="#inventorySubmenu">
                        <i class="bi bi-box fs-5"></i>
                        <span class="menu-text">Inventory</span>
                    </a>
                    <ul class="collapse list-unstyled submenu" id="inventorySubmenu">
                        <li>
                            <a href="view_all_item.php" class="load-content">
                                <i class="bi bi-list-ul fs-5 sub-icon"></i>
                                <span class="submenu-text">View All Items</span>
                            </a>
                        </li>
                        <li>
                            <a href="borrow.php" class="load-content">
                                <i class="bi bi-person-lines-fill fs-5 sub-icon"></i>
                                <span class="submenu-text">Borrow Item</span>
                            </a>
                        </li>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'User'): ?>
                            <li>
                                <a href="add_item.php" class="load-content">
                                    <i class="bi bi-plus-circle fs-5 sub-icon"></i>
                                    <span class="submenu-text">Add New Item</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'User'): ?>
                    <li class="nav-item">
                        <a href="#" class="has-submenu" data-bs-toggle="collapse" data-bs-target="#stockSubmenu">
                            <i class="bi bi-stack fs-5"></i>
                            <span class="menu-text">Management</span>
                        </a>
                        <ul class="collapse list-unstyled submenu" id="stockSubmenu">
                            <li>
                                <a href="borrow_request.php" class="load-content">
                                    <i class="bi bi-arrow-down-up fs-5 sub-icon"></i>
                                    <span class="submenu-text">Borrow Request</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="load-content">
                                    <i class="bi bi-clipboard-check fs-5 sub-icon"></i>
                                    <span class="submenu-text">For Release</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="bi bi-exclamation-triangle fs-5 sub-icon"></i>
                                    <span class="submenu-text">Low Stock Alerts</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'User'): ?>
                    <li class="nav-item">
                        <a href="report.html" class="load-content">
                            <i class="bi bi-graph-up fs-5"></i>
                            <span class="menu-text">Reports</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="user_management.php" class="load-content">
                            <i class="bi bi-person-fill-gear fs-5"></i>
                            <span class="menu-text">User Management</span>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
            <div class="sidebar-footer">
                <a id="sidebarCollapse" class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left-right"></i>
                    <span class="ms-2">Minimize</span>
                </a>
            </div>
        </nav>


        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 rounded">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapseResponsive" class="btn btn-primary d-md-none">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="ms-2">
                        <h4 class="mb-0" id="pageTitle">Dashboard</h4>
                    </div>
                    <div class="ms-auto d-flex">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell"></i>
                                <span class="badge bg-danger">3</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">Low stock alert: Item #1234</a></li>
                                <li><a class="dropdown-item" href="#">New order received</a></li>
                                <li><a class="dropdown-item" href="#">Shipment arrived</a></li>
                            </ul>
                        </div>
                        <div class="dropdown ms-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="confirmLogout()">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div id="subcontent">

            </div>


        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="inventory.js"></script>



    <script>


        document.addEventListener("DOMContentLoaded", function () {
            const subcontent = document.getElementById('subcontent');
            const pageTitles = {
                'dashboard.php': 'Dashboard',
                'view_all_item.php': 'All Items',
                'add_item.php': 'Add New Item',
                'borrow.php': 'Borrow Item',
                'report.html': 'Reports',
                'borrow_request.php': 'Borrow Request',
                'user_management.php': 'User Management',

                // Add more as needed
            };


            const initialPage = 'dashboard.php';
            loadPage(initialPage);
            const dashboardLink = document.querySelector('a[href="dashboard.php"]');
            if (dashboardLink) {
                dashboardLink.classList.add('active');
            }


            document.querySelectorAll('.load-content').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelectorAll('.load-content').forEach(item => item.classList.remove('active'));

                    this.classList.add('active');
                    const page = this.getAttribute('href');
                    window.location.hash = page;
                    loadPage(page);

                });
            });




            function loadPage(url) {
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        subcontent.innerHTML = html;
                        document.getElementById('pageTitle').textContent = pageTitles[url] || 'Page';

                        if (url === 'report.html') {
                            initCharts();
                        }






                       


                        function validateFileSize(input) {
                            const maxSize = 5 * 1024 * 1024;
                            if (input.files[0] && input.files[0].size > maxSize) {
                                alert("The selected file is too large. Maximum allowed size is 5 MB.");
                                input.value = '';
                            }
                        }

                        const editItemForm = document.getElementById('editItemForm');

                        if (editItemForm) {
                            editItemForm.addEventListener('submit', function (e) {
                                e.preventDefault();

                                const formData = new FormData(editItemForm);

                                fetch('update_item.php', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                    .then(async res => {
                                        const text = await res.text();
                                        console.log('Raw response:', text);
                                        return JSON.parse(text);
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            editItemForm.reset();
                                            editItemForm.classList.remove('was-validated');
                                            refreshItemsTable();
                                            const modal = bootstrap.Modal.getInstance(document.getElementById('editItemModal'));
                                            modal.hide();
                                            showAlertEditItem()


                                        } else {
                                            alert('Error: ' + (data.message || 'Unknown error.'));
                                        }
                                    })
                                    .catch(() => {
                                        alert('Update failed. Please try again.');
                                    });
                            });
                        }

                        const addItemform = document.getElementById('addItemForm');


                        if (addItemform) {
                            addItemform.addEventListener('submit', function (e) {
                                e.preventDefault();

                                const formData = new FormData(addItemform);

                                fetch('add_item_handler.php', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            addItemform.reset();
                                            addItemform.classList.remove('was-validated');
                                            showAlertAddedItem()
                                        } else {
                                            alert('Error: ' + (data.error || 'Unknown error.'));
                                        }
                                    })
                                    .catch(() => {
                                        alert('Submission failed. Try again.');
                                    });
                            });
                        }



                        const addCategoryForm = document.getElementById('addCategoryForm');
                        const categorySelect = document.getElementById('category');

                        if (addCategoryForm) {
                            addCategoryForm.addEventListener('submit', function (e) {
                                e.preventDefault();

                                const formData = new FormData(addCategoryForm);

                                fetch('add_category.php', {
                                    method: 'POST',
                                    body: formData,
                                })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                                            modal.hide();
                                            showAlertAddedCategory()

                                            addCategoryForm.reset(); // Keep this to clear only the category modal form

                                            // Create and insert new option
                                            const newOption = document.createElement('option');
                                            newOption.value = data.id;
                                            newOption.textContent = data.name;

                                            const addNewOption = categorySelect.querySelector('option[value="add_new_category"]');
                                            categorySelect.insertBefore(newOption, addNewOption);

                                            // Select the newly added category
                                            categorySelect.value = data.id;
                                            categorySelect.dispatchEvent(new Event('change'));
                                        } else {
                                            alert('Failed to add category: ' + data.error);
                                        }
                                    })
                                    .catch(() => alert('Something went wrong. Please try again.'));
                            });
                        }


                        document.querySelectorAll('.table-filter-btn').forEach(button => {
                            button.addEventListener('click', () => {
                                document.querySelectorAll('.table-filter-btn').forEach(btn => btn.classList.remove('active'));
                                button.classList.add('active');

                                const filter = button.getAttribute('data-filter');
                                const rows = document.querySelectorAll('table tbody tr');

                                rows.forEach(row => {
                                    const status = row.getAttribute('data-status');


                                    if (filter === 'all' || status === filter) {
                                        row.style.display = '';
                                    } else {
                                        row.style.display = 'none';
                                    }
                                });
                            });
                        });




                        if (url === 'borrow.php') {
                            const steps = document.querySelectorAll('.carousel-step');
                            const stepIndicators = document.querySelectorAll('.stepper .step');
                            const prevBtn = document.getElementById('prevBtn');
                            const nextBtn = document.getElementById('nextBtn');
                            const formFooter = document.querySelector('.form-footer');
                            const itemSelect = document.getElementById('itemName');
                            const quantitySpan = document.getElementById('availableQuantity');
                            let currentStep = 0;

                            prevBtn.addEventListener('click', () => {
                                if (currentStep > 0) {
                                    currentStep--;
                                    showStep(currentStep);
                                }
                            });

                            nextBtn.addEventListener('click', () => {
                                if (currentStep < steps.length - 1) {
                                    currentStep++;
                                    showStep(currentStep); 
                                }
                            });


                            function updateStepper(index) {
                                stepIndicators.forEach((step, i) => {
                                    step.classList.remove('active', 'completed');
                                    if (i < index) step.classList.add('completed');
                                    if (i === index) step.classList.add('active');
                                });
                            }

                            function showStep(index) {
                                steps.forEach((step, i) => {
                                    step.classList.toggle('active', i === index);
                                });
                                updateStepper(index);
                                prevBtn.disabled = index === 0;
                                formFooter.style.display = currentStep === steps.length - 0 ? 'none' : 'flex';
                                nextBtn.textContent = index === steps.length - 1 ? 'Submit Request' : 'Next';

                                updateNextButtonState();


                            }

                            function validateCurrentStep() {
                                const currentStepEl = steps[currentStep];
                                const inputs = currentStepEl.querySelectorAll('input, select, textarea');

                                for (const input of inputs) {
                                    if (input.hasAttribute('required')) {
                                        if (input.tagName.toLowerCase() === 'select') {
                                            const selectedOption = input.options[input.selectedIndex];
                                            if (!selectedOption || selectedOption.disabled) {
                                                return false;
                                            }
                                        } else if (input.value.trim() === '') {
                                            return false;
                                        }
                                    }
                                }
                                return true;
                            }

                            document.getElementById('agreeTerms').addEventListener('change', updateNextButtonState);

                            function updateNextButtonState() {
                                const currentStepElement = steps[currentStep];
                                const inputs = currentStepElement.querySelectorAll('select, textarea');

                                let allFilled = true;

                                inputs.forEach(input => {
                                    if (
                                        (input.type === 'checkbox' && input.required && !input.checked) ||
                                        (input.type !== 'checkbox' && (!input.value || input.value === 'Select department' || input.value === 'Select Item' || input.value === 'Select purpose'))
                                    ) {
                                        allFilled = false;
                                    }
                                });


                                const agreeTerms = document.getElementById('agreeTerms');
                                if (agreeTerms && !agreeTerms.checked) {
                                    allFilled = false;
                                }

                                nextBtn.disabled = !allFilled;
                            }


                            function attachStepValidationListeners() {
                                steps.forEach(step => {
                                    const fields = step.querySelectorAll('input, select, textarea');
                                    fields.forEach(field => {
                                        field.addEventListener('input', updateNextButtonState);
                                        field.addEventListener('change', updateNextButtonState);
                                        field.addEventListener('keyup', updateNextButtonState);
                                    });
                                });


                            }

                            attachStepValidationListeners();
                            showStep(currentStep);

                            document.getElementById('itemName').addEventListener('change', function () {
                                const selectedOption = this.options[this.selectedIndex];
                                const quantity = selectedOption.dataset.quantity || 'N/A';
                                const itemImage = selectedOption.dataset.item_img || '';
                                const img = document.getElementById('itemImage');
                                const noImageText = document.getElementById('noImageText');
                                document.getElementById('availableQuantity').textContent = quantity;
                                if (itemImage) {
                                    img.src = "data:image/jpeg;base64," + itemImage;
                                    img.style.display = 'block';
                                    noImageText.style.display = 'none';
                                } else {
                                    img.src = "";
                                    img.style.display = 'none';
                                    noImageText.style.display = 'block';
                                }
                            });

                             const borrowRequestform = document.getElementById('borrowingForm');
                             const imageSrc = document.getElementById('itemImage').src;
                            if (borrowRequestform) {
                                borrowRequestform.addEventListener('submit', function (e) {
                                    e.preventDefault();

                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'Do you want to submit this Request?',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, submit',
                                        cancelButtonText: 'Cancel'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            const formData = new FormData(borrowRequestform);                                           
                                                formData.append('imageSrc', imageSrc);                                           

                                            fetch('borrow_request_handler.php', {
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    'X-Requested-With': 'XMLHttpRequest'
                                                }
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                if (data.success) {
                                                    borrowRequestform.reset();
                                                    borrowRequestform.classList.remove('was-validated');
                                                    showAlertBorrowRequest();
                                                    loadPage('dashboard.php');
                                                } else {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: data.error || 'Unknown error.'
                                                    });
                                                }
                                            })
                                            .catch(() => {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Submission failed',
                                                    text: 'Try again.'
                                                });
                                            });
                                        }
                                        // If cancelled, do nothing
                                    });
                                });
                            }

                            



                        }

                        if (url === 'view_all_item.php') {

                            function bindEditButtons() {
                                const editButtons = document.querySelectorAll('.edit-button');

                                editButtons.forEach(button => {
                                    button.addEventListener('click', function () {
                                        document.getElementById('editItemID').value = this.dataset.id;
                                        document.getElementById('editItemName').value = this.dataset.name;
                                        document.getElementById('editItemBrand').value = this.dataset.brand;
                                        document.getElementById('editItemQuantity').value = this.dataset.quantity;
                                        document.getElementById('editItemPrice').value = this.dataset.price;
                                        document.getElementById('editItemCategory').value = this.dataset.categoryId;
                                        document.getElementById('editItemStatus').value = this.dataset.status;

                                        const imagePreview = document.getElementById('editItemImagePreview');
                                        if (this.dataset.image) {
                                            imagePreview.src = 'data:image/jpeg;base64,' + this.dataset.image;
                                            imagePreview.style.display = 'block';
                                        } else {
                                            imagePreview.style.display = 'none';
                                        }
                                    });
                                });
                            }



                            function bindViewDetailsButtons() {
                                document.querySelectorAll('.view-details-button').forEach(button => {
                                    button.addEventListener('click', function () {
                                        const imageBase64 = this.dataset.image;
                                        const content = `
                                            <div class="item-image-wrapper">
                                                <img src="data:image/jpeg;base64,${imageBase64}" alt="Item Image" class="item-image">
                                            </div>
                                            
                                            <!-- Details grid -->
                                            <div class="item-details-grid">
                                                <div class="detail-card">
                                                <div class="detail-label">Item ID</div>
                                                <div class="detail-value">${this.dataset.id}</div>
                                                </div>
                                                
                                                <div class="detail-card">
                                                <div class="detail-label">Name</div>
                                                <div class="detail-value">${this.dataset.name}</div>
                                                </div>
                                                
                                                <div class="detail-card">
                                                <div class="detail-label">Brand</div>
                                                <div class="detail-value">${this.dataset.brand}</div>
                                                </div>
                                                
                                                <div class="detail-card">
                                                <div class="detail-label">Category</div>
                                                <div class="detail-value">${this.dataset.category}</div>
                                                </div>
                                                
                                                <div class="detail-card">
                                                <div class="detail-label">Quantity</div>
                                                <div class="detail-value">${this.dataset.quantity}</div>
                                                </div>
                                                
                                                <div class="detail-card">
                                                <div class="detail-label">Price</div>
                                                <div class="detail-value price">$${parseFloat(this.dataset.price).toFixed(2)}</div>
                                                </div>
                                                
                                                <div class="detail-card">
                                                <div class="detail-label">Status</div>
                                                <div class="detail-value">${this.dataset.status}</div>
                                                </div>
                                                
                                                <div class="detail-card">
                                                <div class="detail-label">Date Added</div>
                                                <div class="detail-value">${this.dataset.date}</div>
                                                </div>
                                                
                                                <div class="detail-card full-width">
                                                <div class="detail-label">Description</div>
                                                <div class="detail-value description-text">${this.dataset.description.replace(/\n/g, '<br>')}</div>
                                                </div>
                                            </div>
                                        `;
                                        document.getElementById('offcanvasContent').innerHTML = content;
                                    });
                                });
                            }



                            function refreshItemsTable() {
                                fetch('load_items_table.php')
                                    .then(res => res.text())
                                    .then(html => {
                                        const parser = new DOMParser();
                                        const doc = parser.parseFromString(html, 'text/html');

                                        // Update only the tbody content
                                        const newTbody = doc.getElementById('itemsTableBody');
                                        document.getElementById('itemsTableBody').innerHTML = newTbody.innerHTML;

                                        // Also update pagination and table info (optional)
                                        const newPagination = doc.getElementById('pagination');
                                        if (newPagination) {
                                            document.getElementById('pagination').innerHTML = newPagination.innerHTML;
                                        }

                                        const newInfo = doc.querySelector('.table-info');
                                        const oldInfo = document.querySelector('.table-info');
                                        if (newInfo && oldInfo) {
                                            oldInfo.innerHTML = newInfo.innerHTML;
                                        }

                                        // Rebind buttons
                                        bindEditButtons();
                                        bindViewDetailsButtons();
                                        bindPaginationEvents();
                                    })
                                    .catch(err => console.error('Refresh fetch error:', err));
                            }



                            function bindPaginationEvents() {
                                const links = document.querySelectorAll('.pagination-item');
                                links.forEach(link => {
                                    link.addEventListener('click', function (e) {
                                        e.preventDefault();
                                        const page = this.getAttribute('data-page');

                                        fetch(`load_items_table.php?page=${page}`)
                                            .then(response => response.text())
                                            .then(html => {
                                                const parser = new DOMParser();
                                                const doc = parser.parseFromString(html, 'text/html');


                                                document.getElementById('itemsTableBody').innerHTML =
                                                    doc.getElementById('itemsTableBody').innerHTML;


                                                document.getElementById('pagination').innerHTML =
                                                    doc.getElementById('pagination').innerHTML;


                                                const newInfo = doc.querySelector('.table-info');
                                                const oldInfo = document.querySelector('.table-info');
                                                if (newInfo && oldInfo) {
                                                    oldInfo.innerHTML = newInfo.innerHTML;
                                                }
                                                // Rebind events
                                                bindEditButtons();
                                                bindViewDetailsButtons()
                                                bindPaginationEvents();

                                                document.querySelectorAll('.pagination-item').forEach(link => {
                                                    link.classList.remove('active');
                                                    if (link.getAttribute('data-page') == page && !link.querySelector('i')) {
                                                        link.classList.add('active');
                                                    }
                                                });

                                            })
                                            .catch(err => console.error('Pagination fetch error:', err));
                                    });
                                });
                            }

                            bindEditButtons();
                            bindViewDetailsButtons()
                            bindPaginationEvents();
                        }

                        if (url === 'user_management.php') {
                            const addDepartmentForm = document.getElementById('addDepartmentForm');
                            const departmentSelect = document.getElementById('department');

                            if (addDepartmentForm) {
                                addDepartmentForm.addEventListener('submit', function (e) {
                                    e.preventDefault();

                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'Do you want to add this department?',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, add it',
                                        cancelButtonText: 'Cancel'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            const formData = new FormData(addDepartmentForm);

                                            fetch('add_department.php', {
                                                method: 'POST',
                                                body: formData,
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                if (data.success) {
                                                    // Hide modal
                                                    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('addDepartmentModal'));
                                                    modalInstance.hide();

                                                    // Success alert
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Department added successfully!',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    });

                                                    addDepartmentForm.reset();

                                                    // Add new option to select
                                                    const newOption = document.createElement('option');
                                                    newOption.value = data.id;
                                                    newOption.textContent = data.name;

                                                    // Insert before the "Add new department" option
                                                    const addNewOption = departmentSelect.querySelector('option[value="add_new_department"]');
                                                    departmentSelect.insertBefore(newOption, addNewOption);

                                                    // Select the newly added department
                                                    departmentSelect.value = data.id;
                                                    departmentSelect.dispatchEvent(new Event('change'));
                                                } else {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error adding department',
                                                        text: data.error || 'Unknown error.'
                                                    });
                                                }
                                            })
                                            .catch(() => {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Something went wrong',
                                                    text: 'Please try again.'
                                                });
                                            });
                                        }
                                    });
                                });
                            }


                            const addPositionForm = document.getElementById('addPositionForm');

                            if (addPositionForm) {
                                addPositionForm.addEventListener('submit', function (e) {
                                    e.preventDefault();

                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'Do you want to add this position?',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, add it',
                                        cancelButtonText: 'Cancel'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            const formData = new FormData(addPositionForm);
                                            const departmentSelect = document.getElementById('department');
                                            if (departmentSelect) {
                                                formData.append('position_department', departmentSelect.value);
                                            }

                                            fetch('add_position.php', {
                                                method: 'POST',
                                                body: formData,
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                if (data.success) {
                                                    const modal = bootstrap.Modal.getInstance(document.getElementById('addPositionModal'));
                                                    modal.hide();

                                                    // Show success alert
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Position added successfully!',
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    });

                                                    addPositionForm.reset();

                                                    // Add new option to the select
                                                    const positionSelect = document.getElementById('position');
                                                    if (positionSelect) {
                                                        const newOption = document.createElement('option');
                                                        newOption.value = data.id;
                                                        newOption.textContent = data.name;

                                                        const addNewOption = positionSelect.querySelector('option[value="add_new_position"]');
                                                        positionSelect.insertBefore(newOption, addNewOption);
                                                        positionSelect.value = data.id;
                                                        positionSelect.dispatchEvent(new Event('change'));
                                                    }
                                                } else {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Failed to add position',
                                                        text: data.error || 'Unknown error.'
                                                    });
                                                }
                                            })
                                            .catch(() => {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Something went wrong',
                                                    text: 'Please try again.'
                                                });
                                            });
                                        }
                                    });
                                });
                            }




                            const addUserForm = document.getElementById('addUserForm');

                            if (addUserForm) {
                                addUserForm.addEventListener('submit', function (e) {
                                e.preventDefault();

                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "Do you want to add this user?",
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, add user',
                                    cancelButtonText: 'Cancel'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const formData = new FormData(addUserForm);

                                        fetch('add_user_handler.php', {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest'
                                            }
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            if (data.success) {
                                                
                                                const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
                                                if (modal) modal.hide();

                                                
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'User added successfully!',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });

                                                
                                                addUserForm.reset();
                                                addUserForm.classList.remove('was-validated');
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: data.error || 'Unknown error.'
                                                });
                                            }
                                        })
                                        .catch(() => {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Submission failed',
                                                text: 'Try again.'
                                            });
                                        });
                                    }
                                });
                            });
                        }



                        }

                        if (url === 'borrow_request.php') {
                            document.querySelectorAll('.approve-btn').forEach(button => {
                                button.addEventListener('click', function () {
                                    const requestId = this.getAttribute('data-id');
                                    const quantity = this.getAttribute('data-quantity');
                                    const approveButton = this;
                                    console.log('Request ID:', requestId);
                                    Swal.fire({
                                        title: 'Are you sure to approve this request?',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes',
                                        cancelButtonText: 'No'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            const formData = new FormData();
                                            formData.append('request_id', requestId);
                                            formData.append('quantity', quantity);

                                            fetch('approverequest_handler.php', {
                                                method: 'POST',
                                                body: formData,
                                            })
                                                .then(res => res.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        Swal.fire('Approved!', 'The request has been approved.', 'success');
                                                        loadPage('borrow_request.php');
                                                        
                                                        // const statusCell = document.getElementById('status-' + requestId);
                                                        // if (statusCell) statusCell.textContent = 'Approved';

                                                        // approveButton.disabled = true;
                                                        // approveButton.title = "Already Approved";
                                                    } else {
                                                        Swal.fire('Error', data.error || 'Approval failed.', 'error');
                                                    }
                                                })
                                                .catch(() => {
                                                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                                                });
                                        }
                                    });
                                });
                            });
                            document.querySelectorAll('.disapprove-btn').forEach(button => {
                                button.addEventListener('click', function () {
                                    const requestId = this.getAttribute('data-id');
                                    const disapproveButton = this;

                                    Swal.fire({
                                        title: 'Are you sure to disapprove this request?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, Disapprove',
                                        cancelButtonText: 'Cancel'
                                    }).then(result => {
                                        if (result.isConfirmed) {
                                            const formData = new FormData();
                                            formData.append('request_id', requestId);

                                            fetch('disapprovedrequest_handler.php', {
                                                method: 'POST',
                                                body: formData,
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                if (data.success) {
                                                    Swal.fire('Disapproved', 'The request has been Disapproved.', 'success');
                                                    loadPage('borrow_request.php');
                                                    // const statusCell = document.getElementById('status-' + requestId);
                                                    // if (statusCell) statusCell.textContent = 'Disapproved';

                                                    // disapproveButton.disabled = true;
                                                    // disapproveButton.title = "Already Disapproved";
                                                } else {
                                                    Swal.fire('Error', data.error || 'Disapproval failed.', 'error');
                                                }
                                            })
                                            .catch(() => {
                                                Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                                            });
                                        }
                                    });
                                });
                            });

                            function bindViewRequestDetailsButtons() {
                                document.querySelectorAll('.view-request-details').forEach(button => {
                                    button.addEventListener('click', function () {
                                        const imageBase64 = this.dataset.image;
                                        const content = `
                                            
                                            <div class="item-details-grid">
                                                
                                                <div class="detail-card full-width">
                                                    <div class="detail-label"><h4>Borrowers Information</h4></div>
                                                    <div class="detail-value"><span style="font-weight: bold;">Name:</span> ${this.dataset.requestername}</div>
                                                    <div class="detail-value"><span style="font-weight: bold;">Email:</span> ${this.dataset.requesteremail}</div>
                                                    <div class="detail-value"><span style="font-weight: bold;">Contact:</span> ${this.dataset.contact}</div>
                                                    <div class="detail-value"><span style="font-weight: bold;">Department:</span> ${this.dataset.department}</div>
                                                </div>
                                                
                                                
                                                <div class="detail-card full-width">
                                                    <div class="detail-label"><h4>Request Details</h4></div>
                                                    <div class="detail-value"><span style="font-weight: bold;">Request No.:</span> ${this.dataset.requestid}</div>
                                                    <div class="detail-value"><span style="font-weight: bold;">Item Name:</span> ${this.dataset.itemname}</div>
                                                    <div class="detail-value"><span style="font-weight: bold;">Quantity:</span> ${this.dataset.quantity}</div>
                                                    <div class="detail-value"><span style="font-weight: bold;">Status:</span> ${this.dataset.action}</div>
                                                    <div class="detail-value">
                                                        <img src="${imageBase64}" alt="Item Image" style="max-width: 100%; height: auto; margin-top: 10px; border-radius: 8px;"/>
                                                    </div>
                                                </div>
                                                
                                                <div class="detail-card">
                                                <div class="detail-label">Borrowed Date</div>
                                                <div class="detail-value">${this.dataset.borroweddate}</div>
                                                </div>
                                                
                                                <div class="detail-card">
                                                <div class="detail-label">Return Date</div>
                                                <div class="detail-value">${this.dataset.returneddate}</div>
                                                </div>
                                                
                                                <div class="detail-card full-width">
                                                <div class="detail-label">Description</div>
                                                <div class="detail-value description-text">${this.dataset.requestremarks.replace(/\n/g, '<br>')}</div>
                                                </div>
                                            </div>
                                        `;
                                        document.getElementById('offcanvasContentRequest').innerHTML = content;
                                    });
                                });
                            }

                            bindViewRequestDetailsButtons()

                        }

                        function handleCategoryChange(selectElement) {
                            if (selectElement.value === "add_new_category") {
                                selectElement.selectedIndex = 0;
                                const modal = new bootstrap.Modal(document.getElementById('addCategoryModal'));
                                modal.show();
                            }
                        }

                        if (url === 'add_item.php') {
                            const categorySelect = document.getElementById('category');
                            if (categorySelect) {
                                categorySelect.addEventListener('change', function () {
                                    handleCategoryChange(this);
                                });
                            }
                        }

                        function handleDepartmentChange(select) {
                            const departmentId = select.value;
                            const positionSelect = document.getElementById('position');

                            // If "Add new department" is selected, show the modal
                            if (departmentId === 'add_new_department') {
                                const deptModal = new bootstrap.Modal(document.getElementById('addDepartmentModal'));
                                deptModal.show();
                                select.value = "";
                                positionSelect.disabled = true;
                                return;
                            }

                            // Enable the position dropdown
                            positionSelect.disabled = false;
                            // Otherwise, fetch positions based on selected department

                            positionSelect.innerHTML = '<option disabled selected>Loading positions...</option>';

                            const formData = new FormData();
                            formData.append('department_id', departmentId);

                            fetch('get_positions.php', {
                                method: 'POST',
                                body: formData
                            })
                                .then(res => res.json())
                                .then(data => {
                                    positionSelect.innerHTML = ''; // Clear all options

                                    if (data.success && data.positions.length > 0) {
                                        const defaultOption = document.createElement('option');
                                        defaultOption.disabled = true;
                                        defaultOption.selected = true;
                                        defaultOption.textContent = "Select position";
                                        positionSelect.appendChild(defaultOption);

                                        data.positions.forEach(pos => {
                                            const opt = document.createElement('option');
                                            opt.value = pos.positionId;
                                            opt.textContent = pos.position_name;
                                            positionSelect.appendChild(opt);
                                        });
                                    } else {
                                        const opt = document.createElement('option');
                                        opt.disabled = true;
                                        opt.selected = true;
                                        opt.textContent = "No positions available";
                                        positionSelect.appendChild(opt);
                                    }

                                    // Add "Add new position" option
                                    const addNewOption = document.createElement('option');
                                    addNewOption.value = "add_new_position";
                                    addNewOption.classList.add('text-primary');
                                    addNewOption.textContent = "+ Add new position";
                                    positionSelect.appendChild(addNewOption);

                                })
                                .catch(err => {
                                    console.error("Error fetching positions:", err);
                                    positionSelect.innerHTML = '<option disabled selected>Error loading positions</option>';
                                });
                        }


                        function handlePositionChange(select) {
                            if (select.value === 'add_new_position') {
                                const posModal = new bootstrap.Modal(document.getElementById('addPositionModal'));
                                posModal.show();
                                select.value = "";
                            }
                        }

                        if (url === 'user_management.php') {
                            const departmentSelect = document.getElementById('department');
                            if (departmentSelect) {
                                departmentSelect.addEventListener('change', function () {
                                    handleDepartmentChange(this);
                                });
                            }

                            const positionSelect = document.getElementById('position');
                            if (positionSelect) {
                                positionSelect.addEventListener('change', function () {
                                    handlePositionChange(this);
                                });
                            }
                        }


                    })

                    .catch(() => {
                        subcontent.innerHTML = '<p>Error loading content.</p>';
                    });
            }





        });

        function showAlertAddedItem() {
            Swal.fire({
                title: 'Item Added Successfully!',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        }

        function showAlertEditItem() {
            Swal.fire({
                title: 'Item Edited Successfully!',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        }

        function showAlertAddedCategory() {
            Swal.fire({
                title: 'Category Added Successfully!',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        }

        function showAlertBorrowRequest() {
            Swal.fire({
                title: 'Request Submitted Successfully!',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        }

        function showAlertAddUser() {
            Swal.fire({
                title: 'User Added Successfully!',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        }

        function showAlertAddDepartment() {
            Swal.fire({
                title: 'Department Added Successfully!',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        }

        function showAlertAddedPosition() {
            Swal.fire({
                title: 'Position Added Successfully!',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        }


        function confirmLogout() {
            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "log_in.php";
                }
            });
        }



        function loadItemsByCategory(category) {
            if (!category) return;

            const xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_items.php?category=" + encodeURIComponent(category), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const items = JSON.parse(xhr.responseText);
                    const itemSelect = document.getElementById('itemName');
                    const quantitySpan = document.getElementById('availableQuantity');
                    const itemImage = document.getElementById('itemImage');
                    console.log(items);
                    itemSelect.innerHTML = '<option selected disabled>Select Item</option>';
                    quantitySpan.textContent = ''; // Clear on category change
                    itemImage.src = ''; // Clear image on category change

                    items.forEach(function (item) {
                        const option = document.createElement('option');
                        option.value = item.itemID;
                        option.textContent = item.item_name;
                        option.dataset.quantity = item.quantity; // ✅ Set quantity as data-attribute
                        option.dataset.item_img = item.item_img || '';
                        itemSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }


    </script>
</body>

</html>