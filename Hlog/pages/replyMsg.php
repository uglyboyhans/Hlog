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
        <title>Hlog - reply message</title>
    </head>
    <body>
        <?php
        $id = $_GET["q"];
        $query = "select visitor,content,addtime from message where id=" . $id;
        $result_message = mysql_query($query, $con);
        echo "<p>------------------------------</p>";
        if (!empty($result_message)) {
            while ($row_message = mysql_fetch_array($result_message)) {
                $query = "select name from userInfo where userID =" . $row_message['visitor'];
                $result_userID = mysql_query($query, $con);
                while ($row1 = mysql_fetch_array($result_userID)) {
                    $visitor = $row1['name'];
                }
                echo "<a href='#' onclick='blogIndex(" . $row_message['visitor'] . ")'>" . $visitor . "</a> :<br />";
                echo $row_message['content'] . "<br />";
                echo "------------------" . $row_message['addtime'] . "<br />";
                if (!empty($row_message['reply'])) {              //in case it's NULL
                    echo "admin reply:" . $row_message['reply'] . "<br />";
                }
            }
        }
        mysql_close($con);
        ?>
        <p>----------------------------------------------------</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="form_comment" method="post">
            <textarea cols="55" rows="11" name="content"></textarea>
            <input type="hidden" value="<?php echo $id; ?>" name="relyID" />
            <input type="submit" value="Reply" />
        </form>
        <?php
        //init:
        $content = "";
        $relyID = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $content = str_replace(["\r\n", "\r", "\n"], "<br />", $_POST["content"]);
            $content = str_replace("'", "\'", $content);
            $relyID = $_POST["relyID"];
        }
        if ($content != "" && $relyID != "") {
            $con = mysql_connect("localhost", "loguser", "uglyboy");
            if (!$con) {
                die("Could not connect:" . mysql_error());
            } else {
                mysql_select_db("hlog", $con);
                $query = "insert into reply (ObType,relyID,content,addTime) "
                        . "values ('message',$relyID,'$content',now())";
                if (mysql_query($query, $con)) {
                    mysql_close($con);
                    echo "<script>"
                    . "history.go(-2);"
                    . "</script>";
                }
            }
        }
        ?>
        <br /><a href="center.php">Center</a>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</html>
