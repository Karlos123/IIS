<?php
  header("Content-Type: text/html; charset=UTF-8");
  session_save_path("tmp");
  session_start();
  if(!isset($_SESSION['use']))
  {
    header('Location: '. 'error_page.php');
  }

  require_once 'db.php';




?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<!-- HEAD  -->
<head>
  <meta charset=utf-8>
  <title>ZOOIS</title>
  <link rel="stylesheet" href="style.css" type="text/css" >
  <script>
  function row(x) {
       window.location.href = "animalEdit.php?pk=" + document.getElementById("tbl").rows[x.rowIndex].cells[0].innerHTML;
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
  <div id="header">
    Animals
    <!-- <div id="logged_user">
      <?php echo $_SESSION['use'] ?>
    </div> -->
  </div>

  <!-- Content -->
  <div id="content">
    <?php
      if($_SESSION['priv']==3 || $_SESSION['priv']==2){ ?>
        <form action="animalAdd.php">
            <button class="add" type="submit">Add animal</button>
        </form> <?php
      }
    ?>

    <table class="display" id="tbl">
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
          <th>Fence #</th>
        </tr><tr></tr>
        <?php
        # ADMIN
        if($_SESSION['priv']==3 || $_SESSION['priv']==2){
          $q='SELECT * FROM Zvire';
          $res=$db->query($q);
        }
        # osterovatel
        elseif ($_SESSION['priv']==1) {
          $q= 'SELECT Zvire.kod_zvirete, Zvire.jmeno,Zvire.pohlavi,Zvire.zarazeni,
          Zvire.hmotnost,Zvire.datum_narozeni, Zvire.datum_umrti,Zvire.matka,Zvire.otec,
          Zvire.zdarvotni_stav,Zvire.pos_zdrav_prohlidka,Zvire.cislo_vybehu
          FROM Zvire INNER JOIN Stara_se
                ON Stara_se.kod_zvirete = Zvire.kod_zvirete
                WHERE Stara_se.os_cislo="'.$_SESSION['os_cislo'].'"';
          $res=$db->query($q);
        }
          while($row=$res->fetch_assoc())
          {
            echo '<tr onclick="row(this)">';
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

</body>


</html>
