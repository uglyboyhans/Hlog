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
    . "location.href='pages/login.php';"
    . "</script>";
} else {
    echo "<script>"
    . "location.href='pages/center.php'"
    . "</script>";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - index</title>
    </head>
    <body>

        <?php
        ?>
    </body>
</html>
