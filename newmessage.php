<?php
include("header.php");

if(@$_POST['commentsubmit']) {
    if(!isset($_SESSION['myspace'])) {
        die("login to make a blog");
    } else {
        $stmt = $conn->prepare("INSERT INTO publicmessages (author, text, date) VALUES (?, ?, now())");
        $stmt->bind_param("ss", $_SESSION['myspace'], $text);
        $text = str_replace(PHP_EOL, "<br>", htmlspecialchars($_POST['comment']));
        $stmt->execute();
        $stmt->close();

        header("Location: publicmessageboard.php");
    }
}
?>

<form action="" method="post" enctype="multipart/form-data"><br>
    Current Username: <b><?php echo htmlspecialchars(@$_SESSION['myspace']); ?></b><br><br>
    Text: <br><textarea name="comment" rows="4" cols="50" required="required"></textarea><br><br>
    <input type="submit" value="Post" name="commentsubmit">
</form><hr>