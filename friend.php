<?php
include("header.php");

if(!isset($_SESSION['myspace'])) {
    die("Login to send a friend request.");
} else if(isset($_SESSION['myspace'])) {
    if($_GET['user']) {
        //checking if this guy is trying to spam friend requests
        $stmt = $conn->prepare("SELECT * FROM friends WHERE reciever = ? AND sender = ?");
        $stmt->bind_param("ss", $_GET['user'], $_SESSION['myspace']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 1) die('youve already friended this guy');
        $stmt->close();

        //success bro good job
        $stmt = $conn->prepare("INSERT INTO friends (reciever, sender) VALUES (?, ?)");
        $stmt->bind_param("ss", $_GET['user'], $_SESSION['myspace']);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php?success=true");
    }
}
?>