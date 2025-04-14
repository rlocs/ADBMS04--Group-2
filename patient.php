<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Healthworker') {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];
$email = $username . "@gmail.com";
$profilePic = "../profile.jpg";

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}

// Dummy search value placeholder
$search = $_GET['search'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patients - Healthworker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
        }
        .navbar-custom {
            background-color: #ffffff;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .navbar-nav .nav-link {
            color: black !important;
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 10px;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: black;
        }
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .user-info div {
            font-size: 0.95rem;
            line-height: 1.2;
        }
        .logout-btn {
            background-color:rgb(38, 35, 35);
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 1rem;
            border-radius: 5px;
            margin-left: 20px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color:rgb(14, 13, 13);
        }
        .content-section {
            padding: 30px;
        }

        /* Custom Button Colors */
        .btn-custom-add {
            background-color:rgb(0, 0, 0); /* Green */
            color: white;
        }
        .btn-custom-add:hover {
            background-color:rgb(255, 255, 255); /* Darker Green */
        }

        .btn-custom-edit {
            background-color:rgb(0, 0, 0); /* Yellow/Orange */
            color: white;
        }
        .btn-custom-edit:hover {
            background-color:rgb(255, 255, 255); /* Darker Yellow/Orange */
        }

        .btn-custom-delete {
            background-color:rgb(0, 0, 0); /* Red */
            color: white;
        }
        .btn-custom-delete:hover {
            background-color:rgb(255, 255, 255); /* Darker Red */
        }

        .btn-custom-view {
            background-color:rgb(0, 0, 0); /* Bootstrap primary color or choose your own */
            color: white;
            border: none;
        }

        .btn-custom-view:hover {
            background-color:rgb(248, 248, 248); /* A deeper shade for hover effect */
            color: #fff;
        }


        .table-intervention th, .table-intervention td {
        text-align: left; /* Center-align text inside table cells */
        }

        .table-intervention {
            width: 95%;
            margin-top: 16px;
            margin-left: 26px;
            margin-right: 15px;
        }

        .table-intervention thead {
            background-color: #f7f7f7;
            font-weight: bold;
        }

        .table-intervention tbody tr:hover {
            background-color: #f1f1f1; /* Hover effect for rows */
        }


        @media (max-width: 768px) {
            .user-info {
                flex-direction: column;
                align-items: flex-start;
            }
            .user-info img {
                margin-bottom: 10px;
            }
            .navbar-nav .nav-link {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <!-- Left nav links -->
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="healthworker.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="appointment.php">Appointments</a></li>
                <li class="nav-item"><a class="nav-link" href="patient.php">Patients</a></li>
                <li class="nav-item"><a class="nav-link" href="household.php">Household Profiles</a></li>
            </ul>

            <!-- Right profile and logout -->
            <div class="user-info">
                <a href="profile.php"><img src="<?= $profilePic ?>" alt="Profile Picture"></a>
                <div>
                    <div><a href="profile.php" style="text-decoration: none; color: black;"><strong><?= htmlspecialchars($username) ?></strong></a></div>
                    <div><a href="mailto:<?= htmlspecialchars($email) ?>" style="text-decoration: none; color: black;"><?= htmlspecialchars($email) ?></a></div>
                </div>
                <form method="POST" action="">
                    <button type="submit" name="logout" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Content Section -->
<div class="content-section">
    <!-- Add Patient Button (no fields here) -->
    <button type="button" class="btn btn-custom-add mb-4" data-bs-toggle="modal" data-bs-target="#addPatientModal">
        Add Patient
    </button>

    <!-- Search Form -->
    <form method="get" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by Name" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-outline-secondary">Search</button>
    </form>

    <!-- Patient Table -->
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Parents</th>
                    <th>DOB</th>
                    <th>Weight</th>
                    <th>Height</th>
                    <th>Blood Type</th>
                    <th>Reason</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="patientTableBody">
                <?php
                // Example dummy data (replace with data from view.php)
                $patients = [
                    ["id" => 1, "name" => "John Doe", "age" => 30, "gender" => "Male", "address" => "1234 Elm Street", "parents" => "Jane Doe", "dob" => "1995-02-15", "weight" => "70kg", "height" => "180cm", "blood_type" => "O+", "reason" => "Checkup", "description" => "Routine checkup"],
                    ["id" => 2, "name" => "Jane Roe", "age" => 28, "gender" => "Female", "address" => "5678 Oak Avenue", "parents" => "John Roe", "dob" => "1997-06-20", "weight" => "60kg", "height" => "165cm", "blood_type" => "A-", "reason" => "Flu", "description" => "Flu symptoms"]
                ];

                foreach ($patients as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= $p['age'] ?></td>
                    <td><?= $p['gender'] ?></td>
                    <td><?= htmlspecialchars($p['address']) ?></td>
                    <td><?= htmlspecialchars($p['parents']) ?></td>
                    <td><?= $p['dob'] ?></td>
                    <td><?= $p['weight'] ?></td>
                    <td><?= $p['height'] ?></td>
                    <td><?= $p['blood_type'] ?></td>
                    <td><?= $p['reason'] ?></td>
                    <td><?= $p['description'] ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-custom-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $p['id'] ?>">Edit</button>

                        <!-- Delete Form -->
                        <form method="post" class="d-inline" onsubmit="return confirm('Delete this patient?');">
                            <input type="hidden" name="delete_id" value="<?= $p['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-custom-delete btn-sm">Delete</button>
                        </form>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $p['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="post" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $p['id'] ?>">Edit Patient</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($p['name']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Age</label>
                                            <input type="number" name="age" class="form-control" value="<?= $p['age'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Gender</label>
                                            <input type="text" name="gender" class="form-control" value="<?= htmlspecialchars($p['gender']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($p['address']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Parents</label>
                                            <input type="text" name="parents" class="form-control" value="<?= htmlspecialchars($p['parents']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>DOB</label>
                                            <input type="date" name="dob" class="form-control" value="<?= $p['dob'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Weight</label>
                                            <input type="text" name="weight" class="form-control" value="<?= $p['weight'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Height</label>
                                            <input type="text" name="height" class="form-control" value="<?= $p['height'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Blood Type</label>
                                            <input type="text" name="blood_type" class="form-control" value="<?= $p['blood_type'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Reason</label>
                                            <input type="text" name="reason" class="form-control" value="<?= $p['reason'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" required><?= $p['description'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<div class="table-responsive">
    <h4 class="fw-bold mt-5" style="text-align: left; font-size: 1.8rem; margin-left: 26px;">Intervention</h4>
    <table class="table table-bordered table-hover bg-white table-intervention">
            <thead class="table-light">
                <tr>
                    <th>Intervention ID</th>
                    <th>Patient Name</th>
                    <th>Doctor</th>
                    <th>Reason</th>
                    <th>Intervention</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="interventionTableBody">
                <?php
                // Example dummy data (replace with data from view.php)
                $interventions = [
                    ["id" => 1, "patient_name" => "John Doe", "doctor" => "Dr. Smith", "reason" => "Routine Checkup", "intervention" => "Vaccination"],
                    ["id" => 2, "patient_name" => "Jane Roe", "doctor" => "Dr. Johnson", "reason" => "Flu Symptoms", "intervention" => "Health Screening"]
                ];

                foreach ($interventions as $i): ?>
                <tr>
                    <td><?= $i['id'] ?></td>
                    <td><?= htmlspecialchars($i['patient_name']) ?></td>
                    <td><?= htmlspecialchars($i['doctor']) ?></td>
                    <td><?= htmlspecialchars($i['reason']) ?></td>
                    <td><?= htmlspecialchars($i['intervention']) ?></td>
                    <td>
                        <!-- View Button -->
                        <button class="btn btn-custom-view btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?= $i['id'] ?>">View</button>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal<?= $i['id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $i['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewModalLabel<?= $i['id'] ?>">View Intervention</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Intervention ID:</strong> <?= $i['id'] ?></p>
                                        <p><strong>Patient Name:</strong> <?= htmlspecialchars($i['patient_name']) ?></p>
                                        <p><strong>Doctor:</strong> <?= htmlspecialchars($i['doctor']) ?></p>
                                        <p><strong>Reason:</strong> <?= htmlspecialchars($i['reason']) ?></p>
                                        <p><strong>Intervention:</strong> <?= htmlspecialchars($i['intervention']) ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>




<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
                <div class="mb-3"><label>Age</label><input type="number" name="age" class="form-control" required></div>
                <div class="mb-3"><label>Gender</label><input type="text" name="gender" class="form-control" required></div>
                <div class="mb-3"><label>Address</label><input type="text" name="address" class="form-control" required></div>
                <div class="mb-3"><label>Parents</label><input type="text" name="parents" class="form-control" required></div>
                <div class="mb-3"><label>DOB</label><input type="date" name="dob" class="form-control" required></div>
                <div class="mb-3"><label>Weight</label><input type="text" name="weight" class="form-control" required></div>
                <div class="mb-3"><label>Height</label><input type="text" name="height" class="form-control" required></div>
                <div class="mb-3"><label>Blood Type</label><input type="text" name="blood_type" class="form-control" required></div>
                <div class="mb-3"><label>Reason</label><input type="text" name="reason" class="form-control" required></div>
                <div class="mb-3"><label>Description</label><textarea name="description" class="form-control" required></textarea></div>
            </div>

            <div class="modal-body">
                <!-- Add the input fields here similar to the Edit modal -->
                <!-- Same structure, just for adding new data -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="add_patient" class="btn btn-primary">Add Patient</button>
            </div>
        </form>
    </div>
</div>

</div>
 <!-- Pagination -->
 <nav>
        <ul class="pagination">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $p ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
