<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: log_in.php"); // or login.php if you use a combined login form/page
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <link rel="icon" href="anong-context-nung-nakadila-si-alden-v0-q630lpmhcj0f1.png" type="image/png">
    <link rel="stylesheet" href="idex.css">
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
                <span class="logo-text">InventoryPro</span>
            </div>

            <ul class="list-unstyled components">
                <li class="nav-item">
                    <a href="dashboard.php" class="load-content">
                        <i class="bi bi-house-door fs-5"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="has-submenu" data-bs-toggle="collapse" data-bs-target="#inventorySubmenu">
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
                        <li>
                            <a href="add_item.php" class="load-content">
                                <i class="bi bi-plus-circle fs-5 sub-icon"></i>
                                <span class="submenu-text">Add New Item</span>
                            </a>
                        </li>
                    </ul>
                </li>

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
                            <a href="#" class="">
                                <i class="bi bi-clipboard-check fs-5 sub-icon"></i>
                                <span class="submenu-text">Stock Count</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="">
                                <i class="bi bi-exclamation-triangle fs-5 sub-icon"></i>
                                <span class="submenu-text">Low Stock Alerts</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="report.html" class="load-content">
                        <i class="bi bi-graph-up fs-5"></i>
                        <span class="menu-text">Reports</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#">
                        <i class="bi bi-gear fs-5"></i>
                        <span class="menu-text">Settings</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <a id="sidebarCollapse" class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left-right"></i>
                    <span class="ms-2">Collapse</span>
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
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div id="subcontent">

            </div>


        </div>
    </div>

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
                                            new bootstrap.Modal(document.getElementById('successModal')).show();
                                        } else {
                                            alert('Error: ' + (data.error || 'Unknown error.'));
                                        }
                                    })
                                    .catch(() => {
                                        alert('Submission failed. Try again.');
                                    });
                            });
                        }

                        const borrowRequestform = document.getElementById('borrowingForm');
                        if (borrowRequestform) {
                            borrowRequestform.addEventListener('submit', function (e) {
                                e.preventDefault();

                                const formData = new FormData(borrowRequestform);

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
                                            new bootstrap.Modal(document.getElementById('successModal')).show();
                                        } else {
                                            alert('Error: ' + (data.error || 'Unknown error.'));
                                        }
                                    })
                                    .catch(() => {
                                        alert('Submission failed. Try again.');
                                    });
                            });


                        }

                        function validateFileSize(input) {
                            const maxSize = 5 * 1024 * 1024; // 5 MB
                            if (input.files[0] && input.files[0].size > maxSize) {
                                alert("The selected file is too large. Maximum allowed size is 5 MB.");
                                input.value = ''; // Clear the file input
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


                                        } else {
                                            alert('Error: ' + (data.message || 'Unknown error.'));
                                        }
                                    })
                                    .catch(() => {
                                        alert('Update failed. Please try again.');
                                    });
                            });
                        }

                        function bindEditButtons() {
                            const editButtons = document.querySelectorAll('.edit-button');

                            editButtons.forEach(button => {
                                button.addEventListener('click', function () {
                                    document.getElementById('editItemID').value = this.dataset.id;
                                    document.getElementById('editItemName').value = this.dataset.name;
                                    document.getElementById('editItemBrand').value = this.dataset.brand;
                                    document.getElementById('editItemQuantity').value = this.dataset.quantity;
                                    document.getElementById('editItemPrice').value = this.dataset.price;
                                    document.getElementById('editItemCategory').value = this.dataset.category;
                                    document.getElementById('editItemStatus').value = this.dataset.status;

                                    const imgBase64 = this.dataset.image;
                                    if (imgBase64) {
                                        document.getElementById('editItemImagePreview').src = "data:image/jpeg;base64," + imgBase64;
                                    }
                                });
                            });
                        }


                        function refreshItemsTable() {
                            fetch('load_items_table.php')
                                .then(res => res.text())
                                .then(html => {
                                    document.getElementById('itemsTableBody').innerHTML = html;

                                    // Re-bind edit button event listeners
                                    bindEditButtons();
                                });
                        }

                        document.querySelectorAll('.table-filter-btn').forEach(button => {
                            button.addEventListener('click', () => {
                                // Remove "active" class from all buttons
                                document.querySelectorAll('.table-filter-btn').forEach(btn => btn.classList.remove('active'));
                                // Add "active" class to clicked button
                                button.classList.add('active');

                                const filter = button.getAttribute('data-filter');
                                const rows = document.querySelectorAll('table tbody tr');

                                rows.forEach(row => {
                                    const status = row.getAttribute('data-status');

                                    // Show all rows if filter is "all", otherwise match status
                                    if (filter === 'all' || status === filter) {
                                        row.style.display = '';
                                    } else {
                                        row.style.display = 'none';
                                    }
                                });
                            });
                        });

                        const editButtons = document.querySelectorAll('.edit-button');

                        editButtons.forEach(button => {
                            button.addEventListener('click', function () {
                                document.getElementById('editItemID').value = this.dataset.id;
                                document.getElementById('editItemName').value = this.dataset.name;
                                document.getElementById('editItemBrand').value = this.dataset.brand;
                                document.getElementById('editItemQuantity').value = this.dataset.quantity;
                                document.getElementById('editItemPrice').value = this.dataset.price;
                                document.getElementById('editItemCategory').value = this.dataset.category;
                                document.getElementById('editItemStatus').value = this.dataset.status;

                                // Set image preview
                                const imagePreview = document.getElementById('editItemImagePreview');
                                if (this.dataset.image) {
                                    imagePreview.src = 'data:image/jpeg;base64,' + this.dataset.image;
                                    imagePreview.style.display = 'block';
                                } else {
                                    imagePreview.style.display = 'none';
                                }
                            });
                        });



                        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
                        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))


                        if (url === 'borrow.php') {
                            const steps = document.querySelectorAll('.carousel-step');
                            const stepIndicators = document.querySelectorAll('.stepper .step');
                            const prevBtn = document.getElementById('prevBtn');
                            const nextBtn = document.getElementById('nextBtn');
                            const formFooter = document.querySelector('.form-footer');
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
                                } else {
                                    if (validateCurrentStep()) {
                                        document.getElementById('borrowingForm').submit();
                                    } else {
                                        alert('Please fill out all required fields before submitting.');
                                    }
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
                                formFooter.style.display = currentStep === steps.length - 1 ? 'none' : 'flex';
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
                                const inputs = currentStepElement.querySelectorAll('input, select, textarea');

                                let allFilled = true;

                                inputs.forEach(input => {
                                    if (
                                        (input.type === 'checkbox' && input.required && !input.checked) ||
                                        (input.type !== 'checkbox' && (!input.value || input.value === 'Select department' || input.value === 'Select Item' || input.value === 'Select purpose'))
                                    ) {
                                        allFilled = false;
                                    }
                                });

                                // ✅ Require agreeTerms to be checked globally, even on step 0
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
                        }

                        if (url === 'view_all_item.php') {
                            // Load page 1 by default
                            fetch('fetch_item_tables.php?page=1')
                                .then(response => response.text())
                                .then(html => {
                                    document.getElementById('itemsTableBody').innerHTML = html;

                                    // Highlight first pagination item (if applicable)
                                    document.querySelectorAll('.pagination-item').forEach(link => {
                                        if (link.getAttribute('data-page') === '1' && !link.querySelector('i')) {
                                            link.classList.add('active');
                                        }
                                    });
                                })
                                .catch(err => console.error('Initial load error:', err));

                            // Bind pagination events
                            function bindPaginationEvents() {
                                const links = document.querySelectorAll('.pagination-item');
                                links.forEach(link => {
                                    link.addEventListener('click', function (e) {
                                        e.preventDefault();
                                        const page = this.getAttribute('data-page');

                                        fetch(`fetch_item_tables.php?page=${page}`)
                                            .then(response => response.text())
                                            .then(html => {
                                                document.getElementById('itemsTableBody').innerHTML = html;

                                                // Update active state
                                                document.querySelectorAll('.pagination-item').forEach(l => l.classList.remove('active'));
                                                document.querySelectorAll('.pagination-item').forEach(link => {
                                                    if (link.getAttribute('data-page') === page && !link.querySelector('i')) {
                                                        link.classList.add('active');
                                                    }
                                                });
                                            })
                                            .catch(err => console.error('Pagination fetch error:', err));
                                    });
                                });
                            }

                            bindPaginationEvents();
                        }

                    })

                    .catch(() => {
                        subcontent.innerHTML = '<p>Error loading content.</p>';
                    });
            }





        });


        function loadItemsByCategory(category) {
            if (!category) return;

            const xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_items.php?category=" + encodeURIComponent(category), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const items = JSON.parse(xhr.responseText);
                    const itemSelect = document.getElementById('itemName');
                    itemSelect.innerHTML = '<option selected disabled>Select Item</option>';

                    items.forEach(function (item) {
                        const option = document.createElement('option');
                        option.value = item.item_name;
                        option.textContent = item.item_name;
                        itemSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }





    </script>
</body>

</html>