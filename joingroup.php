<?php
include("header.php");

if($_GET['id']) {
    if(!isset($_SESSION['myspace'])) {
        die("login to join groups");
    } else {
        $stmt = $conn->prepare("SELECT * FROM groups WHERE id = ?");
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) exit('group dosent exist');
        while($row = $result->fetch_assoc()) {
            $groupname = $row['groupname'];
        }
        $stmt->close();

        $stmt = $conn->prepare("UPDATE users SET usergroup = ? WHERE username = ?");
        $stmt->bind_param("ss", $groupname, $_SESSION['myspace']);
        $stmt->execute();
        $stmt->close();
    
        header("Location: index.php");
    }
}
?>