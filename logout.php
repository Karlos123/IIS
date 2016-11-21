<?php
  session_save_path("tmp");
  session_start();
  if(!isset($_SESSION['use']))
  {
    header('Location: '. 'error_page.php');
  }
  unset($_SESSION['use']);
  unset($_SESSION['priv']);
  //setcookie('logged', '', time()+10, "/");
  header('Location:'. 'index.php');



?>
<!--
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta  charset=utf-8>
<title>ZOOIS</title>
<link rel="stylesheet" href="homePageStyle.css" type="text/css" >
</head>


<body>

  <img src="logo.png" alt="Logo" style="height:100px;">

  <div id="sidebar">
    <ul>
     <li><a href="homePage.php">Home</a></li>
     <li><a href="news.php">News</a></li>
     <li><a href="personal_schedule.php">Personal schedule</a></li>
     <li><a href="planning.php">Planning</a></li>
     <li><a href="animals.php">Animals</a></li>
     <li><a href="runs.php">Runs</a></li>
     <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
  <div id="header"><b>Logout</b></div>
  <div id="content">
    Good bye
  </div>





</div>




</body>


</html>
