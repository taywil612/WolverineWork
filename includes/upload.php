<?php
$uploadDir = '../uploads/';
$maxFileSize = 10 * 1024 * 1024; // 10 MB

if (isset($_FILES['file-upload'])) {
    $files = $_FILES['file-upload'];
    foreach ($files['tmp_name'] as $key => $tmpName) {
        $fileName = $files['name'][$key];
        $fileSize = $files['size'][$key];
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $uploadPath = $uploadDir . $fileName;

        // Check file type
        $allowedTypes = ['pdf', 'docx'];
        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo "Error: Only .pdf and .docx files are allowed.";
            continue; 
        }

        // Check file size
        if ($fileSize > $maxFileSize) {
            echo "Error: File size exceeds the maximum limit of 10 MB.";
            continue; 
        }

        // Move uploaded file to the destination
        if (move_uploaded_file($tmpName, $uploadPath)) {
            $insertQuery = "INSERT INTO files (post_id, file_name) 
                            VALUES ('$post_id', '$fileName')";
            if ($conn->query($insertQuery) !== TRUE) {
                echo "Error inserting file details: " . $conn->error;
            }
        }
    }
}
?>