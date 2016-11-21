<?php
  session_save_path('tmp');
  //session_start();
  echo ">>>".$_SESSION['priv'];
?>
<ul>
  <li><a href="homePage.php">Home</a></li>
  <li><a href="animals.php">Animals</a></li>
  <li><a href="runs.php">Stats</a></li>
  <li><a href="planning.php">Fences</a></li>
  


<?php
if($_SESSION['priv']==3) # ADMIN
{
?>
  <li><a href="planning.php">Admin stuff bro</a></li>


<?php
}
elseif($_SESSION['priv']==2) # Hlavni osetrovatel
{
?>


<?php
}
elseif($_SESSION['priv']==1) # osterovatel
{
?>


<?php
}
?>


  <li><br><br></li>
  <li><a href="logout.php">Logout</a></li>
</ul>
