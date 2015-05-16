<?php

$q = $_GET["q"]; //photoID
$con = mysql_connect("localhost", "loguser", "uglyboy");
if (!$con) {
    die('Could not connect: ' . mysql_error());
} else {
    mysql_select_db("hlog", $con); //use database
    //get path in order to deleting from folder:
    $query = "select src,album from photos where id=" . $q;
    $result = mysql_query($query, $con);
    while ($row = mysql_fetch_array($result)) {
        $filePath = $row["src"];
        //if it's cover of the photoAlbum,change che cover:
        $query_chgCover = "update photoalbums set cover = 11 where id=" . $row["album"] . " and cover=$q";
        if (!mysql_query($query_chgCover, $con)) {
            die(mysql_error());
        }
    }
    $query = "delete from photos where id=" . $q;
    if (mysql_query($query, $con)) {//delete from mysql
        mysql_close($con);
        unlink($filePath); //delete from folder
    } else {
        die(mysql_error());
    }
}
