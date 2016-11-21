<?php
  session_save_path("tmp");
  session_start();
  if(!isset($_SESSION['use']))
  {
    header('Location: '. 'error_page.php');
  }

  require_once 'db.php';

  foreach($_POST as $key => $value)
  {
      echo "\r\n".$key." ".$value."\r\n";
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
    Animals
    <!-- <div id="logged_user">
      <?php echo $_SESSION['use'] ?>
    </div> -->
  </div>

  <!-- Content -->
  <div id="content">
    <form action="animalAdd.php">
        <input  type="submit" value="Add animal" />
    </form>



    <table class="display">
      <tbody>
        <tr>
          <th>N.</th>
          <th>Name</th>
          <th>Sex</th>
          <th>Speice</th>
          <th>Weight (kg)</th>
          <th>Birthdate</th>
          <th>Deathdate</th>
          <th>Father</th>
          <th>Mother</th>
          <th>Health</th>
          <th>Med-check</th>
          <th>Run #</th>
        </tr><tr></tr>
        <?php
        $q='SELECT * FROM Zvire';
        $res=$db->query($q);
        while($row=$res->fetch_assoc())
        {
          echo "<tr>";
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


  </div>








</div>





</body>


</html>
