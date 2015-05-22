<?php

$q = $_GET["q"]; //albumID
$con = mysql_connect("localhost", "loguser", "uglyboy");
if (!$con) {
    die('Could not connect: ' . mysql_error());
} else {
    mysql_select_db("hlog", $con); //use database
    $query = "select id from photos where album=" . $q;
    $result = mysql_query($query, $con);
    include '../Functions/delPhoto.php';
    while ($photoIDs = mysql_fetch_array($result)) {
        delPhoto($photoIDs["id"]);
    }
    $query = "delete from photoAlbums where id=" . $q;
    if (mysql_query($query, $con)) {
        mysql_close($con);
    }
}

