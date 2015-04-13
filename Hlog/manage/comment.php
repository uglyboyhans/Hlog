<?php

session_start();
$login_name = $_SESSION["login"];

if ($login_name === "" || $login_name === NULL) {
    echo "<script>"
    . "location.href='../pages/login.php';"
    . "</script>";
}
//init:
$content = "";
$relyID = $_GET["q"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = str_replace(["\r\n", "\r", "\n"], "<br />", $_POST["content"]);
    $content = str_replace("'", "\'", $content);
    $ObType = $_POST["ObType"];
}
if ($content != "" && $relyID != "") {
    $con = mysql_connect("localhost","loguser","uglyboy");
    if (!$con) {
        die("Could not connect:" . mysql_error());
    } else {
        mysql_select_db("hlog", $con);
        $addtime = date("Y-m-d h:i:s");
        $query = "select userID from userlogin where username = '$login_name'";
                $result = mysql_query($query, $con);
                while ($row1 = mysql_fetch_array($result)) {
                    $userID = $row1['userID'];
                }
        $query = "insert into comment (visitor,content,addtime,ObType,relyID)"
                . " values ($userID,'$content','$addtime','$ObType',$relyID)";
        if (mysql_query($query, $con)) {
            mysql_close($con);
            echo "<script>"
            . "alert('OK!');history.back();"
            . "</script>";
        }else {
            echo mysql_error();
        }
    }
}
?>


