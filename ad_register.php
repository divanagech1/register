
<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $dbname = "register_db";

    $conn = new mysqli("localhost", "root", "", "register_db");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Insert admin data into database
    $sql = "INSERT INTO admin (name, username, password) VALUES ('$name', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Admin registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="login/style.css">
</head>
<body>
    
    <form method="post" action="">
    <h2>Admin Registration</h2>
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Register">

        <p>Already have an account? <a href="Ad_login.php">Login here</a>.</p>

    </form>

    <script type="text/javascript" src="script.js"></script>
</body>
</html>
