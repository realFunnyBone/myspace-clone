<?php
include("header.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<form method="post" action="register.php">
<div class="input-group">
    <label>Username</label><br>
    <input type="text" name="name" pattern="[^()/><\][\\\x22,;|]+" required><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" class="btn" name="reg_user">Register</button>
</form>
<?php
if (@$_POST){
    $sql = "SELECT `username` FROM `users` WHERE `username`='". htmlspecialchars($_POST['name']) ."'";
    $result = $conn->query($sql);
    if($result->num_rows >= 1) {
        echo "Username already exists, try something else.";
    } else {
        $stmt = $conn->prepare("INSERT INTO `users` (`username`, `email`, `password`, `date`, `description`, `css`) VALUES (?, ?, ?, now(), ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $password, $description, $css);

        $description = "Hello!";
        $username = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $css = "";
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
        echo "<br><br>SUCESSFULLY CREATED ACCOUNT<br><a href='login.php'>CLICK HERE TO LOGIN</a>";
    }
}
?>