<?php
// delete.php

$uploadDir = 'uploads/';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileName = basename($_POST['file']);
    $filePath = $uploadDir . $fileName;
    $password = $_POST['password'];

    // Replace 'admin_password' with the actual password you want to use
    if ($password === 'admin_password') {
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file
            unlink($filePath . '.json'); // Delete the metadata file
            echo "File deleted successfully!";
        } else {
            echo "File not found.";
        }
    } else {
        echo "Incorrect password.";
    }
}
?>

