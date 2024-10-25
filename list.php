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
echo "<form method='GET' action='list.php'>"; // Ensure action is set to list.php
echo "<input type='text' name='search' placeholder='Search by Name or Phone Number' value='$search_query'>"; // Set value attribute to maintain search query
echo "<button type='submit'>search</button>";
echo "<input type='date' name='date' placeholder='Filter by Date' value='$date_filter'>"; // Set value attribute to maintain date filter
echo "<button type='submit'>filter</button>";
echo "<button type='submit' name='generate_report'>Generate report</button>";
echo "</form>";

// Display data table
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
    echo "<td><a href='update.php?id=".$row['id']."'>Update</a> | <a href='delete.php?id=".$row['id']."'>Delete</a></td>"; // Add action buttons
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
    echo "<a href='list.php?page=$i&search=$search_query&date=$date_filter'>$i</a>"; // Ensure the link points to list.php
}
echo "</div>";

$conn->close();
?>
