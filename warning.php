<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register_db";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    // Check if the phone number is provided
    if(isset($_POST["id"]) && !empty($_POST["id"])) {
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind SQL statement
        $sql = "DELETE FROM users WHERE phone_number=?";
        $stmt = $conn->prepare($sql);

        // Check if the statement was prepared successfully
        if (!$stmt) {
            die("Error: " . $conn->error);
        }

        // Bind parameter
        $stmt->bind_param("s", $phone_number); 

        // Assign value to parameter
        $phone_number = $_POST["id"];

        // Execute the statement
        try {
            if ($stmt->execute()) {
                // Display confirmation message and redirect
                echo "<script>
                        if (confirm('Data deleted successfully!')) {
                            window.location.href = 'list_of_customers.php';
                        } else {
                            window.location.href = 'delete.php'; // Redirect if cancel button is clicked
                        }
                      </script>";
                exit();
            } else {
                echo "Error deleting record.";
            }
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Phone number is not provided.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="msg/msg.css">
</head>
<body>
    <div class="container">
        <div class="popup">
            <img src="img/warning.png">
            <h2>Are you sure?</h2>
            <p>To delete this data</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_POST["id"]); ?>">
                <button type="submit" name="delete">OK</button>
                <a href="list_of_customers.php"><button type="button">Cancel</button></a>
            </form>
        </div>
    </div>
</body>
</html>
