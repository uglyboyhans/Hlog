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
$relyID = $_GET["q"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = str_replace("'", "\'", $_POST["content"]);
    $ObType = $_POST["ObType"];
    $userID=$_POST["userID"];
}
if ($content != "" && $relyID != "") {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect:" . mysql_error());
    } else {
        mysql_select_db("hlog", $con);
        $query = "insert into comment (visitor,userID,content,addtime,ObType,relyID)"
                . " values ($login_ID,$userID,'$content',now(),'$ObType',$relyID)";
        if (mysql_query($query, $con)) {
            mysql_close($con);
            echo "<script>"
            . "alert('OK!');history.back();"
            . "</script>";
        } else {
            echo mysql_error();
        }
    }
}
?>


