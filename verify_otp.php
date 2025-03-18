<?php
session_start();

// Include PHPMailer Autoload file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";
// Adjust the path as per your project structure

// Include database connection script
include("database.php");

// Check if OTP and signup data are stored in session
if (!isset($_SESSION['otp']) || !isset($_SESSION['signup_data'])) {
    echo "Session data not found. Please go back to the signup page.";
    exit();
}

// Check if form is submitted
if (isset($_POST["submit"])) {
    $otp_entered = $_POST['otp'];
    $otp_generated = $_SESSION['otp'];
    $signup_data = $_SESSION['signup_data'];

    // Verify OTP
    if ($otp_entered == $otp_generated) {
        // Insert user data into the database
        $username = $signup_data['username'];
        $password = $signup_data['password'];
        $email = $signup_data['email'];

        // Insert user data into the database
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

        if ($conn->query($sql) === TRUE) {
            // Clear session data
            unset($_SESSION['otp']);
            unset($_SESSION['signup_data']);
            // Redirect to upload.php
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-blue-400 to-indigo-600 flex justify-center items-center h-screen">
    <div class="max-w-md w-full mx-auto bg-white rounded-lg p-8 shadow-lg">
        <h2 class="text-3xl font-bold mb-4 text-center text-black-600">OTP Verification</h2>
        <form action="verify_otp.php" method="post">
            <div class="mb-4">
                <input type="text" name="otp" id="otp" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter OTP" required>
            </div>
            <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-full">Verify OTP</button>
        </form>
    </div>
</body>
</html>

