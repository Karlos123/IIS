<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("tmp");
session_start();
require_once 'db.php';

if(!isset($_SESSION['use'])){
    header('Location: '. 'error_page.php');
}
if($_POST['valid']=="true")
{
    foreach($_POST as $key => $value)
    {
        $_POST[$key]= ($value == '' ? 'NULL' : "'".$value."'");
    }
    $q="INSERT INTO Vybeh (typ, max_zvirat, cas_na_cisteni, otevren)
    VALUES (".$_POST['type'].", ".$_POST['capacity'].", ".$_POST['cleaning_time'].", ".$_POST['opened_from'].")";

    if($db->query($q)=== FALSE)
    {
        header('Location: '. 'error_page.php');
    }
    else {
        header('Location:'.'fences.php');
    }

}



?>

!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<!-- HEAD  -->
<head>
    <meta charset=utf-8>
    <title>ZOOIS</title>
    <link rel="stylesheet" href="style.css" type="text/css" >
</head>


<!-- BODY  -->
<body>

    <!-- Logo  -->
    <img src="logo.png" alt="Logo" style="height:100px;">

    <!-- Side bar -->
    <div id="sidebar">
        <?php require_once 'sidebar.php' ?>
    </div>

    <!-- Header-->
    <div id="header">
        Fences->Add
    </div>

    <!-- Content -->

    <div id="content">
        <form method="post" onsubmit="return check_values();" accept-charset="utf8">
            <table>
                <tr><td>Type:</td><td><input class="add" type="text" required="" placeholder="Type" name="type"></td></tr>
                <tr><td>Capacity:</td><td><input class="add" type="text" placeholder="Capacity" name="capacity"></td></tr>
                <tr><td>Cleaning time:</td><td><input id="clean_time" class="add" type="text" placeholder="Cleaning time" name="cleaning_time"></td><td>(minimum 10)</td></tr>
                <tr><td>Opened from:</td><td><input id="opened_from" class="add" type="text" placeholder="Opened from" name="opened_from"></td><td>(yyyy-mm-dd)</td><td>
                </table>
                <input type="hidden" name="valid" id="valid" value="false">
                <button class="add" type="submit" >Add fence</button>
            </form>
            <p id="result"></p>
            <script>
            function check_values() {
                var x=document.getElementById('clean_time').value;
                var d=document.getElementById('opened_from').value;
                var valid=false;
                var day, month, year, date, my_date;

                if(!(x == ""))
                {
                    if(isNaN(x) || x<10 || x>120)
                    {
                        document.getElementById("result").innerHTML="Cleaning time is not valid!";
                        return false;
                    }
                }
                if(!(d== ""))
                {

                    if(d.length == 10)
                    {
                        year=d.substring(0,4);
                        month=d.substring(5,7);
                        day=d.substring(8,10);
                        date = new Date();
                        my_date= new Date(year, month, day);
                        if(my_date >= date )
                        {
                            document.getElementById("result").innerHTML="Opened from is not valid!";
                            return false;
                        }
                    }
                    else
                    {
                        document.getElementById("result").innerHTML="Time format is not valid";
                        return false;
                    }
                }
                document.getElementById("valid").value = true;
                return true;

            }
            </script>


        </div>



    </body>


    </html>
