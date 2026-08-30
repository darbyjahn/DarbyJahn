<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);

// Where the message should be sent
$to = "Darby@gmail.com";
$subject = "Website Contact";

// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Invalid request method");
}

// Get form data
$name    = trim($_POST["name"] ?? "");
$email   = trim($_POST["email"] ?? "");
$message = trim($_POST["message"] ?? "");

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit("Invalid email address??");
}

// Validate message
if ($message === "") {
    http_response_code(400);
    exit("You should probably write something first");
}

// Build email
$body  = "Name: " . $name . "\n";
$body .= "Email: " . $email . "\n\n";
$body .= "Message:\n" . $message;

// Headers
$headers  = "From: Darby Jahn <no-reply@darbyjahn.com>\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send
if (mail($to, $subject, $body, $headers)) {

    // Tell JavaScript it worked
    http_response_code(200);
    echo "Message sent";

} else {

    http_response_code(500);
    echo "Please try again.";
}
?>