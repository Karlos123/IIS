<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("tmp");
session_start();
require_once 'db.php';

if(!isset($_SESSION['use'])){
    header('Location: '. 'error_page.php');
}
if(isset($_POST['add'])){
    foreach($_POST as $key => $value)
    {
        $_POST[$key]= ($value == '' ? 'NULL' : "'".$value."'");
    }

    $q="INSERT INTO Zvire (jmeno, pohlavi, zarazeni, hmotnost, datum_narozeni, datum_umrti, matka, otec, zdarvotni_stav, pos_zdrav_prohlidka, cislo_vybehu)
    VALUES(".$_POST['name'].",
            ".$_POST['sex'].",
            ".$_POST['speice'].",
            ".$_POST['weight'].",
            ".$_POST['birthday'].",
            ".$_POST['deathdate'].",
            ".$_POST['father'].",
            ".$_POST['mother'].",
            ".$_POST['health'].",
            ".$_POST['medCheck'].",
            ".$_POST['fence'].")";

    $res=$db->query($q);
    if(!$res)
        header('Location: '. 'error_page.php');
    else
        header('Location: '. 'animals.php');
}


?>

!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<!-- HEAD  -->
<head>
    <meta charset=utf-8>
    <title>ZOOIS</title>
    <link rel="stylesheet" href="style.css" type="text/css" >

    <script>
    function validateForm() {
        var x = document.forms["inputForm"]["weight"].value;

        if (isNaN(x) || x <= 0 || x == "") {
            alert("Wrong input in weight field!");
            return false;
        }

        var x = document.forms["inputForm"]["speice"].value;
        if (x == "") {
            alert("Speice field is requiered!");
            return false;
        }

        if(!validateTime(document.forms["inputForm"]["birthday"].value) ||
        !validateTime(document.forms["inputForm"]["deathdate"].value) ||
        !validateTime(document.forms["inputForm"]["medCheck"].value)){
            alert("Invalid date format!");
            return false;
        }
    }
    function validateTime(time){
        var valid=false;
        var day, month, year, date, my_date;
        if(time!= ""){
            if(time.length == 10){
                year=time.substring(0,4);
                month=time.substring(5,7);
                day=time.substring(8,10);
                date = new Date();
                my_date= new Date(year, month, day);
                if(my_date >= date )
                return false;
            }
            else
            return false;
        }
        return true;

    }
    $(document).ready(function(){
        $("table td").click(function() {

            var column_num = parseInt( $(this).index() ) + 1;
            var row_num = parseInt( $(this).parent().index() )+1;

            $("#result").html( "Row_num =" + row_num + "  ,  Rolumn_num ="+ column_num );
        });
    });
    </script>


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
        Animals->Add
    </div>

    <!-- Content -->

    <div id="content">
        <!-- Input form -->
        <form method="post" name= "inputForm" onsubmit="return validateForm()">
            <table id=table>
                <tr><td>Name:</td><td><input class="add" type="text" placeholder="Name" name="name"></td></tr>
                <tr><td>Sex:</td><td>
                    <select name="sex">
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                        <option value="N/A">N/A</option>
                        <option value="hermafrodit">hermaphrodite</option>
                    </select></td>
                    <tr><td>Speice:</td><td><input class="add" type="text" placeholder="Speice" name="speice"></td></tr>
                    <tr><td>Weight (kg):</td><td><input class="add" type="text" placeholder="Weight" name="weight"></td></tr>
                    <tr><td>Birthdate:</td><td><input class="add" type="text" placeholder="Birthdate" name="birthday"></td><td>
                        <tr><td>Deathdate:</td><td><input class="add" type="text" placeholder="Deathdate" name="deathdate"></td><td>
                            <tr><td>Father:</td><td><input class="add" type="text" placeholder="Father" name="father"></td></tr>
                            <tr><td>Mother:</td><td><input class="add" type="text" placeholder="Mother" name="mother"></td></tr>
                            <tr><td>Health:</td><td>
                                <select name="health">
                                    <option value="OK">OK</option>
                                    <option value="Nemocný">Sick</option>
                                    <option value="N/A">N/A</option>
                                </select></td>
                                <tr><td>Med-check:</td><td><input class="add" type="text" placeholder="Med-check" name="medCheck"></td></td><td>
                                    <tr><td>Fence #:</td><td>
                                        <select name="fence">
                                            <?php
                                            $fenceNums="SELECT cislo_vybehu FROM Vybeh";
                                            $fenceNums=$db->query($fenceNums);
                                            if(!$fenceNums)
                                            die($db->error);
                                            while($row=$fenceNums->fetch_assoc())
                                            {
                                                echo "<option selected='selected' value=\"".$row['cislo_vybehu']."\">".$row['cislo_vybehu']."</option>";
                                            }
                                            ?>
                                        </select></td>
                                    </table>

                                    <button class="add" type="submit" name="add">Add animal</button>
                                </form>

                                <script>

                                </script>
                            </div>

                        </body>


                        </html>
