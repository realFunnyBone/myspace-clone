<?php
include("header.php");

if(!isset($_SESSION['myspace'])) {
    die("Login to send a friend request.");
} else if(isset($_SESSION['myspace'])) {
    if($_GET['user']) {
        $stmt = $conn->prepare("UPDATE friends SET status = ? WHERE sender = ?");
        $stmt->bind_param("si", $denied, $_GET['user']);
        $denied = "denied";
        $stmt->execute();
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