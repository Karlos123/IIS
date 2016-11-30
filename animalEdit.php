<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("tmp");
session_start();
require_once 'db.php';

if(!isset($_SESSION['use'])){
    header('Location: '. 'error_page.php');
}
if(!isset($_GET['pk'])){
    header('Location: '. 'error_page.php');
}

if(isset($_POST['update'])){
    foreach($_POST as $key => $value)
    {
        $_POST[$key]= ($value == '' ? 'NULL' : "'".$value."'");
    }

    $q="UPDATE Zvire SET
    jmeno=".$_POST['name'].",
    pohlavi=".$_POST['sex'].",
    zarazeni=".$_POST['speice'].",
    hmotnost=".$_POST['weight'].",
    datum_narozeni=".$_POST['birthday'].",
    datum_umrti=".$_POST['deathdate'].",
    matka=".$_POST['mother'].",
    otec=".$_POST['father'].",
    zdarvotni_stav=".$_POST['health'].",
    pos_zdrav_prohlidka=".$_POST['medCheck'].",
    cislo_vybehu=".$_POST['fence']."
    WHERE kod_zvirete='".$_GET['pk']."'";


    $res=$db->query($q);
    if(!$res)
        header('Location: '. 'error_page.php');
    else
        header('Location: '. 'animals.php');
}

if(isset($_POST['delete'])){
    // Mazani zvirete
    $q="DELETE FROM Zvire WHERE kod_zvirete=".$_GET['pk'];
    $res1=$db->query($q);
    if(!$res1)
        die($db->error);
    else
        header("Location:"."animals.php");

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
    function validateForm(a) {
        alert(a);
        if(a=="Delete"){
            return true;
        }
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
        Animals->Update
    </div>

    <!-- Content -->

    <div id="content">
        <!-- Input form -->

        <?php
        $q="SELECT * FROM Zvire WHERE kod_zvirete='". $_GET['pk'] ."'";
        $res=$db->query($q);
        $res = $res->fetch_assoc();
        ?>
        <form method="post" name= "inputForm" onsubmit="return validateForm(this.submited);">
            <table class="edit">
                <tr><td>Name:</td><td><input class="upd" type="text" name="name" placeholder="Name"  value='<?php echo $res["jmeno"]?>'></td></tr>
                <tr><td>Sex:</td><td>
                    <select name="sex">
                        <option value="female"<?php if($res["pohlavi"] == 'female') echo'selected="selected"';?>>Female</option>
                        <option value="male"   <?php if($res["pohlavi"] == 'male') echo'selected="selected"';?>>Male</option>
                        <option value="N/A"    <?php if($res["pohlavi"] == 'N/A') echo'selected="selected"';?>>N/A</option>
                        <option value="hermafrodit"<?php if($res["pohlavi"] == 'hermafrodit') echo'selected="selected"';?>>hermaphrodite</option>
                    </select></td>
                    <tr><td>Speice:</td><td><input class="add" type="text" placeholder="Speice" name="speice" value='<?php echo $res["zarazeni"]?>'></td></tr>
                    <tr><td>Weight (kg):</td><td><input class="add" type="text" placeholder="Weight" name="weight" value='<?php echo $res["hmotnost"]?>'></td></tr>
                    <tr><td>Birthdate:</td><td><input class="add" type="text" placeholder="Birthdate" name="birthday" value='<?php echo $res['datum_narozeni']?>'></td><td>(yyyy-mm-dd)</td><td>
                        <tr><td>Deathdate:</td><td><input class="add" type="text" placeholder="Deathdate" name="deathdate" value='<?php echo $res["datum_umrti"]?>'></td><td>(yyyy-mm-dd)</td><td>
                            <tr><td>Father:</td><td><input class="add" type="text" placeholder="Father" name="father"value='<?php echo $res["otec"]?>'></td></tr>
                            <tr><td>Mother:</td><td><input class="add" type="text" placeholder="Mother" name="mother"value='<?php echo $res["matka"]?>'></td></tr>
                            <tr><td>Health:</td><td>
                                <select name="health">
                                    <option value="OK" <?php if($res["zdarvotni_stav"] == 'OK') echo'selected';?> >OK</option>
                                    <option value="Nemocný"<?php if($res["zdarvotni_stav"] == 'Nemocný') echo 'selected';?>>Sick</option>
                                    <option value="N/A" <?php if($res["zdarvotni_stav"] == 'N/A') echo 'selected';  ?>>N/A</option>
                                </select></td>
                                <tr><td>Med-check:</td><td><input class="add" type="text" placeholder="Med-check" name="medCheck" value='<?php echo $res["pos_zdrav_prohlidka"]?>'></td></td><td>(yyyy-mm-dd)</td><td>
                                    <tr><td>Fence #:</td><td><input class="add" type="text" placeholder="Fence" name="fence" value=<?php echo $res["cislo_vybehu"]?>></td></tr>
                                </table>
                                <button class="update" type="submit"  onclick="this.form.submited=this.value;" name="update">Update</button>
                                <?php
                                if($_SESSION['priv']>=2){ ?>
                                    <button type="submit" class="delete" onclick="this.form.submited=this.value;" name="delete" value="Delete" >Delete</button>
                                    <?php
                                }
                                ?>

                            </form>

                        </div>

                    </body>


                    </html>
