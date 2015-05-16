<?php

$albumID = $_GET["q"];
if ($albumID !== "") {
    $con = mysql_connect("localhost", "loguser", "uglyboy");
    if (!$con) {
        die("Could not connect:" . mysql_error());
    } else {
        mysql_select_db("hlog");
        $query = "select id,src from photos where album=" . $albumID;
        $result = mysql_query($query, $con);
        while ($row = mysql_fetch_array($result)) {
            if (!empty($row["id"])) {
                $id = $row["id"];
                $src = $row["src"];
                //$img_show_out = "<img width='120px' src='$src'/>";
                $str_function = "onclick=\"selectPhoto('$id','$src');\"";//  use " \ " solve quot problem!!!
                $img_in_iframe = "<img width='120px' src='$src' " . $str_function . " />";
                echo $img_in_iframe;
            }
        }
    }
    mysql_close($con);
}