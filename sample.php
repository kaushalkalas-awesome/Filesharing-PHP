<?php
    // Include the PHP QR Code library
    include('phpqrcode/qrlib.php');
    include('config.php'); // Assuming this file contains configuration settings
    
    // Define the temporary directory for storing PNG files
    $tempDir = "qrcodes/";
    
    // Define the content for the QR code
    $codeContents = 'This Goes From File';
    
    // Generate a unique filename for the QR code
    $fileName = '005_file_'.md5($codeContents).'.png';
    
    // Define the absolute file path for the PNG file
    $pngAbsoluteFilePath = $tempDir.$fileName;
    
    // Define the URL-relative file path for the PNG file
    $urlRelativeFilePath = "http://localhost/php_project/qrcodes/".$fileName;
    
    // Generate the QR code if it doesn't already exist
    if (!file_exists($pngAbsoluteFilePath)) {
        QRcode::png($codeContents, $pngAbsoluteFilePath);
        echo 'File generated!';
        echo '<hr />';
    } else {
        echo 'File already generated! We can use this cached file to speed up site on common codes!';
        echo '<hr />';
    }
    
    // Display the server PNG file path
    echo 'Server PNG File: '.$pngAbsoluteFilePath;
    echo '<hr />';
    
    // Display the QR code image
    echo '<img src="'.$urlRelativeFilePath.'" />';
?>
