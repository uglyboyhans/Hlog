<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
$login_ID = $_SESSION["login"];

if ($login_ID === "" || $login_ID === NULL) {
    echo "<script>"
    . "location.href='login.php';"
    . "</script>";
} else {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect:" . mysql_error());
    } else {
        mysql_select_db("hlog");
        $query = "select name from userInfo where userID=".$login_ID;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            $name=$row["name"];
        }
        mysql_close($con);
    }
    echo "Welcome: " . $name . " ! <a href='logout.php'>logout</a><br />";
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
        $con = mysql_connect("localhost", "loguser", "uglyboy");
        if (!$con) {
            die("Failed to connect:" . mysql_error());
        } else {
            mysql_select_db("hlog", $con);
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
                    echo "<p><select>"
                    . "<option value='manage'>manage</option>"
                    . "<option value='edit' onclick='editBlog(" . $q . ")'>edit</option>"
                    . "<option value='delete' onclick='deleteBlog(" . $q . ")'>delete</option>"
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
                    echo "<a href='#' onclick='blogIndex(" . $row_comment['visitor'] . ")'>" .$visitor . "</a> says:<br />";
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
        }
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

