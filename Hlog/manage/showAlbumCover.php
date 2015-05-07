<?php

$albumID = $_GET["q"];
if ($albumID !== "") {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect" . mysql_error());
    } else {
        mysql_select_db("hlog");
        $query = "select photoAlbums.cover,Photos.src from photoAlbums,Photos "
                . "where photoAlbums.cover=photos.id "
                . "and photoAlbums.id=" . $albumID;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            if (!empty($row["src"])) {
                echo "<img src='" . $row["src"] . "' width='100px' />";
            }
        }
    }
}