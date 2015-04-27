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
    . "location.href='../pages/login.php';"
    . "</script>";
}
$q = $_GET["q"]; //userID being followed

$con = mysql_connect("localhost", "loguser", "uglyboy");
if (!$con) {
    die("Could not connect:" . mysql_error());
} else {
    mysql_select_db("hlog", $con);
    $query = "select following from following where userID=$login_ID and following=$q";
    $result = mysql_query($query, $con);
    while ($row=  mysql_fetch_array($result)) {
        echo "<script>"
        . "history.back();"
        . "</script>";
    } //else {
        $query = "insert into following (userID,following) values ($login_ID,$q)";
        if (mysql_query($query, $con)) {
            mysql_close($con);
            exit;
        } else {
            die(mysql_error());
        }
    //}
}
