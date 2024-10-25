<?php
session_start();


$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "register_db";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

  
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);


    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
       
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username;

     
        header("Location: mssg.php");
        exit();
    } else {
       
        $error = "Invalid username or password";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="login/style.css">
</head>
<body>

    <form method="post" action="">
    <h2>Admin Login</h2>
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
        <p>Already have an account? <a href="ad_register.php">Register</a>.</p>
    </form>
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

    <script type="text/javascript" src="script.js"></script>

</body>
</html>
