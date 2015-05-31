<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//get session information to know the user;
include '../PagePart/SessionInfo.php';
mysql_close($con);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - Write Feeling</title>
    </head>
    <body onload="NewInfoNum()">
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <textarea cols="50" rows="7" name="article" id="input_feeling"></textarea>
                <input id="picture" type="hidden" value="" name="picture" />
                <img id="show_pic" width="90px" />
                <div id="add_picture"></div>
                <div id="select_picture" style="display: none;">
                    <select onchange="addPic(this.value)">
                        <option value="">Add Picture</option>
                        <option value="addPic_new">Upload new Picture</option>
                        <option value="addPic_album">From photo albums</option>
                    </select>
                </div>
                <br /><span onclick="addPicture()" style="font-size: 3em" alt="Add Picture">&oplus;</span>
                <input type="submit" value="publish" />
            </form>
        </div>
        <?php
        //init:
        $article = $picture = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $article = $_POST["article"];
            $picture = $_POST["picture"];
        }
        if ($article !== "") {
            $con = mysql_connect("localhost", "loguser", "uglyboy");
            if (!$con) {
                die("Failed to connect:" . mysql_error());
            } else {
                mysql_select_db("hlog", $con);
                if ($picture === "" || $picture === NULL) {
                    $query = "insert into feelings (author,article,addtime)"
                            . "values($login_ID,'$article','$addTime')";
                } else {
                    $query = "insert into feelings (author,article,addtime,picture)"
                            . "values($login_ID,'$article',now(),$picture)";
                }
                if (mysql_query($query, $con)) {
                    mysql_close($con);
                    echo "<script>"
                    . "alert('OK!');location.href='center.php';"
                    . "</script>";
                } else {
                    die(mysql_error());
                }
            }
        }
        ?>
        <div><!--links-->
            <a href="center.php">Center</a>
        </div>
    </body>
    <script src="../js/addPicture.js"></script>
    <script src="../js/showAlbumCover.js"></script>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
    <script src="../js/newInfo.js"></script>
</html>
