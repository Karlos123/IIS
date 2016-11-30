<?php
session_save_path("tmp");
session_start();
require_once 'db.php';

if(!isset($_SESSION['use'])){
    header('Location: '. 'error_page.php');
}
if($_POST['valid']==true)
{
    foreach($_POST as $key => $value)
    {
        $_POST[$key]= ($value == '' ? 'NULL' : "'".$value."'");
    }

    $q="INSERT INTO Osetrovatel (jmeno, primeni, datum_narozeni, mesto, ulice, nej_dosazene_vzdelani)
    VALUES(".$_POST['name'].",
    ".$_POST['surname'].",
    ".$_POST['birthdate'].",
    ".$_POST['city'].",
    ".$_POST['street'].",
    ".$_POST['school'].")";

    if($db->query($q)=== FALSE)
    header('Location: '. 'error_page.php');

    $q="SELECT os_cislo FROM Osetrovatel WHERE jmeno=".$_POST['name']." AND primeni=".$_POST['surname']." AND datum_narozeni=".$_POST['birthdate'];
    $res=$db->query($q);
    if(!$res)
        header('Location:'. "error_page.php");

    if($res->num_rows== 1)
    {
        $os=$res->fetch_assoc();
        $os=$os['os_cislo'];
    }
    else
        header('Location:'. "error_page.php");

    $q="INSERT INTO Uzivatel (username, password, privileges, pk_osetrovatel)
    VALUES (".$_POST['username'].",
    ".$_POST['password'].",
    ".$_POST['privileges'].",
    (SELECT os_cislo FROM Osetrovatel WHERE os_cislo=".$os."))";
    if($db->query($q)===FALSE)
        header('Location:'. "error_page.php");
    else
        header("Location:". "staff.php");
}



?>

!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<!-- HEAD  -->
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
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
        Staff->Add
    </div>

    <!-- Content -->

    <div id="content">
        <form method="post" onsubmit="return check_values();" accept-charset="utf8">
            <table>
                <tr><td>Username:</td><td><input class="add" type="text" required="" placeholder="Username" name="username"></td></tr>
                <tr><td>Password:</td><td><input class="add" type="password" required="" name="password"></td></tr>
                <tr><td>Privileges:</td><td>
                    <select name="privileges">
                        <option value="2">Manager</option>
                        <option value="1">Regular</option>
                    </select></td>

                    <tr><td><br></td></tr>
                    <tr><td>Name:</td><td><input class="add" type="text" required="" placeholder="Name" name="name"></td></tr>
                    <tr><td>Surname:</td><td><input class="add" type="text" placeholder="Surname" name="surname"></td></tr>
                    <tr><td>Birthdate:</td><td><input id="birthdate" class="add" type="text" placeholder="yyyy-mm-dd" name="birthdate"></td><td>
                        <tr><td>City:</td><td><input id="city" class="add" type="text" placeholder="City" name="city"></td></tr>
                        <tr><td>Street:</td><td><input id="street" class="add" type="text" placeholder="Street" name="street"></td>
                            <tr><td>School:</td><td>
                                <select name="school">
                                    <option value="Středoškolské">High school</option>
                                    <option value="Vysokoškolské">College</option>
                                </select></td>
                            </table>
                            <input type="hidden" name="valid" id="valid" value="false">
                            <button class="add" type="submit" name="add">Add employee </button>
                        </form>
                        <p id="result"></p>
                        <script>
                        function check_values() {
                            var d=document.getElementById('birthdate').value;
                            var valid=false;
                            var day, month, year, date, my_date;

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
                                        document.getElementById("result").innerHTML="Time format is not valid";
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
