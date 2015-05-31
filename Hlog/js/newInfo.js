/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var xmlHttp;
xmlHttp = GetXmlHttpObject();
function NewInfoNum() {
    if (xmlHttp === null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "../manage/NewInfoNum.php";
    url = url + "?sid=" + Math.random();
    xmlHttp.onreadystatechange = stateChangedNewInfoNum;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
    var time = setTimeout('NewInfoNum()', 60000);//get new info number every minite
}

function stateChangedNewInfoNum()
{
    if (xmlHttp.readyState === 4 || xmlHttp.readyState === "complete") {
        document.getElementById("NewInfoNum").innerHTML=xmlHttp.responseText;
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

