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

// Include database connection script
include("database.php");

// Function to generate a random OTP
function generateOTP() {
    $otp = rand(100000, 999999); // Generate a 6-digit OTP
    return $otp;
}

// Check if form is submitted
if(isset($_POST["submit"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Check if email already exists
    $sql_check_email = "SELECT id FROM users WHERE email='$email'";
    $result_check_email = $conn->query($sql_check_email);

    if ($result_check_email->num_rows > 0) {
        // Email already exists
        echo "Email already exists. Please choose a different email.";
    } else {
        // Generate OTP
        $otp = generateOTP();

        // Send OTP to the user's email address using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Enable verbose debug output
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Uncomment for debugging

            // Set mailer to use SMTP
            $mail->isSMTP();

            // Specify SMTP server credentials
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'kalaskaushal@gmail.com'; // Your SMTP username
            $mail->Password = 'pqmwpshgquyzhixh'; // Your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set email parameters
            $mail->setFrom('kalaskaushal@gmail.com', 'File Forge'); // Your email address and name
            $mail->addAddress($email); // Recipient's email address
            $mail->Subject = 'OTP Verification';
            $mail->Body = 'Your OTP for signup is: ' . $otp;

            // Send email
            $mail->send();
            echo "An OTP has been sent to your email address for verification.";

            // Store OTP and signup data in session for verification
            $_SESSION['otp'] = $otp;
            $_SESSION['signup_data'] = array(
                'username' => $username,
                'password' => $password,
                'email' => $email
            );

            // Redirect to OTP verification page
            header("Location: verify_otp.php");
            exit();
        } catch (Exception $e) {
            echo "Failed to send OTP. Please try again later. Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-blue-400 to-indigo-600 flex justify-center items-center h-screen">
    <div class="max-w-md w-full mx-auto bg-white rounded-lg p-8 shadow-lg">
        <h2 class="text-3xl font-bold mb-4 text-center text-black-600">Get Started!</h2>
        <form action="signup.php" method="post">
            <div class="mb-4">
                <input type="text" name="username" id="username" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your username" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" id="password" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your password" required>
            </div>
            <div class="mb-4">
                <input type="email" name="email" id="email" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your email" required>
            </div>
            <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-full">Signup</button>
        </form>
    </div>
</body>
</html>
