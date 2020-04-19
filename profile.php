<?php
include("header.php");

if($_GET['id']) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 0) exit('user dosent exist');
    while($row = $result->fetch_assoc()) {
        echo "<style>" . $row['css'] . "</style>";
        echo "<div class='extended'><h3><span class=''>" . $row['username'] . "</span> is in your extended network</h3></div>";
        echo "<div class='topLeft'><h1>" . $row['username'] . "</h1>";
        echo "<img src='profilepictures/" . $row['profilepic'] . "'><br><br>";
        echo "<div class='userinfo'><b>Gender: </b>" . $row['gender'] . "<br>";
        echo "<b>Age: </b>" . $row['age'] . "<br>";
        echo "<b>Location: </b>" . $row['location'] . "</div><br>";
        echo "<div class='url'><div><b>MySpace URL:</b></div><div><a style=':#000;text-decoration:none;' href='profile.php?id=" . $row['id'] .  "'>https://atari0.cf/myspace2/profile.php?id=" . $row['id'] .  "</a></div></div></div>";
        echo "<div class='topRight'><div class='userbanner'><h3><b>About Me: </b></h3></div>" . $row['description'] . "<br><br><b>Register Time:</b> " . $row['date'] . "<br>"; 
        echo "<div class='userbanner'><h3><b>Friends: </b></h3></div>Friends aren't added yet. They will be added soon.<br><br>";
        echo "<b><div class='music'>" . $row['username'] . "'s Music:</b><br><br><audio controls='' autoplay='' src='music/" . $row['musicurl'] . "'></audio><br><br></div><hr>";
    }
    $stmt->close();
}

$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);

echo "<div class='users'>";

while($row = $result->fetch_assoc()) {
    echo "<li><a href='profile.php?id=" . $row['id'] . "'>" . $row['username'] . "</a><br></li>";
}

echo "</div>";
?>
