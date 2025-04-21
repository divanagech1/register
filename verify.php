<?php
// verify.php
include 'config.php';

if (isset($_GET['code'])) {
    $verification_code = $_GET['code'];

    $sql = "UPDATE users SET verified = 1 WHERE verification_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $verification_code);

    if ($stmt->execute()) {
        echo "Email verified successfully.";
    } else {
        echo "Invalid verification code.";
    }

    $stmt->close();
    $conn->close();
}
