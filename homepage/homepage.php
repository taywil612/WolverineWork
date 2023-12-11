<?php
    session_start();

        // Connect to the database
        include('../database/connection.php');

        //PHP file for handling likes for the like buttons
        include('like_handler.php');
       

        // Function to fetch recent posts
        function getRecentPosts($offset, $limit) {
            global $conn;
            $query = "SELECT post_id, username, title, caption, created_at FROM post ORDER BY created_at DESC LIMIT $offset, $limit";
            $result = mysqli_query($conn, $query);

            $posts = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $posts[] = $row;
            }

            return $posts;
        }

        // Function to fetch file preview by post_id
        function getFilePreview($post_id) {
            global $conn;
            $query = "SELECT file_name FROM files WHERE post_id = $post_id LIMIT 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            return isset($row['file_name']) ? $row['file_name'] : null;
        }

        // Define the number of posts to display on each page
        $postsPerPage = 3;

        // Get the page number from the URL parameter
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        // Calculate the offset for the SQL query
        $offset = ($page - 1) * $postsPerPage;

        // Fetch recent posts
        $recentPosts = getRecentPosts($offset, $postsPerPage);

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

        <!-- For Footer CSS -->
        <link rel="stylesheet" href="../Footer/footer.css"> 
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            #mySidebar {
                width: 300px;
            }
    
            .c {
                margin-left: 300px; /* Set initial margin to 0 */
            }
        
        </style>

    </head>
    <body>
        <?php  include('../NavigationBar/side-nav.php'); ?> 

        <div class="c">
        <!-- Button to open menu -->
        <div class="menu" onclick="openFilter()">&#9776;</div>
        <!-- Loop through recent posts -->
        <?php foreach ($recentPosts as $post) : ?>
            <div class="post">
                <!-- Display post details -->
                <div class= "profile">
                    <div class= "profile-img">
                        <img id="profile-image-preview" src="../Profile/profilepic.png" alt="Profile Picture">
                    </div>
                </div>

                <div class="profile-name">
                    <a href="../Profile/Profile.php?username=<?= $post['username'] ?>">
                        <p><?= $post['username'] ?></p>
                    </a>
                </div>
                
                <div class="essayTitle">
                    <h2><?= $post['title'] ?></h2>
                </div>
                <div class="essay">
                    <h3><?= $post['caption'] ?></h3>
                </div>

                <!-- Display file preview -->
                <?php $filePreview = getFilePreview($post['post_id']); ?>
                <?php if ($filePreview) : ?>
                    <div class="file-preview">
                        <a href="../uploads/<?= $filePreview ?>" target="_blank">Click here to read the document!</a>
                    </div>
                <?php endif; ?>
                
                <!-- Like Button -->
                <style>
                  .like-counter {
                        margin-left: 5px;
                        font-size: 20px; /* Adjust the font size as needed */
                        color: #00274C; /* Optional: Customize the color */
                    }

                    .like-container {
                        display: flex;
                        align-items: center;
                    }
                </style>
            
                <div class="like-container">
                    <div class="like-button" type="button" onclick="increaseLike(this, <?= $post['post_id'] ?>)">&#x2665;</div>
                    <span class="like-counter"><?=getLikeCount($post['post_id'])?></span>
                </div>

            </div>
            
        <?php endforeach; ?>

        <!-- "See More" button -->
        <a href="?page=<?= $page + 1 ?>" class="more-button">See More</a>
        <div class="spacer"> </div>
        </div>

        <script>

            //Function to have the likes increase in value everytime the like button is pressed (and store in database)
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

        <div class="spacer"> </div>

        <!-- Footer Section -->
        <footer>
          <?php  include('../Footer/Footer.html'); ?> 
        </footer>
       
    </body>
   
</html>
