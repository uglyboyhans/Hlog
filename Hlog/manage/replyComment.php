<?php

session_start();
$login_ID = $_SESSION["login"];

if ($login_ID === "" || $login_ID === NULL) {
    echo "<script>"
    . "location.href='../pages/login.php';"
    . "</script>";
}
//init:
$reply = "";
$id="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reply = str_replace(["\r\n", "\r", "\n"], "<br />", $_POST["reply"]);
    $reply = str_replace("'", "\'", $reply);
    $id=$_POST["id"];
}
if ($reply != "" && $id != "") {
    $con = mysql_connect("localhost","loguser","uglyboy");
    if (!$con) {
        die("Could not connect:" . mysql_error());
    } else {
        mysql_select_db("hlog", $con);
        $query = "update comment set reply='$reply' where id=". $id;
        if (mysql_query($query, $con)) {
            mysql_close($con);
            echo "<script>"
            . "alert('OK!');history.back();"
            . "</script>";
        }
    }
}
?>