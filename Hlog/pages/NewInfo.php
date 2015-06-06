<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include '../PagePart/SessionInfo.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - New Information</title>
    </head>
    <body>
        <a href="CommentMe.php">comment</a>&nbsp;
        <a href="ReplyMe.php">reply</a>&nbsp;
        <a href="MessageMe.php">message</a>&nbsp;
        <a href="Letters.php">letter</a>&nbsp;
        <br />
        <?php
        $query = "select id,infoType,relyID,addTime from NewInfo where userID=$login_ID order by id desc";
        $result_newInfo = mysql_query($query, $con);
        while ($row_newInfo = mysql_fetch_array($result_newInfo)) {
            //use "if else" get infoType to know how echo:
            if ($row_newInfo["infoType"] === "comment") {
                $query = "select userInfo.name,comment.ObType,comment.relyID from userInfo,comment "
                        . "where userInfo.userID=comment.visitor and "
                        . "comment.id=" . $row_newInfo["relyID"];
                $result_comment = mysql_query($query, $con);
                while ($row_comment=  mysql_fetch_array($result_comment)){
                    //use "if else" get ObType to know comment what:
                    if($row_comment["ObType"]==="blog"){
                        echo $row_comment["name"]." comment your blog.";
                        echo " <a href='#' onclick='readBlog(" . $row_comment["relyID"] . ")'>Check</a><br />";
                        echo "..........".$row_newInfo["addTime"];
                        echo "<hr />";
                    }else if($row_comment["ObType"]==="photo"){
                        echo $row_comment["name"]." comment your photo.";
                        echo " <a href='#' onclick='viewPhoto(" . $row_comment["relyID"] . ")'>Check</a><br />";
                        echo "..........".$row_newInfo["addTime"];
                        echo "<hr />";
                    }else if($row_comment["ObType"]==="feeling"){
                        echo $row_comment["name"]." comment your feeling.";
                        echo " <a href='#' onclick='readFeeling(" . $row_comment["relyID"] . ")'>Check</a><br />";
                        echo "..........".$row_newInfo["addTime"];
                        echo "<hr />";
                    }
                }
            } else if ($row_newInfo["infoType"] === "reply") {
                
            } else if ($row_newInfo["infoType"] === "message") {
                
            } else if ($row_newInfo["infoType"] === "letter") {
                
            }
        }
        ?>


        <br /><a href="center.php">Center</a>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</html>
