<?php
    session_start();

    $username = isset($_GET['username']) ? $_GET['username'] : '';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">   
    <title>User Profile</title>
    <link href='https://fonts.googleapis.com/css?family=Nunito+Sans' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
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
                <div class="name-section">
                    <h3 class="name-editable" onclick="enableNameEdit(this)"><span class="name-text">John Doe</span></h3>
                </div>
                <div class="about-me">
                    <h3>About Me</h3>
                    <textarea id="about-me-input" rows="4" placeholder="Write something about yourself..."></textarea>
                </div>
                <div class="contacts">
                    <h3>Contact Me</h3>
                    <textarea id="contacts-input" rows="4" placeholder="Add your contact information..."></textarea>
                </div>
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