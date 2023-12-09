<?php
    session_start();

    // Connect to the database
    include('../database/connection.php');

    // Check if logged in 
    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../homepage/error-page.html");
        exit();
    }

    $username = isset($_GET['username']) ? $_GET['username'] : '';
  
    //Get about me content
    $getAboutMe= "SELECT about_me FROM account WHERE username='$username'";
    $result = $conn->query($getAboutMe);
    $about_me = $result->fetch_column();

    //Get contact me content
    $getContactMe= "SELECT contact_me FROM account WHERE username='$username'";
    $result = $conn->query($getContactMe);
    $contact_me = $result->fetch_column();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">   
    <title>User Profile</title>
    <link href='https://fonts.googleapis.com/css?family=Nunito+Sans' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link href='../NavigationBar/side-nav-ss.css' rel='stylesheet'>

    <!-- For space between content and footer -->
    <link rel="stylesheet" href="homepage.css"> 
    <link rel="stylesheet" href="../Footer/footer.css"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        #mySidebar {
            width: 0;
        }

        .c {
            margin-left: 0; /* Set initial margin to 0 */
        }
    </style>

   
</head>
<body >
    <?php  include('../NavigationBar/side-nav.php'); ?> 
    <div class="c">
        <div class="container">
                <div class="menu" onclick="openFilter()">☰</div>
                
                <div class="profile-card">
                <div class="profile-picture">
                    <input type="file" id="profile-image-input" class="custom-file-input" accept="image/*">
                    <label for="profile-image-input" class="custom-file-label">
                        <span class="custom-file-label-text">Change Profile Picture</span>
                    </label>
                    <img id="profile-image-preview" src="placeholder.jpg" alt="Profile Picture">
                </div>
    

                <!-- Name Section -->
                <div class="name-section">
                    <!-- Display Username -->
                    <h3 class="name-editable"><span class="name-text"><?=$username?></span></h3>

                </div>

                <div class="spacer"> </div>


                <!-- About Me Section -->
                <div class="about-me">
                    <h3>About Me</h3><br>
                    <pre><p><?=$about_me?></p></pre>

                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <textarea id="about-me-input" rows="4" name="about_me_text" placeholder= "Write something about yourself.."></textarea>
                        <input class="input-button" type="submit" value="Save My Edits" name="about_me_button">  
                    </form>    
                </div>
                
                <?php
                   if(isset($_POST['about_me_button']))
                   {   
                       // refresh current page to update info
                       header("location:../Profile/Profile.php?username=" . $_SESSION['name'] .""); 
                    
                       $textareaValue = trim($_POST['about_me_text']);

                       $username = ($_SESSION['name']);
                       $sql = "UPDATE account SET about_me = '$textareaValue' WHERE username= '$username'";
                       
                       // Prepare statement
                       $stmt = $conn->prepare($sql);
                        // execute the query
                       $stmt->execute();
                       $stmt->close();
                   }
                ?>

                <!-- Contact Me Section -->
                <div class="contacts">
                    <h3>Contact Me</h3><br>
                    <pre><p><?=$contact_me?></p></pre>

                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <textarea id="contacts-input" rows="4" name="contact_me_text" placeholder="Add your contact information..."></textarea>
                        <input class="input-button" type="submit" value="Save My Edits" name="contact_me_button"> 
                    </form>    
                </div>

                <?php
                   if(isset($_POST['contact_me_button']))
                   {   
                       // refresh current page to update info
                       header("location:../Profile/Profile.php?username=" . $_SESSION['name'] .""); 
                    
                       $textareaValue = trim($_POST['contact_me_text']);

                       $username = ($_SESSION['name']);
                       $sql = "UPDATE account SET contact_me = '$textareaValue' WHERE username= '$username'";
                       
                       // Prepare statement
                       $stmt = $conn->prepare($sql);
                        // execute the query
                       $stmt->execute();
                       $stmt->close();
                   }
                ?>



            </div>

            <div class="posts">
                <div class="posts-title">
                    <h3>Posts</h3>
                </div>
                <div class="posts-content">
                    <!-- Placeholder posts with like, comments, and edit buttons -->
                    <div class="post">
                        <img src="placeholder.jpg" alt="Post">
                        <div class="post-actions">
                            <div class="like-container">
                                <div class="like-button" onclick="increaseLike(this)">&#x2665;</div>
                                <span class="like-counter">0</span>
                            </div>
                            <div class="edit-button">✏️</div>
                        </div>
                    </div>
                    <div class="post">
                        <img src="placeholder.jpg" alt="Post">
                        <div class="post-actions">
                            <div class="like-container">
                                <div class="like-button" onclick="increaseLike(this)">&#x2665;</div>
                                <span class="like-counter">0</span>
                            </div>
                            <div class="edit-button">✏️</div>
                        </div>
                    </div>
                    <div class="post">
                        <img src="placeholder.jpg" alt="Post">
                        <div class="post-actions">
                            <div class="like-container">
                                <div class="like-button" onclick="increaseLike(this)">&#x2665;</div>
                                <span class="like-counter">0</span>
                            </div>
                            <div class="edit-button">✏️</div>
                        </div>
                    </div>
                    <div class="post">
                        <img src="placeholder.jpg" alt="Post">
                        <div class="post-actions">
                            <div class="like-container">
                                <div class="like-button" onclick="increaseLike(this)">&#x2665;</div>
                                <span class="like-counter">0</span>
                            </div>
                            <div class="edit-button">✏️</div>
                        </div>
                    </div>
                    <div class="post">
                        <img src="placeholder.jpg" alt="Post">
                        <div class="post-actions">
                            <div class="like-container">
                                <div class="like-button" onclick="increaseLike(this)">&#x2665;</div>
                                <span class="like-counter">0</span>
                            </div>
                            <div class="edit-button">✏️</div>
                        </div>
                    </div>
                    <div class="post">
                        <img src="placeholder.jpg" alt="Post">
                        <div class="post-actions">
                            <div class="like-container">
                                <div class="like-button" onclick="increaseLike(this)">&#x2665;</div>
                                <span class="like-counter">0</span>
                            </div>
                            <div class="edit-button">✏️</div>
                        </div>
                    </div>
                    <div class="post">
                        <img src="placeholder.jpg" alt="Post">
                        <div class="post-actions">
                            <div class="like-container">
                                <div class="like-button" onclick="increaseLike(this)">&#x2665;</div>
                                <span class="like-counter">0</span>
                            </div>
                            <div class="edit-button">✏️</div>
                        </div>
                    </div>
                    <div class="post">
                        <img src="placeholder.jpg" alt="Post">
                        <div class="post-actions">
                            <div class="like-container">
                                <div class="like-button" onclick="increaseLike(this)">&#x2665;</div>
                                <span class="like-counter">0</span>
                            </div>
                            <div class="edit-button">✏️</div>
                        </div>
                    </div>
                    <div class="post">
                        <img src="placeholder.jpg" alt="Post">
                        <div class="post-actions">
                            <div class="like-container">
                                <div class="like-button" onclick="increaseLike(this)">&#x2665;</div>
                                <span class="like-counter">0</span>
                            </div>
                            <div class="edit-button">✏️</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="spacer"> </div>

    <!-- Footer Section -->
    <footer>
        <style>
            .footer{
                margin-top: 10%;
            }
        </style>
        <?php  include('../Footer/Footer.html'); ?> 
    </footer>
    
    <script>
        // JS functions to open and close the sidebar
        function openFilter() {
            document.getElementById("mySidebar").style.width = "300px";
            document.getElementsByClassName("c")[0].style.marginLeft = "300px"; 
        }

        function closeFilter() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementsByClassName("c")[0].style.marginLeft = "0";
        }


        const profileImageInput = document.getElementById("profile-image-input");
        const profileImagePreview = document.getElementById("profile-image-preview");


        const nameSection = document.querySelector(".name-section");
        const nameText = document.querySelector(".name-text");

        const aboutMeInput = document.getElementById("about-me-input");
        const contactsInput = document.getElementById("contacts-input");
    
        profileImageInput.addEventListener("change", function () {
            const file = profileImageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    profileImagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    
       
        
        function enableNameEdit(element) {
            const nameEditable = document.createElement("input");
            nameEditable.type = "text";
            nameEditable.value = nameText.innerText;
            nameEditable.className = "name-edit";
            nameEditable.addEventListener("keyup", function (event) {
                if (event.key === "Enter") {
                    disableNameEdit(element, nameEditable.value);
                }
            });

            element.innerHTML = ""; // Clear the content
            element.appendChild(nameEditable);
            nameEditable.focus();
            nameEditable.select(); // Select the text in the input field for easy editing

        }

        function disableNameEdit(element, newName) {
            const newNameText = document.createTextNode(newName);
            element.innerHTML = ""; // Clear the content
            const newH3 = document.createElement("h3");
            newH3.className = "name-editable";
            newH3.onclick = function () {
                enableNameEdit(this);
            };
            newH3.appendChild(newNameText);
            element.replaceWith(newH3);
        }
    
        document.addEventListener("click", function (event) {
            const nameEditable = document.querySelector(".name-edit");
            if (nameEditable && !nameSection.contains(event.target)) {
                disableNameEdit(nameSection, nameEditable.value);
            }
        });
    
        nameSection.onclick = function () {
            enableNameEdit(this);
        };
    


        const likedPosts = new Set(); // Set to store liked posts

        function increaseLike(button) {
            if (!likedPosts.has(button)) {
            const counter = button.nextElementSibling;
            let currentLikes = parseInt(counter.innerText);
            counter.innerText = currentLikes + 1;
            likedPosts.add(button);

            // Toggle the red class for the heart icon
            button.classList.toggle("red");
            }   
        }

    </script>
    
</body>
</html>