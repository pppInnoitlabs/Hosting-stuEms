<?php
// Include the database connection file
require_once 'database.php';

// Fetch student details
try {
    $stmt = $pdo->query("SELECT id, name, email, mobile, student_id FROM students");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Fetch teacher details
try {
    $stmt = $pdo->query("SELECT id, name, email, mobile, teacher_id FROM teachers");
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  
    <title>Admin Dashboard</title>
    <style>
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f8f9fa;
        }

        .nav_logo {
            width: 17%;
        }

        .nav_logo img,
        .profile_img{
            width: 35px;
            height: 35px;
            border-radius: 8px;
        }

        .search {
            flex-grow: 1;
            margin: 0 20px;
        }

        .search input {
            width: 100%;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .nav_profile_message ul {
            list-style: none;
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .nav_profile_message ul li {
            margin-right: 15px;
        }

        .profile_img select {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 2px 5px;
        }

        .side_bar {
            background-color: beige;
            height: 100vh;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="body_child">
        <!-- Navbar -->
        
        <nav class="navbar navbar-expand-lg bg-body-tertiary px-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Left Section: Title -->
            <div class="d-flex align-items-center">
            <h1 class="fs-5 fw-bold text-primary mb-0">Admin Name</h1>
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
        
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block side_bar">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Manage Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">View Reports</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                </nav>
                
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content">
                    <!-- Dashboard Stats -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Students</h5>
                                    <p class="card-text">150,000</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Teachers</h5>
                                    <p class="card-text">2,250</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-warning mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Tasks</h5>
                                    <p class="card-text">5,690</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-danger mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Exams</h5>
                                    <p class="card-text">$193,000</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Details Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <h4>Student's Details</h4>
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Name</th>
                                            <th>Student ID</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $student): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                                <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                                <td><?php echo htmlspecialchars($student['mobile']); ?></td>
                                                <td>
                                                    <a href="adminEditStudent.php?id=<?php echo $student['id']; ?>">
                                                        <button class="btn btn-primary btn-sm">Edit</button>
                                                    </a>
                                                    <a href="deleteStudent.php?id=<?php echo $student['id']; ?>"
                                                        onclick="return confirm('Are you sure you want to delete this student?');">
                                                        <button class="btn btn-danger btn-sm">Delete</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <a href="adminCreateStudent.php">
                                    <button type="button" class="btn btn-success">Add Student</button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Teacher Details Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <h4>Teacher's Details</h4>
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Name</th>
                                            <th>Teacher ID</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($teachers as $teacher): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($teacher['name']); ?></td>
                                                <td><?php echo htmlspecialchars($teacher['teacher_id']); ?></td>
                                                <td><?php echo htmlspecialchars($teacher['email']); ?></td>
                                                <td><?php echo htmlspecialchars($teacher['mobile']); ?></td>
                                                <td>
                                                    <a href="adminEditTeacher.php?id=<?php echo $teacher['id']; ?>">
                                                        <button class="btn btn-primary btn-sm">Edit</button>
                                                    </a>
                                                    <a href="deleteTeacher.php?id=<?php echo $teacher['id']; ?>"
                                                        onclick="return confirm('Are you sure you want to delete this teacher?');">
                                                        <button class="btn btn-danger btn-sm">Delete</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <a href="adminCreateTeacher.php">
                                    <button type="button" class="btn btn-success">Add Teacher</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
