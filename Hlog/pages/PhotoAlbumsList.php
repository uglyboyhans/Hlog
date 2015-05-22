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
        <title>Hlog - Photo Album List</title>
    </head>
    <body>
        <a href="Photos.php">All photos</a>&nbsp;
        <a href="UploadPhoto.php">Upload photo</a><br />
        <?php
        $query = "select photoAlbums.name,photoAlbums.id,photoAlbums.cover,Photos.src,Photos.id as p_id "
                . "from photoAlbums,Photos "
                . "where photoAlbums.cover=photos.id "
                . "and photoAlbums.author=" . $login_ID;
        $result=  mysql_query($query, $con);
        while ($row=  mysql_fetch_array($result)){
            echo "<div style='border-style: solid; border-width: 2px;'>";
            if(!empty($row["id"])){
                if ($row["p_id"] !== '11') {//I don't konw why id number mast be in quot...
                    echo "<img src='" . $row["src"] . "' width='100px' onclick='photoAlbum(".$row["id"].")' />";
                }else{//show default cover
                    $query = "select src from photos where id in (select max(id) as max_id from photos where album=".$row["id"].")";
                    $result_default=  mysql_query($query, $con);
                    while($row_default=  mysql_fetch_array($result_default)){
                        echo "<img src='" . $row_default["src"] . "' width='100px' onclick='photoAlbum(".$row["id"].")' />";
                    }
                }
                
            }
            echo "<br />".$row["name"];
            echo "</div>";
        }
        ?>
        <div>
            <a href="center.php">Center</a>
        </div>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</html>
