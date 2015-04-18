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
        $result_name = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result_name)) {
            $name = $row["name"];
        }
    }
    echo "Welcome: " . $name . " ! <a href='logout.php'>logout</a><br />";
}
?>
<?php
$q = $_GET["q"]; //owner's userID
if($q===$login_ID){
    echo "<script>"
    . "location.href='center.php';"
    . "</script>";
}
$followerNum=$followingNum=0;//numbers about owner's following situation
$doFollow="<button id='btn_follow' onclick='follow($q)' >follow</button>";
$query = "select name from userInfo where userID=" . $q;
$result_ownername = mysql_query($query, $con);
while ($row = mysql_fetch_array($result_ownername)) {
    $owner_name = $row['name'];
}
//set doFollow:
$query = "select following from following where userID=" .$login_ID;
$result_doFollow = mysql_query($query, $con);
while ($row = mysql_fetch_array($result_doFollow)) {
    $doFollow="<button id='btn_unFollow' onclick='unFollow($q)' >Unfollow</button>";
}

//count following and follower numbers:
$query = "select COUNT(following) as followingNum from following where userID=".$q;//following number
$rst_Folingnum=mysql_query($query, $con);
while($row_folingnum=  mysql_fetch_array($rst_Folingnum)){
    $followingNum=$row_folingnum["followingNum"];
}

$query = "select COUNT(userID) as followerNum from following where following=".$q;//follower number
$rst_Folernum=mysql_query($query, $con);
while($row_folernum=  mysql_fetch_array($rst_Folernum)){
    $followerNum=$row_folernum["followerNum"];
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - <?php echo $owner_name; ?>'s blog index</title>
    </head>
    <body>
        <div><!--userInfo-->
            <?php echo $doFollow ?><!--<button >follow</button>-->
            <span id="following">following:<?php echo $followingNum; ?></span>&nbsp;&nbsp;
            <span id="follower">follower:<?php echo $followerNum; ?></span>
            <br />
            
        </div>
        <div><!--Main part-->
        <?php
        $query = "select id,title,addtime from blog where author=" . $q;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            echo "<p>-------------------------------------</p>";
            echo "<a href='#' onclick='readBlog(" . $row['id'] . ")'>" . $row['title'] . "</a>";
            echo "--------<a href='#' onclick='blogIndex(" . $q . ")'>" . $owner_name .
            "</a>--------" . $row['addtime'];
        }
        mysql_close($con);
        ?>
        </div>
        <a href="center.php">Center</a>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</html>
