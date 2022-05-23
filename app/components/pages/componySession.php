<?php

$session=$_REQUEST['campaign_id'];
session_start();
$_SESSION['compony']=$_REQUEST['campaign_id'];
header("Location:https://yestravaux.com/crm2/app/index.php?page=leads");
?>