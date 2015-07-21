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
        $query = "select id,infoType,relyID,addTime from newInfo where userID=$login_ID order by id desc";
        $result_newInfo = mysql_query($query, $con);
        while ($row_newInfo = mysql_fetch_array($result_newInfo)) {
            //use "if else" get infoType to know how echo:
            if ($row_newInfo["infoType"] === "comment") {
                $query = "select userInfo.name,comment.ObType,comment.relyID,comment.content from userInfo,comment "
                        . "where userInfo.userID=comment.visitor and "
                        . "comment.id=" . $row_newInfo["relyID"];
                $result_comment = mysql_query($query, $con);
                while ($row_comment=  mysql_fetch_array($result_comment)){
                    //use "if else" get ObType to know comment what:
                    if($row_comment["ObType"]==="blog"){
                        $query="select title from blog where id=". $row_comment["relyID"];
                        $result_blog_title=  mysql_query($query, $con);
                        while($row_blog_title=  mysql_fetch_array($result_blog_title)){
                            $blog_title=$row_blog_title["title"];
                        }
                        echo $row_comment["name"]." comment your blog '$blog_title':<br />\""
                                . $row_comment["content"]
                                . "\"<br />";
                        echo "..........".$row_newInfo["addTime"];
                        echo " <br /><a href='javascript:;' onclick='readBlog(" . $row_comment["relyID"] . ")'>Check</a>";
                        echo "<hr />";
                    }else if($row_comment["ObType"]==="photo"){
                        $query="select name from photos where id=". $row_comment["relyID"];
                        $result_photo_name=  mysql_query($query, $con);
                        while($row_photo_name=  mysql_fetch_array($result_photo_name)){
                            $photo_name=$row_photo_name["name"];
                        }
                        echo $row_comment["name"]." comment your photo:'$photo_name'<br />\""
                                . $row_comment["content"]
                                . "\"<br />";
                        echo "..........".$row_newInfo["addTime"];
                        echo " <br /><a href='javascript:;' onclick='viewPhoto(" . $row_comment["relyID"] . ")'>Check</a>";
                        echo "<hr />";
                    }else if($row_comment["ObType"]==="feeling"){
                        $query="select article from feelings where id=". $row_comment["relyID"];
                        $result_feelings=  mysql_query($query, $con);
                        while($row_feelings=  mysql_fetch_array($result_feelings)){
                            $feelings=$row_feelings["article"];
                        }
                        echo $row_comment["name"]." comment your feeling '$feelings'<br />\""
                                . $row_comment["content"]
                                . "\"<br />";
                        echo "..........".$row_newInfo["addTime"];
                        echo "<br /> <a href='javascript:;' onclick='readFeeling(" . $row_comment["relyID"] . ")'>Check</a>";
                        echo "<hr />";
                    }
                }
            } else if ($row_newInfo["infoType"] === "reply") {
                
            } else if ($row_newInfo["infoType"] === "message") {
                $query="select userInfo.name from message,userInfo "
                        . "where message.visitor=userInfo.userID and message.userID=$login_ID";
                $result_msg=  mysql_query($query,$con);
                while ($row_msg = mysql_fetch_array($result_msg)) {
                    echo $row_msg["name"]." send a message to you.<br />";
                    echo "<a href='javascript:;' onclick='MsgBoard($login_ID)'>Check</a>";
                    echo "<br />..........".$row_newInfo["addTime"];
                    echo "<hr />";
                }
            } else if ($row_newInfo["infoType"] === "letter") {
                
            }
        }
        ?>


        <br /><a href="center.php">Center</a>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</html>
