<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//get session information to know the user;
include '../PagePart/SessionInfo.php';

/*
 * get owner's ID;
 * get following information;
 * get visitor information;
 */
$q = $_GET["q"]; //owner's userID

$followerNum = $followingNum = 0; //numbers about owner's following situation
$doFollow = "<button id='btn_follow' onclick='follow($q)' >Follow</button>";
$query = "select name from userInfo where userID=" . $q;
$result_ownerName = mysql_query($query, $con);
while ($row = mysql_fetch_array($result_ownerName)) {
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
    <body onload="NewInfoNum()">
        <a href="center.php">Center</a>
        <!--userInfo-->
        <div id="div_userInfo">
            <?php echo $doFollow ?><!--<button >follow</button>-->
            <span id="following">following:<?php echo $followingNum; ?></span>&nbsp;&nbsp;
            <span id="follower">follower:<?php echo $followerNum; ?></span>&nbsp;&nbsp;
            <span id="visitNum">visitor number:<?php echo $newVstNum; ?></span>
            <br />
        </div><!--end userinfo-->

        <!--Main part-->
        <div id="div_mainPart">
            <!--audio src="../../userData/mediaFiles/music/曹方 - 春花秋开.mp3" controls="controls">春花秋开</audio-->
            <h3>Photos</h3>
            <p>Choose Album:</p>
            <select onchange="showAlbumCover(this.value)">
                <option value="">Albums</option>
                <?php
                $query = "select id,name from photoAlbums where author=" . $q;
                $result_albums = mysql_query($query, $con);
                while ($row = mysql_fetch_array($result_albums)) {
                    if (!empty($row["id"])) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option> ";
                    }
                }
                ?>
            </select>
            <div id="albumCover"></div>
            <h3>Blog</h3>
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
        </div><!--End Main part-->

        <!--feelings-->
        <div id="div_feelings">
            <h2>Feelings</h2>
            <?php
            $query = "select article,addTime,picture from feelings where author=" . $q . " order by id desc limit 1";
            $result_feeling = mysql_query($query, $con);
            while ($row_feeling = mysql_fetch_array($result_feeling)) {
                if (!empty($row_feeling)) {
                    echo $row_feeling["article"]."<br />";
                    if($row_feeling["picture"]!==""&&$row_feeling["picture"]!==NULL){
                        $query="select src from photos where id=".$row_feeling["picture"];
                        $result_pic=  mysql_query($query, $con);
                        while($row_pic=  mysql_fetch_array($result_pic)){
                            echo "<img src='".$row_pic["src"]."' width='150px' />";
                        }
                    }
                    echo "<br />...".$row_feeling["addTime"];
                }
            }
            ?>
            <p><a href="javascript:void(0)" onclick="Feelings(<?php echo $q; ?>)">more>></a></p>
        </div><!--End feelings-->

        <!--msgBoard-->
        <div id="div_msgBoard">
            <h2>Message Board</h2>
            <a href="#" onclick="sendMsg(<?php echo $q; ?>)">Write Message</a><br />
            <?php
            $query = "select id,visitor,content,addtime from message where userID=" . $q . " order by id desc limit 3";
            $result_message = mysql_query($query, $con);
            echo "<p>------------------------------</p>";
            if (!empty($result_message)) {
                while ($row_message = mysql_fetch_array($result_message)) {
                    $query = "select name from userInfo where userID =" . $row_message['visitor'];
                    $result_visitorName = mysql_query($query, $con);
                    while ($row1 = mysql_fetch_array($result_visitorName)) {
                        $visitor = $row1['name'];
                    }
                    echo "<a href='#' onclick='blogIndex(" . $row_message['visitor'] . ")'>" . $visitor . "</a> :<br />";
                    echo $row_message['content'] . "<br />";
                    echo "------------------" . $row_message['addtime'] . "<br />";
                    $query = "select content,addTime from reply where Obtype='message' and relyID=" . $row_message['id'];
                    $result_reply = mysql_query($query, $con);
                    while ($row_reply = mysql_fetch_array($result_reply)) {
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='blogIndex(" . $q. ")'>" . $owner_name . "</a> reply:";
                        echo "&nbsp;" . $row_reply["content"];
                        echo "(" . $row_reply["addTime"] . ")<br />";
                    }
                }
            }
            mysql_close($con);
            ?>
            <a href="#" onclick="MsgBoard(<?php echo $q; ?>)">more>></a>
        </div><!--End msgBoard-->

    </body>
    <script src="../js/showAlbumCover.js"></script>
    <script src="../js/toPages.js"></script>
    <script src="../js/manage.js"></script>
    <script src="../js/newInfo.js"></script>
</html>
