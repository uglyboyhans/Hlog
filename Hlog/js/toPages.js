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
    /*xmlHttp.onreadystatechange = stateChanged;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);*/
    location.href=url;
}

function stateChanged()
{
    if (xmlHttp.readyState === 4 || xmlHttp.readyState === "complete")
    {
        document.getElementById("txtHint").innerHTML = xmlHttp.responseText;
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

