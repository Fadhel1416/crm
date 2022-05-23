<?php
$session=$_REQUEST['camp_id'];
session_start();
$_SESSION['sessioncamp']=$_REQUEST['camp_id'];
?>