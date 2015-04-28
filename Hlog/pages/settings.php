<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
$login_ID = $_SESSION["login"];

if ($login_ID === "" || $login_ID === NULL) {
    echo "<script>"
    . "location.href='login.php';"
    . "</script>";
} else {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect:" . mysql_error());
    } else {
        mysql_select_db("hlog");
        $query = "select * from userInfo where userID=" . $login_ID;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            $name = $row["name"];
            $birthDate = $row["birthDate"];
            if ($row["email"] === NULL or $row["email"] === "") {
                $email = "";
            } else {
                $email = $row["email"];
            }
            if ($row["signature"] === NULL or $row["signature"] === "") {
                $signature = "";
            } else {
                $signature = $row["signature"];
            }
            if ($row["icon"] !== NULL && $row["icon"] !== "") {
                $icon = $row["icon"];
            } else {
                $icon = "../mediaFiles/icon/default.jpg";
            }
        }
        mysql_close($con);
    }
    echo "<img src='$icon' width='40px' /> Welcome: " . $name . " !"
    . " <a href='logout.php'>logout</a><br />";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - settings</title>
    </head>
    <body>
        <div id="div_setting">
            <br />
            <form id="form_setting" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <label>Name:<input type="text" placeholder="The name we see.." name="name" size="20" value="<?php echo $name; ?>" /></label>
                <br />
                <!--icon-->
                <label>Icon:<input type="file" name="icon" /></label>
                <br />
                <label>Gender:<input type="radio" name="gender" value="female" checked="checked" />Female</label>
                <label><input type="radio" name="gender" value="male" />Male</label>
                <br />
                <label>BirthDate:<input type="text" placeholder="xxxx-mm-dd" name="birthdate" size="10" value="<?php echo $birthDate; ?>" />
                    <span class="error" id="error_date"></span></label>
                <br />
                <label>e-mail:<input type="text" placeholder="e-mail address" name="email" value="<?php echo $email; ?>" /></label>
                <br />
                <textarea name="signature" cols="30" rows="4"><?php echo $signature; ?></textarea>
                <input type="submit" value="submit" />
            </form>
        </div>
        <?php
        //userInfo[]={userID,name,gender,birthDate,email,icon,signature}
        $flag = false;
        $icon = $name = $gender = $birthDate = $email = $signature = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $gender = $_POST["gender"];
            $birthDate = $_POST["birthdate"];
            $email = $_POST["email"];
            $signature = $_POST["signature"];
            $icon = $_FILES["icon"];
            $flag = true; //can return after save changes to mysql;
        }

        $con = mysql_connect("localhost", "loguser", "uglyboy");
        if (!$con) {
            die("Failed to connect:" . mysql_error());
        } else {
            mysql_select_db("hlog", $con);
            if ($icon !== "") {
                if ($icon["type"] == "image/gif" || $icon["type"] == "image/jpeg" || $icon["type"] == "image/pjpeg") {//file type is correct
                    if ($icon["error"] > 0) {
                        echo "File error:" . $icon["error"] . "<br />";
                    } else {
                        //get extention of the file:
                        $nameReverse = strrev($icon["name"]); //reverse the file name
                        $cutString = explode(".", $nameReverse);
                        $extension = "." . strrev($cutString[0]);
                        $iconPath = "../../userData/mediaFiles/icon/" . $login_ID . $extension;
                        if (!file_exists($iconPath)) {//if the file not exist,save to folder
                            move_uploaded_file($icon["tmp_name"], $iconPath);
                            //save to mysql:
                            $query = "update userInfo set icon='$iconPath' where userID=$login_ID"; //set icon (path)
                            if (!mysql_query($query, $con)) {
                                die(mysql_error());
                                mysql_close($con);
                            }
                        } else {//exist already:delete and save new icon to folder
                            unlink($iconPath);
                            move_uploaded_file($icon["tmp_name"], $iconPath);
                            //no use to update mysql
                        }
                    }
                } else {
                    echo "Type error";
                    $flag = false;
                }
            }//end icon

            if ($name !== "") {
                $query = "update userInfo set name='$name' where userID=$login_ID"; //set name
                if (!mysql_query($query, $con)) {
                    die(mysql_error());
                    mysql_close($con);
                }
            }//end name

            if ($gender !== "") {
                $query = "update userInfo set gender='$gender' where userID=$login_ID"; //set gender
                if (!mysql_query($query, $con)) {
                    die(mysql_error());
                    mysql_close($con);
                }
            }//end gender

            if ($birthDate !== "") {
                $query = "update userInfo set birthDate='$birthDate' where userID=$login_ID"; //set gender
                if (!mysql_query($query, $con)) {
                    die(mysql_error());
                    mysql_close($con);
                }
            }//end birthdate

            if ($email !== "") {
                $query = "update userInfo set email='$email' where userID=$login_ID"; //set gender
                if (!mysql_query($query, $con)) {
                    die(mysql_error());
                    mysql_close($con);
                }
            }//end email

            if ($signature !== "") {
                $query = "update userInfo set signature='$signature' where userID=$login_ID"; //set gender
                if (!mysql_query($query, $con)) {
                    die(mysql_error());
                    mysql_close($con);
                }
            }//end signature

            mysql_close($con);
            if ($flag) {
                echo "<script>"
                . "alert('OK!');location.href='center.php';"
                . "</script>";
            }
        }//end connect success;
        ?>
        <br /><a href="center.php">Center</a>
    </body>
</html>
