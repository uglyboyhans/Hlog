<?php
session_start();
$login_ID = $_SESSION["login"];
$con = mysql_connect("localhost", "loguser", "uglyboy");
if (!$con) {
    die("Could not connect" . mysql_error());
} else {
    mysql_select_db("hlog");
    $newInfoNum=0;
    $query = "select count(newInfo.id) as info_num from newInfo,message "
            . "where message.haveRead='NO' and newInfo.InfoType='message' and message.id=newInfo.relyID and newInfo.userID=".$login_ID;
    $result = mysql_query($query, $con);
    while ($row=  mysql_fetch_array($result)){
        $newInfoNum+=$row["info_num"];
    }
    $query = "select count(newInfo.id) as info_num from newInfo,comment "
            . "where comment.haveRead='NO' and newInfo.InfoType='comment' and comment.id=newInfo.relyID and newInfo.userID=".$login_ID;
    $result = mysql_query($query, $con);
    while ($row=  mysql_fetch_array($result)){
        $newInfoNum+=$row["info_num"];
    }
    $query = "select count(newInfo.id) as info_num from newInfo,reply "
            . "where reply.haveRead='NO' and newInfo.InfoType='reply' and reply.id=newInfo.relyID and newInfo.userID=".$login_ID;
    $result = mysql_query($query, $con);
    while ($row=  mysql_fetch_array($result)){
        $newInfoNum+=$row["info_num"];
    }
    $query = "select count(newInfo.id) as info_num from newInfo,letter "
            . "where letter.haveRead='NO' and newInfo.InfoType='letter' and letter.id=newInfo.relyID and newInfo.userID=".$login_ID;
    $result = mysql_query($query, $con);
    while ($row=  mysql_fetch_array($result)){
        $newInfoNum+=$row["info_num"];
    }
    
    if($newInfoNum!==0){
        echo $newInfoNum;
    }
}
