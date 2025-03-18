<?php
session_start();

// Include database connection script
include("database.php");

// Check if file ID is provided
if(isset($_GET['id'])) {
    $file_id = $_GET['id'];
    
    // Query to retrieve file details
    $sql = "SELECT * FROM user_files WHERE id='$file_id'";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        // Fetch file details
        $row = $result->fetch_assoc();
        $file_name = $row['file_name'];
        $file_size = $row['file_size'];
        $file_type = $row['file_type'];
        $file_content = $row['file_content'];

        // Set headers for file download
        header("Content-type: $file_type");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-length: $file_size");

        // Output file content
        echo $file_content;
    } else {
        echo "File not found";
    }
} else {
    echo "Invalid file ID";
}
?>
