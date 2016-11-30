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

  // editace uzivatele
  if($_POST['valid']=="true"  && $_POST['delete']=="false")
  {
      foreach($_POST as $key => $value)
      {
          $_POST[$key]= ($value == '' ? 'NULL' : "'".$value."'");
      }

      $q="UPDATE Osetrovatel SET
      jmeno=".$_POST['name'].",
      primeni=".$_POST['surname'].",
      datum_narozeni=".$_POST['birthdate'].",
      mesto=".$_POST['city'].",
      ulice=".$_POST['street'].",
      nej_dosazene_vzdelani=".$_POST['school']."
      WHERE os_cislo='".$_GET['pk']."'";
      $res=$db->query($q);
      if(!$res)
          header("Location:"."error_page.php");


     if($_SESSION['priv']==3)
     {
         $q="UPDATE Uzivatel SET username=".$_POST['username'].",";
         if(!$_POST['password']=="NULL")
         {
            $q=$q."password=".$_POST['password'].",";
         }
         $q=$q."privileges=".$_POST['privileges']." WHERE pk_osetrovatel='".$_GET['pk']."'";
         $res=$db->query($q);
         if(!$res)
            header("Location:". "error_page.php");
        else
            header("Location:"."staff.php");
     }
  }

  // Smazani osetrovatele
  if($_POST['delete']=="true")
  {
      $q="SELECT COUNT(*) FROM Osetrovatel JOIN Hlavni_Osetrovatel
      WHERE Osetrovatel.os_cislo=Hlavni_Osetrovatel.os_cislo AND Osetrovatel.os_cislo=".$_GET['pk'];
      $res=$db->query($q);
      if(!$res)
          header("Location:"."error_page.php");

      $res=$res->fetch_assoc();
      $res=$res['COUNT(*)'];
      if($res==1)
      {
          $q="UPDATE Hlavni_Osetrovatel SET os_cislo=NULL";
          $res=$db->query($q);
          if(!$res)
            header("Location:". "error_page.php");
      }
      $q="DELETE FROM Stara_se WHERE os_cislo=".$_GET['pk'];
      $res=$db->query($q);
      if(!$res)
          header("Location:"."error_page.php");

      $q="DELETE FROM Uzivatel WHERE pk_osetrovatel=".$_GET['pk'];
      $res=$db->query($q);
      if(!$res)
          header("Location:"."error_page.php");

      $q="DELETE FROM Osetrovatel WHERE os_cislo=".$_GET['pk'];
      $res=$db->query($q);
      if(!$res)
          header("Location:"."error_page.php");

    header("Location:"."staff.php");
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
        Staff->Edit
</div>

<!-- Content -->
<div id="content">
    <div id="content">
        <?php
          $q="SELECT * FROM Osetrovatel WHERE os_cislo='". $_GET['pk'] ."'";
          $res=$db->query($q);
          $f = $res->fetch_assoc();
          $q="SELECT username, privileges FROM Uzivatel WHERE pk_osetrovatel='".$_GET['pk']."'";
          $res=$db->query($q);
          $u=$res->fetch_assoc();

      ?>

        <form method="post" onsubmit="return check_values(this.submited);" accept-charset="utf8">
            <table>
                <?php
                if($_SESSION['priv']==3)
                {
                ?>
                <tr><td>Username:</td><td><input class="edit" type="text" required="" placeholder="Name" name="username" value="<?php echo $u['username']; ?>"></td></tr>
                <tr><td>Password:</td><td><input class="edit" type="password" placeholder="password" name="password" value=""></td></tr>
                <tr><td>Privileges:</td><td>
                  <select name="privileges">
                    <option value="1" <?php if($u["privileges"] == '1') echo 'selected="selected"';?>>Regular</option>
                    <option value="2" <?php if($u['privileges'] == '2') echo 'selected="selected"';?>>Manager</option>
                  </select></td>
                <tr></tr>
                <?php } ?>
                <tr><td>Name:</td><td><input class="edit" type="text" required="" placeholder="Name" name="name" value="<?php echo $f['jmeno']; ?>"></td></tr>
                <tr><td>Surname:</td><td><input class="edit" type="text" placeholder="Surname" name="surname" value="<?php echo $f['primeni']; ?>"></td></tr>
                <tr><td>Birhtdate:</td><td><input id="birthdate" class="edit" type="text" placeholder="yyyy-mm-dd" name="birthdate" value="<?php echo $f['datum_narozeni']; ?>"></td></tr>
                <tr><td>City:</td><td><input class="edit" type="text" placeholder="City" name="city" value="<?php echo $f['mesto'] ?>"></td></tr>
                <tr><td>Street:</td><td><input class="edit" type="text" placeholder="Street" name="street" value="<?php echo $f['ulice'] ?>"></td></tr>

                <tr><td>School:</td><td>
                  <select name="school">
                    <option value="Středoškolské" <?php if($f["nej_dosazene_vzdelani"] == 'Středoškolské') echo 'selected="selected"';?>>High school</option>
                    <option value="Vysokoškolské" <?php if($f['nej_dosazene_vzdelani'] == 'Vysokoškolské') echo 'selected="selected"';?>>College</option>
                  </select></td>

                </table>
                <input type="hidden" name="valid" id="valid" value="false">
                <input type="hidden" name="delete" id="delete" value="false">

                <button class="update" type="submit" onclick="this.form.submited=this.value;"> Update </button>
                <button class="delete" type="submit" onclick="this.form.submited=this.value;"> Delete </button>
            </form>
            <p id="result"></p>
            <script>
            function check_values(a) {
                if(a=="Delete")
                {
                    document.getElementById("delete").value = true;
                    return true;
                }
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
                            document.getElementById("result").innerHTML="Birthdate is not valid!";
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








    </div>

</body>


</html>
