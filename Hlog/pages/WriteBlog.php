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
        <title>HLog - create</title>
        <script src="../ckeditor/ckeditor.js"></script>
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

        <a href="../index.php">Index</a>

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
            $con = mysql_connect("localhost", "root", "aishangni520");
            if (!$con) {
                die("Failed to connect:" . mysql_error());
            } else {
                //init time:
                $time = date("Y-m-d h:i:s");
                //select db:
                mysql_select_db("hlog", $con);
                //get userID:
                $query = "select userID from userlogin where username = '$login_name'";
                $result = mysql_query($query, $con);
                while ($row1 = mysql_fetch_array($result)) {
                    $userID = $row1['userID'];
                }
                //insert blog:
                $query = "insert into blog (title,author,article,addTime,genre)"
                        . " values ('$title',$userID,'$article','$time','$genre')";
                if (mysql_query($query, $con)) {
                    //add to readNum(count the read number):
                    //get blog id:
                    $query = "select max(id) as id from blog where author =$userID";
                    $result = mysql_query($query, $con);
                     while ($row1 = mysql_fetch_array($result)) {
                      $relyID = $row1['id'];
                      } 
                    //insert into readNum
                    $query = "insert into readNum values ('blog',$relyID,0)";
                    if (mysql_query($query, $con)) {
                        mysql_close($con);
                        echo "<script>"
                        . "alert('OK!');location.href='center.php';"
                        . "</script>";
                    } else {
                        die(mysql_error($con));
                    }
                } else {
                    die(mysql_error($con));
                }
            }
        }
        ?>
    </body>
</html>
