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
<?php
$q = $_GET["q"]; //owner's userID

$query = "select name from userInfo where userID=" . $q;
$result = mysql_query($query, $con);
while ($row = mysql_fetch_array($result)) {
    $owner_name = $row['name'];
    //echo $name;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - <?php echo $owner_name; ?>'s blog index</title>
    </head>
    <body>
        <?php
        
            mysql_select_db("hlog");
            $query = "select id,title,addtime from blog where author=" . $q;
            $result = mysql_query($query, $con);
            while ($row = mysql_fetch_array($result)) {
                echo "<p>-------------------------------------</p>";
                echo "<a href='#' onclick='readBlog(" . $row['id'] . ")'>" . $row['title'] . "</a>";
                echo "--------<a href='#' onclick='blogIndex(" . $q . ")'>" . $owner_name .
                "</a>--------" . $row['addtime'];
            }
            mysql_close($con);
        
        ?>
    </body>
    <script src="../js/toPages.js"></script>
</html>
