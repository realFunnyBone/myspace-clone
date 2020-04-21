<?php
include("header.php");

echo "<h2>Music Selection</h2>";

if(@$_GET['id']) {
    $sql = "SELECT * FROM `users` WHERE id='" . (int)$_GET['id'] . "'";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        echo "<div class='music'>" . $row['username'] . "'s Music:</b><br><br><audio controls='' autoplay='' src='music/" . $row['musicurl'] . "'></audio><br><br></div>";
        echo "<hr>";
    }
}


$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "<li><a href='music.php?id=" . $row['id'] . "'>" . $row['username'] . "</a><br></li>";
}
?>

