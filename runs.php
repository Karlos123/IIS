<?php
  session_save_path("tmp");
  session_start();
    if(!isset($_SESSION['use'])){
      header('Location: '. 'error_page.php');
    }


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<!-- HEAD  -->
<head>
<meta  charset=utf-8>
<title>ZOOIS</title>
<link rel="stylesheet" href="homePageStyle.css" type="text/css" >
</head>


<!-- BODY  -->
<body>

  <!-- Logo  -->
  <img src="logo.png" alt="Logo" style="height:100px;">

  <div id="sidebar">
    <?php require_once 'sidebar.php' ?>
  </div>
  <div id="header">RUNs</div>
  <div id="content">
    Runs
  </div>

  <!-- Side bar -->




</div>




</body>


</html>
