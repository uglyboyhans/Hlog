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
        <title>Hlog - read</title>
    </head>
    <body>
        <?php
        $isAdmin = false;
        $q = $_GET["q"]; //blogID

        $query = "select blog.title,blog.article,blog.addtime,blog.author,userInfo.name as authorName "
                . "from blog,userInfo where blog.author=userInfo.userID and id=" . $q;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            echo "<h2>" . $row['title'] . "</h2>";
            //get name because $row['author'] is author's ID:
            $authorID = $row["author"];
            $authorName = $row["authorName"];
            echo "<a href='#' onclick='blogIndex($authorID)'>" . $authorName . "</a><br />";
            echo "----------------" . $row['addtime'] . "<br />";
            echo $row['article'];
            if ($login_ID === $authorID) {//if author,can manage blog~
                $isAdmin = true;
                $str_function = "manage(this.value,$q)";
                echo "<p><select onchange=$str_function>"
                . "<option value=''>manage</option>"
                . "<option value='editBlog'>edit</option>"
                . "<option value='deleteBlog'>delete</option>"
                . "</select></p>";
            }
        }
        echo "<p>**********************************************************</p>";
        echo "Comments:<br />-------------------------------------<br />";
        $query = "select id,visitor,content,addtime from comment where ObType='blog' and relyID=$q";
        $result_comment = mysql_query($query, $con);
        if (!empty($result_comment)) {
            while ($row_comment = mysql_fetch_array($result_comment)) {
                //get this comment:
                $query = "select name from userInfo where userID =" . $row_comment['visitor'];
                $result = mysql_query($query, $con);
                while ($row1 = mysql_fetch_array($result)) {
                    $visitor = $row1['name'];
                }
                echo "<a href='#' onclick='blogIndex(" . $row_comment['visitor'] . ")'>" . $visitor . "</a> says:<br />";
                echo $row_comment['content'] ;
                echo "(" . $row_comment['addtime'] . ")<br />";
                //get all reply:
                $query = "select content,addTime from reply where Obtype='comment' and relyID=". $row_comment['id'] ;
                $result_reply=  mysql_query($query, $con);
                while($row_reply=  mysql_fetch_array($result_reply)){
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='blogIndex(" . $authorID . ")'>" . $authorName . "</a> reply:";
                    echo "&nbsp;".$row_reply["content"];
                    echo "(".$row_reply["addTime"].")<br />";
                }

                if ($isAdmin) {//if author,can manage comment~
                    echo "<button onclick='reply(" . $row_comment['id'] . ")'>reply</button>";
                    echo "<button onclick='deleteComment(" . $row_comment['id'] . ")'>delete</button>";
                    echo "<div id='" . $row_comment['id'] . "' style='display:none'>"
                    . "<form action='../manage/replyComment.php' method='post'>"
                    . "<input type='hidden' name='relyID' value=" . $row_comment['id'] . " />"
                    . "<textarea cols='22' rows='3' name='content'></textarea>"
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
            <input type="hidden" value="<?php echo $authorID; ?>" name="userID" />
            <textarea cols="55" rows="11" name="content"></textarea>
            <input type="submit" id="submit_comment" value="Comment" />
            <input type="hidden" value="blog" name="ObType" />
        </form>
        <br /><a href="center.php">Center</a>
        <script src="../js/manage.js"></script>
        <script src="../js/toPages.js"></script>
    </body>
</html>

