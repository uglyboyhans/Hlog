<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hlog - sign up</title>
    </head>

    <body onload="enableSubmit()">
        <div id="div_register">
            <form id="form_register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label id="label_username">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    username:<input type="text" placeholder="username..." name="username" size="20" />* no more than 20
                </label><br />
                <label id="label_password">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    password:<input type="password" size="16" name="password" id="input_pass" />
                    * no less than 9 but no more than 16
                </label><br />
                <label id="label_password_repeat">
                    password again:<input type="password" size="16" name="password_r" id="input_pass_r" />
                    <span id="repeat_error" class="error"></span>
                </label><br />
                Gender:
                <input type="radio" name="gender" value="female">Female</input>
                <input type="radio" name="gender" value="male" checked="checked">Male</input>
                <br />
                <input type="submit" id="register_submit" value="SignUp" disabled="true" />
            </form>
            <p>
                Have account already?<a href="login.php">login now!</a>
            </p>
            <?php
            //init:
            $flag = true;
            $username = $password = $gender = "";
            //post:
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $gender = $_POST["gender"];
            }
            //connect mysql:
            if ($username != "" && $password != "") {
                $con = mysql_connect("localhost", "loguser", "uglyboy");
                if (!$con) {
                    die("Failed to connect:" . mysql_error());
                } else {
                    mysql_select_db("hlog", $con);
                    $query = "select username from userLogin where username='$username'"; //check whether it exist..
                    $result = mysql_query($query, $con);
                    while ($row = mysql_fetch_array($result)) {
                        //if (!empty($row['username'])) {
                        mysql_close($con);
                        echo "The username has already exist!Please use another username!";
                        $flag = false; //can't regiest
                    }
                    if ($flag) {
                        //insert into table "userlogin,userInfo,usersetting,visitNum:
                        $signDate = date("y-m-d");
                        $query = "insert into userLogin (username,password,signDate)"
                                . " values ('$username','$password','$signDate')";
                        if (mysql_query($query, $con)) {
                            $userID = mysql_insert_id($con); //get userID that registering now
                        } else {
                            echo mysql_error(); //insert userlogin
                        }
                        $query = "insert into userInfo (userID,name,gender)"
                                . " values ($userID,'$username','$gender')";
                        if (mysql_query($query, $con)) {
                            $query = "insert into userSettings (userID)"
                                    . " values ($userID)";
                            if (mysql_query($query, $con)) {
                                $query = "insert into visitNum (userID,num)"
                                        . " values ($userID,0)";
                                if (mysql_query($query, $con)) {
                                    mysql_close($con);
                                    session_start();
                                    $_SESSION["login"] = $userID;
                                    echo "<script>"
                                    . "alert('OK!');location.href='center.php';"
                                    . "</script>";
                                } else {
                                    echo mysql_error(); //insert visitNum
                                }
                            } else {
                                echo mysql_error(); //insert userSettings
                            }
                        } else {
                            echo mysql_error(); //insert userInfo
                        }
                    }
                }
            }
            ?>
            <script>
                function enableSubmit() {
                    var pass = document.getElementById("input_pass").value;
                    var pass_r = document.getElementById("input_pass_r").value;
                    if (pass_r !== "") {
                        document.getElementById("repeat_error").innerHTML = "two passwords are not seem!"
                        if (pass === pass_r && pass.length >= 9) {
                            document.getElementById("register_submit").disabled = false;
                            document.getElementById("repeat_error").innerHTML = "";
                        } else {
                            document.getElementById("register_submit").disabled = true;
                        }

                    }
                    var time = setTimeout('enableSubmit()', 30);
                }
            </script>
        </div>
    </body>
</html>
