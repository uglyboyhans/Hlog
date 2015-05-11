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
} else {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect" . mysql_error());
    } else {
        mysql_select_db("hlog");
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <p>Choose Album:</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <select onchange="showAlbumCover(this.value)" name="albumID">
                <option value="" selected="selected">Albums</option>
                <?php
                $photoID = $_GET["q"];
                $query = "select author from photos where id=" . $photoID;
                $result_author = mysql_query($query, $con);
                while ($row = mysql_fetch_array($result_author)) {
                    $author = $row["author"];
                }
                $query = "select id,name from photoAlbums where author=" . $author;
                $result_albums = mysql_query($query, $con);
                while ($row = mysql_fetch_array($result_albums)) {
                    if (!empty($row["id"])) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option> ";
                    }
                }
                ?>
            </select>
            <input type="hidden" name="photoID" value="<?php echo $photoID; ?>" />
            <input type="submit" value="Move" />
        </form>
        <div id="albumCover"></div>
        <?php
        $photoID=$targetAlbum = ""; //init
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $targetAlbum = $_POST["albumID"];
            $photoID = $_POST["photoID"];
        }
        if ($targetAlbum !== "") {
            $query = "update photos set album = $targetAlbum where id=$photoID";
            if (mysql_query($query, $con)) {
                echo "<script>"
                . "parent.location.href='../pages/PhotoAlbumsList.php';"
                . "</script>";
            }else{
                echo mysql_error();
            }
        }
        ?>
    </body>
    <script src="../js/showAlbumCover.js"></script>
</html>
