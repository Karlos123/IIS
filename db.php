<?php
header("Content-Type: text/html; charset=UTF-8");
$db_addr='localhost';
$db_login='xkropa06';
$db_password='etunhu4o';
$db_name='xkropa06';
$db_server='localhost:/var/run/mysql/mysql.sock';

$db=new mysqli($db_addr, $db_login, $db_password, $db_name);

if($db->connect_error)
{
  die('Connect_error '. $db->connect_errno .' '. $db->connect_error);
}
$db->set_charset('utf8');
?>
