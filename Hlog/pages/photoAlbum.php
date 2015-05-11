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
        <title>Hlog - <?php echo $name; ?>'s Photo Album</title>
    </head>
    <body>
        <div>
            <select>
                <?php
                $albumID = $_GET["q"];
                $query = "select author from photoAlbums where id=" . $albumID;
                $result_author = mysql_query($query, $con);
                while ($row = mysql_fetch_array($result_author)) {
                    $author = $row["author"];
                }
                $query = "select id,name from photoAlbums where author=" . $author;
                $result_albums = mysql_query($query, $con);
                while ($row = mysql_fetch_array($result_albums)) {
                    if (!empty($row["id"])) {
                        if ($row["id"] === $albumID) {//set selected of this option
                            echo "<option onclick='photoAlbum(" . $row['id'] . ")' selected='selected'>" . $row['name'] . "</option> ";
                        } else {
                            echo "<option onclick='photoAlbum(" . $row['id'] . ")'>" . $row['name'] . "</option> ";
                        }
                    }
                }
                ?>
            </select>
        </div>
        <div>
            <?php
            $query = "select id,src from photos where album=" . $albumID;
            $result = mysql_query($query, $con);
            while ($row = mysql_fetch_array($result)) {
                if (!empty($row["id"])) {
                    echo "<img src='" . $row["src"] . "' width='300px' onclick='viewPhoto(".$row["id"].")' />";
                }
            }
            mysql_close($con);
            ?>
        </div>
        <div>
            <a href="UploadPhoto.php">Upload photo</a>
            <a href="PhotoAlbumsList.php">Album List</a><br />
            <a href="center.php">Center</a>
        </div>
        <script src="../js/toPages.js"></script>
        <script src="../js/manage.js"></script>
    </body>
</html>
