<?php
// upload.php

$uploadDir = 'uploads/';
$uploadTime = date('Y-m-d H:i:s');

// Ensure the upload directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);

    // Move uploaded file to the uploads directory
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        // Create metadata for the file
        $metadata = [
            'upload_time' => $uploadTime,
            'upload_ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ];

        // Save metadata to a JSON file
        file_put_contents($uploadFile . '.json', json_encode($metadata));

        echo "File uploaded successfully!";
    } else {
        echo "File upload failed.";
    }
} else {
    echo "No file uploaded or invalid request.";
}
?>

