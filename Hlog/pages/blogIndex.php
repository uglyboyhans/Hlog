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

/*
 * get owner's ID;
 * get following information;
 * get visitor information;
 */
$q = $_GET["q"]; //owner's userID

$followerNum = $followingNum = 0; //numbers about owner's following situation
$doFollow = "<button id='btn_follow' onclick='follow($q)' >Follow</button>";
$query = "select name from userInfo where userID=" . $q;
$result_ownername = mysql_query($query, $con);
while ($row = mysql_fetch_array($result_ownername)) {
    $owner_name = $row['name'];
}
//set doFollow:
if ($q !== $login_ID) {
    $query = "select following from following where userID=" . $login_ID . " and following=" . $q;
    $result_doFollow = mysql_query($query, $con);
    if (!empty($result_doFollow)) {
        while ($row_doFollow = mysql_fetch_array($result_doFollow)) {
            $doFollow = "<button id='btn_unFollow' onclick='unFollow($q)' >Unfollow</button>";
        }
    }
} else {
    $doFollow = "";
}

//count following and follower numbers:
$query = "select COUNT(following) as followingNum from following where userID=" . $q; //following number
$rst_Folingnum = mysql_query($query, $con);
while ($row_folingnum = mysql_fetch_array($rst_Folingnum)) {
    $followingNum = $row_folingnum["followingNum"];
}
$query = "select COUNT(userID) as followerNum from following where following=" . $q; //follower number
$rst_Folernum = mysql_query($query, $con);
while ($row_folernum = mysql_fetch_array($rst_Folernum)) {
    $followerNum = $row_folernum["followerNum"];
}
//get visitor number:
$query = "select num from visitNum where userID=" . $q;
$result_vstNum = mysql_query($query, $con);
while ($row_vstNum = mysql_fetch_array($result_vstNum)) {
    $visitNum = $row_vstNum['num']; //add visitNum from this time
    //if not myself: (visitor number )+1 and to mysql:
    if ($q !== $login_ID) {
        $newVstNum = $visitNum + 1;
        $query1 = "update visitNum set num=$newVstNum where userID=" . $q;
        if (mysql_query($query1, $con)) {
            
        } else {
            die(mysql_error());
        }
    } else {
        $newVstNum = $visitNum;
    }
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
            <span id="follower">follower:<?php echo $followerNum; ?></span>&nbsp;&nbsp;
            <span id="visitNum">visitor number:<?php echo $newVstNum; ?></span>
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
            ?>
        </div>
        <div id="div_msgBoard">
            <h2>Message Board</h2>
            <a href="#" onclick="sendMsg(<?php echo $q; ?>)">Write Message</a><br />
            <?php
            $query = "select id,visitor,content,addtime,reply from message where userID=" . $q." order by id desc limit 3";
            $result_message = mysql_query($query, $con);
            echo "<p>------------------------------</p>";
            if (!empty($result_message)) {
                while ($row_message = mysql_fetch_array($result_message)) {
                    $query = "select name from userInfo where userID =" . $row_message['visitor'];
                    $result_userID = mysql_query($query, $con);
                    while ($row1 = mysql_fetch_array($result_userID)) {
                        $visitor = $row1['name'];
                    }
                    echo "<a href='#' onclick='blogIndex(" . $row_message['visitor'] . ")'>" . $visitor . "</a> :<br />";
                    echo $row_message['content'] . "<br />";
                    echo "------------------" . $row_message['addtime'] . "<br />";
                    if (!empty($row_message['reply'])) {              //in case it's NULL
                        echo "admin reply:" . $row_message['reply'] . "<br />";
                    }
                }
            }
            mysql_close($con);
            ?>
            <a href="#" onclick="MsgBoard(<?php echo $q; ?>)">more>></a>
        </div>
        <a href="center.php">Center</a>
    </body>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
</html>
