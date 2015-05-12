<?php

$q = $_GET["q"]; //photoID
$con = mysql_connect("localhost", "loguser", "uglyboy");
if (!$con) {
    die('Could not connect: ' . mysql_error());
} else {
    mysql_select_db("hlog", $con); //use database
    //get path in order to deleting from folder
    $query = "select src from photos where id=" . $q;
    $result = mysql_query($query, $con);
    while ($row = mysql_fetch_array($result)) {
        $filePath = $row["src"];
    }
    $query = "delete from photos where id=" . $q;
    if (mysql_query($query, $con)) {//delete from mysql
        mysql_close($con);
        unlink($filePath); //delete from folder
    } else {
        die(mysql_error());
    }
}
