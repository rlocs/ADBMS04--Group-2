<?php
session_start();

// Check if user is logged in and is a Healthworker
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Healthworker') {
    header("Location: ../index.php");
    exit;
}

// Example user details
$username = $_SESSION['username'];
$email = $username . "@gmail.com"; // Replace with actual DB email if needed
$profilePic = "../profile.jpg"; // Use a default image or fetch from DB if available

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Healthworker Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .content-section {
            padding: 30px;
            margin-top: 20px;
        }

        .content {
            display: none;
            margin-top: 20px;
        }

        .content.active {
            display: block;
            padding: 15px;
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


        /* Make the dashboard responsive */
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
            <!-- Left side nav -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="healthworker.php" onclick="showSection('dashboard')">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="appointment.php" onclick="showSection('appointments')">Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#patient.php" onclick="showSection('patients')">Patients</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#hhprofile.php" onclick="showSection('households')">Household Profiles</a>
                </li>
            </ul>

            <!-- Right side profile and logout -->
            <div class="user-info">
                <a href="profile.php">
                    <img src="<?php echo $profilePic; ?>" alt="Profile Picture">
                </a>
                <div>
                    <div>
                        <a href="profile.php" style="text-decoration: none; color: black;">
                            <strong><?php echo htmlspecialchars($username); ?></strong>
                        </a>
                    </div>
                    <div>
                        <a href="mailto:<?php echo htmlspecialchars($email); ?>" style="text-decoration: none; color: black;">
                            <?php echo htmlspecialchars($email); ?>
                        </a>
                    </div>
                </div>
                <form method="POST" action="">
                    <button type="submit" name="logout" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Dashboard Section -->
<div id="dashboard" class="content active">
    <h3>Dashboard</h3>
    <p>Welcome to your dashboard. Here you can manage all your tasks.</p>
</div>

<!-- Appointments Section -->
<div id="appointments" class="content">
    <h3>Appointments</h3>
    <p>Appointment section goes here.</p>
</div>

<!-- Patients Section -->
<div id="patients" class="content">
    <h3>Patients</h3>
    <p>Patient records section goes here.</p>
</div>

<!-- Household Profiles Section -->
<div id="households" class="content">
    <h3>Household Profiles</h3>
    <p>Household profile section goes here.</p>
</div>

<script>
    function showSection(id) {
        document.querySelectorAll('.content').forEach(div => {
            div.classList.remove('active');
        });
        document.getElementById(id).classList.add('active');
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
