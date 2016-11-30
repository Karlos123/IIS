<?php
 header("Content-Type: text/html; charset=UTF-8");
  session_save_path("tmp");
  session_start();
  require_once 'db.php';

  if(!isset($_SESSION['use'])){
    header('Location: '. 'error_page.php');
  }

  if(!isset($_GET['pk1']) || !isset($_GET['pk2'])){
    header('Location: '. 'error_page.php');
  }
  else{
    $q="INSERT INTO Stara_se VALUES(".$_GET['pk2']. "," .$_GET['pk1']. ")";

    $res=$db->query($q);
    if($res){
      header("Location:"."assignKeeper.php");
    }
    else {
        header("Location:". "error_page.php");
    }
  }

?>
