<?php

$q = $_GET["q"]; //photoID
$con = mysql_connect("localhost", "loguser", "uglyboy");
if (!$con) {
    die('Could not connect: ' . mysql_error());
} else {
    mysql_select_db("hlog", $con); //use database
    include '../Functions/delPhoto.php';
    delPhoto($q);
    mysql_close($con);    
}
