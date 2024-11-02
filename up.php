<?php
// Define the target directory where files will be uploaded
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);

// Create the uploads directory if it doesn't exist
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// Check if the file is a valid upload
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}
?>
