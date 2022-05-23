<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once "config.inc.php";
include_once "commun.inc.php";
date_default_timezone_set('Europe/Paris');
$b = new MongoClient("localhost:37011");
$db = $b->crm; // select db 
$lead = $db->t_lead;
$camp = $db->t_campaign;
$notes=$db->t_note;
$noti=$db->t_notification;
$sequence=$db->t_sequence;
$task=$db->t_task;
global $sqlserver;

$campanoies=$camp->find();
 foreach($campanoies as $document)
 {

  if($document["status"]==1){
  $camp_id =  json_decode(json_encode($document["_id"]), true);
  $campid= $camp_id['$id'];
  $cursorsequence =$sequence->find(array('CAMP_ID'=>$campid));
  $cursorleads =$lead->find(array('campaign_id'=>$campid));

  foreach($cursorleads as $doclead) 
      {  
        $lead_id =  json_decode(json_encode($doclead["_id"]), true);
        $leadid= $lead_id['$id'];
        foreach($cursorsequence as $docseq){
          $seq_id =  json_decode(json_encode($docseq["_id"]), true);
          $seqid= $seq_id['$id'];
          $date=date('y-m-d',strtotime($doclead["DATE_ADD_LEAD"].'+'.$docseq["NB_JOURS"].' day'));
          if(strtotime(date('y-m-d'))===strtotime($date)){
            $tasklist=$task->findOne(array('lead_id'=>$leadid,'action_type'=>$docseq["ACTION_TYPE"],'status'=>"traité",'seq_id'=>$seqid));
            
            if($tasklist==null){
              if($docseq["ACTION_TYPE"]==1)
              {

                $contenu=$docseq["CONTENU"];
                $email=$doclead["email"];
                $URLP= "https://www.yestravaux.com/webservice/crm/mail2.php";  
                  $S_FROM = "YesTravaux";
                $POSTVALUE= "name=".$doclead["nom"]."&message=sendtask"."&url=".$contenu;
                $S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
                $S_SUBJECT= "Confirmations Task";
                $S_MAIL = array();	
                $S_MAIL['S_FROM'] = $S_FROM;
                $S_MAIL['S_NAME_FROM'] = $S_FROM." <support@yestravaux.com>"; 
                $S_MAIL['S_REPLYTO_EMAIL'] = "support@yestravaux.com";
                $S_MAIL['S_TO_NAME'] =$doclead["nom"];
                $S_MAIL['S_TO'] =$email;
                $S_MAIL['S_SUBJECT'] = base64_encode(urlencode ($S_SUBJECT)); 
                $S_MAIL['S_BODY'] = base64_encode(urlencode ($S_TEMPLATE));
                $S_MAIL['S_BODYTXT'] = "";
                $S_MAIL = json_encode ($S_MAIL);		
                $URLP = "http://trs.emailsolar.net/webservice/index.php";
                $POSTVALUE= "fct=EmailPush&S_MAIL=".$S_MAIL."&B_POOL_BATI=1";
                $resultat= curl_do_post($URLP, $POSTVALUE);
                $tt=json_decode($resultat);
                $tt=(array) $tt;
                if($tt["success"]==1)
                {
                  $doc=[];
                $doc["campaign_id"]=$campid;
                $doc["lead_id"]=$leadid;
                $doc["status"]="traité";
                $doc["action_type"]=$docseq["ACTION_TYPE"];
                if(intval($docseq["ACTION_TYPE"])==1){
                  $doc["action"]="EMAIL";
                } 
                else if(intval($docseq["ACTION_TYPE"])==2){
                  $doc["action"]="SMS";
                }
                else{
                  $doc["action"]="CALL";
                }
                $doc["DATE_ADD_TASK"]=date('y-m-d');
                $doc["DATE_MODIF_TASK"]=date('y-m-d');
                
                $doc["time"]=date('h:i:s');
                $doc["seq_id"]=$seqid;
                $task->insert($doc);

                }
                
              }  
                else if($docseq["ACTION_TYPE"]==2)
                {
                  $contenu=$docseq["CONTENU"];
                  $tel=$doclead["phone"];
                  $S_NAME_SMS="Yestravaux";
                  $S_MESSAGE="Bonjour".$doclead["nom"]."".$contenu;
                  $URL = "https://www.yestravaux.com/webservice/sms/index.php";
                  // $URL = "https://www.yestravaux.com/webservice/sms/"; 
                  $POSTVALUE = "fct=SmsSendWL&S_TEL=".$tel."&S_SENDER=".$S_NAME_SMS."&S_MESSAGE=$S_MESSAGE";
                  $var = curl_do_post($URL, $POSTVALUE);
                  $var=substr($var,0,strlen($var)-1);
                  $tt=json_decode($var);
                    $tt=(array) $tt;
                  if($tt["result"]==200)
                  {
                    $doc=[];
                    $doc["campaign_id"]=$campid;
                    $doc["lead_id"]=$leadid;
                    $doc["status"]="traité";
                    $doc["action_type"]=$docseq["ACTION_TYPE"];
                    if(intval($docseq["ACTION_TYPE"])==1){
                      $doc["action"]="EMAIL";
                    } 
                    else if(intval($docseq["ACTION_TYPE"])==2){
                      $doc["action"]="SMS";
                    }
                    else{
                      $doc["action"]="CALL";
                    }
                    $doc["DATE_ADD_TASK"]=date('y-m-d');
                    $doc["DATE_MODIF_TASK"]=date('y-m-d');
                    
                    $doc["time"]=date('h:i:s');
                    $doc["seq_id"]=$seqid;
                    $task->insert($doc);
                  }    

                }
                
                  
                  }
            
              }  
              else if(strtotime(date('y-m-d')) > strtotime($date))
              {
                $tasklist=$task->findOne(array('lead_id'=>$leadid,'action_type'=>$docseq["ACTION_TYPE"],'seq_id'=>$seqid));
                  
                if($tasklist==null){
                
                  $doc=[];
                  $doc["campaign_id"]=$campid;
                  $doc["lead_id"]=$leadid;
                  $doc["status"]="non traité";
                  $doc["action_type"]=$docseq["ACTION_TYPE"];
                  if(intval($docseq["ACTION_TYPE"])==1){
                    $doc["action"]="EMAIL";
                  } 
                  else if(intval($docseq["ACTION_TYPE"])==2){
                    $doc["action"]="SMS";
                  }
                  else{
                    $doc["action"]="CALL";
                  }
                  $doc["DATE_ADD_TASK"]=date('y-m-d');
                  $doc["DATE_MODIF_TASK"]=date('y-m-d');
                  
                  $doc["time"]=date('h:i:s');
                  $doc["seq_id"]=$seqid;
                  $task->insert($doc);
                
                }

      }    
        
        }}

        }

    }

    ?>