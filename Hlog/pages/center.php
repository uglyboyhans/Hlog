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
        <title>Hlog - Individual Center</title>
    </head>
    <body>
        <div id="div_topGuide">
            <!--a href="../index.php"--><img alt="hlog" src="#" /><!--/a-->
            <a href="WriteBlog.php">Write Blog</a>
            <a href="WriteFeeling.php">Add Feeling</a>
            <a href="settings.php">settings</a>
        </div>
        <div id="div_SelfInformation">
            <?php
            //include "../manage/weather.php";
            ?>
        </div>
        <div id="div_mainPart">
            <a href="PhotoAlbumsList.php">My Photos</a>
            <h2>Blogs:</h2>
            <?php
            //mysql has been open at the top;
            $query = "select id,title,addtime,author from blog";
            $result = mysql_query($query, $con);
            while ($row = mysql_fetch_array($result)) {
                $query = "select name from userInfo where userID =" . $row['author'];
                $result1 = mysql_query($query, $con);
                while ($row1 = mysql_fetch_array($result1)) {
                    $author = $row1['name'];
                }
                echo "<p>-------------------------------------</p>";
                echo "<a href='#' onclick='readBlog(" . $row['id'] . ")'>" . $row['title'] . "</a>";
                echo "--------<a href='#' onclick='blogIndex(" . $row['author'] . ")'>" . $author .
                "</a>--------" . $row['addtime'];
            }
            ?>
        </div>
        <div id="div_msgBoard">
            <h2>Message Board</h2>
            <?php
            $query = "select id,visitor,content,addtime from message where userID=" . $login_ID . " order by id desc limit 3";
            $result_message = mysql_query($query, $con);
            echo "<p>------------------------------</p>";
            if (!empty($result_message)) {
                while ($row_message = mysql_fetch_array($result_message)) {
                    $query = "select name from userInfo where userID =" . $row_message['visitor'];
                    $result_visitorName = mysql_query($query, $con);
                    while ($row1 = mysql_fetch_array($result_visitorName)) {
                        $visitor = $row1['name'];
                    }
                    echo "<a href='#' onclick='blogIndex(" . $row_message['visitor'] . ")'>" . $visitor . "</a> :<br />";
                    echo $row_message['content'] . "<br />";
                    echo "------------------" . $row_message['addtime'] . "<br />";
                    $query = "select content,addTime from reply where Obtype='message' and relyID=" . $row_message['id'];
                    $result_reply = mysql_query($query, $con);
                    while ($row_reply = mysql_fetch_array($result_reply)) {
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='blogIndex(" . $login_ID. ")'>" . $name . "</a> reply:";
                        echo "&nbsp;" . $row_reply["content"];
                        echo "(" . $row_reply["addTime"] . ")<br />";
                    }
                    $str_function = "manage(this.value," . $row_message['id'] . ")";
                    echo "<p><select onchange=$str_function>"
                    . "<option value=''>manage</option>"
                    . "<option value='replyMsg'>reply</option>"
                    . "<option value='deleteMsg'>delete</option>"
                    . "</select></p>";
                }
            }
            mysql_close($con);
            ?>
            <a href="#" onclick="MsgBoard(<?php echo $login_ID; ?>)">more>></a>
        </div>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
    <script src="../js/newInfo.js"></script>
</html>
