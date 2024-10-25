<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register_db";

// Check if delete form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    // Get the phone number to delete
    $phone_number = $_POST["id"];
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL to delete record
    $sql = "DELETE FROM users WHERE phone_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone_number);

    if ($stmt->execute()) {
        // Record deleted successfully
        echo '<script>
                alert("Record deleted successfully.");
                window.location = "list_of_customers.php";
              </script>';
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmDelete() {
            if (confirm("Are you sure you want to delete this record?")) {
                return true;
            }
            return false;
        }
    </script>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return confirmDelete()">
        <h2>Delete Record</h2>
        <label for="id">Enter phone number to delete:</label><br>
        <input type="text" id="id" name="id" required><br><br>
        <input type="submit" name="delete" value="Delete">
        <a href="list_of_customers.php"><button type="button">Cancel</button></a>
    </form>
</body>
</html>
