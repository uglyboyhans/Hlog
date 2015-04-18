<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$login_ID = $_SESSION["login"];

if ($login_ID === "" || $login_ID === NULL) {
    echo "<script>"
    . "location.href='login.php';"
    . "</script>";
}
$q = $_GET["q"]; //userID being followed

$con = mysql_connect("localhost", "loguser", "uglyboy");
if (!$con) {
    die("Could not connect:" . mysql_error());
} else {
    mysql_select_db("hlog", $con);
    $query = "delete from following where userID=$login_ID and following=$q";
    if (mysql_query($query, $con)) {
        mysql_close($con);
        echo "<script>"
        . "history.back();"
        . "</script>";
        exit;
    } else {
        mysql_close($con);
        die(mysql_error());
    }
    //}
}
