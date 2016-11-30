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

      //die(print_r($_POST));
      //echo "<script type='text/javascript'>alert('".print_r($_POST)."')</script>";
      $q="INSERT INTO Krmi (os_cislo, kod_zvirete, datum_krmeni, od, do, mnozstvi_zradla)
      VALUES(".$_SESSION['os_cislo'].", ".$_POST['animal'].",
      ".var_export($_POST['date'],true).", ".var_export($_POST['from'],true).",
      ".var_export($_POST['to'],true).", ".var_export($_POST['foodAmount'],true).")";

      //die($q);
      if($db->query($q)=== FALSE)
      {
          header('Location: '. 'error_page.php');
      }
      else {
          header('Location:'.'personal_schedule.php');
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
      Personal schedule->Add feeding
    </div>

        <!-- Content -->

        <div id="content">
          <form method="post" onsubmit="return check_values();" accept-charset="utf8">
            <table>
              <tr><td>Date:</td><td><input required="required" id="date" class="add" type="text"  placeholder="yyyy-mm-dd" name="date"></td></tr>
              <tr><td>From:</td><td><input required  id="from" class="add" type="text" placeholder="hh:mm" name="from"></td></tr>
              <tr><td>To:</td><td><input  required id="to" class="add" type="text" placeholder="hh:mm" name="to"></td></tr>
              <tr><td>Food amount:</td><td><input required  id="foodAmount" class="add" type="text" placeholder="Food amount (kg)" name="food"></td></tr>
              <tr><td>Animal:</td><td>
                <select name="animal">
                    <?php
                    $q='SELECT Zvire.kod_zvirete, Zvire.jmeno  FROM Zvire INNER JOIN Stara_se
                          ON Stara_se.kod_zvirete = Zvire.kod_zvirete WHERE Stara_se.os_cislo="'.$_SESSION['os_cislo'].'"';
                    $res=$db->query($q);
                    if(!$res)
                        die($db->error);
                    while($row=$res->fetch_assoc())
                    {
                        echo "<option value='".$row['kod_zvirete']."'>".$row['jmeno']."</option>";
                    }
                    ?>

                </select></td>
            </table>
            <input type="hidden" name="valid" id="valid" value="false">
            <button class="add" type="submit" >Add feeding</button>
          </form>
          <br>
          <p id="result"></p>
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
                      document.getElementById("result").innerHTML="Date is not valid!";
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
