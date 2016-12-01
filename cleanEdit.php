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
    $q= "SELECT C.datum_cisteni, C.od, C.do, C.stav_po, V.cislo_vybehu
    FROM Osetrovatel as O JOIN Cisti as C JOIN Vybeh as V WHERE O.os_cislo=C.os_cislo AND
    C.cislo_vybehu=V.cislo_vybehu AND O.os_cislo='".$_SESSION['os_cislo']."'";
    $q = $q . "LIMIT 1 OFFSET ". $_GET['pk']."";
    $res=$db->query($q);
    $res = $res->fetch_assoc();
    if(!$res)
        header('Location: '. 'error_page.php');
}

if(isset($_POST['update'])){
    foreach($_POST as $key => $value)
    {
        $_POST[$key]= ($value == '' ? 'NULL' : "'".$value."'");
    }
    $q ="UPDATE Cisti SET
    cislo_vybehu=".$_POST['fence'].",
    datum_cisteni=".$_POST['date'].",
    od=".$_POST['from'].",
    do=".$_POST['to'].",
    stav_po=".$_POST['conAfter']."
    WHERE os_cislo='".$_SESSION['os_cislo']."'
    AND  cislo_vybehu='".$res['cislo_vybehu']."'
    AND  datum_cisteni='".$res['datum_cisteni']."'
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
    $q="DELETE FROM Stara_se WHERE os_cislo='".$_SESSION['os_cislo']."'
    AND  cislo_vybehu'".$res['cislo_vybehu']."'
    AND  datum_cisteni='".$res['datum_cisteni']."'
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
        Personal schedule->Cleaning Update
    </div>
    <!-- Input form -->

    <!-- Content -->

    <div id="content">
        <!-- Input form -->
        <?php
        $q= "SELECT C.datum_cisteni, C.od, C.do, C.stav_po, V.cislo_vybehu
        FROM Osetrovatel as O JOIN Cisti as C JOIN Vybeh as V WHERE O.os_cislo=C.os_cislo AND
        C.cislo_vybehu=V.cislo_vybehu AND O.os_cislo='".$_SESSION['os_cislo']."'";
        $q = $q . "LIMIT 1 OFFSET ". $_GET['pk']."";
        $res=$db->query($q);
        $res = $res->fetch_assoc();
        if(!$res)
            header('Location: '. 'error_page.php');
        ?>

        <form method="post" onsubmit="return check_values();" accept-charset="utf8">
            <table class="edit">
                <tr><td>Date:</td><td><input id="date" required="" type="text" name="date" placeholder="yyyy-mm-dd" value= '<?php echo $res["datum_cisteni"]?>'></td></tr>
                <tr><td>From:</td><td><input id="from"  required="" type="text" name="from" placeholder="hh:mm"  value='<?php echo $res["od"]?>'></td></tr>
                <tr><td>To:</td><td><input id="to"  required="" type="text" name="to" placeholder="hh:mm"  value='<?php echo $res["do"]?>'></td></tr>
                <tr><td>Condition after:</td><td><input  type="text" name="conAfter" placeholder="Condition after"  value='<?php echo $res["stav_po"]?>'></td></tr>
                <tr><td>Fence:</td><td>
                    <select name="fence">
                        <?php
                        $q='SELECT cislo_vybehu FROM Vybeh';
                        $resAllFences=$db->query($q);
                        if(!$resAllFences)
                        die($db->error);
                        while($row=$resAllFences->fetch_assoc())
                        {
                            if($row['cislo_vybehu'] == $res['cislo_vybehu'])
                                echo "<option selected='selected' value='".$row['cislo_vybehu']."'>".$row['cislo_vybehu']."</option>";
                            else
                                echo "<option value='".$row['cislo_vybehu']."'>".$row['cislo_vybehu']."</option>";
                        }
                        ?>

                    </select></td>
                </table>
                <input type="hidden" name="valid" id="valid" value="false">
                <button class="update" type="submit"  name="update" value="update">Update</button>
                <button class="delete" type="submit"  name="delete" value="delete">Delete</button>
            </form>
            <br>
            <p id="result"></p>

        </form>

        <script>
        function check_values() {
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
                    return false;
                }
            }
            else {
                document.getElementById("result").innerHTML="Time validation failed";
                return false;
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
