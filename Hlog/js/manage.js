/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//when manage in <select>:
function manage(value, id) {
    if (value === "replyMsg") {
        replyMsg(id);
    } else if (value === "deleteMsg") {
        deleteMsg(id);
    } else if(value==="editBlog"){
        editBlog(id);
    }else if(value==="deleteBlog"){
        deleteBlog(id);
    }else if(value==="deleteFeeling"){
        deleteFeeling(id);
    }
}

var xmlHttp;
xmlHttp = GetXmlHttpObject();
function follow(followingID) {
    if (xmlHttp === null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "../manage/follow.php";
    url = url + "?q=" + followingID;
    url = url + "&sid=" + Math.random();
    xmlHttp.onreadystatechange = stateChanged;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function unFollow(followingID) {
    if (xmlHttp === null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "../manage/unFollow.php";
    url = url + "?q=" + followingID;
    url = url + "&sid=" + Math.random();
    xmlHttp.onreadystatechange = stateChanged;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function editBlog(blog_id) {//actually it should be in "toPages.js"
    var url = "../manage/editBlog.php";
    url = url + "?q=" + blog_id;
    url = url + "&sid=" + Math.random();
    location.href = url;
}

function deleteBlog(del_id) {
    if (confirm("Sure to delete this article?") === true) {
        if (xmlHttp === null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        var url = "../manage/deleteBlog.php";
        url = url + "?q=" + del_id;
        url = url + "&sid=" + Math.random();
        xmlHttp.onreadystatechange = stateChanged;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}

//delete comment:
function deleteComment(del_id) {
    if (confirm("delete?") === true) {
        if (xmlHttp === null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        var url = "../manage/deleteComment.php";
        url = url + "?q=" + del_id;
        url = url + "&sid=" + Math.random();
        xmlHttp.onreadystatechange = stateChanged;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}

function deleteMsg(del_id) {
    if (confirm("delete?") === true) {
        if (xmlHttp === null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        var url = "../manage/deleteMsg.php";
        url = url + "?q=" + del_id;
        url = url + "&sid=" + Math.random();
        xmlHttp.onreadystatechange = stateChanged;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}
function deleteFeeling(FeelingID){
    if (confirm("delete?") === true) {
        if (xmlHttp === null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        var url = "../manage/deleteFeeling.php";
        url = url + "?q=" + FeelingID;
        url = url + "&sid=" + Math.random();
        xmlHttp.onreadystatechange = stateChanged;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}

function reply(reply_id) {// show the form to reply a comment;
    document.getElementById(reply_id).style.display = "block";
}

function stateChanged()
{
    if (xmlHttp.readyState === 4 || xmlHttp.readyState === "complete") {
        history.go(0);
    }
}

function GetXmlHttpObject()
{
    var xmlHttp = null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    }
    catch (e)
    {
        //Internet Explorer
        try
        {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

