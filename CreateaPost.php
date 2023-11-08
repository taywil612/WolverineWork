
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">   
    <title>Submit Your Written Work</title>
    <link href='https://fonts.googleapis.com/css?family=Nunito+Sans' rel='stylesheet'>
    <link href='nav.css' rel='stylesheet'>
    <style>
        body {
            background-color: #00274C;
            font-family: 'Nunito Sans';
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
        }

        h2 {
            text-align: center;
            font-size: 40px;
            color: #00274C;
        }

        .container {
            margin-top: 60px;
            background-color: white;
            padding: 20px;
            width: 75%;
            height: 100%;
        }

        input[type="text"], textarea {
            width: 80%;
            padding: 15px;
            margin: 10px 0;
            background-color: white;
            border: 1px solid gray;
            border-radius: 10px;
            box-sizing: border-box;
            box-shadow: 1px 10px 5px 0px rgba(161,152,152,0.75);
            font-family: 'Nunito Sans';
            font-size: 15px;
        }

        .centered-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .upload-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 80%;
            padding: 15px;
            margin: 5%;
            background-color: white;
            border: 1px solid gray;
            border-radius: 10px;
            box-sizing: border-box;
            box-shadow: 1px 10px 5px 0px rgba(161,152,152,0.75);
            font-family: 'Nunito Sans';
            font-size: 12px;
            
        }

        .custom-file-input {
            display: none;
        }

        .custom-file-label {
            width: 20%;
            background-color: #ccc;
            padding: 30px;
            border: 2px solid #333;
            border-radius: 10px;
            border-color: darkgray;
            border-style: dashed;
            cursor: pointer;
            font-size: 15px;
            font-family: 'Nunito Sans';
            text-align: center;
            font: bold;
        }

        .custom-file-label-text {
            display: block;
        }

        #uploaded-files {
            text-align: right;
            font-size: 15px;
            margin-right: 50%;
        }

        .custom-file-label:hover {
            opacity: 0.75;
        }

        .post-button {
            background-color: navy;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-family: 'Nunito Sans';
            background-color: #00274C;
            margin-left: 10%;
            width: 20%;
        }

        .post-button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include("sidenav.html")?>
        <h2>Submit your written work here!</h2>
        <form method="POST">
            <div class="centered-container">
                <input type="text" placeholder="Title your work..." required>
                <textarea rows="8" placeholder="Add a caption..."></textarea>
                <br>
                <div class="upload-container">
                    <input type="file" class="custom-file-input" id="file-upload" onchange="updateFileName(this)" required>
                    <label for="file-upload" class="custom-file-label">
                        <span class="custom-file-label-text">Click to browse</span>
                        <span class="custom-file-label-text">.docx or .pdf</span>
                        <span class="custom-file-label-text">Max 10 MB</span>
                    </label>
                    <div id="uploaded-files">No file selected</div>
                </div>
            </div>
            <button type="submit" class="post-button" onclick="location.href='home'"">Post</button>
        </form>
    </div>

    <script>
        function updateFileName(input) {
            const uploadedFiles = document.getElementById("uploaded-files");
            uploadedFiles.textContent = input.files[0] ? input.files[0].name : "No file selected";
        }
    </script>
</body>
</html>