<?php
include 'server.php';

$query = "SELECT * FROM category";
$result = mysqli_query($conn, $query);
?>

<link rel="stylesheet" href="subcontent.css">
<div class="container">
    <div class="form-container shadow-md">
        <form id="addItemForm" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6 form-section">
                    <div class="mb-4">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name"
                            placeholder="Enter item name" required>
                        <div class="invalid-feedback">
                            Please provide an item name.
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <div class="input-group input-with-icon">
                                <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1"
                                    placeholder="0" required>
                            </div>
                            <div class="invalid-feedback">
                                Please provide a quantity.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label">Price ($)</label>
                            <div class="input-group input-with-icon">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" min="0.01"
                                    placeholder="0.00" required>
                            </div>
                            <div class="invalid-feedback">
                                Please provide the price of the Item.
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Specific Description</label>
                        <textarea class="form-control" id="description" name="description"
                            placeholder="Enter item description" required></textarea>
                        <div class="invalid-feedback">
                            Please provide a description.
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6 form-section">
                    <div class="mb-4">
                        <label for="item_brand" class="form-label">Item Brand</label>
                        <input type="text" class="form-control" id="item_brand" name="item_brand"
                            placeholder="Enter item brand" required>
                        <div class="invalid-feedback">
                            Please provide an item brand.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="" selected disabled>Select status</option>
                            <option value="In Stock">New</option>
                            <option value="Low Stock">Re-Stock</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a status.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required
                            onchange="handleCategoryChange(this)">
                            <option value="" selected disabled>Select category</option>
                            <?php
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['category_id'];
                                    $name = htmlspecialchars($row['category_name']);
                                    echo "<option value=\"$id\">$name</option>";
                                }
                            } else {
                                echo "<option disabled>No categories available</option>";
                            }
                            ?>
                            <option value="add_new_category" class="text-primary">+ Add new category</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a category.
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label for="item_image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="item_image" name="item_image" accept="image/*"
                            required>
                        <div class="invalid-feedback">
                            Please upload an image.
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2">
                    <i class="fas fa-plus-circle me-2"></i>Add Item
                </button>
            </div>
        </form>

    </div>
</div>


<div id="formResponse"></div>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Item added successfully!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addCategoryForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newCategoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="newCategoryName" name="category_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="newCategoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="newCategoryDescription" name="category_description"
                            rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </div>
        </form>
    </div>
</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
</script>