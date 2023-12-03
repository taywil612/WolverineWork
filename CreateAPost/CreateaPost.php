<?php
session_start();

// Check if logged in 
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../homepage/error-page.html");
    exit();
}

// Connect to the database
include('../database/connection.php');

if ($_POST) {
    // Populating variables with form data
    $title = $_POST['title'];
    $caption = $_POST['caption'];
    // Need session variable to complete
    $username = $_SESSION['name'];

    // Prepared Statement to insert post info into the database
    $insert_post = "INSERT INTO post(username, title, caption) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_post);
    $stmt->bind_param("sss", $username, $title, $caption);
    $stmt->execute();
    
    // Getting the Auto Incremented ID from the last query
    $post_id = mysqli_insert_id($conn);

    // Close stmt
    $stmt->close();

    // Upload file to uploads folder
    include '../includes/upload.php';

    // Redirect back to the homepage
    header("Location: home");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">   
    <title>Submit Your Written Work</title>
    <link href='https://fonts.googleapis.com/css?family=Nunito+Sans' rel='stylesheet'>
    <link rel="shortcut icon" type="image/png" href="../img/placeholderlogo.png" />
    <link href='../NavigationBar/side-nav-ss.css' rel='stylesheet'>
    <link href='CaP.css' rel='stylesheet'>
    <style>
        #mySidebar {
            width: 0;
        }

        .c {
            margin-left: 0; /* Set initial margin to 0 */
        }
    </style>
</head>
<body>
    <?php include('../NavigationBar/side-nav.html'); ?>
    <div class="c">
        <div class="content">
            <div class="menu" onclick="openFilter()">☰</div>
            <h2>Submit your written work here!</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="centered-container">
                    <input type="text" name='title' placeholder="Title your work..." required>
                    <textarea rows="8" name='caption' placeholder="Add a caption..."></textarea>
                    <br>
                    <div class="upload-container">
                    <input type="file" class="custom-file-input" name="file-upload[]" id="file-upload" onchange="updateFileName(this)" accept=".pdf, .docx" required>
                        <label for="file-upload" class="custom-file-label">
                            <span class="custom-file-label-text">Click to browse</span>
                            <span class="custom-file-label-text">.docx or .pdf</span>
                            <span class="custom-file-label-text">Max 10 MB</span>
                        </label>
                        <div id="uploaded-files">No file selected</div>
                    </div>
                </div>
                <button type="submit" class="post-button">Post</button>
            </form>
        </div>
    </div>

    <script>
        // Display file name 
        function updateFileName(input) {
            const uploadedFiles = document.getElementById("uploaded-files");
            uploadedFiles.textContent = input.files[0] ? input.files[0].name : "No file selected";
        }

        // JS functions to open and close the sidebar
        function openFilter() {
            document.getElementById("mySidebar").style.width = "300px";
            document.getElementsByClassName("c")[0].style.marginLeft = "300px"; // Adjusted margin
        }

        function closeFilter() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementsByClassName("c")[0].style.marginLeft = "0";
        }
        </script>
</body>
</html>
