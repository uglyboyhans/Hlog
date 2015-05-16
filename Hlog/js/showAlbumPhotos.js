/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var xmlHttp;
xmlHttp = GetXmlHttpObject();
function showAlbumPhotos(albumID) {
    if (albumID !== "") {
        if (xmlHttp === null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }
        var url = "../manage/showAlbumPhotos.php";
        url = url + "?q=" + albumID;
        url = url + "&sid=" + Math.random();
        xmlHttp.onreadystatechange = stateChangedshowAlbumPhotos;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}

function selectPhoto(photoID,src){
    parent.document.getElementById('picture').value=photoID;
    parent.document.getElementById('show_pic').src=src;
}

//in case of function name hazard of "stateChange" in 'manage.js':
function stateChangedshowAlbumPhotos()
{
    if (xmlHttp.readyState === 4 || xmlHttp.readyState === "complete") {
        document.getElementById("showPhotos").innerHTML = xmlHttp.responseText;
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

