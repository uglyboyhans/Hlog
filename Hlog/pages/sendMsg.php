<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
$login_ID = $_SESSION["login"]; //it's visitor ID

if ($login_ID === "" || $login_ID === NULL) {
    echo "<script>"
    . "location.href='login.php';"
    . "</script>";
} else {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect:" . mysql_error());
    } else {
        $query = "select name,icon from userInfo where userID=" . $login_ID;
        $result_name = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result_name)) {
            $name = $row["name"];
            if ($row["icon"] !== NULL && $row["icon"] !== "") {
                $icon = $row["icon"];
            } else {
                $icon = "../mediaFiles/icon/default.jpg";
            }
        }
    }
    echo "<img src='$icon' width='40px' /> Welcome: " . $name . " !"
    . " <a href='logout.php'>logout</a><br />";
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - Send Message</title>
    </head>
    <body>
        <div id="div_sendMsg">
            <form id="form_sendMsg" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <textarea name="content" cols="30" rows="5"></textarea>
                <input type="hidden" value="<?php echo $_GET["q"]; ?>" name="userID" />
                <input type="submit" value="Send" />
            </form>
        </div>
        <?php
        $content = "";
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $content = str_replace("'", "\'", $_POST["content"]);
            $userID = $_POST["userID"];
        }
        if ($content !== "") {
            $addtime = date("Y-m-d h:i:s");
            $query = "insert into message (userID,visitor,content,addtime)"
                    . "values($userID,$login_ID,'$content','$addtime')";
            if (mysql_query($query, $con)) {
                mysql_close($con);
                echo "<script>"
                . "alert('OK!~');history.go(-2);"
                . "</script>";
            } else {
                die(mysql_error());
            }
        }
        ?>
        <a href="center.php">Center</a>
    </body>
    <script src="../js/toPages.js"></script>
</html>
