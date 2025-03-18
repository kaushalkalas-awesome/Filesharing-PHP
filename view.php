<?php
session_start();

// Include database connection script
include("database.php");

// Check if file ID is provided in the URL
if (isset($_GET['id'])) {
    $file_id = $_GET['id'];

    // Retrieve file details from the database
    $sql = "SELECT * FROM user_files WHERE id=$file_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_name = $row['file_name'];
        $file_content = $row['file_content'];

        // Set appropriate headers for file download
        header("Content-Disposition: inline; filename=\"$file_name\"");
        header("Content-Type: " . $row['file_type']);
        header("Content-Length: " . $row['file_size']);

        // Output file content
        echo $file_content;
    } else {
        echo "File not found.";
    }
} else {
    echo "File ID not provided.";
}
?>
