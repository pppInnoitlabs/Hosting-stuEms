

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student EMS</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .banner {
            width: 85%;
            height: 85%;
            background: url("https://www.codehim.com/wp-content/uploads/2022/09/bootstrap-5-card-with-shadow-on-hover.png") no-repeat center center;
            background-size: cover;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .threecardsIMG{
            width: 100%;
            height: auto;
        }
        .threecards_main{
            display: flex;
            justify-content: space-evenly;
            margin-top: 20px;
        }
        .threecards {
            text-align: center;
            max-width: 200px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Left-side title -->
            <a class="navbar-brand" href="#">Student</a>
            <!-- Toggle button for mobile view -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Right-side links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Feedback</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Cards Section -->
    <div class="container">
        <div class="threecards_main">
            <div class="threecards card">
                <img src="https://imgcdn.stablediffusionweb.com/2024/3/15/0a4d4ea6-0aa8-4716-821d-917cec983d30.jpg" alt="threecards image" class="threecardsIMG card-img-top">
                <div class="card-body">
                    <a href="studentLogin.php"><button type="button" class="btn btn-info">Student</button></a>
                    <p class="card-text">Some quick example text to build on the card title.</p>
                </div>
            </div>
            <div class="threecards card">
                <img src="https://www.thoughtco.com/thmb/TOV_4R2lcb4PH7B1tjJoVew6O74=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/teacher-standing-in-front-of-a-class-of-raised-hands-dv1940073-5b42b097c9e77c00371ba22c.jpg" alt="image" class="threecardsIMG card-img-top">
                <div class="card-body">
                    <a href="teacherLogin.php"><button type="button" class="btn btn-info">Teacher</button></a>
                    <p class="card-text">Some quick example text to build on the card title.</p>
                </div>
            </div>
            <div class="threecards card">
                <img src="https://ibu.ca/wp-content/uploads/2024/01/m29.webp" alt="image" class="threecardsIMG card-img-top">
                <div class="card-body">
                    <a href="adminLogin.php"><button type="button" class="btn btn-info">Admin</button></a>
                    <p class="card-text">Some quick example text to build on the card title.</p>
                </div>
            </div>
        </div>
    </div>


    
    <!-- Centered and resized image banner -->
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="banner"></div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
