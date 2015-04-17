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
        }
        mysql_close($con);
    }
    echo "Welcome: " . $name . " ! <a href='logout.php'>logout</a><br />";
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
                <!--icon
                <label>Icon:<input type="file" name="icon" /></label>-->
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
        $flag=false;
        $name = $gender = $birthDate = $email = $signature = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $gender = $_POST["gender"];
            $birthDate = $_POST["birthdate"];
            $email = $_POST["email"];
            $signature = $_POST["signature"];
            $flag=true;
        }

        $con = mysql_connect("localhost", "loguser", "uglyboy");
        if (!$con) {
            die("Failed to connect:" . mysql_error());
        } else {
            mysql_select_db("hlog", $con);
            if ($name !== "") {
                $query = "update userInfo set name='$name' where userID=$login_ID"; //set name
                if (!mysql_query($query, $con)) {
                    die(mysql_error());
                    mysql_close($con);
                }
            }
            if ($gender !== "") {
                $query = "update userInfo set gender='$gender' where userID=$login_ID"; //set gender
                if (!mysql_query($query, $con)) {
                    die(mysql_error());
                    mysql_close($con);
                }
            }
            if ($birthDate !== "") {
                $query = "update userInfo set birthDate='$birthDate' where userID=$login_ID"; //set gender
                if (!mysql_query($query, $con)) {
                    die(mysql_error());
                    mysql_close($con);
                }
            }
            if ($email !== "") {
                $query = "update userInfo set email='$email' where userID=$login_ID"; //set gender
                if (!mysql_query($query, $con)) {
                    die(mysql_error());
                    mysql_close($con);
                }
            }
            if ($signature !== "") {
                $query = "update userInfo set signature='$signature' where userID=$login_ID"; //set gender
                if (!mysql_query($query, $con)) {
                    die(mysql_error());
                    mysql_close($con);
                }
            }
            mysql_close($con);
            if ($flag) {
                echo "<script>"
                . "alert('OK!');location.href='center.php';"
                . "</script>";
            }
        }
        ?>
        <br /><a href="center.php">Center</a>
    </body>
</html>
