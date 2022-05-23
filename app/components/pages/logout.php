<?php
session_start();
ini_set ("display_errors",1);


$k_key=$_SESSION['K_KEY'];
$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
$POSTVALUE= "fct=UserStatusUpdate&K_KEY=".$_SESSION['K_KEY']."&status=0";

//echo $URLP."?".$POSTVALUE;die();

$resultat = curl_do_post($URLP,$POSTVALUE);
//session_unset();
session_destroy();
echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
// header("Location: app/components/pages/auth_login.php");
?>
