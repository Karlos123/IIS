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
  <div id="header">Novinky</div><?php require_once 'sidebar.php' ?>
  <div id="content">
    <div id="content_header">
      <button id="myBtn">Pridat novinky</button>
      <button id="myBtn1">Editovat novinky</button>
      <button id="myBtn2">Odebrat novinky</button>
    </div>
  </div>

  <!-- Side bar -->
  <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">Close</span>
        <h2>Modal Header</h2>
      </div>
      <div class="modal-body">
        <p>Some text in the Modal Body</p>
        <p>Some other text...</p>
      </div>
      <div class="modal-footer">
        <h3>Modal Footer</h3>
      </div>
    </div>
  </div>
<script>
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>



</div>
