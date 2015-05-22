<?php

$newName = ""; //init
$photoID = $_GET["q"];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newName = $_POST["newName"];
}
if ($newName !== "") {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect:" . mysql_error());
    } else {
        mysql_select_db("hlog", $con);
        $query="update photos set name='$newName' where id=".$photoID;
        if(mysql_query($query,$con)){
            echo "<script>"
            . "history.back();"
            . "</script>";
        }
    }
}
