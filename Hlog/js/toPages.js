/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function readBlog(read_id) {
    var url = "../pages/readBlog.php";
    url = url + "?q=" + read_id;
    url = url + "&sid=" + Math.random();
    location.href = url;
}

function blogIndex(author_id) {
    var url = "../pages/blogIndex.php";
    url = url + "?q=" + author_id;
    url = url + "&sid=" + Math.random();
    location.href=url;
}

function sendMsg(owner_id) {
    var url = "../pages/sendMsg.php";
    url = url + "?q=" + owner_id;
    url = url + "&sid=" + Math.random();
    location.href=url;
}

function replyMsg(msgID){
    var url = "../pages/replyMsg.php";
    url = url + "?q=" + msgID;
    url = url + "&sid=" + Math.random();
    location.href=url;
}

function MsgBoard(userID){
    var url = "../pages/MsgBoard.php";
    url = url + "?q=" + userID;
    url = url + "&sid=" + Math.random();
    location.href=url;
}

function photoAlbum(album_id){
    var url = "../pages/photoAlbum.php";
    url = url + "?q=" + album_id;
    url = url + "&sid=" + Math.random();
    location.href=url;
}

function viewPhoto(photo_id) {
    var url = "../pages/viewPhoto.php";
    url = url + "?q=" + photo_id;
    url = url + "&sid=" + Math.random();
    location.href = url;
}

function Feelings(userID){
    var url = "../pages/Feelings.php";
    url = url + "?q=" + userID;
    url = url + "&sid=" + Math.random();
    location.href = url;
}