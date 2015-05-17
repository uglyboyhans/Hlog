<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include '../PagePart/SessionInfo.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - Feelings</title>
    </head>
    <body>
        <a href="center.php">Center</a>
        <?php
        $q = $_GET["q"]; //ownerID
        $query = "select id,article,addTime,picture from feelings where author=" . $q . " order by id desc";
        $result_feelings = mysql_query($query, $con);
        echo "<p>------------------------------</p>";
        while ($row_feelings = mysql_fetch_array($result_feelings)) {
            if (!empty($row_feelings["id"])) {
                echo $row_feelings["article"] . "<br />";
                if ($row_feelings["picture"] !== "" && $row_feelings["picture"] !== NULL) {
                    $query = "select src from photos where id=" . $row_feelings["picture"];
                    $result_pic = mysql_query($query, $con);
                    while ($row_pic = mysql_fetch_array($result_pic)) {
                        echo "<img src='" . $row_pic["src"] . "' width='150px' />";
                    }
                }
                echo "<br />..." . $row_feelings["addTime"];
                //if admin,can manage:
                if ($q === $login_ID) {
                    echo "<button onclick='deleteFeel(" . $row_feelings["id"] . ")'>delete</button>";
                }
                echo "<button onclick='commentFeel(" . $row_feelings["id"] . ")'>comment</button>";
                echo "<hr />";
            } else {
                echo "There is no feeling has been published~";
            }
        }
        mysql_close($con);
        ?>
        <a href="#" onclick="blogIndex(<?php echo $q; ?>)">Back to Blog Index</a>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</html>
