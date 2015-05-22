<?php

$newName = ""; //init
$albumID = $_GET["q"];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newName = $_POST["newName"];
}
if ($newName !== "") {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect:" . mysql_error());
    } else {
        mysql_select_db("hlog", $con);
        $query="update photoalbums set name='$newName' where id=".$albumID;
        if(mysql_query($query,$con)){
            mysql_close($con);
            echo "<script>"
            . "history.back();"
            . "</script>";
        }
    }
}
