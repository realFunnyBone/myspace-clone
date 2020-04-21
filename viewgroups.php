<?php
include("header.php");

echo "<h2>Groups</h2><a href='newgroup.php'>Make a new group</a><hr>";


$stmt = $conn->prepare("SELECT * FROM groups");
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) echo ('This user has no blogs.');
while($row = $result->fetch_assoc()) {
    echo "<b>" . $row['groupname'] . "</b> <small>(owned by " . $row['owner'] . ")</small> &bull; <a href='joingroup.php?id=" . $row['id'] . "'>Join Group</a><br>";
    echo "" . $row['text'] . "<hr>";
}
?>