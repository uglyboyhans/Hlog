<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!--actually it should be in pages-->
<?php
//get session information to know the user;
include '../PagePart/SessionInfo.php';

$title = $article = ""; //init;

//get id:
$q = $_GET["q"];

//get original article:
$query = "select title,article from blog where id=" . $q;
$result = mysql_query($query, $con);
while ($row = mysql_fetch_array($result)) {
    $title = $row['title'];
    $article = $row['article'];
}
mysql_close($con);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - edit</title>
        <script src="../../ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <div style="margin-left:auto;
             margin-right:auto;
             width:40%;
             background-color:#b0e0e6;
             text-align: center;">
            <form action="postEdit.php" method="post">
                <input type="hidden" value="<?php echo $q; ?>" name="blog_id" />
                <label>Title:<input type="text" value="<?php echo $title; ?>" id="input_title" name="title"/></label><br />
                <textarea cols="55" rows="31" name="article" id="input_article"><?php echo $article; ?></textarea>
                <br />
                <input type="submit" value="publish" />
                <script>
                    CKEDITOR.replace('article');
                </script>
            </form>
        </div>

        <a href="../pages/center.php">Center</a>&nbsp;&nbsp;<a href="javascript:history.back();">Back</a>

    </body>
</html>