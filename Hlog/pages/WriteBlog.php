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
        die("Could not connect" . mysql_error());
    } else {
        mysql_select_db("hlog");
        $query = "select name from userInfo where userID=" . $login_ID;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            $name = $row["name"];
        }
        mysql_close($con);
    }
    echo "Welcome: " . $name . " ! <a href='logout.php'>logout</a><br />";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - create</title>
        <script src="../../ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label>Title:<input type="text" placeholder="your title.." id="input_title" name="title"/></label><br />
                <textarea cols="55" rows="31" name="article" id="input_article"></textarea>
                <br />
                <label>Blog Class:<input type="text" value="fellings" id="input_genre" name="genre" /></label><br />
                <input type="submit" value="publish" />
                <script>
                    CKEDITOR.replace('article');
                </script>
            </form>
        </div>

        <a href="center.php">Center</a>

        <?php
        $title = $article = $genre = ""; //init;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
        }
        if ($title != "") {
            //get article from post:
            $article = $_POST["article"];
            $genre = $_POST["genre"];
            //save the blog into mysql:
            $con = mysql_connect("localhost", "loguser", "uglyboy");
            if (!$con) {
                die("Failed to connect:" . mysql_error());
            } else {
                //init time:
                $time = date("Y-m-d h:i:s");
                //select db:
                mysql_select_db("hlog", $con);
                //insert blog:
                $query = "insert into blog (title,author,article,addTime,genre)"
                        . " values ('$title',$login_ID,'$article','$time','$genre')";
                if (mysql_query($query, $con)) {
                    //add to readNum(count the read number):
                    //get blog id:
                    $relyID = mysql_insert_id($con);
                    //insert into readNum
                    $query = "insert into readNum values ('blog',$relyID,0)";
                    if (mysql_query($query, $con)) {
                        mysql_close($con);
                        echo "<script>"
                        . "alert('OK!');location.href='center.php';"
                        . "</script>";
                    } else {//end if(insert into readNum)
                        die(mysql_error($con));
                    }
                } else {//end if(insert into blog)
                    die(mysql_error($con));
                }
            }
        }
        ?>
    </body>
</html>
