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
    <body onload="displayInputNewAlbum()">
        <form id="form_uploadPhoto" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label>Photo's name:<input name="name" type="text" size="30" /></label>
            <br />
            <label>Please choose a file:<input type="file" name="photo" /></label>
            <br />
            Select the album you want the photo store in:<br />
            <!--album select-->
            <select name="photoAlbums" id="select_ptAlbum">
                <option id="option_new" value="0" selected="selected">new</option>
                <?php
                //get user's albums and set options:
                $con = mysql_connect("localhost", "loguser", "uglyboy");
                if (!$con) {
                    die("Could not connect:" . mysql_error());
                } else {
                    mysql_select_db("hlog", $con);
                    $query1 = "select id,name from photoAlbums where author=$login_ID";
                    $result_albums = mysql_query($query1, $con);
                    echo $query1 . "test";
                    while ($row1 = mysql_fetch_array($result_albums)) {
                        echo $query1;
                        if (!empty($row1["id"])) {
                            echo "<option value='" . $row1['id'] . "'>" . $row1['name'] . "</option> ";
                        }
                    }
                    mysql_close($con2);
                }
                ?>
            </select>
            <input type="text" name="newAlbumName" id="input_newAlbum" style="display: none;" />
            <br />
            <input type="submit" value="Upload" />
        </form>
        <?php
        $name = $photo = $photoAlbums = $newAlbumName = ""; //photoAlbums is ID,newAlbum is album name!
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $storeName = iconv("UTF-8", "gb2312", $name); //solve coding problem of Chinese character;
            $photoAlbums = $_POST["photoAlbums"];
            $newAlbumName = $_POST["newAlbumName"];
            $photo = $_FILES["photo"];
        }
        //add new album:
        if ($photo !== "") {
            $con = mysql_connect("localhost", "loguser", "uglyboy");
            if (!$con) {
                die("Could not connect:" . mysql_error());
            } else {
                mysql_select_db("hlog", $con);
                if ($photoAlbums === "0" && $newAlbumName !== "") {
                    //add new album to mysql:
                    $addTime = date("Y-m-d h:i:s");
                    $query = "insert into photoAlbums (author,name,addtime,cover) "
                            . "values ($login_ID,'$newAlbumName','$addTime',11)"; //add default coverID
                    if (mysql_query($query, $con)) {
                        //get album id that inserting:
                        $newAlbumID = mysql_insert_id($con);
                    } else {
                        die("Add new album error:" . mysql_error());
                    }
                    //set albums select = new album
                    $photoAlbums = $newAlbumID;
                }

                //save file to folder:
                //if ($photo !== "") {
                if ($photo["type"] == "image/gif" || $photo["type"] == "image/jpeg" || $photo["type"] == "image/pjpeg") {//file type is correct
                    if ($photo["error"] > 0) {
                        echo "File error:" . $photo["error"] . "<br />";
                    } else {
                        //get extention of the file:
                        $nameReverse = strrev($photo["name"]); //reverse the file name
                        $cutString = explode(".", $nameReverse);
                        $extension = "." . strrev($cutString[0]);
                        //save the file like this in case of duplicate name:
                        if ($name === "") {
                            $name = $photo["name"]; //default name is the file name;
                            $storeName = iconv("UTF-8", "gb2312", $name); //solve coding problem of Chinese character;
                        }
                        $photoPath = "../../userData/mediaFiles/photos/" . $login_ID . $photoAlbums . $storeName . microtime() . rand() . $extension;
                        //save to folder:
                        move_uploaded_file($photo["tmp_name"], $photoPath);
                        //save to mysql:
                        $photoSrc = iconv("gb2312", "UTF-8", $photoPath);
                        $addTime = date("Y-m-d h:i:s");
                        $query = "insert into photos (author,name,src,album,addTime)"
                                . "values ($login_ID,'$name','$photoSrc',$photoAlbums,'$addTime')";
                        if (mysql_query($query, $con)) {
                            $insertPhotoID = mysql_insert_id($con);
                            $show = "<img src='$photoSrc' width='100px' />";
                            mysql_close($con);
                            echo "<script>"
                            . "parent.document.getElementById('picture').value='$insertPhotoID';"
                            . "parent.document.getElementById('show_pic').src='$photoSrc';"
                            . "parent.document.getElementById('add_picture').innerHTML='';"
                            . "</script>";
                        } else {//insert photo error
                            die("Upload photo error:" . mysql_error());
                        }
                    }
                } else {//if type is not picture:
                    echo "Type error!Please upload a picture!<br />";
                }
            }
        }
        ?>
        <script>
            function displayInputNewAlbum() {
                if (document.getElementById("select_ptAlbum").value === "0") {
                    document.getElementById("input_newAlbum").style.display = "block";
                } else {
                    document.getElementById("input_newAlbum").style.display = "none";
                    document.getElementById("input_newAlbum").value = "";
                }
                setTimeout("displayInputNewAlbum()", 30);
            }
        </script>
    </body>
</html>
