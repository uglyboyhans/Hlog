<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>HLog - logout</title>
    </head>
    <body>
        <?php
        session_start();
        unset($_SESSION["login"]);
        echo "OK!<a href='login.php'>Come back</a>"
        ?>
    </body>
</html>
