<?php

$albumID = $_GET["q"];
if ($albumID !== "") {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect" . mysql_error());
    } else {
        mysql_select_db("hlog");
        $query = "select photoAlbums.cover,Photos.src,Photos.id from photoAlbums,Photos "
                . "where photoAlbums.cover=photos.id "
                . "and photoAlbums.id=" . $albumID;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            if (!empty($row["id"])) {
                if ($row["id"] !== '11') {//I don't konw why id number mast be in quot...
                    echo "<img src='" . $row["src"] . "' width='100px' onclick='photoAlbum($albumID)' />";
                }else{
                    /*$query = "select max(id) as max_id,src from photos where album=".$albumID;
                    $result_max_id=mysql_query($query, $con);
                    while($row_id=  mysql_fetch_array($result_max_id)){
                        $default_cover=$row_id["max_id"];
                    }*/
                    $query = "select src from photos where id in (select max(id) as max_id from photos where album=$albumID)";
                    $result_default=  mysql_query($query, $con);
                    while($row_default=  mysql_fetch_array($result_default)){
                        echo "<img src='" . $row_default["src"] . "' width='100px' onclick='photoAlbum($albumID)' />";
                    }
                }
            }
        }
    }
    mysql_close($con);
}