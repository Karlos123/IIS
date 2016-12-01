<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("tmp");
session_start();
require_once 'db.php';

if(!isset($_SESSION['use'])){
    header('Location: '. 'error_page.php');
}
if(!isset($_GET['pk'] )){
    header('Location: '. 'error_page.php');
}

if(isset($_POST['update']) || isset($_POST['delete'])){
    // Vybrani stareho zaznamu
    $q= "SELECT K.datum_krmeni, K.od, K.do, K.mnozstvi_zradla, Z.kod_zvirete
    FROM Osetrovatel as O JOIN Krmi as K JOIN Zvire as Z WHERE O.os_cislo=K.os_cislo AND
    K.kod_zvirete=Z.kod_zvirete AND O.os_cislo='".$_SESSION['os_cislo']."'";
    $q = $q . "LIMIT 1 OFFSET ". $_GET['pk']."";
    $res=$db->query($q);
    $res = $res->fetch_assoc();
    if(!$res)
    die($db->error);
}

if(isset($_POST['update'])){
    foreach($_POST as $key => $value)
    {
        $_POST[$key]= ($value == '' ? 'NULL' : "'".$value."'");
    }
    $q ="UPDATE Krmi SET
    kod_zvirete=".$_POST['animal'].",
    datum_krmeni=".$_POST['date'].",
    od=".$_POST['from'].",
    do=".$_POST['to'].",
    mnozstvi_zradla=".$_POST['foodAmount']."
    WHERE os_cislo='".$_SESSION['os_cislo']."'
    AND  kod_zvirete='".$res['kod_zvirete']."'
    AND  datum_krmeni='".$res['datum_krmeni']."'
    AND  od='".$res['od']."'
    AND  do='".$res['do']."' ";
    $res=$db->query($q);
    if(!$res)
        header('Location: '. 'error_page.php');
    else
        header('Location: '. 'personal_schedule.php');
}

if(isset($_POST['delete'])){
    // Mazani zvirete
    $q="DELETE FROM Krmi WHERE os_cislo='".$_SESSION['os_cislo']."'
    AND  kod_zvirete='".$res['kod_zvirete']."'
    AND  datum_krmeni='".$res['datum_krmeni']."'
    AND  od='".$res['od']."'
    AND  do='".$res['do']."' ";

    $res1=$db->query($q);
    if(!$res1)
        header('Location: '. 'error_page.php');
    else
        header("Location:"."personal_schedule.php");

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
        Personal schedule->Feeding Update
    </div>
    <!-- Input form -->

    <!-- Content -->

    <div id="content">
        <!-- Input form -->
        <?php
        $q= "SELECT K.datum_krmeni, K.od, K.do, K.mnozstvi_zradla, Z.kod_zvirete, Z.jmeno
        FROM Osetrovatel as O JOIN Krmi as K JOIN Zvire as Z WHERE O.os_cislo=K.os_cislo AND
        K.kod_zvirete=Z.kod_zvirete AND O.os_cislo='".$_SESSION['os_cislo']."'";

        $q = $q . "LIMIT 1 OFFSET ". $_GET['pk']."";
        $res=$db->query($q);
        $res = $res->fetch_assoc();
        if(!$res)
        die($db->error);
        ?>

        <form method="post" onsubmit="return check_values();" accept-charset="utf8">
            <table class="edit">
                <tr><td>Date:</td><td><input id="date" required="" type="text" name="date" placeholder="yyyy-mm-dd" value= '<?php echo $res["datum_krmeni"]?>'></td></tr>
                <tr><td>From:</td><td><input  id="from" required="" type="text" name="from" placeholder="hh:mm"  value='<?php echo $res["od"]?>'></td></tr>
                <tr><td>To:</td><td><input id="to" required="" type="text" name="to" placeholder="hh:mm"  value='<?php echo $res["do"]?>'></td></tr>
                <tr><td>Food amount:</td><td><input id="foodAmount" type="text" name="foodAmount" placeholder="Food amount (kg)"  value='<?php echo $res["mnozstvi_zradla"]?>'></td></tr>
                <tr><td>Animal:</td><td>
                    <select name="animal">
                        <?php
                        $q='SELECT Zvire.kod_zvirete, Zvire.jmeno  FROM Zvire INNER JOIN Stara_se
                        ON Stara_se.kod_zvirete = Zvire.kod_zvirete WHERE Stara_se.os_cislo="'.$_SESSION['os_cislo'].'"';
                        $resAllAnimals=$db->query($q);
                        if(!$resAllAnimals)
                        die($db->error);
                        while($row=$resAllAnimals->fetch_assoc())
                        {
                            if($row['kod_zvirete'] == $res['kod_zvirete'])
                            echo "<option selected='selected' value=\"".$row['kod_zvirete']."\">".$row['jmeno']."</option>";
                            else
                            echo "<option value=\"".$row['kod_zvirete']."\">".$row['jmeno']."</option>";
                        }
                        ?>

                    </select></td>
                </table>

                <button class="update" type="submit"  name="update" value="update">Update</button>
                <button class="delete" type="submit"  name="delete" value="delete">Delete</button>
                <br>
                <p id="result"></p>

            </form>

            <script>
            function check_values() {
                var x=document.getElementById('foodAmount').value;
                var d=document.getElementById('date').value;
                var f=document.getElementById('from').value;
                var t=document.getElementById('to').value;
                var valid=false;
                var day, month, year, date, my_date;

                var f1=/^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(f);
                var t1=/^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(t);
                if(f1 && t1)
                {
                    var sts = f.split(":");
                    var ets = t.split(":");

                    var stMin = (parseInt(sts[0]) * 60 + parseInt(sts[1]));
                    var etMin = (parseInt(ets[0]) * 60 + parseInt(ets[1]));
                    if( etMin < stMin)
                    {
                        document.getElementById("result").innerHTML="From > to";
                        alert("Time in \"To\" is sonner than  time in \"From\"";
                        return false;
                    }
                }
                else {
                    document.getElementById("result").innerHTML="Time validation failed";
                    return false;
                }

                if(!(x == ""))
                {
                    if(isNaN(x) || x<0 )
                    {
                        document.getElementById("result").innerHTML="Time is not valid!";
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
                        if(my_date <= date )
                        {
                            document.getElementById("result").innerHTML="Date from is not valid!";
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
