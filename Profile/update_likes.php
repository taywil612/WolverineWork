<?php
    include('../database/connection.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = isset($_POST['post_id']) ? $_POST['post_id'] : '';
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if ($postId && ($action === 'increase' || $action === 'decrease')) {
            if ($action === 'increase') {
                // Increase like count
                $insertLike = "INSERT INTO likes (post_id, username) VALUES ($postId, '{$_SESSION['name']}')";
                $conn->query($insertLike);
            } else {
                // Decrease like count
                $deleteLike = "DELETE FROM likes WHERE post_id=$postId AND username='{$_SESSION['name']}'";
                $conn->query($deleteLike);
            }

            // Get updated like count
            $likeCount = getLikeCount($postId, $conn);

            // Return the updated like count
            echo json_encode(['like_count' => $likeCount]);
        }
    }
?>
