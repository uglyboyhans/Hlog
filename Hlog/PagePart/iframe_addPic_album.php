<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
$login_ID = $_SESSION["login"];

if ($login_ID === "" || $login_ID === NULL) {
    echo "<script>"
    . "location.href='login.php';"
    . "</script>";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <select onchange="showAlbumPhotos(this.value)">
            <option value="">Select Album</option>
            <?php
            $con = mysql_connect("localhost", "loguser", "uglyboy");
            if (!$con) {
                die("Could not connect" . mysql_error());
            } else {
                mysql_select_db("hlog");
                $query = "select id,name from photoAlbums where author=" . $login_ID;
                $result_albums = mysql_query($query, $con);
                while ($row = mysql_fetch_array($result_albums)) {
                    if (!empty($row["id"])) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option> ";
                    }
                }
            }
            ?>
        </select>
        <div id="showPhotos"></div>
        <script src="../js/showAlbumPhotos.js"></script>
    </body>
</html>
