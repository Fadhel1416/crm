<?php
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once "config.inc.php";
include_once "commun.inc.php";  
//ini_set ("display_errors",1);
$b = new MongoClient("localhost:37011");
$db = $b->crm; // select db 
$camp = $db->t_campaign;
//$userstest=$db->userstest;
global $sqlserver;
	
function valid_email($email) {
    return !!filter_var($email, FILTER_VALIDATE_EMAIL);
}
//generate a random chaine ....................................
function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength=strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_REQUEST['fct']=="UserLogin") 
{
	$login =$_REQUEST['S_EMAIL'];

    if(valid_email($login) ){
    $sql = $sqlserver->prepare("select top 1 PK_USER, S_EMAIL, S_PASSWORD,K_KEY,FK_USER_PRINCIPAL from t_user where S_EMAIL=?");
	$sql->execute(array($_REQUEST['S_EMAIL']))  or die (print_r($sql->errorInfo()));
	$resuly_user = $sql->fetchObject();
    $sql->closeCursor();
    } else {

    echo "email invalide";
    }		
	$S_PASSWORD_BASE=mc_decrypt($resuly_user->S_PASSWORD,ENCRYPTION_KEY);
     
	//echo $S_PASSWORD_BASE;
	//$S_PASSWORD_BASE = $result_model->S_PASSWORD;
	//echo $S_PASSWORD_BASE;
	//die();
    
	if ($S_PASSWORD_BASE == $_REQUEST['S_PASSWORD'])
	{
		
	      if ($resuly_user->PK_USER > 0)
		{
			//$user = $_SERVER['HTTP_USER_AGENT'];
			if ($resuly_user->FK_USER_PRINCIPAL !=null)
		{
			//$user = $_SERVER['HTTP_USER_AGENT'];
			$S_IP=$_SERVER['REMOTE_ADDR'];
			$datee=date('Y-m-d H:i:s');
			$sqlinsert = $sqlserver->prepare("insert into t_user_log_connexion (FK_USER,S_IP,D_DATE_LOG_CONNEXION,S_USER_AGENT) VALUES(?,?,?,?)");     
       		$resultinsert= $sqlinsert->execute(array ($resuly_user->PK_USER,$S_IP,$datee,$_REQUEST['browser'])) or die(var_dump($sqlinsert->errorInfo()));
			echo json_encode(array('PK_USER'=> $resuly_user->FK_USER_PRINCIPAL,'K_KEY' => $resuly_user->K_KEY,'Pass' => $resuly_user->S_PASSWORD));
		}
		else{
			$S_IP=$_SERVER['REMOTE_ADDR'];
			$datee=date('Y-m-d H:i:s');
			$sqlinsert = $sqlserver->prepare("insert into t_user_log_connexion (FK_USER,S_IP,D_DATE_LOG_CONNEXION,S_USER_AGENT) VALUES(?,?,?,?)");     
       		$resultinsert= $sqlinsert->execute(array ($resuly_user->PK_USER,$S_IP,$datee,$_REQUEST['browser'])) or die(var_dump($sqlinsert->errorInfo()));
			echo json_encode(array('PK_USER'=> $resuly_user->PK_USER,'K_KEY' => $resuly_user->K_KEY,'Pass' => $resuly_user->S_PASSWORD));
		}
		}
		else
		{
			echo 0;
		}
		//echo json_encode(array('PK_USER'=> $resuly_user->PK_USER,'K_KEY' => $resuly_user->K_KEY,'Pass' => $resuly_user->S_PASSWORD));
	} 
}

if ($_REQUEST['fct']=="UserAdd") // insert user
{
	
	//$pwd = mc_encrypt(bin2hex(openssl_random_pseudo_bytes(4)),ENCRYPTION_KEY); 
	$pwd=mc_encrypt($_REQUEST['password'],ENCRYPTION_KEY);
	
	$dataforkey=$_REQUEST['email'].$_REQUEST['password'];
	$dataforkey=str_replace("+", " ", $dataforkey);

	//$api_key=mc_encrypt($dataforkey,ENCRYPTION_KEY);
	$api_key=generateRandomString(90);
		if (!isset($_REQUEST['S_IP']))
		{
			$S_IP = $_SERVER['REMOTE_ADDR']; 
		}
		else
		{
			$S_IP = $_REQUEST['S_IP'];
		}
		
		$somme_duplicate = 0;
		
				$sql_count = $sqlserver->query("select count(*) as somme from t_user WITH(NOLOCK)
				where S_EMAIL like '".$_REQUEST['email']."'"); 
				$result_count = $sql_count->fetchObject();
				$somme_duplicate = $result_count->somme;
				if($somme_duplicate ==0)
				{
				
		// insertion : 
		
		$sql3 = $sqlserver->prepare("if NOT EXISTS (select PK_USER from t_user WITH(NOLOCK) where S_EMAIL=?  and D_DATE_ADD>dateadd(minute,-10,getdate()) )
		BEGIN
		insert into  t_user (S_PASSWORD ,S_NAME, S_API_KEY,S_TEL, S_IP_ADDR,S_EMAIL,FK_ROLE)
		VALUES(?,?,?,?,?,?,?)
		END");	   
		$result= $sql3->execute(array ($_REQUEST['email'],$pwd, $_REQUEST['S_NAME'], $api_key,$_REQUEST['S_TEL'], $S_IP,$_REQUEST['email'],1)) or die(var_dump($sql3->errorInfo())); 
		$action="inscrit";
		$URLP = "https://www.yestravaux.com/webservice/crm/mail2.php";  
		$S_FROM = "YesTravaux";
		$POSTVALUE= "name=".$_REQUEST['S_NAME']."&message=".$action;
		$S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
		$S_SUBJECT= "Inscription";
		$S_MAIL = array();	
		$S_MAIL['S_FROM'] = $S_FROM;
		$S_MAIL['S_NAME_FROM'] = $S_FROM." <support@yestravaux.com>"; 
		$S_MAIL['S_REPLYTO_EMAIL'] = "support@yestravaux.com";
		$S_MAIL['S_TO_NAME'] = "";
		$S_MAIL['S_TO'] =$_REQUEST['email'];
		$S_MAIL['S_SUBJECT'] = base64_encode(urlencode ($S_SUBJECT)); 
		$S_MAIL['S_BODY'] = base64_encode(urlencode ($S_TEMPLATE));
		$S_MAIL['S_BODYTXT'] = "";
		$S_MAIL = json_encode ($S_MAIL);		
		$URLP = "http://trs.emailsolar.net/webservice/index.php";
		$POSTVALUE= "fct=EmailPush&S_MAIL=".$S_MAIL."&B_POOL_BATI=1";
		$resultat= curl_do_post($URLP, $POSTVALUE);
		$S_NAME_SMS="Yestravaux";
		$lien='https://yestravaux.com/crm2/app/components/pages/auth_login.php';
		$S_MESSAGE="Félicitations ".$_REQUEST['S_NAME']." votre compte a été créé avec succès , vous pouvez vous connectez en cliquant sur ce lien ".$lien;
		$URL = "https://www.yestravaux.com/webservice/sms/index.php";
		$POSTVALUE = "fct=SmsSendWL&S_TEL=".$_REQUEST['S_TEL']."&S_SENDER=".$S_NAME_SMS."&S_MESSAGE=$S_MESSAGE";
		$var = curl_do_post($URL, $POSTVALUE);  
		
		}
		if($somme_duplicate==0)
			{
				echo 1;
			}
			else
			{
				echo "DUPLICATE";	
			}
	/* $pays = "FR";
		$S_TEL_1 = FormatNumberIns($_REQUEST['S_TEL'],$pays);
					
		if ($S_TEL_1!="")
		{
			$URL = "https://www.boostercampaign.com/webservice/sms/";
			// $URL = "https://www.yestravaux.com/webservice/sms/"; 
			$POSTVALUE = "fct=SmsSendWL&S_TEL=".$S_TEL_1."&S_SENDER=".$S_NAME_SMS."&S_MESSAGE=$S_MESSAGE";
			$var = curl_do_post($URL, $POSTVALUE);  
		}  
	

    */	
}
if ($_REQUEST['fct']=="UserDecryptPass") 
{
	$passwordd=str_replace(" ", "+", $_REQUEST['PASSWORD']);
		$S_PASSWORD_BASE = mc_decrypt($passwordd, ENCRYPTION_KEY);
		echo json_encode($S_PASSWORD_BASE);
}

if ($_REQUEST['fct']=="UserProfil") 
{
	  $sqlprofil = $sqlserver->prepare("select * from t_user where K_KEY = ?");
	  $sqlprofil->execute(array($_REQUEST['kkey'])) or die (print_r($sqlprofil->errorInfo()));
	  $resprofil = $sqlprofil->fetchObject();
	  echo json_encode($resprofil);
}
if ($_REQUEST['fct']=="UserAccount") 
{
	  $sqlprofil = $sqlserver->prepare("select * from t_user where  PK_USER = ?");
	  $sqlprofil->execute(array($_REQUEST['pk_user'])) or die (print_r($sqlprofil->errorInfo()));
	  $resprofil = $sqlprofil->fetchObject();
	  echo json_encode($resprofil);
}
if ($_REQUEST['fct']=="UserAutoConnect") 
{
	  $sqlAutoConnect = $sqlserver->prepare("select * from t_user where PK_PRO=? and K_KEY = ? and FK_PRO_ETAT!=1");
	  $sqlAutoConnect->execute(array($_REQUEST['pk_user'],$_REQUEST['kkey'])) or die (print_r($sqlAutoConnect->errorInfo()));
	  $resAutoConnect = $sqlAutoConnect->fetchObject();
	  
	  echo json_encode($resAutoConnect);
}

//get user informations.....................................................
if ($_REQUEST['fct']=="UserInfo") 
{
	  $sqlprofil = $sqlserver->prepare("select * from t_user where K_KEY=?");
	  $sqlprofil->execute(array($_REQUEST['k_key'])) or die (print_r($sqlprofil->errorInfo()));
	  $resprofil = $sqlprofil->fetchObject();
	  echo json_encode($resprofil);
}

//update user informations web service......................................
if ($_REQUEST['fct']=="UpdateUserInfo") 
{
	$sqlprofil =$sqlserver->prepare("select * from t_user where K_KEY=?");
	$sqlprofil->execute(array($_REQUEST['k_key'])) or die (print_r($sqlprofil->errorInfo()));
	$ConnectedUser=$sqlprofil->fetchObject();
	$sqlprofil->closeCursor();
	if($ConnectedUser !=null)
	{
		$sqlprofil = $sqlserver->prepare("update t_user set S_NAME=?,S_EMAIL=?,S_TEL=? where S_EMAIL like '".$ConnectedUser->S_EMAIL."'");
		$sqlprofil->execute(array($_REQUEST['user_name'],$_REQUEST['user_email'],$_REQUEST['user_tel'])) or die (print_r($sqlprofil->errorInfo()));
		$UpdateConnected_User=$sqlprofil->fetchObject();
		$sqlprofil->closeCursor();
		$value="User avec key ".$_REQUEST['k_key']." est modifié avec succès";
		$sqllog = $sqlserver->prepare("select PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
		$sqllog->execute(array($value)) or die (print_r($sqllog->errorInfo()));
		$sqlres1 = $sqllog->fetchObject();
		$sqllog->closeCursor();

		if($sqlres1 ==null){

		$sqlinsertlog = $sqlserver->prepare("insert into t_type_action_log(S_TYPE_ACTION_LOG) VALUES(?)");     
		$sqlinsertlog->execute(array($value)) or die(var_dump($sqlinsertlog->errorInfo()));
		$sqllog1 = $sqlserver->prepare("select PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
		$sqllog1->execute(array($value)) or die (print_r($sqllog1->errorInfo()));
		$sqlres2 = $sqllog1->fetchObject();
		$sqllog1->closeCursor();

		if($sqlres2->PK_TYPE_ACTION_LOG > 0)
		{
			$S_IP=$_SERVER['REMOTE_ADDR'];
			$datee=date('Y-m-d H:i:s');
			$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
			$sqlinsertlog2->execute(array($sqlres2->PK_TYPE_ACTION_LOG,$datee,$_REQUEST['pk_user'],NULL,$S_IP,$_REQUEST['browser'])) or die(var_dump($sqlinsertlog2->errorInfo()));
		}
		else{
			echo '0';
		}

		}
		else{
			$S_IP=$_SERVER['REMOTE_ADDR'];
			$datee=date('Y-m-d H:i:s');
			$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
			$sqlinsertlog2->execute(array($sqlres1->PK_TYPE_ACTION_LOG,$datee,$_REQUEST['pk_user'],NULL,$S_IP,$_REQUEST['browser'])) or die(var_dump($sqlinsertlog2->errorInfo()));

		}


		
		echo json_encode(array('updateduser'=>$UpdateConnected_User));
	}
	else
	{
		echo 'Not Authorized';
	}	  
}

//update user password web service........................................................
if($_REQUEST['fct']=="UpdateUserPassword")
{
	$sqlprofil =$sqlserver->prepare("select * from t_user where K_KEY=?");
	$sqlprofil->execute(array($_REQUEST['k_key'])) or die (print_r($sqlprofil->errorInfo()));
	$ConnectedUser=$sqlprofil->fetchObject();
	$sqlprofil->closeCursor();
	if($ConnectedUser != null)
	{
		$pwd=mc_encrypt($_REQUEST['passwordvalue'],ENCRYPTION_KEY);
        $sqlprofil = $sqlserver->prepare("update t_user set S_PASSWORD=? where K_KEY=?");
		$sqlprofil->execute(array($pwd,$_REQUEST['k_key'])) or die (print_r($sqlprofil->errorInfo()));
		$value="Mot de passe pour user avec key ".$_REQUEST['k_key']." est modifié avec succès";
		$sqllog = $sqlserver->prepare("select  PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
		$sqllog->execute(array($value)) or die (print_r($sqllog->errorInfo()));
		$sqlres1 =$sqllog->fetchObject();
		$sqllog->closeCursor();
		if($sqlres1==null)
		{
			$sqlinsertlog =$sqlserver->prepare("insert into t_type_action_log(S_TYPE_ACTION_LOG) VALUES(?)");     
			$sqlinsertlog->execute(array($value)) or die(var_dump($sqlinsertlog->errorInfo()));
			$sqllog1 = $sqlserver->prepare("select  PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
			$sqllog1->execute(array($value)) or die (print_r($sqllog1->errorInfo()));
			$sqlres2 = $sqllog1->fetchObject();
			$sqllog1->closeCursor();
			if($sqlres2->PK_TYPE_ACTION_LOG > 0)
			{
				$S_IP=$_SERVER['REMOTE_ADDR'];
				$datee=date('Y-m-d H:i:s');
				$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
				$sqlinsertlog2->execute(array($sqlres2->PK_TYPE_ACTION_LOG,$datee,$_REQUEST['pk_user'],NULL,$S_IP,$_REQUEST['browser'])) or die(var_dump($sqlinsertlog2->errorInfo()));
				}
			else{
				echo '0';
			}
			}
			else{
				$S_IP=$_SERVER['REMOTE_ADDR'];
				$datee=date('Y-m-d H:i:s');
				$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
				$sqlinsertlog2->execute(array($sqlres1->PK_TYPE_ACTION_LOG,$datee,$_REQUEST['pk_user'],NULL,$S_IP,$_REQUEST['browser'])) or die(var_dump($sqlinsertlog2->errorInfo()));
	
			}
		echo json_encode(array('result'=>"work fine"));
	}
	else{
		echo 'Not authorized';
	}

}
// get all log for user connections.....................
if($_REQUEST['fct']=="UserInfoLog")
{
	$pk_user=$_REQUEST['pk_user'];
	$k_key=$_REQUEST['k_key'];
	$sqlprofil1 =$sqlserver->prepare("select * from t_user where K_KEY=?");
	$sqlprofil1->execute(array($k_key)) or die (print_r($sqlprofil2->errorInfo()));
	$sqlres1 =$sqlprofil1->fetchObject();
	$sqlprofil1->closeCursor();
	$sqlprofil =$sqlserver->prepare("select * from t_user_log_connexion where FK_USER=?");
	$sqlprofil->execute(array($sqlres1->PK_USER)) or die (print_r($sqlprofil->errorInfo()));
	$result=[];
	foreach($sqlprofil->fetchAll(PDO::FETCH_NUM) as $row) {
			$resultdoc=[];
			$resultdoc["D_DATE_LOG_CONNEXION"]=$row[1];
			$resultdoc["S_IP"]=$row[3];
			$resultdoc["S_USER_AGENT"]=$row[4];
			array_push($result,$resultdoc);
	}
    echo json_encode($result);

}
//get log informations for all update................................................
if($_REQUEST['fct']=="UserUpdateLog")
{
	$pk_user=$_REQUEST['pk_user'];
	$k_key=$_REQUEST['k_key'];
	$sqlprofil1 =$sqlserver->prepare("select * from t_user where K_KEY=?");
	$sqlprofil1->execute(array($k_key)) or die (print_r($sqlprofil2->errorInfo()));
	$sqlres1 =$sqlprofil1->fetchObject();
	$sqlprofil1->closeCursor();
	$sqlprofil =$sqlserver->prepare("select * from t_log where FK_USER=?");
	$sqlprofil->execute(array($sqlres1->PK_USER)) or die (print_r($sqlprofil->errorInfo()));
	$result=[];
	foreach($sqlprofil->fetchAll(PDO::FETCH_NUM) as $row) {
	$resultdoc=[];
	$sqlprofil2 =$sqlserver->prepare("select * from t_type_action_log where PK_TYPE_ACTION_LOG=?");
	$sqlprofil2->execute(array($row[1])) or die (print_r($sqlprofil2->errorInfo()));
	$sqlres1 =$sqlprofil2->fetchObject();
	$sqlprofil2->closeCursor();
	$resultdoc["ACTION"]=$sqlres1->S_TYPE_ACTION_LOG;
	$resultdoc["D_DATE_LOG_CONNEXION"]=$row[2];
	if($row[4] != null)
	{
	$cursor = $camp->findOne(array('_id' => new MongoId($row[4])));
	$resultdoc["ID_CAMP"]=$cursor["companyName"];
	}
	else{
		$resultdoc["ID_CAMP"]="Not Defined";

	}

	$resultdoc["S_IP"]=$row[5];
	$resultdoc["S_USER_AGENT"]=$row[6];
	array_push($result,$resultdoc);
}
    echo json_encode($result);

}

// verifications password..............................................................
if($_REQUEST['fct']=="VerificationPassword")
{
	$sql = $sqlserver->prepare("select top 1 PK_USER, S_EMAIL, S_PASSWORD,K_KEY,S_NAME from t_user where S_EMAIL=?");
	$sql->execute(array($_REQUEST['email']))  or die (print_r($sql->errorInfo()));
	$resuly_user = $sql->fetchObject();
    $sql->closeCursor();
	$S_PASSWORD_BASE=mc_decrypt($resuly_user->S_PASSWORD,ENCRYPTION_KEY);
	if($S_PASSWORD_BASE == $_REQUEST["passwordvalue"])
	{
		$data=array("verif"=>"ok");
	}
	else{
		$action="mdp";
		$URLP= "https://www.yestravaux.com/webservice/crm/mail2.php";  
		$S_FROM = "YesTravaux";
		$POSTVALUE= "name=".$resuly_user->S_NAME."&message=".$action;
		$S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
		$S_SUBJECT= "Tentative de modifications de mot de passe";
		$S_MAIL = array();	
		$S_MAIL['S_FROM'] = $S_FROM;
		$S_MAIL['S_NAME_FROM'] = $S_FROM." <support@yestravaux.com>"; 
		$S_MAIL['S_REPLYTO_EMAIL'] = "support@yestravaux.com";
		$S_MAIL['S_TO_NAME'] = "";
		$S_MAIL['S_TO'] =$resuly_user->S_EMAIL;
		$S_MAIL['S_SUBJECT'] = base64_encode(urlencode ($S_SUBJECT)); 
		$S_MAIL['S_BODY'] = base64_encode(urlencode ($S_TEMPLATE));
		$S_MAIL['S_BODYTXT'] = "";
		$S_MAIL = json_encode ($S_MAIL);		
		$URLP = "http://trs.emailsolar.net/webservice/index.php";
		$POSTVALUE= "fct=EmailPush&S_MAIL=".$S_MAIL."&B_POOL_BATI=1";
		$resultat= curl_do_post($URLP, $POSTVALUE);	

		$data=array("verif"=>"not found");
	}

	echo json_encode($data);

}


//test  user existence..................................................................
if($_REQUEST['fct']=="MailVerifExist")
{
	$email=$_REQUEST['email'];
	$password=$_REQUEST['password'];
	$sql = $sqlserver->prepare("select top 1 PK_USER,S_PASSWORD from t_user where S_EMAIL=?");
	$sql->execute(array($email))  or die(print_r($sql->errorInfo()));
	$resuly_user = $sql->fetchObject();
    $sql->closeCursor();
	if($resuly_user == null){
		$data=array("verifmail"=>"error1");
	}
	else{
		
		$S_PASSWORD_BASE=mc_decrypt($resuly_user->S_PASSWORD,ENCRYPTION_KEY);
        if($S_PASSWORD_BASE==$password)
		{
			$data=array("verifmail"=>"ok");

		}
		else{
			$data=array("verifmail"=>"error2");

		}

	}

	echo json_encode($data);

}


//send email for password reset web service...................................................
if($_REQUEST['fct']=="SendInitPassword")
{
$email=$_REQUEST['S_EMAIL'];

$sql = $sqlserver->prepare("select top 1 PK_USER,S_EMAIL,K_KEY,S_NAME from t_user where S_EMAIL=?");
	$sql->execute(array($email))  or die(print_r($sql->errorInfo()));
	$resuly_user = $sql->fetchObject();
    $sql->closeCursor();
	if($resuly_user!=null)
	{
		$action="initPASS";
		$cle=$resuly_user->K_KEY;
		$name=$resuly_user->S_NAME;	
		$url="https://yestravaux.com/crm2/app/components/pages/modifie_mdp.php?key=".$cle;
		$URLP= "https://www.yestravaux.com/webservice/crm/mail2.php";  
		$S_FROM = "YesTravaux";
		$POSTVALUE= "name=".$name."&message=".$action."&url=".$url;
		$S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
		$S_SUBJECT= "Réinitialisation mot de passe";
		$S_MAIL = array();	
		$S_MAIL['S_FROM'] = $S_FROM;
		$S_MAIL['S_NAME_FROM'] = $S_FROM." <support@yestravaux.com>"; 
		$S_MAIL['S_REPLYTO_EMAIL'] = "support@yestravaux.com";
		$S_MAIL['S_TO_NAME'] = "";
		$S_MAIL['S_TO'] =$resuly_user->S_EMAIL;
		$S_MAIL['S_SUBJECT'] = base64_encode(urlencode ($S_SUBJECT)); 
		$S_MAIL['S_BODY'] = base64_encode(urlencode ($S_TEMPLATE));
		$S_MAIL['S_BODYTXT'] = "";
		$S_MAIL = json_encode ($S_MAIL);		
		$URLP = "http://trs.emailsolar.net/webservice/index.php";
		$POSTVALUE= "fct=EmailPush&S_MAIL=".$S_MAIL."&B_POOL_DESK=1";
		$resultat= curl_do_post($URLP, $POSTVALUE);	
		$tt=json_decode($resultat);
		$tt=(array) $tt;
		if($tt["success"]==1)
		{
			echo json_encode(array("result"=>"ok"));
		}
	}
	else{
		echo json_encode(array("result"=>"error"));
	}
}


//Reset password web service.................................................................................
if($_REQUEST['fct']=="InitPassword")
{
	//$email=$_REQUEST['S_EMAIL'];
	$password=$_REQUEST['S_PASSWORD'];
	$key=$_REQUEST['K_KEY'];
	$sqlprofil =$sqlserver->prepare("select * from t_user where K_KEY=?");
	$sqlprofil->execute(array($key)) or die (print_r($sqlprofil->errorInfo()));
	$ConnectedUser=$sqlprofil->fetchObject();
	$sqlprofil->closeCursor();
	if($ConnectedUser != null)
	{
		$pwd=mc_encrypt($password,ENCRYPTION_KEY);
        $sqlprofil = $sqlserver->prepare("update t_user set S_PASSWORD=? where S_EMAIL=? and K_KEY=?");
		$sqlprofil->execute(array($pwd,$ConnectedUser->S_EMAIL,$key)) or die (print_r($sqlprofil->errorInfo()));
		$value="Mot de passe pour user avec key ".$key." est modifié avec succès";
		$sqllog = $sqlserver->prepare("select  PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
		$sqllog->execute(array($value)) or die (print_r($sqllog->errorInfo()));
		$sqlres1 =$sqllog->fetchObject();
		$sqllog->closeCursor();
		if($sqlres1==null)
		{
			$sqlinsertlog =$sqlserver->prepare("insert into t_type_action_log(S_TYPE_ACTION_LOG) VALUES(?)");     
			$sqlinsertlog->execute(array($value)) or die(var_dump($sqlinsertlog->errorInfo()));
			$sqllog1 = $sqlserver->prepare("select  PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
			$sqllog1->execute(array($value)) or die (print_r($sqllog1->errorInfo()));
			$sqlres2 = $sqllog1->fetchObject();
			$sqllog1->closeCursor();
			if($sqlres2->PK_TYPE_ACTION_LOG > 0)
			{
				$S_IP=$_SERVER['REMOTE_ADDR'];
				$datee=date('Y-m-d H:i:s');
				$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
				$sqlinsertlog2->execute(array($sqlres2->PK_TYPE_ACTION_LOG,$datee,$ConnectedUser->PK_USER,NULL,$S_IP,$_REQUEST['browser'])) or die(var_dump($sqlinsertlog2->errorInfo()));
			}
			else{
				echo '0';
			}
			}
			else{
				$S_IP=$_SERVER['REMOTE_ADDR'];
				$datee=date('Y-m-d H:i:s');
				$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
				$sqlinsertlog2->execute(array($sqlres1->PK_TYPE_ACTION_LOG,$datee,$ConnectedUser->PK_USER,NULL,$S_IP,$_REQUEST['browser'])) or die(var_dump($sqlinsertlog2->errorInfo()));
	
			}
	

		echo json_encode(array('result'=>"ok"));
	}
	else{
		echo json_encode(array('result'=>"Not Exist"));
	}
}

//just for testing the API ...........................................
if($_REQUEST['fct']=="TestSmsApi")
{
	$S_NAME_SMS="Yestravaux";
	$lien='https://yestravaux.com/crm2/app/components/pages/auth_login.php';
	$S_MESSAGE="Félicitations ".$_REQUEST['S_NAME']." votre compte a été créé avec succès , vous pouvez vous connectez en cliquant sur ce lien ".$lien;
	$URL = "https://www.yestravaux.com/webservice/sms/index.php";
    $POSTVALUE = "fct=SmsSendWL&S_TEL=".$_REQUEST['S_TEL']."&S_SENDER=".$S_NAME_SMS."&S_MESSAGE=$S_MESSAGE";
    $var = curl_do_post($URL, $POSTVALUE);
    $var=substr($var,0,strlen($var)-1);
    $tt=json_decode($var);
	$tt=(array) $tt;
	if($tt["result"]==200)
	{
		echo "ok";
	}  
}

//just for testing the API.........................
if($_REQUEST['fct']=="SendEmailApi")
{
	$URLP= "https://www.yestravaux.com/webservice/crm/mail2.php";  
		$S_FROM = "";
		$POSTVALUE= "name=fadhel"."&message=initPASS"."&url=https://www.yestravaux.com";
		$S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
		$S_SUBJECT= "Réinitialisation mot de passe";
		$S_MAIL = array();	
		$S_MAIL['S_FROM'] = $S_FROM;
		$S_MAIL['S_NAME_FROM'] = $S_FROM." <support@desk.com>"; 
		$S_MAIL['S_REPLYTO_EMAIL'] = "support@desk.com";
		$S_MAIL['S_TO_NAME'] = "fadhel";
		$S_MAIL['S_TO'] ="ali.f@externalisation.pro";
		$S_MAIL['S_SUBJECT'] = base64_encode(urlencode ($S_SUBJECT)); 
		$S_MAIL['S_BODY'] = base64_encode(urlencode ($S_TEMPLATE));
		$S_MAIL['S_BODYTXT'] = "";
		$S_MAIL = json_encode ($S_MAIL);		
		$URLP = "http://trs.emailsolar.net/webservice/index.php";
		$POSTVALUE= "fct=EmailPush&S_MAIL=".$S_MAIL."&B_POOL_DESK=1";
		$resultat= curl_do_post($URLP, $POSTVALUE);	
		$tt=json_decode($resultat);
	    $tt=(array) $tt;
		if($tt["success"]==1)
		{
			echo "ok";
		}	
}


if($_REQUEST['fct']=="UploadFile")
{

	$maxsize = 5242880;
	$ext = strtolower(substr(strrchr($_FILES['UserImage']['name'],'.'),1));
	$extensions_valides = array('jpg' , 'jpeg' , 'png' );
	$nouveauNom=substr(str_shuffle("012354654"),0,20);//generate a random name for the image.....
	if ($_FILES['UserImage']['error'] > 0) {
	echo json_encode(array("ETAT" => "error_transfert"));
	}

	//Test2: taille limite max. 1 Mo
	else if ($_FILES['UserImage']['size'] > $maxsize) {
		echo json_encode(array("ETAT" => "error_size"));
	}
       //Test3: extension     
	else if (!in_array($ext,$extensions_valides)) {
		echo json_encode(array("ETAT" => "error_extension"));
	}
        //Déplacement
	else {
	$sqlprofil =$sqlserver->prepare("select * from t_user where K_KEY=?");
	$sqlprofil->execute(array($_REQUEST['k_key'])) or die (print_r($sqlprofil->errorInfo()));
	$ConnectedUser=$sqlprofil->fetchObject();
	$sqlprofil->closeCursor();
	$value="Image for user with name ".$ConnectedUser->S_NAME." and key ".$_REQUEST['k_key']." est ajouté avec succès";
	$sqllog = $sqlserver->prepare("select  PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
	$sqllog->execute(array($value)) or die (print_r($sqllog->errorInfo()));
	$sqlres1 =$sqllog->fetchObject();
	$sqllog->closeCursor();
	if($sqlres1==null)
	{
	$sqlinsertlog =$sqlserver->prepare("insert into t_type_action_log(S_TYPE_ACTION_LOG) VALUES(?)");     
	$sqlinsertlog->execute(array($value)) or die(var_dump($sqlinsertlog->errorInfo()));
	$sqllog1 = $sqlserver->prepare("select  PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
	$sqllog1->execute(array($value)) or die (print_r($sqllog1->errorInfo()));
	$sqlres2 = $sqllog1->fetchObject();
	$sqllog1->closeCursor();
	if($sqlres2->PK_TYPE_ACTION_LOG > 0)
	{
		$S_IP=$_SERVER['REMOTE_ADDR'];
		$datee=date('Y-m-d H:i:s');
		$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
		$sqlinsertlog2->execute(array($sqlres2->PK_TYPE_ACTION_LOG,$datee,$ConnectedUser->PK_USER,NULL,$S_IP,$_REQUEST['browser'])) or die(var_dump($sqlinsertlog2->errorInfo()));
	}

		}
	else{
		$S_IP=$_SERVER['REMOTE_ADDR'];
		$datee=date('Y-m-d H:i:s');
		$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
		$sqlinsertlog2->execute(array($sqlres1->PK_TYPE_ACTION_LOG,$datee,$ConnectedUser->PK_USER,NULL,$S_IP,$_REQUEST['browser'])) or die(var_dump($sqlinsertlog2->errorInfo()));

	}
	if($ConnectedUser->S_IMAGE!= null)
	{
		//if user have image delete it from the server............................................
		unlink(dirname(dirname(dirname(__FILE__))).'/pro/manager/photos/'.$ConnectedUser->S_IMAGE.'');
	}		
	$nom_fichier = $nouveauNom.".".$ext;
	$destination = dirname(dirname(dirname(__FILE__)))."/pro/manager/photos/{$nouveauNom}.{$ext}";

	$deplacement = move_uploaded_file($_FILES['UserImage']['tmp_name'],$destination);

		if ($deplacement) {
		$sqlprofil = $sqlserver->prepare("update t_user set S_IMAGE=? where K_KEY=?");
		$sqlprofil->execute(array($nom_fichier,$_REQUEST['k_key'])) or die (print_r($sqlprofil->errorInfo()));
		
		echo json_encode(array("ETAT" => "success_transfert"));
	// $sql = $sqlserver->prepare("update t_pro set S_PHOTO_PRO = ?  where PK_PRO=? and K_KEY=?");
	// $sql->execute(array($nom_fichier,$PK_PRO, $K_KEY)) or die (print_r($sql->errorInfo()));
	
	} else{  
		echo json_encode(array("ETAT" => "error"));
	}
	}
}

	if($_REQUEST['fct']=="GetRolesLists")
	{
	$sqlprofil =$sqlserver->prepare("select * from t_role where PK_ROLE !=?");
	$sqlprofil->execute(array(1)) or die (print_r($sqlprofil->errorInfo()));
	$result=[];
	foreach($sqlprofil->fetchAll(PDO::FETCH_NUM) as $row)
	 {
		$resultdoc=[];
		$resultdoc["PK_ROLE"]=$row[0];
		$resultdoc["S_ROLE"]=$row[1];
		array_push($result,$resultdoc);
	}
	echo json_encode($result);
	}


if($_REQUEST['fct']=="SendInvitations")
{
$api_key=generateRandomString(90);
if (!isset($_REQUEST['S_IP']))
{
	$S_IP = $_SERVER['REMOTE_ADDR']; 
}
else
{
	$S_IP = $_REQUEST['S_IP'];
}

$somme_duplicate = 0;

	$sql_count = $sqlserver->query("select count(*) as somme from t_user WITH(NOLOCK)
		where S_EMAIL like '".$_REQUEST['email']."'"); 
	$result_count = $sql_count->fetchObject();
	$somme_duplicate = $result_count->somme;
	$sqlprofil2 =$sqlserver->prepare("select * from t_user where K_KEY=?");
	$sqlprofil2->execute(array($_REQUEST['kkey'])) or die (print_r($sqlprofil->errorInfo()));
	$ConnectedUser=$sqlprofil2->fetchObject();
	$sqlprofil2->closeCursor();
			if($somme_duplicate==0)
			{
				$value="Votre invitation a l'utilisateur ".$_REQUEST['email']." a été envoyé avec succès";
				$sqllog = $sqlserver->prepare("select PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
				$sqllog->execute(array($value)) or die (print_r($sqllog->errorInfo()));
				$sqlres1 =$sqllog->fetchObject();
				$sqllog->closeCursor();
				if($sqlres1==null)
			{
				$sqlinsertlog =$sqlserver->prepare("insert into t_type_action_log(S_TYPE_ACTION_LOG) VALUES(?)");     
				$sqlinsertlog->execute(array($value)) or die(var_dump($sqlinsertlog->errorInfo()));
				$sqllog1 = $sqlserver->prepare("select  PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
				$sqllog1->execute(array($value)) or die (print_r($sqllog1->errorInfo()));
				$sqlres2 = $sqllog1->fetchObject();
				$sqllog1->closeCursor();
				if($sqlres2->PK_TYPE_ACTION_LOG > 0)
				{
					$S_IP=$_SERVER['REMOTE_ADDR'];
					$datee=date('Y-m-d H:i:s');
					$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
					$sqlinsertlog2->execute(array($sqlres2->PK_TYPE_ACTION_LOG,$datee,$ConnectedUser->PK_USER,NULL,$S_IP,$_REQUEST['browser'])) or die(var_dump($sqlinsertlog2->errorInfo()));
				}
				}
				else{
					$S_IP=$_SERVER['REMOTE_ADDR'];
					$datee=date('Y-m-d H:i:s');
					$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
					$sqlinsertlog2->execute(array($sqlres1->PK_TYPE_ACTION_LOG,$datee,$ConnectedUser->PK_USER,NULL,$S_IP,$_REQUEST['browser'])) or die(var_dump($sqlinsertlog2->errorInfo()));
		
				}
			
	// insertion : 
	
		$sql3 = $sqlserver->prepare("if NOT EXISTS (select PK_USER from t_user WITH(NOLOCK) where S_EMAIL=?  and D_DATE_ADD>dateadd(minute,-10,getdate()) )
		BEGIN
		insert into  t_user (S_API_KEY,S_IP_ADDR,S_EMAIL,FK_ROLE,FK_USER_PRINCIPAL,S_ETAT_USER)
		VALUES(?,?,?,?,?,?)
		END");	   
		
		$sqlprofil3 =$sqlserver->prepare("select * from t_role where PK_ROLE=?");
		$sqlprofil3->execute(array($_REQUEST['FK_ROLE'])) or die (print_r($sqlprofil->errorInfo()));
		$roles=$sqlprofil3->fetchObject();
		$sqlprofil3->closeCursor();
		$result= $sql3->execute(array($_REQUEST['email'],$api_key,$S_IP,$_REQUEST['email'],intval($_REQUEST['FK_ROLE']),intval($_REQUEST['pk_user']),"sended")) or die(var_dump($sql3->errorInfo())); 
		$action="Invitations";
		$url="https://yestravaux.com/crm2/app/components/pages/accepte_invitation.php?email=".$_REQUEST['email'];

		$URLP = "https://www.yestravaux.com/webservice/crm/activation_mail.php";  
		$S_FROM = "YesTravaux";
		$POSTVALUE= "sender=".$ConnectedUser->S_EMAIL."&message=".$action."&url=".$url."&role=".$roles->S_ROLE;
		$S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
		$S_SUBJECT= "Invitations";
		$S_MAIL = array();	
		$S_MAIL['S_FROM'] = $S_FROM;
		$S_MAIL['S_NAME_FROM'] = $S_FROM." <support@yestravaux.com>"; 
		$S_MAIL['S_REPLYTO_EMAIL'] = "support@yestravaux.com";
		$S_MAIL['S_TO_NAME'] = "";
		$S_MAIL['S_TO'] =$_REQUEST['email'];
		$S_MAIL['S_SUBJECT'] = base64_encode(urlencode ($S_SUBJECT)); 
		$S_MAIL['S_BODY'] = base64_encode(urlencode ($S_TEMPLATE));
		$S_MAIL['S_BODYTXT'] = "";
		$S_MAIL = json_encode ($S_MAIL);		
		$URLP = "http://trs.emailsolar.net/webservice/index.php";
		$POSTVALUE= "fct=EmailPush&S_MAIL=".$S_MAIL."&B_POOL_BATI=1";
		$resultat= curl_do_post($URLP, $POSTVALUE);
		$tt=json_decode($resultat);
		$tt=(array) $tt;
	
		
	}
	if($ConnectedUser->S_EMAIL==$_REQUEST['email'])
	{
		echo json_encode(array("result"=>"MyAccount"));
	}
	else if($somme_duplicate==0 && $tt["success"]==1)
	{
		echo json_encode(array("result"=>"ok"));
	}
	else
	{
		echo json_encode(array("result"=>"DUPLICATE"));
	}
}

if($_REQUEST['fct']=="GetInvitedUsers")
{
	$sqlprofil =$sqlserver->prepare("select * from t_user where FK_USER_PRINCIPAL =?");
	$sqlprofil->execute(array($_REQUEST['PK_USER'])) or die (print_r($sqlprofil->errorInfo()));
	$result=[];

	foreach($sqlprofil->fetchAll(PDO::FETCH_NUM) as $row) {
		$resultdoc=[];
		$resultdoc["S_NAME"]=$row[2];
		$resultdoc["D_DATE_ADD"]=$row[3];
		$resultdoc["S_EMAIL"]=$row[5];
		$resultdoc["FK_ROLE"]=$row[10];
		$resultdoc["S_ETAT_ROLE"]=$row[12];
		$resultdoc["S_IMAGE"]=$row[9];
		$resultdoc["K_KEY"]=$row[1];
		$resultdoc["S_USER_STATUS"]=$row[13];
		array_push($result,$resultdoc);
	}

	/*$sqlprofil =$sqlserver->prepare("select * from t_user where PK_USER =?");
	$sqlprofil->execute(array($_REQUEST['PK_USER'])) or die (print_r($sqlprofil->errorInfo()));
	$User_Principal=$sqlprofil->fetchObject();
	$resdoc2["S_NAME"]=$User_Principal->S_NAME;
	$resdoc2["D_DATE_ADD"]=$User_Principal->D_DATE_ADD;
	$resdoc2["S_EMAIL"]=$User_Principal->S_EMAIL;
	$resdoc2["FK_ROLE"]=$User_Principal->FK_ROLE;
	$resdoc2["S_ETAT_ROLE"]=$User_Principal->S_ETAT_ROLE;
	$resdoc2["S_IMAGE"]=$User_Principal->S_IMAGE;
	$resdoc2["K_KEY"]=$User_Principal->K_KEY;
	$resdoc2["S_USER_STATUS"]=$User_Principal->S_USER_STATUS;
	array_push($result,$resdoc2);*/



	echo json_encode($result);
}
if($_REQUEST['fct']=="GetInvitedUsers2")
{
	$sqlprofil =$sqlserver->prepare("select * from t_user where FK_USER_PRINCIPAL =? or PK_USER=?");
	$sqlprofil->execute(array($_REQUEST['PK_USER'],$_REQUEST['PK_USER'])) or die (print_r($sqlprofil->errorInfo()));
	$result=[];

	foreach($sqlprofil->fetchAll(PDO::FETCH_NUM) as $row) {
		$resultdoc=[];
		$resultdoc["S_NAME"]=$row[2];
		$resultdoc["D_DATE_ADD"]=$row[3];
		$resultdoc["S_EMAIL"]=$row[5];
		$resultdoc["FK_ROLE"]=$row[10];
		$resultdoc["S_ETAT_ROLE"]=$row[12];
		$resultdoc["S_IMAGE"]=$row[9];
		$resultdoc["K_KEY"]=$row[1];
		$resultdoc["S_USER_STATUS"]=$row[13];
		array_push($result,$resultdoc);
	}

	// $sqlprofil2 =$sqlserver->prepare("select * from t_user where PK_USER =?");
	// $sqlprofil2->execute(array(intval($_REQUEST['PK_USER']))) or die (print_r($sqlprofil2->errorInfo()));
	// $User_Principal=$sqlprofil2->fetchObject();
	// $resdoc2["S_NAME"]=$User_Principal["S_NAME"];
	// // $resdoc2["D_DATE_ADD"]=$User_Principal->D_DATE_ADD;
	// // $resdoc2["S_EMAIL"]=$User_Principal->S_EMAIL;
	// // $resdoc2["FK_ROLE"]=$User_Principal->FK_ROLE;
	// // $resdoc2["S_ETAT_ROLE"]=$User_Principal->S_ETAT_ROLE;
	// // $resdoc2["S_IMAGE"]=$User_Principal->S_IMAGE;
	// // $resdoc2["K_KEY"]=$User_Principal->K_KEY;
	// // $resdoc2["S_USER_STATUS"]=$User_Principal->S_USER_STATUS;
	// // array_push($result,$resdoc2);



	echo json_encode($result);
}


if($_REQUEST['fct']=="UpdateInvitedUser")
{
	$pwd=mc_encrypt($_REQUEST['password'],ENCRYPTION_KEY);
	$somme_duplicate = 0;
	
			$sql_count = $sqlserver->query("select count(*) as somme from t_user WITH(NOLOCK)
			where S_EMAIL like '".$_REQUEST['email']."'"); 
			$result_count = $sql_count->fetchObject();
			$somme_duplicate = $result_count->somme;
			if($somme_duplicate !=0)
			{
			
	// insertion : 
	
		$sql3 = $sqlserver->prepare("update t_user set S_NAME=?,S_TEL=?,S_PASSWORD=?,S_ETAT_USER=? where S_EMAIL like '".$_REQUEST['email']."'");	   
		$result= $sql3->execute(array ($_REQUEST['S_NAME'],$_REQUEST['S_TEL'],$pwd,"accepted")) or die(var_dump($sql3->errorInfo())); 
		$action="inscrit";
		$URLP = "https://www.yestravaux.com/webservice/crm/mail2.php";  
		$S_FROM = "YesTravaux";
		$POSTVALUE= "name=".$_REQUEST['S_NAME']."&message=".$action;
		$S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
		$S_SUBJECT= "Inscription";
		$S_MAIL = array();	
		$S_MAIL['S_FROM'] = $S_FROM;
		$S_MAIL['S_NAME_FROM'] = $S_FROM." <support@yestravaux.com>"; 
		$S_MAIL['S_REPLYTO_EMAIL'] = "support@yestravaux.com";
		$S_MAIL['S_TO_NAME'] = "";
		$S_MAIL['S_TO'] =$_REQUEST['email'];
		$S_MAIL['S_SUBJECT'] = base64_encode(urlencode ($S_SUBJECT)); 
		$S_MAIL['S_BODY'] = base64_encode(urlencode ($S_TEMPLATE));
		$S_MAIL['S_BODYTXT'] = "";
		$S_MAIL = json_encode ($S_MAIL);		
		$URLP = "http://trs.emailsolar.net/webservice/index.php";
		$POSTVALUE= "fct=EmailPush&S_MAIL=".$S_MAIL."&B_POOL_BATI=1";
		$resultat= curl_do_post($URLP, $POSTVALUE);
		$S_NAME_SMS="Yestravaux";
		$lien='https://yestravaux.com/crm2/app/components/pages/auth_login.php';
		$S_MESSAGE="Félicitations ".$_REQUEST['S_NAME']." votre compte a été créé avec succès , vous pouvez vous connectez en cliquant sur ce lien ".$lien;
		$URL = "https://www.yestravaux.com/webservice/sms/index.php";
		$POSTVALUE = "fct=SmsSendWL&S_TEL=".$_REQUEST['S_TEL']."&S_SENDER=".$S_NAME_SMS."&S_MESSAGE=$S_MESSAGE";
		$var = curl_do_post($URL, $POSTVALUE);  
		
		}

		$sqlprofil =$sqlserver->prepare("select * from t_user where S_EMAIL=?");
		$sqlprofil->execute(array($_REQUEST['email'])) or die (print_r($sqlprofil->errorInfo()));
		$User=$sqlprofil->fetchObject();
		$sqlprofil->closeCursor();
		$sqlprofil =$sqlserver->prepare("select * from t_user where PK_USER=?");
		$sqlprofil->execute(array($User->FK_USER_PRINCIPAL)) or die (print_r($sqlprofil->errorInfo()));
		$UserConf=$sqlprofil->fetchObject();
		$sqlprofil->closeCursor();


		$action="confirmation_admin";
		$URLP = "https://www.yestravaux.com/webservice/crm/activation_mail.php";  
		$S_FROM = "YesTravaux";
		$POSTVALUE= "name=".$UserConf->S_NAME."&message=".$action."&email=".$_REQUEST['email'];
		$S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
		$S_SUBJECT= "Inscription";
		$S_MAIL = array();	
		$S_MAIL['S_FROM'] = $S_FROM;
		$S_MAIL['S_NAME_FROM'] = $S_FROM." <support@yestravaux.com>"; 
		$S_MAIL['S_REPLYTO_EMAIL'] = "support@yestravaux.com";
		$S_MAIL['S_TO_NAME'] = "";
		$S_MAIL['S_TO'] =$UserConf->S_EMAIL;
		$S_MAIL['S_SUBJECT'] = base64_encode(urlencode ($S_SUBJECT)); 
		$S_MAIL['S_BODY'] = base64_encode(urlencode ($S_TEMPLATE));
		$S_MAIL['S_BODYTXT'] = "";
		$S_MAIL = json_encode ($S_MAIL);		
		$URLP = "http://trs.emailsolar.net/webservice/index.php";
		$POSTVALUE= "fct=EmailPush&S_MAIL=".$S_MAIL."&B_POOL_BATI=1";
		$resultat= curl_do_post($URLP, $POSTVALUE);
		if($somme_duplicate !=0)
		{
			echo 1;
		}
		else
		{
			echo "DUPLICATE";	
		}
	}


if($_REQUEST['fct']=="UpdateRoleUser")
{
	$key=$_REQUEST['k_key'];
	$role=intval($_REQUEST['fk_role']);
	$sql3 = $sqlserver->prepare("update t_user set FK_ROLE=? where K_KEY= ? ");	   
	$result= $sql3->execute(array($role,$key)) or die(var_dump($sql3->errorInfo())); 
	if($result)
	{
		echo json_encode(array("result"=>"ok"));
	}
	else{
		echo json_encode(array("result"=>"error"));
	}
}
if($_REQUEST['fct']=="VerifyMDP")
{
$key=$_REQUEST['k_key'];
$password=$_REQUEST['password'];
$sqlprofil =$sqlserver->prepare("select * from t_user where K_KEY=?");
$sqlprofil->execute(array($key)) or die (print_r($sqlprofil->errorInfo()));
$ConnectedUser=$sqlprofil->fetchObject();
$sqlprofil->closeCursor();
$S_PASSWORD_BASE=mc_decrypt($ConnectedUser->S_PASSWORD,ENCRYPTION_KEY);


if($S_PASSWORD_BASE==$password)
{
	echo json_encode(array("result"=>"ok"));
}
else{
	echo json_encode(array("result"=>"error"));
}

}
if($_REQUEST['fct']=="DeleteInvitedUser")
{
	$USER_KEY=$_REQUEST['k_key'];
	$PK_USER=$_REQUEST['pk_user'];
	$BROWSER=$_REQUEST['browser'];
	$INVITED_USER_KEY=$_REQUEST['key_invited'];
	$sqlprofil =$sqlserver->prepare("select * from t_user where K_KEY=?");
	$sqlprofil->execute(array($INVITED_USER_KEY)) or die (print_r($sqlprofil->errorInfo()));
	$User=$sqlprofil->fetchObject();
	$sqlprofil->closeCursor();

	$sqlprofillog =$sqlserver->prepare("delete from t_log where FK_USER=?");
	$sqlprofillog->execute(array($User->PK_USER)) or die (print_r($sqlprofillog->errorInfo()));
	$sqlprofillog =$sqlserver->prepare("delete from t_user_log_connexion where FK_USER=?");
	$sqlprofillog->execute(array($User->PK_USER)) or die (print_r($sqlprofillog->errorInfo()));

	$sqlprofil =$sqlserver->prepare("delete from t_user where K_KEY=?");
	$sqlprofil->execute(array($INVITED_USER_KEY)) or die (print_r($sqlprofil->errorInfo()));
	
	$value="utilisateur invité avec le ".$INVITED_USER_KEY." a été supprimé avec succès";
	$sqllog = $sqlserver->prepare("select  PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
	$sqllog->execute(array($value)) or die (print_r($sqllog->errorInfo()));
	$sqlres1 =$sqllog->fetchObject();
	$sqllog->closeCursor();
	if($sqlres1==null)
	{
	$sqlinsertlog =$sqlserver->prepare("insert into t_type_action_log(S_TYPE_ACTION_LOG) VALUES(?)");     
	$sqlinsertlog->execute(array($value)) or die(var_dump($sqlinsertlog->errorInfo()));
	$sqllog1 = $sqlserver->prepare("select  PK_TYPE_ACTION_LOG from t_type_action_log where S_TYPE_ACTION_LOG like ?");
	$sqllog1->execute(array($value)) or die (print_r($sqllog1->errorInfo()));
	$sqlres2 = $sqllog1->fetchObject();
	$sqllog1->closeCursor();
	if($sqlres2->PK_TYPE_ACTION_LOG > 0)
	{
		$S_IP=$_SERVER['REMOTE_ADDR'];
		$datee=date('Y-m-d H:i:s');
		$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
		$sqlinsertlog2->execute(array($sqlres2->PK_TYPE_ACTION_LOG,$datee,$PK_USER,NULL,$S_IP,$BROWSER)) or die(var_dump($sqlinsertlog2->errorInfo()));
	}
	}
	else{
		$S_IP=$_SERVER['REMOTE_ADDR'];
		$datee=date('Y-m-d H:i:s');
		$sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
		$sqlinsertlog2->execute(array($sqlres1->PK_TYPE_ACTION_LOG,$datee,$PK_USER,NULL,$S_IP,$BROWSER)) or die(var_dump($sqlinsertlog2->errorInfo()));
	}
	$sqlprofil =$sqlserver->prepare("select * from t_user where K_KEY=?");
	$sqlprofil->execute(array($INVITED_USER_KEY)) or die (print_r($sqlprofil->errorInfo()));
	$InvitedUser=$sqlprofil->fetchObject();
	$sqlprofil->closeCursor();
	if($InvitedUser==null)
	{
		echo json_encode(array("result"=>"ok"));
	}
	else{
		echo json_encode(array("result"=>"error"));
	}

}


//regenerate a random key for  user
if($_REQUEST['fct']=='generateKey'){
	$pk_user=$_REQUEST['pk_user'];
	$k_key=$_REQUEST['k_key'];
	$nouveau_key=generateRandomString(90);
	$sql3 = $sqlserver->prepare("update t_user set S_API_KEY=? where K_KEY= ? and PK_USER=? ");	   
	$result= $sql3->execute(array($nouveau_key,$k_key,$pk_user)) or die(var_dump($sql3->errorInfo())); 
	if($result)
	{
		echo json_encode(array("result"=>"ok"));
	}
	else{
		echo json_encode(array("result"=>"error"));
	}

}



if($_REQUEST['fct']=='UserStatusUpdate'){
	$sqlprofil = $sqlserver->prepare("update t_user set S_USER_STATUS=? where K_KEY=?");
	$sqlprofil->execute(array(intval($_REQUEST['status']),$_REQUEST['K_KEY'])) or die (print_r($sqlprofil->errorInfo()));
	//$UpdateConnected_User=$sqlprofil->fetchObject();
	$sqlprofil->closeCursor();
}

?>