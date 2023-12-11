<?php
 
 // Connect to the database
 include('../database/connection.php');


 //Function to get the like count for each post
 function getLikeCount($post_id){
    global $conn;
    $query = "SELECT count(*) FROM likes WHERE post_id = $post_id";
    $result = mysqli_query($conn, $query);
    $likeCount = $result->fetch_column(); 

    return $likeCount;
}

 // Function to insert like into the database
 function insertLike($post_id, $username) {
    global $conn;
    $query = "INSERT INTO likes (post_id, username) VALUES ($post_id, '$username')";
    mysqli_query($conn, $query);

 }

 // Function to check if a user has already liked a post
 function hasUserLiked($post_id, $username) {
    global $conn;
    $query = "SELECT COUNT(*) FROM likes WHERE post_id = $post_id AND username = '$username'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_fetch_array($result)[0];

    return $count > 0;
}

 // Check if the request is a POST request
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the post_id and username parameters are set
    if (isset($_POST["post_id"]) && isset($_POST["username"])) {
        $post_id = $_POST["post_id"];
        $username = $_POST["username"];

        // Check if the user has already liked the post
        if (!hasUserLiked($post_id, $username)) {
            // Insert the like into the database
            insertLike($post_id, $username);
        } else {
            //error message for if a user already liked a post
            echo json_encode(["status" => "error", "message" => "You have already liked this post!"]);
            exit; // Stop further execution
        }
    }
}

?>