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

    $q="INSERT INTO Prispivatel (jmeno, typ_prispivani, mesto, ulice, castka, celkova_castka)
    VALUES(".$_POST['name'].",
    ".$_POST['type'].",
    ".$_POST['city'].",
    ".$_POST['street'].",
    ".$_POST['amount'].",
    ".$_POST['amount'].")";


    if($db->query($q)=== FALSE)
        header('Location: '. 'error_page.php');
    else
        header('Location: '. 'contributors.php');

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
        Contributors->Add
    </div>

    <!-- Content -->

    <div id="content">
        <form method="post" onsubmit="return check_values();" accept-charset="utf8">
            <table>
                <tr><td>Name:</td><td><input class="add" type="text" required="" placeholder="Name" name="name"></td></tr>
                <tr><td>Contribution type:</td><td>
                    <select name="type">
                        <option value="Měsíční">Month</option>
                        <option value="Roční">Year</option>
                    </select></td>
                    <tr><td>City:</td><td><input class="add" type="text" placeholder="City" name="city"></td></tr>
                    <tr><td>Street:</td><td><input class="add" type="text" placeholder="Street" name="street"></td></tr>
                    <tr><td>Amount:</td><td><input class="add" type="text" placeholder="$$" name="amount"></td></tr>

                </table>
                <input type="hidden" name="valid" id="valid" value="false">
                <button class="add" type="submit" name="add"> Add contributor </button>
            </form>
            <p id="result"></p>
            <script>
            function check_values() {
                var x=document.getElementById('amount').value;
                var valid=false;

                if(!(x == ""))
                {
                    if(isNaN(x) || x<0)
                    {
                        document.getElementById("result").innerHTML="Value is not valid!";
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
