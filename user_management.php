<?php
include 'server.php';

$sql = "SELECT 
            ua.userID, 
            ua.username, 
            ua.users_role, 
            d.department_name, 
            p.position_name 
        FROM users_account ua
        LEFT JOIN department d ON ua.departmentID = d.departmentID
        LEFT JOIN position p ON ua.positionId = p.positionId";

$result = $conn->query($sql);

$deptResult = $conn->query("SELECT * FROM department");

?>

<link rel="stylesheet" href="subcontent_management.css">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="table-container border shadow-sm">
                    <div class="container mt-4">
                        <div class="d-flex justify-content-end mb-3">
                            <form action="add_admin.php" method="post">
                                <button class="btn btn-primary" type="submit">Create Admin Account</button>
                            </form>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"><i
                                    class="fas fa-plus-circle me-2"></i>Add
                                User</button>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Username</th>
                                    <th> Role</th>
                                    <th> Department</th>
                                    <th> Position</th>
                                    <th> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <?php if (strtolower($row["users_role"]) !== 'admin'): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row["username"]) ?></td>
                                                <td><?= htmlspecialchars($row["users_role"]) ?></td>
                                                <td><?= htmlspecialchars($row["department_name"]) ?></td>
                                                <td><?= htmlspecialchars($row["position_name"]) ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn"><i class="fas fa-edit"></i></button>
                                                        <button class="btn"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center;">No users found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="table-footer">
                    <div class="showing-info">
                        Showing <span class="fw-medium">5</span> of <span class="fw-medium">25</span> entries
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="addUserForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact No.</label>
                            <input type="text" name="contact" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">User Role</label>
                            <select class="form-select" name="users_role" id="user-role" required>
                                <option value="" selected disabled>Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" name="department" required
                                onchange="handleDepartmentChange(this)">
                                <option value="" selected disabled>Select Department</option>
                                <?php
                                if ($deptResult && $deptResult->num_rows > 0) {
                                    while ($row = $deptResult->fetch_assoc()) {
                                        $id = $row['departmentID'];
                                        $name = htmlspecialchars($row['department_name']);
                                        echo "<option value=\"$id\">$name</option>";
                                    }
                                } else {
                                    echo '<option disabled>No departments available</option>';
                                }
                                ?>
                                <option value="add_new_department" class="text-primary">+ Add new department</option>
                            </select>
                            <div class="invalid-feedback">Please select a department.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="position" class="form-label">Position</label>
                            <select class="form-select" id="position" name="position" disabled required>
                                <option value="" disabled selected>Select position</option>
                                <?php
                                $positionResult = $conn->query("SELECT * FROM position");
                                while ($pos = $positionResult->fetch_assoc()):
                                    ?>
                                    <option value="<?= $pos['positionId'] ?>">
                                        <?= htmlspecialchars($pos['position_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                                <option value="add_new_position" class="text-primary">Add new position</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_user" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="addDepartmentModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="addDepartmentForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">Department Name</label>
                        <input type="text" name="department_name" id="department_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Department</button>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="addPositionModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="addPositionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="addPositionForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPositionLabel">Add New Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="position_name" class="form-label">Position Name</label>
                        <input type="text" class="form-control" id="position_name" name="position_name" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Position</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>