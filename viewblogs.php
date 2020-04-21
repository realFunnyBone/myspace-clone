<?php
include("header.php");

echo "<h2>" . htmlspecialchars($_GET['user']) . "'s Blogs</h2>";

$stmt = $conn->prepare("SELECT * FROM blog WHERE author = ?");
$stmt->bind_param("s", $_GET['user']);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) echo ('This user has no blogs.');
while($row = $result->fetch_assoc()) {
    echo "<b>" . $row['author'] . "</b>'s blog <small>(" . $row['date'] . ")</small><br>";
    echo "" . $row['text'] . "<hr>";
}
?>