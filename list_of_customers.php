

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Dashboard</title>

<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="list/style.css">

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

</head>
<body>
<div class="container">
    <div class="">
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

             

                <div class="user">
                <img src="img/logo.jpg" alt="Logo">
                </div>
            </div>
            
            <?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "register_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize and format CSV data
function sanitize_csv_field($value) {
    return '"' . str_replace('"', '""', $value) . '"';
}

// Function to generate CSV from query result
function generate_csv($conn) {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $output = fopen('php://output', 'w');
    fputcsv($output, array('Name', 'Phone Number', 'Age', 'Wereda', 'Subcity', 'Date', 'Subsidy', 'Heard From', 'Payment 1', 'Payment 2'));

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array(
            sanitize_csv_field($row['name']),
            sanitize_csv_field($row['phone_number']),
            sanitize_csv_field($row['Age']),
            sanitize_csv_field($row['wereda']),
            sanitize_csv_field($row['subcity']),
            sanitize_csv_field($row['date']),
            sanitize_csv_field($row['subsidy']),
            sanitize_csv_field($row['heard_from']),
            sanitize_csv_field($row['payment_1']),
            sanitize_csv_field($row['payment_2'])
        ));
    }

    fclose($output);
}

// If Generate report button is clicked
if (isset($_GET['generate_report'])) {
    // Set headers for CSV download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=users_report.csv');

    // Generate and output CSV
    generate_csv($conn);
    exit();
}

// Search parameters
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';

// Pagination parameters
$results_per_page = 5;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $results_per_page;

// SQL query with search and date filter
$sql = "SELECT * FROM users WHERE (name LIKE '%$search_query%' OR phone_number LIKE '%$search_query%')";
if (!empty($date_filter)) {
    $sql .= " AND date = '$date_filter'";
}
$sql .= " LIMIT $start_from, $results_per_page";

// Execute SQL query
$result = $conn->query($sql);

// Display search form
echo "<form method='GET' action='list_of_customers.php'>"; // Ensure action is set to list.php
echo "<input type='text' name='search' placeholder='Search by Name or Phone Number' value='$search_query'>"; // Set value attribute to maintain search query
echo "<button type='submit'>search</button>";
echo "<input type='date' name='date' placeholder='Filter by Date' value='$date_filter'>"; // Set value attribute to maintain date filter
echo "<button type='submit'>filter</button>";
echo "<button type='submit' name='generate_report'>Generate report</button>";
echo "</form>";

// Display data table
echo "<form method='GET' action='list_of_customers.php'>";
echo "<h2> list of customers</h2>";
echo "<table border='1'>
<tr>
<th>Name</th>
<th>Phone Number</th>
<th>Age</th>
<th>Wereda</th>
<th>Subcity</th>
<th>Date</th>
<th>Subsidy</th>
<th>Heard From</th>
<th>Payment 1</th>
<th>Payment 2</th>
<th>Action</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['phone_number'] . "</td>";
    echo "<td>" . $row['Age'] . "</td>";
    echo "<td>" . $row['wereda'] . "</td>";
    echo "<td>" . $row['subcity'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['subsidy'] . "</td>";
    echo "<td>" . $row['heard_from'] . "</td>";
    echo "<td>" . $row['payment_1'] . "</td>";
    echo "<td>" . $row['payment_2'] . "</td>";
    echo "<td><a href='update.php?id=".$row['id']."'>Update</a> | <a href='delete.php?id=".$row['id']."'>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";

// Pagination links
$sql_pagination = "SELECT COUNT(id) AS total FROM users";
$result_pagination = $conn->query($sql_pagination);
$row_pagination = $result_pagination->fetch_assoc();
$total_pages = ceil($row_pagination['total'] / $results_per_page);

echo "<div class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='list_of_customers.php?page=$i&search=$search_query&date=$date_filter'>$i</a>"; // Ensure the link points to list.php
}
echo "</div>";
echo "</form>";
$conn->close();
?>




<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script src="js/main.js"></script>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">



</script>
</body>
</html>

