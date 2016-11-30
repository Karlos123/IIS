<?php
  session_save_path("tmp");
  session_start();

  if(array_key_exists('user', $_POST) and array_key_exists('password', $_POST))
  {
      require_once 'db.php';
      $user=$_POST['user'];
      $pass=$_POST['password'];

      $q='SELECT * FROM Uzivatel WHERE username="'.$user.'" AND password="'.$pass.'"';
      $result=$db->query($q);
      if($result->num_rows==1)
      {
          $item=$result->fetch_assoc();
          setcookie('logged', $item['pk'], time()+360, '/');
          $_SESSION['use']=$user;
          $_SESSION['priv']=$item['privileges'];
          $_SESSION['os_cislo']=$item['pk_osetrovatel'];
          header("Location: ".'homePage.php');
      }
      else
      {
          echo "<script type='text/javascript'>alert('Wrong password or login!')</script>";
      }
  }
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<!-- HEAD  -->
<head>
<meta  charset=utf-8>
<title>ZOOIS</title>
<link rel="stylesheet" href="login_style.css" type="text/css" >
</head>


<!-- BODY  -->
<body>
  <div class="header"> </div>
  <form class="log" name="login" action="" method="post" accept-charset="utf-8">
   <div class="imgcontainer">
     <img src="109.png" alt="Avatar" class="avatar">
   </div>

   <div class="container">
     <label><b>Username</b></label>
     <input class="login" type="text" placeholder="Enter Username" name="user" required>

     <label><b>Password</b></label>
     <input class="login" type="password" placeholder="Enter Password" name="password" required>

      <button class="login" type="submit" name="login" value="LOGIN">Login</button>

   </div>

  </form>




</body>


</html>
