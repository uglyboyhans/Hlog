<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//get session information to know the user;
include '../PagePart/SessionInfo.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - Photos</title>
    </head>
    <body onload="NewInfoNum()">
        <a href="UploadPhoto.php">Upload Photo</a>
        <div id="photoAlbumList">
            <?php
            $query = "select id,name from photoAlbums where author=" . $login_ID;
            $result = mysql_query($query, $con);
            while ($row = mysql_fetch_array($result)) {
                if (!empty($row["id"])) {
                    echo "<a href='#' onclick='photoAlbum(".$row["id"].")'>".$row["name"]."</a>";
                    echo "---";
                }
            }
            ?>
        </div>
        <div>
            <?php
            $query = "select id,src from photos where author=" . $login_ID;
            $result = mysql_query($query, $con);
            while ($row = mysql_fetch_array($result)) {
                if (!empty($row["src"])) {
                    echo "<img src='" . $row["src"] . "' width='300px' onclick='viewPhoto(".$row["id"].")' />";
                }
            }
            ?>
        </div>
        <div>
            <a href="center.php">Center</a>
        </div>
        <?php
        mysql_close($con);
        ?>
    </body>
    <a href="PhotoAlbumsList.php">Album List</a><br />
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
    <script src="../js/newInfo.js"></script>
</html>
