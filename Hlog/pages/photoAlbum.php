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
        <title>Hlog - Photo Album</title>
    </head>
    <body>
        <div>
            <!--get all albums by this author,and make it into <select>-->
            jump to:<select onchange="photoAlbum(this.value)">
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
                            echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['name'] . "</option> ";
                        } else {
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option> ";
                        }
                    }
                }
                ?>
            </select>
        </div>
        <div>
            
            <?php
            //show all photos in the album:
            $query = "select id,src from photos where album=" . $albumID;
            $result = mysql_query($query, $con);
            while ($row = mysql_fetch_array($result)) {
                if (!empty($row["id"])) {
                    echo "<img src='" . $row["src"] . "' width='300px' onclick='viewPhoto(" . $row["id"] . ")' />";
                }
            }

            //if admin,can manage the album:
            /*
             * rename:use hidden form;
             * delete photo(s):use select;
             * delete album:delete all photos(seem to select all)
             */
            if ($login_ID === $author) {
                $str_function = "managePhoto(this.value,$albumID)";
                echo "<p><select onchange=\"$str_function\">"
                . "<option value=''>manage</option>"
                . "<option value='deleteAlbum'>delete album</option>"
                . "<option value='batchDelete'>batch delete</option>"
                . "<option value='renameAlbum'>Rename</option>"
                . "</select></p>";
            }
            
            mysql_close($con);
            ?>
            <form action="../manage/renamePhotoAlbum.php?q=<?php echo $albumID ?>" id="form_renamePhotoAlbum" method="post" style="display: none">
                <input type="text" name="newName" />
                <input type="submit" value="Rename" />
            </form>
        </div>
        <div>
            <a href="UploadPhoto.php">Upload photo</a>
            <a href="PhotoAlbumsList.php">Album List</a><br />
            <a href="center.php">Center</a>
        </div>
        <script src="../js/managePhoto.js"></script>
        <script src="../js/toPages.js"></script>
        <script src="../js/manage.js"></script>
    </body>
</html>
