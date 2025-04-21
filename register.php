<?php
// register.php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $verification_code = md5(uniqid(rand(), true));

    $sql = "INSERT INTO users (email, password, verification_code) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $password, $verification_code);

    if ($stmt->execute()) {
        // Send verification email
        $to = $email;
        $subject = "Email Verification";
        $message = "Please verify your email by clicking the link: <a href='http://yourdomain.com/verify.php?code=$verification_code'>Verify Email</a>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@yourdomain.com" . "\r\n"; // Add From header

        if (mail($to, $subject, $message, $headers)) {
            echo "Registration successful, please verify your email.";
        } else {
            echo "Error sending verification email.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
