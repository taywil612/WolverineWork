<?php
session_start();

// Check if logged in, otherwise display sidebar for users not logged in/unregistered
if (!isset($_SESSION['loggedin'])) {
    include('../NavigationBar/side-nav-unreg.html');
}

if (isset($_SESSION['loggedin'])){
    include('../NavigationBar/side-nav.html');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=1440, maximum-scale=1.0" />
        <link rel="shortcut icon" type="image/png" href="../img/placeholderlogo.png" />
        <meta name="twitter:card" content="photo" />

        <link href='https://fonts.googleapis.com/css?family=Nunito+Sans' rel='stylesheet'>
        <link rel="stylesheet" href="homepage.css"> 
        <link href='../NavigationBar/side-nav-ss.css' rel='stylesheet'>
        
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

        <div class="c">
            <div class="menu" onclick="openFilter()">&#9776;</div>
            <div class= "post">
                <div class= "profile">
                    <div class= "profile-img">
                        <img id="profile-image-preview" src="../img/avatarPic2.png" alt="Profile Picture">
                    </div>
                </div>
                    <div class="profile-name">
                        <p>username</p>
                    </div>

                <div class="essayTitle">
                    <h2>Essay Title</h2>
                </div>

                <div class="essay">
                    <h3>Essay</h3>
                </div>

                <div class="like-button">&#x2665; 5</div>             
            </div>
           
            
        </div>

        <script>
            const likeButtons = document.querySelectorAll(".like-button");
            likeButtons.forEach(button => {
            button.addEventListener("click", function () {
                button.classList.toggle("red");
            });

            const newComment = document.getElementById("newComment");
            });

            // JS functions to open and close the sidebar
            function openFilter() {
                document.getElementById("mySidebar").style.width = "300px";
                document.getElementsByClassName("c")[0].style.marginLeft = "300px"; 
            }

            function closeFilter() {
                document.getElementById("mySidebar").style.width = "0";
                document.getElementsByClassName("c")[0].style.marginLeft = "0";
            }
        </script>
      

    </body>

</html>
