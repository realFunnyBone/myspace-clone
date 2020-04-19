<?php
include("header.php");

if(isset($_SESSION['myspace'])){
    if(@$_POST['submit']) {
        $stmt = $conn->prepare("UPDATE `users` SET `description` = ? WHERE `users`.`username` = '" . $_SESSION["myspace"] . "';");
        $stmt->bind_param("s", $description);
    
        $description = str_replace(PHP_EOL, "<br>", htmlspecialchars($_POST['bio']));
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
    
        echo "Sucessfully set your bio";
    } elseif (@$_POST['submit2']){
        $target_dir = "profilepictures/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                mysqli_query($conn, "UPDATE `users` SET `profilepic` = '" . $_FILES["fileToUpload"]["name"] . "' WHERE `users`.`username` = '" . $_SESSION['myspace'] . "';");
                echo "Sucessfully set your profile picture";
            } else {
                echo "Sorry, there was an error uploading your file.";
                echo $_FILES["fileToUpload"]["error"];
            }
        }
    } elseif (@$_POST['submit3']){
        $target_dir = "music/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 50000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if($imageFileType != "mp3") {
            echo "Sorry, only MP3 files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                mysqli_query($conn, "UPDATE `users` SET `musicurl` = '" . $_FILES["fileToUpload"]["name"] . "' WHERE `users`.`username` = '" . $_SESSION['myspace'] . "';");
                echo "Sucessfully set your music";
            } else {
                echo "Sorry, there was an error uploading your file.";
                echo $_FILES["fileToUpload"]["error"];
            }
        }
    } elseif (@$_POST['submit4']){
        $stmt = $conn->prepare("UPDATE `users` SET `gender` = ? WHERE `users`.`username` = ?;");
        $stmt->bind_param("ss", $gender, $_SESSION['myspace']);
    
        $gender = htmlspecialchars($_POST['gender']);
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
    
        echo "Sucessfully set your gender";
    } elseif (@$_POST['submit5']){
        $stmt = $conn->prepare("UPDATE `users` SET `age` = ? WHERE `users`.`username` = ?;");
        $stmt->bind_param("ss", $age, $_SESSION['myspace']);
    
        $age = htmlspecialchars($_POST['age']);
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
    
        echo "Sucessfully set your age";
    } elseif (@$_POST['submit6']){
        $stmt = $conn->prepare("UPDATE `users` SET `location` = ? WHERE `users`.`username` = ?;");
        $stmt->bind_param("ss", $location, $_SESSION['myspace']);
    
        $location = htmlspecialchars($_POST['location']);
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
    
        echo "Sucessfully set your location";
    } elseif (@$_POST['submit7']){
        $stmt = $conn->prepare("UPDATE `users` SET `css` = ? WHERE `users`.`username` = ?;");
        $stmt->bind_param("ss", $cssfil, $_SESSION['myspace']);
        
        //bad practice
        $css = $_REQUEST['css'];
        $css1 = str_replace("<?php", "", $css);
        $css2 = str_replace("?>", "", $css1);
        $css3 = str_replace("<script>", "", $css2);
        $css4 = str_replace("</script>", "", $css3);
        $css5 = str_replace("<", "", $css4);
        $css6 = str_replace(">", "", $css5);
        $cssfil = $css6;

        $_SESSION['css'] = $css;

        $stmt->execute();
    
        $stmt->close();
        $conn->close();
    
        echo "Sucessfully set your CSS";
    }
} else {
    die("Please login to change your settings!");
}
?>

<h2>Profile Settings</h2>
<form action="" method="post" enctype="multipart/form-data"><br>
    Bio: <br><textarea name="bio" rows="4" cols="50" required="required"></textarea><br><br>
    <input type="submit" value="Set" name="submit">
</form>
<hr>
<form action="" method="post" enctype="multipart/form-data"><br>
    CSS (pure): <br><textarea name="css" rows="4" cols="50" required="required">
<?php if(isset($_SESSION['css'])) {
    echo $_SESSION['css'];
} else {

}
?>    
</textarea><br><br>
    <input type="submit" value="Set" name="submit7">
</form>
<hr>
<form action="" method="post" enctype="multipart/form-data"><br>
    Select image to upload:<br>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit2">
</form>
<hr>
<form action="" method="post" enctype="multipart/form-data"><br>
    Select song to upload:<br>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Song" name="submit3">
</form>
<hr>
<form action="" method="post" enctype="multipart/form-data"><br>
    Gender: <br><input type="text" name="gender" required="required" row="4"></b><br><br>
    <input type="submit" value="Set" name="submit4">
</form>
<form action="" method="post" enctype="multipart/form-data"><br>
    Age: <br><input type="text" name="age" required="required" row="4"></b><br><br>
    <input type="submit" value="Set" name="submit5">
</form>
<form action="" method="post" enctype="multipart/form-data"><br>
    Location: <br><input type="text" name="location" required="required" row="4"></b><br><br>
    <input type="submit" value="Set" name="submit6">
</form>