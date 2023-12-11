<?php
    session_start();

    // Connect to the database
    include('../database/connection.php');

    // Function to fetch recent posts
    function getResults($offset, $limit, $search = null) {
        global $conn;
        // Modify the query to include a WHERE clause for searching
        $query = "SELECT post_id, username, title, caption, created_at FROM post";
        if ($search) {
            $query .= " WHERE username LIKE '%$search%' OR title LIKE '%$search%' OR caption LIKE '%$search%'";
        }
        $query .= " ORDER BY created_at DESC LIMIT $offset, $limit";

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
    $postsPerPage = 8;

    // Get the page number from the URL parameter
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // Calculate the offset for the SQL query
    $offset = ($page - 1) * $postsPerPage;

    // If search submit display results
    $resultPosts = [];
    $searchTerm = '';
    if ($_GET) {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : null;
        $resultPosts = getResults($offset, $postsPerPage, $searchTerm);
    }


    //Function to get the like count per post
    function getLikeCount($post_id){
        global $conn;
        $query = "SELECT count(*) FROM likes WHERE post_id = $post_id";
        $result = mysqli_query($conn, $query);
        $likeCount = $result->fetch_column(); 

        return $likeCount;
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
        <link rel="stylesheet" href="search.css"> 
        <link href='../NavigationBar/side-nav-ss.css' rel='stylesheet'>

     
        <link rel="stylesheet" href="../Footer/footer.css"> 
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            #mySidebar {
                width: 0px;
            }
    
            .c {
                margin-left: 0px; /* Set initial margin to 0 */
            }
        </style>
    </head>
    <body>
        <?php  include('../NavigationBar/side-nav.php'); ?> 

        <div class="c">
        <!-- Button to open menu -->
        <div class="menu" onclick="openFilter()">&#9776;</div>
                <!-- Add the search bar here -->
        <form action="" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search by username, title, or caption..." value="<?= htmlspecialchars($searchTerm) ?>">
            <button class="search-btn" type="submit">&#x2315; Search</button>
        </form>
        <!-- Loop through result posts -->
        <?php foreach ($resultPosts as $post) : ?>
            <div class="post">
                <!-- Display post details -->
                <div class= "profile">
                    <div class= "profile-img">
                        <img id="profile-image-preview" src="../img/avatarPic2.png" alt="Profile Picture">
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
                    <div class="like-button" type="button" onclick="increaseLike(this)">&#x2665;</div>
                    <span class="like-counter"><?=getLikeCount($post['post_id'])?></span>
                </div>

            </div>
            
            <?php endforeach; ?>
            <!-- "See More" button or "No results" message -->
            <?php if (count($resultPosts) == $postsPerPage) : ?>
                <a href="?page=<?= $page + 1 ?>" class="more-button">See More</a>
            <?php elseif (empty($resultPosts) && $searchTerm) : ?>
                <div class="no-results">No results found</div>
            <?php endif; ?>
            <div class="spacer"> </div>

        </div>

        <script>

            //Function for increasing likes (from profile page)
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

    </body>
   
</html>