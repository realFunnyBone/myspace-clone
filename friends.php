<?php
include("header.php");

echo "<h2>Pending Friend Requests</h2>";

//get pending friend requests
$stmt = $conn->prepare("SELECT * FROM friends WHERE reciever = ? AND status = ?");
$stmt->bind_param("ss", $_SESSION['myspace'], $pending);
$pending = "pending";
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) echo('No incoming friend requests.');
while($row = $result->fetch_assoc()) {
    echo "Friend request from <b>" . $row['sender'] . "</b> | <a href='accept.php?id=" . $row['id'] . "'>Accept</a> or <a href='deny.php?id=" . $row['id'] . "'>Deny</a>";
}
$stmt->close();

echo "<h2>Friends</h2>";

//friends
$stmt = $conn->prepare("SELECT * FROM friends WHERE reciever = ?");
$stmt->bind_param("s", $_SESSION['myspace']);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) echo('No friends.');
while($row = $result->fetch_assoc()) {
    echo "" . $row['sender'] . "<br>";
}
$stmt->close();
?>