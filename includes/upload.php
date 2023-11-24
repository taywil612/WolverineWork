<?php

$uploadDir = '../uploads/';

if (isset($_FILES['file-upload'])) {
    $files = $_FILES['file-upload'];
    foreach ($files['tmp_name'] as $key => $tmpName) {
        $fileName = $files['name'][$key];
        $uploadPath = $uploadDir . $fileName;

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