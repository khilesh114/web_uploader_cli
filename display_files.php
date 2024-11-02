<?php
// display_files.php

$uploadDir = 'uploads/'; // Set the directory for uploaded files

// Check if the upload directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
}

// Get all files in the upload directory
$files = scandir($uploadDir);
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..' && !is_dir($uploadDir . $file)) {
        // Load metadata
        $metadataFile = $uploadDir . $file . '.json';
        if (file_exists($metadataFile)) {
            $metadata = json_decode(file_get_contents($metadataFile), true);
        } else {
            $metadata = [];
        }

        // Display each file
        echo '<div class="gallery-item">';
        $filePath = $uploadDir . $file;
        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

        // Display images, videos, ISO files, and other file types accordingly
        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo '<img src="' . htmlspecialchars($filePath) . '" alt="' . htmlspecialchars($file) . '" class="file-image">';
        } elseif (in_array($fileExtension, ['mp4', 'mov', 'avi', 'wmv', 'flv', 'mkv', 'webm'])) {
            echo '<video controls class="file-video"><source src="' . htmlspecialchars($filePath) . '" type="video/' . htmlspecialchars($fileExtension) . '">Your browser does not support the video tag.</video>';
        } elseif ($fileExtension === 'iso') {
            echo '<div class="iso-file">';
            echo '<img src="iso-icon.png" alt="ISO File" class="file-icon">'; // Placeholder for ISO files
            echo '<p>' . htmlspecialchars($file) . ' (ISO file)</p>';
            echo '</div>';
        } else {
            echo '<p>' . htmlspecialchars($file) . '</p>';
        }

        // Display metadata
        echo '<p>Uploaded on: ' . htmlspecialchars($metadata['upload_time'] ?? 'N/A') . '</p>';
        echo '<p>Uploaded from IP: ' . htmlspecialchars($metadata['upload_ip'] ?? 'N/A') . '</p>';
        echo '<p>User Agent: ' . htmlspecialchars($metadata['user_agent'] ?? 'N/A') . '</p>';

        // Add a download button
        echo '<a href="' . htmlspecialchars($filePath) . '" download="' . htmlspecialchars($file) . '">
                <button>Download</button>
              </a>';
        
        // Add delete option
        echo '<form action="delete.php" method="post" onsubmit="return confirm(\'Are you sure you want to delete this file?\');">
                <input type="hidden" name="file" value="' . htmlspecialchars($file) . '">
                <input type="password" name="password" placeholder="Enter password" required>
                <button type="submit">Delete</button>
              </form>';

        echo '</div>'; // End of gallery item
    }
}
?>

