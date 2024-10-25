<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register_db";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind SQL statement
    $sql = "UPDATE users SET payment_1=?, payment_2=? WHERE name=?";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("iis", $payment_1, $payment_2, $name); 

    // Assign values to parameters
    $name = $_POST["name"];
    $payment_1 = isset($_POST["90"]) ? $_POST["90"] : 0; // assuming 0 for unchecked, 1 for checked
    $payment_2 = isset($_POST["700"]) ? $_POST["700"] : 0;

    // Execute the statement
    try {
        if ($stmt->execute()) {
            header("Location: msg.php");
            exit();
        } else {
            echo "Error updating record.";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="style.css">
    <head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

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

                <div class="title">
                <h2>Update payment</h2>
                </div>

                <div class="user">
                <img src="img/logo.jpg" alt="Logo">
                </div>
            </div>

    
           
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <h2>Update Payment</h2>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        
        <label for="payment"> Payment:</label><br>
        <input type="checkbox" name="90" id="90" value="90">
        <label for="90">90</label><br>
        <input type="checkbox" name="700" id="700" value="700">
        <label for="700">700</label><br>


        <input type="submit" name="update" value="Update">
    </form>
            <script type="text/javascript" src="script.js"></script>
    <script src="js/main.js"></script>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>