<?php
// Include database connection script
include("database.php");

// Check if username is provided in the URL parameter
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Retrieve uploaded files for the specified user
    $sql = "SELECT * FROM user_files WHERE username='$username'";
    $result = $conn->query($sql);
} else {
    // Redirect to login page if username is not provided
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Files</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-4 px-4">
        <h2 class="text-2xl font-bold mb-4">Files Uploaded by <?php echo htmlspecialchars($username); ?></h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">File Name</th>
                        <th class="px-4 py-2 text-left">Size</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display uploaded files
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='border px-4 py-2 text-left'>" . htmlspecialchars($row['file_name']) . "</td>";
                            echo "<td class='border px-4 py-2 text-left'>" . htmlspecialchars($row['file_size']) . " bytes</td>";
                            echo "<td class='border px-4 py-2 text-left'>";
                            echo "<a href='download.php?id=" . htmlspecialchars($row['id']) . "' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Download</a>";
                            echo "<a href='view.php?id=" . htmlspecialchars($row['id']) . "' class='bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2'>View</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td class='border px-4 py-2 text-center' colspan='3'>No files uploaded yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
