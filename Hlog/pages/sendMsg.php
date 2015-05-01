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
        <title>Hlog - Send Message</title>
    </head>
    <body>
        <div id="div_sendMsg">
            <form id="form_sendMsg" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <textarea name="content" cols="30" rows="5"></textarea>
                <input type="hidden" value="<?php echo $_GET["q"]; ?>" name="userID" />
                <input type="submit" value="Send" />
            </form>
        </div>
        <?php
        $content = "";
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $content = str_replace("'", "\'", $_POST["content"]);
            $userID = $_POST["userID"];
        }
        if ($content !== "") {
            $addtime = date("Y-m-d h:i:s");
            $query = "insert into message (userID,visitor,content,addtime)"
                    . "values($userID,$login_ID,'$content','$addtime')";
            if (mysql_query($query, $con)) {
                mysql_close($con);
                echo "<script>"
                . "alert('OK!~');history.go(-2);"
                . "</script>";
            } else {
                die(mysql_error());
            }
        }
        ?>
        <a href="center.php">Center</a>
    </body>
    <script src="../js/toPages.js"></script>
</html>
