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
        <title>HLog - Individual Center</title>
    </head>
    <body>
        <div id="div_topGuide">
            <!--a href="../index.php"--><img alt="hlog" src="#" /><!--/a-->
            <a href="WriteBlog.php">Write Blog</a>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
