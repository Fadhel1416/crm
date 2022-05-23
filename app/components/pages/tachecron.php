<?php
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Paris');
$b = new MongoClient("localhost:37011");
$db = $b->crm; // select db 
$lead = $db->t_lead;
$camp = $db->t_campaign;
$notes=$db->t_note;
$noti=$db->t_notification;
$sequence=$db->t_sequence;
$URLP= "https://www.yestravaux.com/webservice/crm/mail2.php";  
		$S_FROM = "YesTravaux";
		$POSTVALUE= "name=fadhel"."&message=initPASS"."&url=https://www.yestravaux.com";
		$S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
		$S_SUBJECT= "Réinitialisation mot de passe";
		$S_MAIL = array();	
		$S_MAIL['S_FROM'] = $S_FROM;
		$S_MAIL['S_NAME_FROM'] = $S_FROM." <support@yestravaux.com>"; 
		$S_MAIL['S_REPLYTO_EMAIL'] = "support@yestravaux.com";
		$S_MAIL['S_TO_NAME'] = "fadhel";
		$S_MAIL['S_TO'] ="ali.f@externalisation.pro";
		$S_MAIL['S_SUBJECT'] = base64_encode(urlencode ($S_SUBJECT)); 
		$S_MAIL['S_BODY'] = base64_encode(urlencode ($S_TEMPLATE));
		$S_MAIL['S_BODYTXT'] = "";
		$S_MAIL = json_encode ($S_MAIL);		
		$URLP = "http://trs.emailsolar.net/webservice/index.php";
		$POSTVALUE= "fct=EmailPush&S_MAIL=".$S_MAIL."&B_POOL_BATI=1";
		$resultat= curl_do_post($URLP, $POSTVALUE);	
		if($resultat){
		echo "finished";
	}


?>
<html>
    dmlfkldfklsdf
</html>