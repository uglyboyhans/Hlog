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
        die("Could not connect" . mysql_error());
    } else {
        mysql_select_db("hlog");
        $query = "select name from userInfo where userID=".$login_ID;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            $name=$row["name"];
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
            <form id="form_setting" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label>Name:<input type="text" placeholder="The name we see.." name="name" size="20" /></label>
                <br />
                <!--icon-->
                <label>Gender:<input type="radio" name="gender" value="female" />Female</label>
                <label><input type="radio" name="gender" value="female" />Female</label>
                <br />
                <label>BirthDate:<input type="text" placeholder="xxxx-mm-dd" name="birthdate" size="10" />
                    <span class="error" id="error_date"></span></label>
                <br />
                <label>e-mail:<input type="text" placeholder="e-mail address" name="email" /></label>
                <br />
                <textarea name="signature" cols="30" rows="4"></textarea>
            </form>
        </div>
        <?php
        //userInfo[]={userID,name,gender,birthDate,email,icon,signature}
        
        ?>
        <br /><a href="center.php">Center</a>
    </body>
</html>
