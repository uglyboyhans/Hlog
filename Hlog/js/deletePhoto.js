/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
        xmlHttp.onreadystatechange = stateChanged3;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
}

function stateChanged3()
{
    if (xmlHttp.readyState === 4 || xmlHttp.readyState === "complete") {
        history.go(-1);
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


