<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$photoID = $_GET["q"];
$con = mysql_connect("localhost", "loguser", "uglyboy");
if (!$con) {
    die('Could not connect: ' . mysql_error());
} else {
    mysql_select_db("hlog", $con); //use database
    //get album id where the photo belong to:
    $query = "select album from photos where id=" . $photoID;
    $result = mysql_query($query, $con);
    while($row=  mysql_fetch_array($result)){
        $albumID=$row["album"];
    }
    $query="update photoAlbums set cover=$photoID where id=$albumID";
    if(!mysql_query($query, $con)){
        die(mysql_error());
    }
}