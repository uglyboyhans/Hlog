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
        $query = "select name from userInfo where userID=" . $login_ID;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            $name = $row["name"];
        }
    }
    echo "Welcome: " . $name . " ! <a href='logout.php'>logout</a><br />";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - Individual Center</title>
    </head>
    <body>
        <div id="div_topGuide">
            <!--a href="../index.php"--><img alt="hlog" src="#" /><!--/a-->
            <a href="WriteBlog.php">Write Blog</a>
            <a href="settings.php">settings</a>
        </div>
        <div id="div_SelfInformation">
            <?php
            //include "../manage/weather.php";
            ?>
        </div>
        <div id="div_mainPart">
            <h2>Blogs:</h2>
            <?php
            //mysql has been open at the top;
            $query = "select id,title,addtime,author from blog";
            $result = mysql_query($query, $con);
            while ($row = mysql_fetch_array($result)) {
                $query = "select name from userInfo where userID =" . $row['author'];
                $result1 = mysql_query($query, $con);
                while ($row1 = mysql_fetch_array($result1)) {
                    $author = $row1['name'];
                }
                echo "<p>-------------------------------------</p>";
                echo "<a href='#' onclick='readBlog(" . $row['id'] . ")'>" . $row['title'] . "</a>";
                echo "--------<a href='#' onclick='blogIndex(" . $row['author'] . ")'>" . $author .
                "</a>--------" . $row['addtime'];
            }
            ?>
        </div>
        <div id="div_msgBoard">
            <h2>Message Board</h2>
            <?php
            $query = "select id,visitor,content,addtime,reply from message where userID=" . $login_ID." order by id desc limit 3";
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
                    echo "<p><select>"
                    . "<option value='manage'>manage</option>"
                    . "<option value='reply' onclick='replyMsg(" . $row_message['id'] . ")'>reply</option>"
                    . "<option value='delete' onclick='deleteMsg(" . $row_message['id'] . ")'>delete</option>"
                    . "</select></p>";
                }
            }
            mysql_close($con);
            ?>
            <a href="#" onclick="MsgBoard(<?php echo $login_ID; ?>)">more>></a>
        </div>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</html>
