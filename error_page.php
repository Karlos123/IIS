<?php

session_save_path("tmp");
session_start();

unset($_SESSION['use']);
unset($_SESSION['priv']);

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
        <ul>
            <li><a href="index.php">Go back</a></li>
        </ul>
    </div>
    <div id="header">Error</div>
    <div id="content">
        <p>Unexpected error occured</p>
    </div>




</div>




</body>


</html>
