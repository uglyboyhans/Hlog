<?php

function delPhoto($photoID) {
    global $con;
    //get path in order to deleting from folder:
    $query = "select src,album from photos where id=" . $photoID;
    $result = mysql_query($query, $con);
    while ($row = mysql_fetch_array($result)) {
        $filePath = $row["src"];
        //if it's cover of the photoAlbum,change che cover:
        $query_chgCover = "update photoAlbums set cover = 11 where id=" . $row["album"] . " and cover=$photoID";
        if (!mysql_query($query_chgCover, $con)) {
            die(mysql_error());
        }
    }
    $query = "delete from photos where id=" . $photoID;
    if (mysql_query($query, $con)) {//delete from mysql
        if(!unlink($filePath)){//delete from folder
            echo "Unable to delete file on server!";
        }
    } else {
        die(mysql_error());
    }
}
