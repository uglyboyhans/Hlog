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
        <title>Hlog - Read Feeling</title>
    </head>
    <body>
        <?php
        $isAdmin = false;
        $q = $_GET["q"]; //feelingID

        $query = "select feelings.article,feelings.author,feelings.addTime,userInfo.name,userInfo.icon "
                . "from userInfo,feelings where userInfo.userID=feelings.author and feelings.id=" . $q;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            $author = $row['name'];
            if ($row["icon"] !== NULL && $row["icon"] !== "") {
                $icon = $row["icon"];
            } else {
                $icon = "../mediaFiles/icon/default.jpg";
            }
            echo "<img src='$icon' width='50px' />";
            echo "<a href='javascript:;' onclick='blogIndex(" . $row['author'] . ")'>" . $author . "</a><br />";
            echo $row['article'] . "<br />";
            //get picture if exist:
            $query = "select photos.src from photos,feelings where photos.id=feelings.picture and feelings.id=".$q;
            $result_pic = mysql_query($query, $con);
            while($row_pic=  mysql_fetch_array($result_pic)){
                if(!empty($row_pic["src"])){
                    echo "<img src='".$row_pic["src"]."' width='150px' />";
                }
            }
            echo "<br />----------------" . $row['addTime'];
            if ($login_ID === $row['author']) {//if author,can manage blog~
                $isAdmin = true;
                $str_function = "manage(this.value,$q)";
                echo "<p><select onchange=$str_function>"
                . "<option value=''>manage</option>"
                . "<option value='deleteFeeling'>delete</option>"
                . "</select></p>";
            }
        }
        echo "<p>**********************************************************</p>";
        echo "Comments:<br />-------------------------------------<br />";
        $query = "select id,visitor,content,addtime,reply from comment where ObType='feeling' and relyID=$q";
        $result_comment = mysql_query($query, $con);
        if (!empty($result_comment)) {
            while ($row_comment = mysql_fetch_array($result_comment)) {
                $query = "select name from userInfo where userID =" . $row_comment['visitor'];
                $result = mysql_query($query, $con);
                while ($row1 = mysql_fetch_array($result)) {
                    $visitor = $row1['name'];
                }
                echo "<a href='#' onclick='blogIndex(" . $row_comment['visitor'] . ")'>" . $visitor . "</a> says:<br />";
                echo $row_comment['content'] . "<br />";
                echo "at " . $row_comment['addtime'] . "<br />";
                if (!empty($row_comment['reply'])) {              //in case it's NULL
                    echo "admin reply:" . $row_comment['reply'] . "<br />";
                }
                if ($isAdmin) {//if author,can manage comment~
                    echo "<button onclick='reply(" . $row_comment['id'] . ")'>reply</button>";
                    echo "<button onclick='deleteComment(" . $row_comment['id'] . ")'>delete</button>";
                    echo "<div id='" . $row_comment['id'] . "' style='display:none'>"
                    . "<form action='../manage/replyComment.php' method='post'>"
                    . "<input type='hidden' name='id' value=" . $row_comment['id'] . " />"
                    . "<textarea cols='22' rows='3' name='reply'></textarea>"
                    . "<input type='submit' value='reply' />"
                    . "</form>"
                    . "</div>";
                }
                echo "<p>------------------------------</p>";
            }
        }
        mysql_close($con);
        ?>
        <p>----------------------------------------------------</p>
        <form action="../manage/comment.php?q=<?php echo $q; ?>" id="form_comment" method="post">
            <textarea cols="55" rows="11" name="content"></textarea>
            <input type="submit" id="submit_comment" value="Comment" />
            <input type="hidden" value="feeling" name="ObType" />
        </form>
        <br /><a href="center.php">Center</a>
        <script src="../js/manage.js"></script>
        <script src="../js/toPages.js"></script>
    </body>
</html>

