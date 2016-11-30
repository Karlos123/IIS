<?php
session_save_path("tmp");
session_start();
if(!isset($_SESSION['use']))
{
    header('Location: '. 'error_page.php');
}
unset($_SESSION['use']);
unset($_SESSION['priv']);
header('Location:'. 'index.php');

?>
