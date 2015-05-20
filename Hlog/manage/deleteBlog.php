<?php

$q = $_GET["q"];
$con = mysql_connect("localhost", "loguser", "uglyboy");
if (!$con) {
    die('Could not connect: ' . mysql_error());
} else {
    mysql_select_db("hlog", $con); //use database
    $query = "delete from blog where id=" . $q;
    if (mysql_query($query, $con)) {//delete blog from mysql
        mysql_close($con);
        echo "<script>"
        . "alert('OK!');location.href='../pages/center.php';"
        . "</script>";
    } else {
        die(mysql_error());
    }
}
?>