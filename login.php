<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include hCaptcha script -->
    <script src="https://hcaptcha.com/1/api.js" async defer></script>
</head>
<body class="bg-gradient-to-r from-blue-400 to-indigo-600 flex justify-center items-center h-screen">
    <div class="max-w-md w-full mx-auto bg-white rounded-lg p-8 shadow-lg">
        <h2 class="text-3xl font-bold mb-4 text-center text-black-600">Welcome Back!</h2>
        <?php
        session_start();

        // Check if form is submitted
        if(isset($_POST["submit"])) {
            // Verify hCaptcha response
            if(isset($_POST['h-captcha-response'])) {
                $captchaResponse = $_POST['h-captcha-response'];
                $secretKey = "ES_933b7f919d3f41158b1ab3c9496bdbf9"; // Your hCaptcha secret key

                // Send POST request to hCaptcha verification endpoint
                $url = 'https://hcaptcha.com/siteverify';
                $data = array(
                    'secret' => $secretKey,
                    'response' => $captchaResponse
                );

                $options = array(
                    'http' => array(
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($data)
                    )
                );

                $context = stream_context_create($options);
                $response = file_get_contents($url, false, $context);
                $result = json_decode($response, true);

                // Check if hCaptcha verification is successful
                if(!$result['success']) {
                    echo "<script>alert('hCaptcha verification failed. Please try again')</script>";
                    exit; // Stop execution if verification fails
                }
            } else {
                echo "<script>alert('hCaptcha verification response not found')</script>";
                exit; // Stop execution if response not found
            }

            // Database connection
            include("database.php");

            $username = $_POST['username'];
            $password = $_POST['password'];

            // Check if username exists
            $sql_check = "SELECT id FROM users WHERE username='$username'";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows == 0) {
                // Username doesn't exist
                echo "<script>alert('Username not found. Please sign up first')</script>";
            } else {
                // Prepare SQL statement for login validation
                $sql = "SELECT id FROM users WHERE username=? AND password=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();
                $result = $stmt->get_result();

                if (!$result) {
                    // Query execution failed
                    die("<div class='alert alert-danger' role='alert'>Query failed: " . $conn->error . "</div>");
                }

                if ($result->num_rows == 1) {
                    // Login successful
                    $_SESSION['username'] = $username;
                    header("Location: upload.php");
                    exit; // Ensure script stops executing after redirection
                } else {
                    // Invalid username or password
                    echo "<scirpt>alert('Invalid username or password');</script>";
                }

                $stmt->close();
            }

            $conn->close();
        }
        ?>
        <form action="login.php" method="post">
            <div class="mb-4">
                <input type="text" name="username" id="username" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your username" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" id="password" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your password" required>
            </div>
            <!-- Add hCaptcha widget -->
            <div class="h-captcha mb-3" data-sitekey="4e400649-aca0-4d67-907b-980b527fb562"></div>
            <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-full">Login</button>
        </form>
    </div>
</body>
</html>
