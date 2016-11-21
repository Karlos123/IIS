<?php
 session_start();


 if (isset($_SESSION['user'])) {
 ?>
   logged in HTML and code here
 <?php

 } else {
   ?>
   Not logged in HTML and code here
   <?php
 }
