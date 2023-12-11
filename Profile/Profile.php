<?php
    session_start();

    // Connect to the database
    include('../database/connection.php');

    //PHP file for handling likes for the like buttons
    include('../homepage/like_handler.php');
       

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

    /*
    // Function to get like count for a post
    function getLikeCount($post_id, $conn) {
        $getLikes = "SELECT COUNT(*) as like_count FROM likes WHERE post_id=$post_id";
        $result = $conn->query($getLikes);
        $row = $result->fetch_assoc();
        return $row['like_count'];
    }
*/
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
                <div class='profile-picture'>
                    <img src='../Profile/profilepic.png' alt='Profile Picture' id='profile-picture'>
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
                <?php
                    $getPosts = "SELECT * FROM post WHERE username='$username' ORDER BY created_at DESC";
                    $resultPosts = $conn->query($getPosts);

                while ($row = $resultPosts->fetch_assoc()) {
                    $postId = $row['post_id'];
                    $title = $row['title'];
                    $caption = $row['caption'];

                    echo "<div class='post'>";
                    echo "<div class='post-details'>";
                    echo "<h4>$title</h4>";
                    echo "<p>$caption</p>";
                    echo "</div>";                   
                    echo "<div class='post-actions'>";

                    
                    echo "<div class='like-container'>";
                    echo "<div class='like-button' onclick='increaseLike(this, $postId)'>&#x2665;</div>";
                    echo "<span class='like-counter'>" . getLikeCount($postId) . "</span>";
                    echo "</div>";
                    echo "<div class='edit-button'>✏️</div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
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

        // Set a fixed height for all posts
        function setFixedPostHeight() {
            const posts = document.querySelectorAll('.post');

            posts.forEach(post => {
                post.style.height = '350px'; // Adjust the height as needed
            });
        }

        // Call the function once the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', setFixedPostHeight);

        // Call the function again if the window is resized
        window.addEventListener('resize', setFixedPostHeight);


        const nameSection = document.querySelector(".name-section");
        const nameText = document.querySelector(".name-text");

        const aboutMeInput = document.getElementById("about-me-input");
        const contactsInput = document.getElementById("contacts-input");

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

        //Updated Increase Like function (same as home page)
        const likedPosts = new Set(JSON.parse(localStorage.getItem('likedPosts')) || []);

        function increaseLike(button, post_id) {
            // Check if the post_id is already liked
            if (!likedPosts.has(post_id)) {
                const counter = button.nextElementSibling;
                let currentLikes = parseInt(counter.innerText);
                counter.innerText = currentLikes + 1;
                likedPosts.add(post_id);

                // Toggle the red class for the heart icon
                button.classList.toggle("red");

                // Store updated likedPosts in localStorage
                localStorage.setItem('likedPosts', JSON.stringify(Array.from(likedPosts)));

                // Send an AJAX request to insert the like into the database
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'like_handler.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Like successfully inserted into the database
                        console.log(xhr.responseText);
                    }
                };
                
                // Get the username from the session
                const username = "<?php echo $_SESSION['name']; ?>";
                // Send the post_id and username to the server
                xhr.send('post_id=' + post_id + '&username=' + username);
                
            }
            else {
                // The post is already liked, keep the button red
                button.classList.add("red");
            }
        }
        
    </script>
    
</body>
</html>