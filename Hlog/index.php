<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <form action="" method="post">
            <textarea name="editor1" rows="30" cols="50"></textarea>
            <input type="submit" value="submit" />
            <script>
                CKEDITOR.replace('editor1');
            </script>
        </form>
        <?php
        
        ?>
    </body>
</html>
