<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Recipient email
$to = "Darby@gmail.com;
$subject = "Website Contact";

// Only handle POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Invalid request method");
}

// Collect and sanitize form data
$name    = trim($_POST["name"] ?? "Not provided");
$email   = trim($_POST["email"] ?? "");
$message = trim($_POST["message"] ?? "");

// Basic validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit("Invalid email address");
}
if ($message === "") {
    http_response_code(400);
    exit("Message cannot be empty");
}

// Build email body
$body  = "Name: $name\n";
$body .= "Email: $email\n\n";
$body .= "Message:\n$message";

// Headers: From is your domain, Reply-To is user email
$headers  = "From: Darby Jahn <no-reply@darbyjahn.com>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
if (mail($to, $subject, $body, $headers)) {
    // Redirect back to homepage with success flag
    header("Location: index.html?sent=1");
    exit();
} else {
    // Failure
    http_response_code(500);
    echo "Message did not send... womp womp. Please try again.";
}
?>