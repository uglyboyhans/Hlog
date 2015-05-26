<?php

session_start();
$login_ID = $_SESSION["login"];

if ($login_ID === "" || $login_ID === NULL) {
    echo "<script>"
    . "location.href='login.php';"
    . "</script>";
} else {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect" . mysql_error());
    } else {
        mysql_select_db("hlog");
        $query = "select name,icon from userInfo where userID=" . $login_ID;
        $result_name = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result_name)) {
            $name = $row["name"];
            if ($row["icon"] !== NULL && $row["icon"] !== "") {
                $icon = $row["icon"];
            } else {
                $icon = "../mediaFiles/icon/default.jpg";
            }
        }
    }
    echo "<img src='$icon' width='40px' /> Welcome: " . $name . " !";
    echo "&nbsp;&nbsp;&nbsp;<a href='../pages/newInfo.php'>New Information(<span id='InfoNum'></span>)</a>";
    echo "&nbsp;&nbsp;&nbsp;<a href='logout.php'>logout</a><br />";
}


