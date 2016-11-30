  <?php
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
<meta  charset=utf-8>
<title>ZOOIS</title>
<link rel="stylesheet" href="style.css" type="text/css" >
</head>


<!-- BODY  -->
<body>

  <!-- Logo  -->
  <img src="logo.png" alt="L" style="height:100px;">

  <div id="sidebar">
    <?php require_once 'sidebar.php' ?>
  </div>
  <div id="header">Home page</div>
  <div id="content">
     <iframe style="width:100%; height:100%;" src="https://www.moviescreen.cz/wp-content/uploads/usvit-e1405634333988.jpg"></iframe>
  </div>

  <!-- Side bar -->




</div>




</body>


</html>
