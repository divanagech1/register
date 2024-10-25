<?php
session_start();

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: Ad_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-pd/yLrQmS+fd/i1vPt3++M5nLbL8nYIU7c7YfB6eFnVIkkAebPv1jvf1aVbNpXzo2YzJ87xOkvzK1J4Ee4Dkfw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="style.css">
    
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <img src="img/logo.jpg" alt="Logo">
                        </span>
                        <span class="title">synergy</span>
                    </a>
                </li>

                <li>
                    <a href="index.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="register.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Register Customers</span>
                    </a>
                </li>
                   
                <li>
                    <a href="list_of_customers.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">List of Customers</span>
                    </a>
                </li>

                <li>
                    <a href="Ad_login.php" id="logout">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user">
                <img src="img/logo.jpg" alt="Logo">
                </div>
            </div>
            <div class="main-content">
    <div class="dashboard-header">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Manage your customers and data efficiently.</p>
    </div>

    <div class="dashboard-cards">
        <div class="card">
            <h2>Total Customers</h2>
            <?php
            // Connect to the database
            $conn = new mysqli("localhost", "root", "", "register_db");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to get the total number of customers
            $total_customers_query = "SELECT COUNT(*) AS total_customers FROM users";
            $total_customers_result = $conn->query($total_customers_query);
            if ($total_customers_result->num_rows > 0) {
                $row = $total_customers_result->fetch_assoc();
                echo "<p>" . $row["total_customers"] . "</p>";
            } else {
                echo "<p>0</p>";
            }
            ?>
        </div>

        <div class="card">
            <h2>Total Payment 1</h2>
            <?php
            // Query to get the total number of payment 1
            $total_payment_1_query = "SELECT COUNT(*) AS total_payment_1 FROM users WHERE payment_1 = 1";
            $total_payment_1_result = $conn->query($total_payment_1_query);
            if ($total_payment_1_result->num_rows > 0) {
                $row = $total_payment_1_result->fetch_assoc();
                echo "<p>" . $row["total_payment_1"] . "</p>";
            } else {
                echo "<p>0</p>";
            }
            ?>
        </div>

        <div class="card">
            <h2> Payment 2</h2>
            <?php
            // Query to get the total number of payment 2
            $total_payment_2_query = "SELECT COUNT(*) AS total_payment_2 FROM users WHERE payment_2 = 1";
            $total_payment_2_result = $conn->query($total_payment_2_query);
            if ($total_payment_2_result->num_rows > 0) {
                $row = $total_payment_2_result->fetch_assoc();
                echo "<p>" . $row["total_payment_2"] . "</p>";
            } else {
                echo "<p>0</p>";
            }
            ?>
        </div>

    </div>
    <section class="dashboard-stats">
            <div class="stat-card">
                <h3>Registered Members</h3>
                <p>10,314</p>
            </div>
            <div class="stat-card">
                <h3>Trade Associations</h3>
                <p>100</p>
            </div>
            <div class="stat-card">
                <h3>Capital to be Raised</h3>
                <p>100M Birr</p>
            </div>
            <!-- Add more stat cards as needed -->
        </section>

        <section class="dashboard-social">
    <div class="social-card">
        <a href="https://www.facebook.com/synergy" target="_blank">
            <i class="fab fa-facebook-f"></i>
            <span>Facebook</span>
        </a>
    </div>
    <div class="social-card">
        <a href="https://twitter.com/synergy" target="_blank">
            <i class="fab fa-twitter"></i>
            <span>Twitter</span>
        </a>
    </div>
    <div class="social-card">
        <a href="https://www.instagram.com/synergy" target="_blank">
            <i class="fab fa-instagram"></i>
            <span>Instagram</span>
        </a>
    </div>
    <div class="social-card">
        <a href="https://www.tiktok.com/@synergy" target="_blank">
            <i class="fab fa-tiktok"></i>
            <span>TikTok</span>
        </a>
    </div>
    <div class="social-card">
        <a href="https://www.synergy.et" target="_blank">
            <i class="fas fa-globe"></i>
            <span>Website</span>
        </a>
    </div>
</section>




            <script type="text/javascript" src="script.js"></script>
    <script src="js/main.js"></script>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>