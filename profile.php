<?php
$embedconn = mysqli_connect("localhost", "username", "password", "database");
?>
<head>
    <meta charset="utf-8">
    <meta name="description" content="typicalname.cf WEBSUTE, IUTS GOOCOOOOGODO">
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

    if($_GET['id']){
        $stmt = $embedconn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) exit('No rows');
        while($row = $result->fetch_assoc()) {
            echo '<meta name="og:description" content="' . $row['username'] .' | Bio: ' . $row['description'] . ' | Age: ' . $row['age'] . ' | Location: ' . $row['location'] . ' | Gender: ' . $row['gender'] . '">';
            echo '<meta property="og:image" content="http://orangebox.cf/myspace/profilepictures/' . $row['profilepic'] . '">';
        }
        $stmt->close();

    }
    ?>
    <meta name="og:site_name" content="atari0.cf">
    <meta name="og:type" content="website">
</head>

<?php
include("header.php");

if($_GET['id']) {
    if(@$_POST['commentsubmit']) {  
        if(isset($_SESSION['myspace'])) {
            $stmt = $conn->prepare("INSERT INTO comments (author, toprofileint, text, date) VALUES (?, ?, ?, now())");
            $stmt->bind_param("sss", $_SESSION['myspace'], $_GET['id'], $text);
            $text = str_replace(PHP_EOL, "<br>", htmlspecialchars($_POST['comment']));
            $stmt->execute();
            $stmt->close();

            header("Refresh: 0");
        } else if(!isset($_SESSION['myspace'])) {
            die("login to post a comment");
        }

    }

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
        echo "<div class='topRight'>
        <fieldset>
            <legend>Manage</legend>
            <a href='friend.php?user=" . $row['username'] . "'>Friend User</a>
        </fieldset>";

        echo "<div class='userbanner'><h3><b>About Me: </b></h3></div>" . $row['description'] . "<br><br><b>Register Time:</b> " . $row['date'] . "<br>"; 
        echo "<div class='userbanner'><h3><b>Friends: </b></h3></div>";
        $stmt = $conn->prepare("SELECT * FROM friends WHERE reciever = ? AND status = ?");
        $stmt->bind_param("ss", $row['username'], $status);
        $status = "accepted";
        $stmt->execute();
        $result = $stmt->get_result();
        while($friendsrow = $result->fetch_assoc()) {
            echo "" . $friendsrow['sender'] . "<br>";
        }   

        $stmt = $conn->prepare("SELECT * FROM friends WHERE sender = ? AND status = ?");
        $stmt->bind_param("ss", $row['username'], $status);
        $status = "accepted";
        $stmt->execute();
        $result = $stmt->get_result();
        while($friendsrow = $result->fetch_assoc()) {
            echo "" . $friendsrow['reciever'] . "<br>";
        }   
        echo "<br><br><b><div class='music'>" . $row['username'] . "'s Music:</b><br><br><audio controls='' autoplay='' src='music/" . $row['musicurl'] . "'></audio><br><br></div><hr>";
    }
    $stmt->close();
}
?>

<div class="userbanner"><h3><b>Comments: </b></h3></div>

<?php
if(isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM comments WHERE toprofileint = ?");
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 0) echo('No comments.');
    while($row = $result->fetch_assoc()) {
        echo "<b>" . $row['author'] . "</b> <small>(" . $row['date'] . ")</small><br>";
        echo "" . $row['text'] . "<br>";
        echo "<hr>";
    }
    $stmt->close();
}   
?>

<form action="" method="post" enctype="multipart/form-data"><br>
    Current Username: <b><?php echo htmlspecialchars(@$_SESSION['myspace']); ?></b><br><br>
    Text: <br><textarea name="comment" rows="4" cols="50" required="required"></textarea><br><br>
    <input type="submit" value="Post" name="commentsubmit">
</form><hr>

<?php
$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);

echo "<div class='users'>";

while($row = $result->fetch_assoc()) {
    echo "<li><a href='profile.php?id=" . $row['id'] . "'>" . $row['username'] . "</a><br></li>";
}

echo "</div>";
?>
