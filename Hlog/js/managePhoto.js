/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function managePhoto(value, id) {
    if (value === "movePhoto") {
        //show the iframe:
        document.getElementById("iframe_movePhoto").style.display = "block";
    } else if (value === "deletePhoto") {
        deletePhoto(id);
    } else if (value === "setAsCover") {
        setAsCover(id);
    } else if (value === "renamePhoto") {
        //show the form:
        document.getElementById("form_renamePhoto").style.display = "block";
    } else if (value === "renameAlbum") {
        //show the form:
        document.getElementById("form_renamePhotoAlbum").style.display = "block";
    } else if (value === "batchDelete") {
        batchDelete(id);
    } else if (value === "deleteAlbum") {
        deleteAlbum(id);
    }
}

var xmlHttp;
xmlHttp = GetXmlHttpObject();
function deletePhoto(photoID) {
    if (confirm("Sure to delete this photo?") === true) {//make sure
        if (xmlHttp === null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        var url = "../manage/deletePhoto.php";
        url = url + "?q=" + photoID;
        url = url + "&sid=" + Math.random();
        xmlHttp.onreadystatechange = stateChangedManagePhoto;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}

function deleteAlbum(AlbumID) {
    if (confirm("Sure to delete this album?") === true) {//make sure
        if (xmlHttp === null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        var url = "../manage/deletePhotoAlbum.php";
        url = url + "?q=" + AlbumID;
        url = url + "&sid=" + Math.random();
        xmlHttp.onreadystatechange = stateChangedDelAlbum;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}

function setAsCover(photoID) {
    if (confirm("Sure to set as Album Cover ?") === true) {//make sure
        if (xmlHttp === null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        var url = "../manage/setPhotoAlbumCover.php";
        url = url + "?q=" + photoID;
        url = url + "&sid=" + Math.random();
        xmlHttp.onreadystatechange = stateChangedManagePhoto;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}

function batchDelete(albumID) {
    var url = "../manage/batchDeletePhotos.php";
    url = url + "?q=" + albumID;
    url = url + "&sid=" + Math.random();
    location.href = url;
}

function stateChangedManagePhoto()
{
    if (xmlHttp.readyState === 4 || xmlHttp.readyState === "complete") {
        history.go(-1);
    }
}
function stateChangedDelAlbum()
{
    if (xmlHttp.readyState === 4 || xmlHttp.readyState === "complete") {
        location.href="../pages/photoAlbumsList.php";
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


