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
        $q = $_GET["q"];//blogID

        $query = "select title,article,addtime,author from blog where id=" . $q;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            echo "<h2>" . $row['title'] . "</h2>";
            //get name because $row['author'] is author's ID:
            $query = "select name from userInfo where userID =" . $row['author'];
            $result = mysql_query($query, $con);
            while ($row1 = mysql_fetch_array($result)) {
                $author = $row1['name'];
            }
            echo "<a href='#' onclick='blogIndex(" . $row['author'] . ")'>" . $author . "</a><br />";
            echo "----------------" . $row['addtime'] . "<br />";
            echo $row['article'];
            if ($login_ID === $row['author']) {//if author,can manage blog~
                $isAdmin = true;
                $str_function="manage(this.value,$q)";
                echo "<p><select onchange=$str_function>"
                . "<option value=''>manage</option>"
                . "<option value='editBlog'>edit</option>"
                . "<option value='deleteBlog'>delete</option>"
                . "</select></p>";
            }
        }
        echo "<p>**********************************************************</p>";
        echo "Comments:<br />-------------------------------------<br />";
        $query = "select id,visitor,content,addtime,reply from comment where ObType='blog' and relyID=$q";
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
            <input type="hidden" value="blog" name="ObType" />
        </form>
        <br /><a href="center.php">Center</a>
        <script src="../js/manage.js"></script>
        <script src="../js/toPages.js"></script>
    </body>
</html>

