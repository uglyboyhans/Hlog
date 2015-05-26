<?php

session_start();
$login_ID = $_SESSION["login"];

if ($login_ID === "" || $login_ID === NULL) {
    echo "<script>"
    . "location.href='../pages/login.php';"
    . "</script>";
}
//init:
$content = "";
$relyID="";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $content = str_replace(["\r\n", "\r", "\n"], "<br />", $_POST["content"]);
    $content = str_replace("'", "\'", $content);
    $relyID=$_POST["relyID"];
}
if ($content != "" && $relyID != "") {
    $con = mysql_connect("localhost","loguser","uglyboy");
    if (!$con) {
        die("Could not connect:" . mysql_error());
    } else {
        mysql_select_db("hlog", $con);
        $query = "insert into reply (sender,ObType,relyID,content,addTime) "
                . "values ($login_ID,'comment',$relyID,'$content',now())";
        if (mysql_query($query, $con)) {
            mysql_close($con);
            echo "<script>"
            . "alert('OK!');history.back();"
            . "</script>";
        }else{
            echo mysql_error();
        }
    }
}
?>