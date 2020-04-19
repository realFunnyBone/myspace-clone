<?php
include("header.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_POST) {
    $sql = "SELECT password FROM `users` WHERE username='" . htmlspecialchars($_POST['name']) .  "'";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        $hash = $row['password'];
        if(password_verify($_POST['password'], $hash)){
            $_SESSION["myspace"] = htmlspecialchars($_POST['name']);
            echo 'Logged in! <br>Click <a href="index.php">here</a> to go to your profile<br>';
        } else {
            echo 'invalid password/email/username';
        }
    }
}
?>

<form method="post" action="login.php">
<div class="input-group">
    <label>Username</label><br>
    <input type="text" name="name"><br>

    <label>Email</label><br>
    <input type="email" name="email"><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit" class="btn" name="reg_user">Login</button>
</form>