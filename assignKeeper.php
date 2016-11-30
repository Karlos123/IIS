<?php
 header("Content-Type: text/html; charset=UTF-8");
  session_save_path("tmp");
  session_start();
  require_once 'db.php';

  if(!isset($_SESSION['use'])){
    header('Location: '. 'error_page.php');
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
    function getSelectedValue(){
      var radios = document.getElementsByName('rad1');
      var i, j;
      var find1, find2;

      for (i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
              find1= true;
              break;
          }
      }

      var radios = document.getElementsByName('rad2');
      for (j = 0, length = radios.length; j < length; j++) {
          if (radios[j].checked) {
              find2=true;
              break;
          }
      }
      if(find1 && find2){
        window.location.href = "assignKeeperDo.php?pk1=" + document.getElementById("tbl1").rows[i+2].cells[0].innerHTML + "&pk2=" +
                                                           document.getElementById("tbl2").rows[j+2].cells[0].innerHTML;
      }
      else{
        alert("Not selected");
      }
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
      Assign to Keeper
    </div>
    <!-- Input form -->

    <!-- Content -->

    <div id="content">
      <!-- Input form -->
      <button  class="update" onclick="getSelectedValue()" name="connect" value="Connect">Connect</button>
      <table class="display" style="position:relative" id="tbl1">
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
            <th>Check</th>
          </tr><tr></tr>
        <?php
          $i = 0;
          $q="SELECT * FROM Zvire";
          $res=$db->query($q);
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
            echo '<td><input name="rad1" type="radio" value=' . "\"" . $i ."\"". '</td>';
            echo "</tr>";
            $i += 1;
          }
      ?>
    </table>


    <table class="display"style="position:relative" id="tbl2">
      <tbody>
        <tr>
          <th>N.</th>
          <th>Name</th>
          <th>Sir Name</th>
          <th>Birthdate</th>
          <th>City</th>
          <th>Street</th>
          <th>Education</th>
          <th>Check</th>
        </tr><tr></tr>
      <?php
        $i = 0;
        $q="SELECT * FROM Osetrovatel";
        $res=$db->query($q);
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
          echo '<td><input name="rad2" type="radio" value=' . "\"" . $i ."\"". '</td>';
          echo "</tr>";
          $i += 1;
        }
    ?>
  </table>




    </div>

  </body>


</html>
