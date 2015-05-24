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
        <title>Hlog - Message Board</title>
    </head>
    <body>
        <a href="center.php">Center</a>
        <?php
        $q = $_GET["q"]; //ownerID
        $query = "select name from userInfo where userID=" . $q;
        $result_ownerName = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result_ownerName)) {
            $owner_name = $row['name'];
        }
        $query = "select id,visitor,content,addtime from message where userID=" . $q . " order by id desc";
        $result_message = mysql_query($query, $con);
        echo "<p>------------------------------</p>";
        if (!empty($result_message)) {
            while ($row_message = mysql_fetch_array($result_message)) {
                echo "<hr />";
                //get message:
                $query = "select name from userInfo where userID =" . $row_message['visitor'];
                $result_userID = mysql_query($query, $con);
                while ($row1 = mysql_fetch_array($result_userID)) {
                    $visitor = $row1['name'];
                }
                echo "<a href='#' onclick='blogIndex(" . $row_message['visitor'] . ")'>" . $visitor . "</a> :<br />";
                echo $row_message['content'] . "<br />";
                echo "------------------" . $row_message['addtime'] . "<br />";
                //get all reply:
                $query = "select content,addTime from reply where Obtype='message' and relyID=" . $row_message['id'];
                $result_reply = mysql_query($query, $con);
                while ($row_reply = mysql_fetch_array($result_reply)) {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='blogIndex(" . $q . ")'>" . $owner_name . "</a> reply:";
                    echo "&nbsp;" . $row_reply["content"];
                    echo "(" . $row_reply["addTime"] . ")<br />";
                }



                //if admin,can manage:
                if ($q === $login_ID) {
                    $str_function = "manage(this.value," . $row_message['id'] . ")";
                    echo "<p><select onchange=$str_function>"
                    . "<option value=''>manage</option>"
                    . "<option value='replyMsg'>reply</option>"
                    . "<option value='deleteMsg'>delete</option>"
                    . "</select></p>";
                }
            }
        }
        mysql_close($con);
        ?>
        <a href="#" onclick="blogIndex(<?php echo $q; ?>)">Back to Blog Index</a>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</html>
