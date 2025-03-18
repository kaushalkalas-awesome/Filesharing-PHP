<?php
session_start();

// Include database connection script
include("database.php");

// Function to generate unique QR code for a file using Google Charts API
function generateQRCode($file_id) {
    // Generate QR code content (e.g., URL to download the file)
    $qr_code_content = "http://192.168.255.69/php_project/download.php?id=" . $file_id;

    // Return the QR code content
    return $qr_code_content;
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if file deletion is requested
if (isset($_GET['delete'])) {
    $file_id = $_GET['delete'];

    // Delete the file from the database
    $sql = "DELETE FROM user_files WHERE id=$file_id";
    if ($conn->query($sql) === TRUE) {
        // Delete the corresponding QR code file if it exists
        $qr_code_file = 'qrcodes/' . $file_id . '.png';
        if (file_exists($qr_code_file)) {
            unlink($qr_code_file);
        }
        echo "<script>alert('File Deleted Successfully');</script>";
    } else {
        echo "<script>alert('Error Deleting File');</script>";
    }
}

// Check if form is submitted
if (isset($_POST["submit"])) {
    $username = $_SESSION['username'];

    // File upload handling
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];

    // Read file content only if it's not empty
    if ($file_size > 0) {
        // Read file content
        $fp = fopen($file_tmp, 'r');
        $file_content = fread($fp, $file_size);
        fclose($fp);

        // Escape special characters
        $file_content = addslashes($file_content);

        // Insert file details into database
        $sql = "INSERT INTO user_files (username, file_name, file_size, file_type, file_content) VALUES ('$username', '$file_name', '$file_size', '$file_type', '$file_content')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('File Uploaded Successfully');</script>";
        } else {
            echo "<script>alert('File Uploading Error.');</script>";
        }
    } else {
        echo "<script>alert('Error: Uploaded file is empty.');</script>";
    }
}

// Retrieve uploaded files for the logged-in user
$username = $_SESSION['username'];
$sql = "SELECT * FROM user_files WHERE username='$username'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .qr-code {
            display: none;
            margin-top: 10px;
        }
        .top-right {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .userQRCode{
            display: flex;
            align-items: center;
            justify-content: left;
        }
    </style>
</head>
<body class="bg-gray-100 relative">
    <div class="container mx-auto mt-4">
        <h2 class="text-2xl font-bold mb-4">Welcome <?php echo $_SESSION['username']; ?>!</h2>
        <!-- Button to generate user QR code -->
        <button id="generateUserQRCodeBtn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded top-right">Generate User QR Code</button>
        <!-- Div to display user QR code -->
        <div id="userQRCode" class="qr-code"></div>
        <h3 class="mt-4 mb-2 text-xl font-bold">Upload File </h3><span>Max size: 5mb</span>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <input type="file" name="file" class="form-input" />
            </div>
            <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload</button>
        </form>
        <h3 class="mt-6 mb-2 text-xl font-bold">Uploaded Files</h3>
        <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='bg-white shadow-md rounded p-4 mb-4'>";
        echo "<h5 class='text-xl font-bold mb-2'>File: " . $row['file_name'] . "</h5>";
        echo "<p class='text-gray-700'>Size: " . $row['file_size'] . " bytes</p>";
        echo "<a href='download.php?id=" . $row['id'] . "' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2'>Download</a>";
        echo "<a href='?delete=" . $row['id'] . "' class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2'>Delete</a>";
        echo "<a href='view.php?id=" . $row['id'] . "' class='bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2'>View</a>";
        echo "<button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded' onclick='shareFile(" . $row['id'] . ")'>Share</button>";
        echo "</div>";
    }
} else {
    echo "<p>No files uploaded yet.</p>";
}
?>

<script>
    // JavaScript function to share the file via WhatsApp
    function shareFile(fileId) {
        // Compose the sharing message containing the file ID
        var message = "http://192.168.255.69/php_project/view.php?id=" + fileId + ".com";

        // Encode the message for use in the URL
        var encodedMessage = encodeURIComponent(message);

        // Open WhatsApp with the message
        window.location.href = "whatsapp://send?text=" + encodedMessage;
    }
</script>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to generate user QR code
            $('#generateUserQRCodeBtn').click(function() {
                var qrCodeContent = "http://192.168.255.69/php_project/view_files.php?username=<?php echo $_SESSION['username']; ?>";

                // Display the user QR code
                $('#userQRCode').html('<img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=' + encodeURIComponent(qrCodeContent) + '" alt="User QR Code" class="img-fluid" />');
                $('#userQRCode').show();
            });
        });

        $(document).ready(function() {
            // Function to share the URL via WhatsApp or email
            $('#shareURLBtn').click(function() {

                // Compose the message containing the URL
                var message = "Check out my uploaded files: " + '';

                // Open WhatsApp with the message
                window.location.href = "whatsapp://send?text=" + encodeURIComponent(message);
            });
        });
    </script>
    </script>
</body>
</html>
