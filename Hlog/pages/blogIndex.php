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
<?php
$q = $_GET["q"]; //owner's userID
$con = mysql_connect("localhost", "loguser", "uglyboy");
if (!$con) {
    die("Could not connect" . mysql_error());
} else {
    mysql_select_db("hlog");
    $query = "select name from userInfo where userID=" . $q;
    $result = mysql_query($query, $con);
    while ($row = mysql_fetch_array($result)) {
        $name = $row['name'];
        //echo $name;
    }
    mysql_close($con);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - <?php echo $name; ?>'s blog index</title>
    </head>
    <body>
        <?php
        $con = mysql_connect("localhost", "loguser", "uglyboy");
        if (!$con) {
            die("Could not connect" . mysql_error());
        } else {
            mysql_select_db("hlog");
            $query = "select id,title,addtime from blog where author=" . $q;
            $result = mysql_query($query, $con);
            while ($row = mysql_fetch_array($result)) {
                echo "<p>-------------------------------------</p>";
                echo "<a href='#' onclick='readBlog(" . $row['id'] . ")'>" . $row['title'] . "</a>";
                echo "--------<a href='#' onclick='blogIndex(" . $q . ")'>" . $name .
                "</a>--------" . $row['addtime'];
            }
            mysql_close($con);
        }
        ?>
    </body>
    <script src="../js/toPages.js"></script>
</html>
