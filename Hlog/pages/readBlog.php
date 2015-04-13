<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
$login_name = $_SESSION["login"];

if ($login_name === "" || $login_name === NULL) {
    echo "<script>"
    . "location.href='login.php';"
    . "</script>";
} else {
    echo "Welcome: " . $login_name . " ! <a href='logout.php'>logout</a><br />";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - read</title>
    </head>
    <body>
        <?php
        $isAdmin = false;
        $q = $_GET["q"];
        $con = mysql_connect("localhost","loguser","uglyboy");
        if (!$con) {
            die("Failed to connect:" . mysql_error());
        } else {
            mysql_select_db("hlog", $con);
            $query = "select title,article,addtime,author from blog where id=" . $q;
            $result = mysql_query($query, $con);
            while ($row = mysql_fetch_array($result)) {
                echo "<h2>" . $row['title'] . "</h2>";
                $query = "select name from userInfo where userID =".$row['author'];
                $result = mysql_query($query, $con);
                while ($row1 = mysql_fetch_array($result)) {
                    $author = $row1['name'];
                }
                echo "<b>" . $author . "</b><br />";
                echo "----------------" . $row['addtime'] . "<br />";
                echo $row['article'];
                if ($login_name === $author) {//if author,can manage blog~
                    $isAdmin = true;
                    echo "<p><select>"
                    . "<option value='manage'>manage</option>"
                    . "<option value='edit' onclick='editBlog(".$q.")'>edit</option>"
                    . "<option value='delete' onclick='deleteBlog(".$q.")'>delete</option>"
                    . "</select></p>";
                }
            }
            echo "<p>**********************************************************</p>";
            echo "Comments:<br />-------------------------------------<br />";
            $query = "select id,visitor,content,addtime,reply from comment where ObType='blog' and relyID=$q";
            $result_comment = mysql_query($query, $con);
            if (!empty($result_comment)) {
                while ($row_comment = mysql_fetch_array($result_comment)) {
                    echo $row_comment['visitor'] . " says:<br />";
                    echo $row_comment['content'] . "<br />";
                    echo "at " . $row_comment['addtime'] . "<br />";
                    if (!empty($row_comment['reply'])) {              //in case it's NULL
                        echo "admin reply:" . $row_comment['reply'] . "<br />";
                    }
                    if ($isAdmin) {//if author,can manage comment~
                        echo "<button onclick='reply(" . $row_comment['id'] . ")'>reply</button>";
                        echo "<button onclick='deleteComment(" . $row_comment['id'] . ")'>delete</button>";
                        echo "<div id='" . $row_comment['id'] . "' style='display:none'>"
                        . "<form action='manage/reply.php' method='post'>"
                        . "<input type='hidden' name='id' value=" . $row_comment['id'] . " />"
                        . "<textarea cols='22' rows='3' name='reply'></textarea>"
                        . "<input type='submit' value='reply' />"
                        . "</form>"
                        . "test~~~"
                        . "</div>";
                    }
                    echo "<p>------------------------------</p>";
                }
            }
            mysql_close($con);
        }
        ?>
        <p>----------------------------------------------------</p>
        <form action="../manage/comment.php?q=<?php echo $q; ?>" id="form_comment" method="post">
            <textarea cols="55" rows="11" name="content"></textarea>
            <input type="submit" id="submit_comment" value="Comment" />
            <input type="hidden" value="blog" name="ObType" />
        </form>
        <br /><a href="center.php">Center</a>
        <script src="js/manage.js"></script>
    </body>
</html>

