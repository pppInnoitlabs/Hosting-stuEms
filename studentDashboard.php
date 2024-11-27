<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not, redirect to login page
    header("Location: userLogin.php");
    exit();
}

// Include the database connection file
require_once 'database.php';

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch student details from the database (excluding the password)
try {
    $stmt = $pdo->prepare("SELECT name, email, mobile, student_id FROM students WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the student's data
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If student data is found, store it in an array to display in HTML
    if ($student) {
        // Store the student data in a variable
        $student_name = htmlspecialchars($student['name']);
        $student_email = htmlspecialchars($student['email']);
        $student_mobile = htmlspecialchars($student['mobile']);
        $student_id = htmlspecialchars($student['student_id']);
    } else {
        $error_message = "Student details not found.";
    }
} catch (PDOException $e) {
    $error_message = "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .profile_img {
            width: 35px;
            height: 35px;
            border-radius: 8px;
        }
        .sidebar {
            height: 100vh; /* Full viewport height */
            background-color: #e9eef3; /* Light gray */
        }
        .sidebar .nav-link {
            color: #2c387e; /* Dark blue */
        }
        .sidebar .nav-link:hover {
            background-color: #d1d9e6; /* Slightly darker background */
            border-radius: 5px;
        }
        .profile-card {
            width: 95%;
            height: 70%;
            margin-left: 20px;
            background-color: darkslategray;
            border-radius: 10px;
        }
        .profile-card-top {
            width: 100%;
            height: 40%;
            background-color: burlywood;
        }
        .profile-card-bottom {
            width: 100%;
            background-color: azure;
            padding: 0px;
        }
    
       
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary px-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Left Section: Title -->
            <div class="d-flex align-items-center">
                <h1 class="fs-5 fw-bold text-primary mb-0"><?php echo $_SESSION['username']; ?></h1>
            </div>

            <!-- Right Section: Icons -->
            <div class="d-flex align-items-center">
                <i class="fas fa-search text-secondary mx-2 icon-hover" style="cursor: pointer;"></i>
                <i class="fas fa-moon text-secondary mx-2 icon-hover" style="cursor: pointer;"></i>
                <i class="fas fa-expand text-secondary mx-2 icon-hover" style="cursor: pointer;"></i>
                <i class="fas fa-comment text-secondary mx-2 icon-hover" style="cursor: pointer;"></i>
                <i class="fas fa-bell text-secondary mx-2 icon-hover" style="cursor: pointer;"></i>
                <i class="fas fa-cog text-secondary mx-2 icon-hover" style="cursor: pointer;"></i>
                <img src="https://as2.ftcdn.net/v2/jpg/02/75/40/57/1000_F_275405741_g5h8rIRmfAv0EnTbDJefUwAPOQ2FB08i.jpg" class="profile_img mx-2" alt="Profile">
            </div>
        </div>
    </nav>

    <!-- Layout: Sidebar + Main Content -->
    <div class="container-fluid all-content">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-2 sidebar p-3">
                <h5 class="text-primary fw-bold">Menu</h5>
                <nav class="nav flex-column">
                    <a href="#" class="nav-link"><i class="fas fa-home me-2"></i>Dashboard</a>
                    <a href="studentTask.php" class="nav-link"><i class="fas fa-tasks me-2"></i>Tasks</a>
                    <a href="studentsingleTask.php" class="nav-link"><i class="fas fa-tasks me-2"></i>Single Tasks</a>
                    <a href="#" class="nav-link"><i class="fas fa-gift me-2"></i>Bonus Points</a>
                    <a href="#" class="nav-link"><i class="fas fa-calendar-alt me-2"></i>Timetable</a>
                    <a href="#" class="nav-link"><i class="fas fa-user-check me-2"></i>Attendance</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-10 p-3 profile-card-main">
                <div class="card-body">
                    <div class="card shadow border-0">
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0">Student Name</h3>
                            <p class="mb-0">Student</p>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row g-4">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-warning text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                                                <i class="bi bi-person fs-4"></i>
                                            </div>
                                            <div>
                                                <div>Student Id:</div>
                                                <div class="fw-bold text-primary"><?= $student_id; ?></div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mt-4">
                                            <div class="rounded-circle bg-warning text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                                                <i class="bi bi-telephone fs-4"></i>
                                            </div>
                                            <div>
                                                <div>Phone:</div>
                                                <div class="fw-bold text-primary"><?= $student_mobile; ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-warning text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-geo-alt fs-4"></i>
                                                </div>
                                                <div>
                                                    <div>Address:</div>
                                                    <div class="fw-bold text-primary">Update, Later</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mt-4">
                                                <div class="rounded-circle bg-warning text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                                                    <i class="bi bi-envelope fs-4"></i>
                                                </div>
                                                <div>
                                                    <div>Email:</div>
                                                    <div class="fw-bold text-primary"><?= $student_email; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    <!-- bonuspoint countdown Content -->
                        <div class="container bonuspoint-countdown-div  mt-4">
                            <div class="row">
                            <!-- First Div -->
                            <div class="col-md-4 bouns-point">
                                <div class="card shadow border-0">
                                <div class="card-body text-center">
                                    <h3 class="mb-0">200</h3>
                                    <p>bonus points</p>
                                </div>
                                </div>
                            </div>

                            <!-- Second Div -->
                            <div class="col-md-4 countdown-div">
                                <div class="card shadow border-0">
                                <div class="card-body text-center">
                                    <h3 class="mb-0">200</h3>
                                    <p>countdown</p>
                                </div>
                                </div>
                            </div>
                        </div>
                       
    </table>
</div>
                    </div>    
                </div>
            </div>
           
        </div>
           
        </div>
       
      
    </div>

    <!-- Bootstrap JS and Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
