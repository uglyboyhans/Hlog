/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function addPic(value){
    if(value==="addPic_new"){
        addPic_new();
    }else if(value==="addPic_album"){
        addPic_album();
    }
}

var xmlHttp;
xmlHttp = GetXmlHttpObject();
function addPic_new() {
    if (xmlHttp === null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "../manage/addPic_new.php";
    url = url + "?sid=" + Math.random();
    xmlHttp.onreadystatechange = stateChangedAddPicture;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function addPic_album() {
    if (xmlHttp === null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "../manage/addPic_album.php";
    url = url + "?sid=" + Math.random();
    xmlHttp.onreadystatechange = stateChangedAddPicture;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function addPicture(){
    document.getElementById("select_picture").style.display = "block";
}

function stateChangedAddPicture()
{
    if (xmlHttp.readyState === 4 || xmlHttp.readyState === "complete") {
        document.getElementById("add_picture").innerHTML=xmlHttp.responseText;
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
