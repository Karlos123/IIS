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
  function rowFood(x) {
       window.location.href = "foodEdit.php?pk=" + (x.rowIndex - 2)  ;

  }
  function rowClean(x) {
       window.location.href = "cleanEdit.php?pk=" + (x.rowIndex - 2)  ;
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
    Personal schedule
    <!-- <div id="logged_user">
      <?php echo $_SESSION['use'] ?>
    </div> -->
  </div>
  <!-- Content -->
  <div id="content">
        <form action="foodAdd.php">
            <button class="add"   style="position:relative" type="submit"> Add Feeding </button>
        </form>

        <form action="cleanAdd.php">
            <button class="add"  style="position:relative" type="submit"> Add Cleaning </button>
        </form>

    <table class="display" style="position:relative" id="tblFood">
      <caption>Feedings</caption>
      <thaed>
        <tr>
          <th>Date</th>
          <th>From</th>
          <th>To</th>
          <th>Food (kg)</th>
          <th>N.</th>
          <th>Name</th>
        </tr><tr></tr>
      </thead>
      <tbody>
        <?php
        # osterovatel
        if ($_SESSION['priv']==1 || $_SESSION['priv']==2) {
          //$q = 'SELECT * FROM Osetrovatel WHERE os_cislo='.$_SESSION['os_cislo'].'")';
          $q= "SELECT K.datum_krmeni, K.od, K.do, K.mnozstvi_zradla, Z.kod_zvirete, Z.jmeno
          FROM Osetrovatel as O JOIN Krmi as K JOIN Zvire as Z WHERE O.os_cislo=K.os_cislo AND
          K.kod_zvirete=Z.kod_zvirete AND O.os_cislo='".$_SESSION['os_cislo']."'";
          $res=$db->query($q);
          while($row=$res->fetch_assoc())
          {
            echo '<tr onclick="rowFood(this)">';
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
    </tbody>
      </table>

      <table class="display" style="position:relative" id="tblClean">
        <caption></br>Cleanings</caption>
        <tr>
          <th>Date</th>
          <th>From</th>
          <th>To</th>
          <th>Condition after</th>
          <th>Fence</th>
        </tr><tr></tr>
        <?php
          $q= "SELECT C.datum_cisteni, C.od, C.do, C.stav_po, V.cislo_vybehu
          FROM Osetrovatel as O JOIN Cisti as C JOIN Vybeh as V WHERE O.os_cislo=C.os_cislo AND
          C.cislo_vybehu=V.cislo_vybehu AND O.os_cislo='".$_SESSION['os_cislo']."'";
          $res=$db->query($q);
          while($row=$res->fetch_assoc())
          {
            echo '<tr onclick="rowClean(this)">';
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
        }
      ?>
  </table>




  </div>

</body>


</html>
