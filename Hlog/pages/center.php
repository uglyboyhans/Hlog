<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
$login_name = $_SESSION["login"];

if ($login_name === "" || $login_name === NULL) {
    echo "<script>"
    . "location.href='login.php';"
    . "</script>";
} else {
    echo "Welcome: " . $login_name . " ! <a href='logout.php'>logout</a><br />";
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
        </div>
        <div id="div_SelfInformation">
            <?php
            //include "../manage/weather.php";
            ?>
        </div>
        <div id="div_mainPart">
            <?php
            $con = mysql_connect("localhost", "loguser", "uglyboy");
            if (!$con) {
                die("Could not connect" . mysql_error());
            } else {
                mysql_select_db("hlog");
                $query = "select id,title,addtime,author from blog";
                $result = mysql_query($query,$con);
                while ($row = mysql_fetch_array($result)) {
                    echo "<p>-------------------------------------</p>";
                    echo "<span onclick='readBlog(" . $row['id'] . ")'>" . $row['title'] . "</span>";
                    echo "--------" . $row['author'] . "--------" . $row['addtime'];
                }
                mysql_close($con);
            }
            ?>
        </div>
    </body>
    <script src="../js/toReadBlog.js"></script>
</html>
