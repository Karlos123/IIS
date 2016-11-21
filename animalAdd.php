<?php
  session_save_path("tmp");
  session_start();
  require_once 'db.php';

  if(!isset($_SESSION['use'])){
    header('Location: '. 'error_page.php');
  }

  if(isset($_POST['add'])){
    #$q="INSERT INTO Zvire VALUES('15', '$name', '$sex', '$speice', '$weight', '$birthday', '$deathdate', '$father', '$mother', '$helath', '$medCheck')";
    #$res=$db->query($q);
    echo $_POST['name'];
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
      Animals->Add Animal
    </div>

    <!-- Content -->

    <div id="content">
      <form method="post">
        <table>
          <tr><td>Name:</td><td><input class="add" type="text" placeholder="Name" name="name"></td></tr>
          <tr><td>Sex:</td><td>
            <select name="sex">
              <option value="female">Female</option>
              <option value="male">Male</option>
              <option value="NA">N/A</option>
              <option value="hermafordit">hermaphrodite</option>
            </select></td>
          <tr><td>Speice:</td><td><input class="add" type="text" placeholder="Speice" name="speice"></td></tr>
          <tr><td>Weight:</td><td><input class="add" type="text" placeholder="Weight" name="weight"></td></tr>
          <tr><td>Birthdate:</td><td><input class="add" type="text" placeholder="Birthdate" name="birthday"></td><td>(yyyy-mm-dd)</td><td>
          <tr><td>Deathdate:</td><td><input class="add" type="text" placeholder="Deathdate" name="deathdate"></td><td>(yyyy-mm-dd)</td><td>
          <tr><td>Father:</td><td><input class="add" type="text" placeholder="Father" name="father"></td></tr>
          <tr><td>Mother:</td><td><input class="add" type="text" placeholder="Mother" name="mother"></td></tr>
          <tr><td>Health:</td><td>
            <select name="health">
              <option value="ok">OK</option>
              <option value="sick">Sick</option>
              <option value="NA">N/A</option>
            </select></td>
          <tr><td>Med-check:</td><td><input class="add" type="text" placeholder="Med-check" name="med-check"></td></tr>
          <tr><td>Run #:</td><td><input class="add" type="text" placeholder="Run" name="run"></td></tr>
        </table>
        <button class="btn" type="submit" name="add">Add animal</button>
      </form>
    </div>

  </body>


</html>
