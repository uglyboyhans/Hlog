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
        $query = "select name,icon from userInfo where userID=" . $login_ID;
        $result_name = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result_name)) {
            $name = $row["name"];
            if ($row["icon"] !== NULL && $row["icon"] !== "") {
                $icon = $row["icon"];
            }else{
                $icon="../mediaFiles/icon/default.jpg";
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
        <title>Hlog - reply message</title>
    </head>
    <body>
        <?php
        $id = $_GET["q"];
        $query = "select visitor,content,addtime,reply from message where id=" . $id;
        $result_message = mysql_query($query, $con);
        echo "<p>------------------------------</p>";
        if (!empty($result_message)) {
            while ($row_message = mysql_fetch_array($result_message)) {
                $query = "select name from userInfo where userID =" . $row_message['visitor'];
                $result_userID = mysql_query($query, $con);
                while ($row1 = mysql_fetch_array($result_userID)) {
                    $visitor = $row1['name'];
                }
                echo "<a href='#' onclick='blogIndex(" . $row_message['visitor'] . ")'>" . $visitor . "</a> :<br />";
                echo $row_message['content'] . "<br />";
                echo "------------------" . $row_message['addtime'] . "<br />";
                if (!empty($row_message['reply'])) {              //in case it's NULL
                    echo "admin reply:" . $row_message['reply'] . "<br />";
                }
            }
        }
        mysql_close($con);
        ?>
        <p>----------------------------------------------------</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="form_comment" method="post">
            <textarea cols="55" rows="11" name="reply"></textarea>
            <input type="hidden" value="<?php echo $id; ?>" name="id" />
            <input type="submit" value="Reply" />
        </form>
        <?php
        $id = $reply = ""; //init
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $reply = str_replace(["\r\n", "\r", "\n"], "<br />", $_POST["reply"]);
            $reply = str_replace("'", "\'", $reply);
            $id = $_POST["id"];
        }
        if ($reply !== "" && $id !== "") {
            $con = mysql_connect("localhost", "loguser", "uglyboy");
            if (!$con) {
                die("Could not connect:" . mysql_error());
            } else {
                mysql_select_db("hlog", $con);
                $query = "update message set reply='$reply' where id=" . $id;
                if (mysql_query($query, $con)) {
                    mysql_close($con);
                    echo "<script>"
                    . "history.go(-2);"
                    . "</script>";
                }
            }
        }
        ?>
        <br /><a href="center.php">Center</a>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</html>
