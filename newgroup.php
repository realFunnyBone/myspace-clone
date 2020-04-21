<?php
include("header.php");


if(@$_POST['commentsubmit']) {
    if(!isset($_SESSION['myspace'])) {
        die("login to make a group");
    } else {
        $stmt = $conn->prepare("UPDATE users SET usergroup = ? WHERE username = ?");
        $stmt->bind_param("ss", $_POST['grouptitle'], $_SESSION['myspace']);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO groups (groupname, owner, text, date) VALUES (?, ?, ?, now())");
        $stmt->bind_param("sss", $_POST['grouptitle'], $_SESSION['myspace'], $text);
        $text = str_replace(PHP_EOL, "<br>", htmlspecialchars($_POST['comment']));
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
    }
}
?>

<form action="" method="post" enctype="multipart/form-data"><br>
    Current Username: <b><?php echo htmlspecialchars(@$_SESSION['myspace']); ?></b><br><br>

    <label>Group Title</label><br>
    <input type="text" name="grouptitle"><br>

    Group Description: <br><textarea name="comment" rows="4" cols="50" required="required"></textarea><br><br>
    <input type="submit" value="Make Group" name="commentsubmit">
</form><hr>