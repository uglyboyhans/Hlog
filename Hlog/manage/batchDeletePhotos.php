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
        <title>Hlog - Photo Album:Batch Delete</title>
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php
            $albumID = $_GET["q"];
            //show all photos in the album:
            $query = "select id,src,name from photos where album=" . $albumID;
            $result = mysql_query($query, $con);
            while ($row = mysql_fetch_array($result)) {
                if (!empty($row["id"])) {
                    echo $row["name"];
                    echo "<img src='" . $row["src"] . "' width='100px' onclick='viewPhoto(" . $row["id"] . ")' />";
                    echo "<input type='checkbox' name='deleteID[]' value='" . $row["id"] . "' />";
                    echo "<br />";
                }
            }
            mysql_close($con);
            ?>
            <input type="submit" value="Delete" />
        </form>
    </div>
    <?php
    include '../Functions/delPhoto.php';
    $photoIDs=array();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $photoIDs = $_POST["deleteID"];
    }
    if (count($photoIDs) !== 0) {
        $con = mysql_connect("localhost", "loguser", "uglyboy");
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db("hlog", $con); //use database
            for ($i = 0; $i < count($photoIDs); $i++) {
                delPhoto($photoIDs[$i]);
            }
            mysql_close($con);
        }
        echo "<script>"
        . "alert('OK!');"
        . "history.go(-2);"
        . "</script>";
    }
    ?>
    <div>
        <a href="javascript:;" onclick="photoAlbum(<?php echo $albumID ?>)">Cancel</a>
        <a href="../pages/PhotoAlbumsList.php">Album List</a><br />
        <a href="../pages/center.php">Center</a>
    </div>
    <script src="../js/managePhoto.js"></script>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</body>
</html>
