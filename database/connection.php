<?php 
    $host= 'localhost';
    $user = 'root';
    $pass = '';
    $database = 'wolverinework';

    // Connecting to database
    $conn = new mysqli($host, $user, $pass, $database);
    if (!$conn){
        die("Could not connect to Wolverine Work database: "  . mysqli_connect_errno());
    }
?>