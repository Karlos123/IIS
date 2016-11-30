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

// Edit fence
if($_POST['valid']=="True"  && $_POST['delete']=="False")
{
    foreach($_POST as $key => $value)
    {
        $_POST[$key]= ($value == '' ? 'NULL' : "'".$value."'");
    }

    $q="UPDATE Vybeh SET
    typ=".$_POST['type'].",
    max_zvirat=".$_POST['capacity'].",
    cas_na_cisteni=".$_POST['cleaning_time'].",
    otevren=".$_POST['opened_from']."
    WHERE cislo_vybehu='".$_GET['pk']."'";

    $res=$db->query($q);
    if(!$res)
        header("Location:"."error_page.php");
    else
        header("Location:"."fences.php");
}

//Delete fence
if($_POST['delete']=="True")
{
    $q="SELECT COUNT(*) FROM Vybeh JOIN Zvire
    WHERE Vybeh.cislo_vybehu=Zvire.cislo_vybehu AND Vybeh.cislo_vybehu=".$_GET['pk'];
    $res=$db->query($q);
    if(!$res)
    {
        header("Location:"."error_page.php");
    }
    $res=$res->fetch_assoc();
    $res=$res['COUNT(*)'];
    if($res == 0)
    {
        $q="DELETE FROM Vybeh WHERE cislo_vybehu=".$_GET['pk'];
        $res1=$db->query($q);
        if(!$res1)
            header("Location:"."error_page.php");
        else
            header("Location:"."fences.php");
    }
    else
    {
        echo "<script>
        alert('Fence not empty!');
        window.location.href='fences.php';
        </script>";
    }
}


?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
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
    <div id="header">
        Fence->Fence Update

    </div>
</div>

<!-- Content -->
<div id="content">
    <div id="content">
        <?php
        $q="SELECT * FROM Vybeh WHERE cislo_vybehu='". $_GET['pk'] ."'";
        $res=$db->query($q);
        $f = $res->fetch_assoc();
        ?>

        <form method="post" onsubmit="return check_values(this.submited);" accept-charset="utf8">
            <table>
                <tr><td>Type:</td><td><input class="edit" type="text" required="" placeholder="Type" name="type" value="<?php echo $f['typ']; ?>"></td></tr>
                <tr><td>Capacity:</td><td><input class="edit" type="text" placeholder="Capacity" name="capacity" value="<?php echo $f['max_zvirat']; ?>"></td></tr>
                <tr><td>Cleaning time:</td><td><input id="clean_time" class="edit" type="text" placeholder="Cleaning time" name="cleaning_time" value="<?php echo $f['cas_na_cisteni']; ?>"></td></tr>
                <tr><td>Opened from:</td><td><input id="opened_from" class="edit" type="text" placeholder="Opened from" name="opened_from" value="<?php echo $f['otevren'] ?>">
                </table>
                <input type="hidden" name="valid" id="valid" value="False">
                <input type="hidden" name="delete" id="delete" value="False">
                <button type="submit" class="update" onclick="this.form.submited=this.value;" value="Update" >Update</button>
                <?php
                if($_SESSION['priv']>=2){ ?>
                    <button type="submit" class="delete" onclick="this.form.submited=this.value;" value="Delete" >Delete</button>
                    <?php
                }
                ?>
            </form>
            <p id="result"></p>
            <script>
            function check_values(a) {
                if(a=="Delete")
                {
                    document.getElementById("delete").value = "True";
                    return true;
                }
                var x=document.getElementById('clean_time').value;
                var d=document.getElementById('opened_from').value;
                var valid=false;
                var day, month, year, date, my_date;

                if(!(x == ""))
                {
                    if(isNaN(x) || x<0)
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
                document.getElementById("valid").value = "True";
                return true;

            }
            </script>
            <br />
            <table class="display" style="width: 35%;; position:relative" id="tbl">
                <caption>Ihabitants</caption>
                <?php
                $q= "SELECT kod_zvirete,jmeno,pohlavi, zarazeni FROM Zvire WHERE cislo_vybehu='". $_GET['pk'] ."'";
                $res=$db->query($q);
                while($row=$res->fetch_assoc())
                {
                    echo '<tr>';
                    foreach($row as $key => $value)
                    {
                        if($value)
                        {
                            echo "<td>".$value."</td>";
                        }
                        else {
                            echo "<td></td>";
                        }

                    }
                    echo "</tr>";
                }
                ?>
            </table>


        </div>








    </div>

</body>


</html>
