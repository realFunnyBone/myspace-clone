<?php
include("header.php");

if($_GET['id']) {
    if(isset($_SESSION['myspace'])) {
        $stmt = $conn->prepare("UPDATE friends SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $accepted, $_GET['id']);
        $accepted = "accepted";
        $stmt->execute();
        $stmt->close();
        
        header("Location: friends.php");
    } else {
        die("login");
    }
} else {
    die("set ur id");
}
?>