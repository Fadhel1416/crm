<?php
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once "config.inc.php";
include_once "commun.inc.php"; 
date_default_timezone_set('Europe/Paris');
$b = new MongoClient("localhost:37011");
$db = $b->crm; // select db 
$campaign = $db->t_campaign;
$sequence = $db->t_sequence;
$ticket = $db->t_ticket;
$ticketReply=$db->t_ticket_reply;
$email=$db->t_email_ticket_send;
$noti=$db->t_notification;
$lead = $db->t_lead;


$data = '{"companyName":"Piedpiper","userId":"214874878"}';
global $sqlserver;


//this function for generate key for user............................
function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength=strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//this function for ticket...........................
function generateSlug($length = 25) {
  $characters = '012597846dnpABHKSS';
  $charactersLength=strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  } 
  return $randomString;   
}



//function to insert data in log Table.............................................................
function insertLog($value,$camp_id,$pk_user,$browser)
{
    global $sqlserver;
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
    $sqlinsertlog2 =$sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
    $sqlinsertlog2->execute(array($sqlres2->PK_TYPE_ACTION_LOG,$datee,$pk_user,$camp_id,$S_IP,$browser)) or die(var_dump($sqlinsertlog2->errorInfo()));
    }
    else{
        echo '0';
    }
    }
    else{
    $S_IP=$_SERVER['REMOTE_ADDR'];
    $datee=date('Y-m-d H:i:s');
    $sqlinsertlog2 = $sqlserver->prepare("insert into t_log(FK_TYPE_ACTION_LOG,D_DATE_LOG,FK_USER,ID_CAMPAiIGN,S_IP,S_BROWSER) VALUES(?,?,?,?,?,?)");     
    $sqlinsertlog2->execute(array($sqlres1->PK_TYPE_ACTION_LOG,$datee,$pk_user,$camp_id,$S_IP,$browser)) or die(var_dump($sqlinsertlog2->errorInfo()));

    }
    
}
function get_lundi_dimanche_from_week($week,$year,$format="d-m-Y") {

    $firstDayInYear=date("N",mktime(0,0,0,1,1,$year));
    if ($firstDayInYear<6)
    $shift=-($firstDayInYear-1)*86400;
    else
    $shift=(8-$firstDayInYear)*86400;
    if ($week>1) $weekInSeconds=($week-1)*604800; else $weekInSeconds=0;
    $timestamp=mktime(0,0,0,1,1,$year)+$weekInSeconds+$shift;
    $timestamp_dimanche=mktime(0,0,0,1,8,$year)+$weekInSeconds+$shift;
    
    return array(date("d",$timestamp),date("d",$timestamp_dimanche),date("m",$timestamp),date("m",$timestamp_dimanche),date("y",$timestamp),date("y",$timestamp_dimanche));
    
    }

// Get Data for Last week for date

function getlast_lundi_dimanche_from_week($week,$year,$format="d-m-Y") {

  $firstDayInYear=date("N",mktime(0,0,0,1,1,$year));
  if ($firstDayInYear<7)
  $shift=-($firstDayInYear-1)*86400;
  else
  $shift=(8-$firstDayInYear)*86400;
  if ($week>1) $weekInSeconds=($week-1)*604800; else $weekInSeconds=0;
  $timestamp=mktime(0,0,0,1,1,$year)+$weekInSeconds+$shift;
  $timestamp_dimanche=mktime(0,0,0,1,7,$year)+$weekInSeconds+$shift;
  
  return array(date("d",$timestamp),date("d",$timestamp_dimanche),date("m",$timestamp),date("m",$timestamp_dimanche),date("y",$timestamp),date("y",$timestamp_dimanche));
  
  }

  function getIpAdresse(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }

  $clientip=getIpAdresse();

if($_REQUEST['fct'] == 'addCamp')
{
    $data = $_REQUEST["data"];
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    // Convert JSON to a PHP array
    $campinfo = json_decode($data);
    echo "<pre>";
    var_dump($leadinfo);
    echo "</pre>";
    //$leadinfo = (array) $leadinfo;
    $campaign->insert($campinfo);
//}
$idcamp=$campaign->find(array('userId'=>''.$_REQUEST["pk_user"]));
foreach($idcamp as $doc){
    $camp_id =  json_decode(json_encode($doc["_id"]), true);
    $id= $camp_id['$id'];
    $name=$doc["companyName"];
    }
    $value="Nouvelle compagne pour user avec clé ".$_REQUEST["k_key"]." a été créé avec succès";
    $pk_user=$_REQUEST['pk_user'];
    $browser=$_REQUEST['browser'];

    insertLog($value,$id,$pk_user,$browser);
    }
    if($_REQUEST['fct'] == 'UpdateCamp')
    {   
        
        $data = $_POST['data'];
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        // Convert JSON to a PHP array
        $campinfo = json_decode($data);
        echo "<pre>";
        var_dump($campinfo);
        echo "</pre>";

        $camp_id =  $_REQUEST['camp_id'];

        $cursor = $campaign->update(
                                array('_id'=> new MongoId($camp_id)),
                                array(
                                '$set' => $campinfo
                                )
                            );
    $cursorfind = $campaign->findOne(array('_id' => new MongoId($camp_id)));
    $cursorfind=(array) $cursorfind;
    $value="Campagne avec le nom ".$cursorfind["companyName"]." a été modifié avec succès";
    $browser=$_REQUEST['browser'];
    $pk_user=$_REQUEST['pk_user'];

    insertLog($value,$camp_id,$pk_user,$browser);


}
if($_REQUEST['fct'] == 'InfoCampagne')
{   
    

    $camp_id =  $_REQUEST['camp_id'];
    $cursor = $campaign->findOne(array('_id' => new MongoId($camp_id)));
     echo json_encode($cursor);
}


if($_REQUEST['fct'] == 'DeleteCampagne')
{  
    $camp_id =  $_REQUEST['camp_id'];
    $cursorfind = $campaign->findOne(array('_id' => new MongoId($camp_id)));
    $cursorfind=(array) $cursorfind;
    $deleteResult = $campaign->remove(array('_id' => new MongoId($camp_id)));
    
    $value="Campagne avec le nom ".$cursorfind["companyName"]." a été supprimé avec succès";
    $browser=$_REQUEST['browser'];
    $pk_user=$_REQUEST['pk_user'];


    insertLog($value,$camp_id,$pk_user,$browser);

    echo json_encode($deleteResult);
}
if($_POST['fct'] == 'verifcamp')
{  
    $camp_id =  $_POST['camp_id'];
    $cursor = $campaign->findOne(array('_id' => new MongoId($camp_id)));
    $status=0;
    
    if($cursor["status"] == 1){
        $status=0;
    }
    else {
        $status=1;
    }
    $data = array('companyName' =>$cursor["companyName"],
    'userId'  =>'1','status'=>$status);
   // $data={"companyName":$_POST["firstName"],"userId":"1"};


 $updateresult = $campaign->update(
    array('_id'=> new MongoId($camp_id)),
    array(
   '$set' => $data
   )
  );
  echo json_encode($updateresult);


}

if($_REQUEST['fct'] == 'addSeq')
{
    $data = $_REQUEST["data"];
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    // Convert JSON to a PHP array
    $seqinfo = json_decode($data);
    echo "<pre>";
    var_dump($seqinfo);
    echo "</pre>";
    $sequence->insert($seqinfo);
    $camp_id=$_REQUEST['camp_id'];
    $cursorfind = $campaign->findOne(array('_id' => new MongoId($camp_id)));
    $cursorfind=(array) $cursorfind;
    $value="Nouvelle Sequence pourle compagne ".$cursorfind["companyName"]." a été créé avec succès";
    $browser=$_REQUEST['browser'];
    $pk_user=$_REQUEST['pk_user'];

    insertLog($value,$camp_id,$pk_user,$browser);

}

if($_REQUEST['fct'] == 'ListSequence')
{   
    
    $result =[];

    $user_id =  $_REQUEST['user_id'];
    $companyID=$_REQUEST['company_id'];

    $cursor = $sequence->find(array('userId' => $user_id,'CAMP_ID'=>$companyID))->sort(array('POSITION'=>1));
                          
      foreach ($cursor as $document) 
        {  
         
          $id =  json_decode(json_encode($document["_id"]), true);
          array_push($result,$document);
        

        }
      echo json_encode($result);
}

if($_REQUEST['fct'] == 'SequenceInfo')
{  

    $Seq_id =  $_REQUEST['Seq_id'];

    $cursor = $sequence->findOne(array('_id' => new MongoId($Seq_id)));

     echo json_encode($cursor);
   
}

if($_REQUEST['fct'] == 'UpdateSequence')
{   
    $data = $_REQUEST["data"];
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    // Convert JSON to a PHP array
    $seqinfo = json_decode($data);
    echo "<pre>";
    var_dump($seqinfo);
    echo "</pre>";

    $seq_id =  $_REQUEST['SeqID'];

    $cursor = $sequence->update(
                                array('_id'=> new MongoId($seq_id)),
                                array(
                                    '$set' => $seqinfo
                                )
                            );
    $cursorfind=$sequence->findOne(array('_id' => new MongoId($seq_id)));
    $cursorfind=(array)$cursorfind;
    $cursorfind2 = $campaign->findOne(array('_id' => new MongoId($cursorfind['CAMP_ID'])));
    $cursorfind2=(array)$cursorfind2;
    $value="Sequence pour le compagne ".$cursorfind2["companyName"]." a été modifié avec succès";
    $browser=$_REQUEST['browser'];
    $pk_user=$_REQUEST['pk_user'];

    insertLog($value,$cursorfind['CAMP_ID'],$pk_user,$browser);
    
}

if($_REQUEST['fct'] == 'DeleteSequence')
{  
    $seq_id =  $_REQUEST['seq_id'];
    $cursorfind=$sequence->findOne(array('_id' => new MongoId($seq_id)));
    $cursorfind=(array)$cursorfind;
    $deleteResult = $sequence->remove(array('_id' => new MongoId($seq_id)));
    $cursorfind2 = $campaign->findOne(array('_id' => new MongoId($cursorfind['CAMP_ID'])));
    $cursorfind2=(array)$cursorfind2;
    $value="Sequence pour le compagne ".$cursorfind2["companyName"]." a été supprimé avec succès";
    $browser=$_REQUEST['browser'];
    $pk_user=$_REQUEST['pk_user'];
    
    insertLog($value,$cursorfind['CAMP_ID'],$pk_user,$browser);

    echo json_encode($deleteResult);
}

if($_REQUEST['fct'] == 'UpdatePosition')
{   
    $data = $_REQUEST["data"];
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    // Convert JSON to a PHP array
    $seqinfo = json_decode($data);
    echo "<pre>";
    var_dump($seqinfo);
    echo "</pre>";

    $seq_id =  $_REQUEST['SeqID'];

    $cursor = $sequence->update(
                                array('_id'=> new MongoId($seq_id)),
                                array(
                                    '$set' => $seqinfo
                                )
                            );

    $cursorfind=$sequence->findOne(array('_id' => new MongoId($seq_id)));
    $cursorfind=(array)$cursorfind;
    $cursorfind2 = $campaign->findOne(array('_id' => new MongoId($cursorfind['CAMP_ID'])));
    $cursorfind2=(array)$cursorfind2;
    $value="Position d'une  sequence pour compagne ".$cursorfind2["companyName"]." a été modifié avec succès";
    $browser=$_REQUEST['browser'];
    $pk_user=$_REQUEST['pk_user'];

    insertLog($value,$cursorfind['CAMP_ID'],$pk_user,$browser);


    
}
if($_REQUEST['fct']=="UpdateDelaiSequence")
{
    $delai = $_REQUEST["delai"];
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    // Convert JSON to a PHP array
    $seqinfo = json_decode($data);
    echo "<pre>";
    var_dump($seqinfo);
    echo "</pre>";

    $seq_id =  $_REQUEST['SeqID'];
    $cursorfind=$sequence->findOne(array('_id' => new MongoId($seq_id)));
    $cursorfind=(array)$cursorfind;
    $cursorfind["NB_JOURS"]=$delai;
    $cursor = $sequence->update(
                                array('_id'=> new MongoId($seq_id)),
                                array(
                                    '$set' => $cursorfind
                                )
                            );
    $cursorfind=$sequence->findOne(array('_id' => new MongoId($seq_id)));
    $cursorfind=(array)$cursorfind;
    $cursorfind2 = $campaign->findOne(array('_id' => new MongoId($cursorfind['CAMP_ID'])));
    $cursorfind2=(array)$cursorfind2;
    $value="Delai for Sequence pour le compagne ".$cursorfind2["companyName"]." a été modifié avec succès";
    $browser=$_REQUEST['browser'];
    $pk_user=$_REQUEST['pk_user'];

    insertLog($value,$cursorfind['CAMP_ID'],$pk_user,$browser);

}
if($_REQUEST['fct'] == 'TicketAdd')
{
        $data = $_POST['data'];
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        // Convert JSON to a PHP array
        $ticketinsert=json_decode($data);
        echo "<pre>";
        var_dump($ticketinsert);
        echo "</pre>";


        $pk_user=$_REQUEST['id_user'];
    
        //$campany = $camp->findOne(array('_id' =>new MongoId($_POST['cmpid'])));
        $ticketinsert=(array) $ticketinsert;
    // $leadinsert["campaign_id"]=$_POST['cmpid'];
        //$leadinsert["companyName"]=$campany['companyName'];
        $ticketinsert["status"]=1;// donnee le status new a votre ticket par default
        $ticketinsert["idUser"]=intval($_REQUEST["id_user"]);
        $ticketinsert["DATE_ADD_TICKET"]=date('y-m-d');
        $ticketinsert["DATE_MODIF_TICKET"]=date('y-m-d');
        $ticketinsert["time"]=date('h:i:s');
        $ticketinsert["TIME_MODIF_TICKET"]=date('h:i:s');
        $ticketinsert["slug"]=generateSlug(10);
        $ticketinsert["source"]="Website";

        $gg=$ticket->insert($ticketinsert);
        $clients_nb_tickets=$ticket->find(array('email'=>$ticketinsert["email"]))->count();
        $URLP= "https://www.yestravaux.com/webservice/crm/mail_ticket.php";  
        $S_FROM = "";
        $POSTVALUE= "name=".$ticketinsert["nom"]."&message=TicketCreations&nb_demande=".$clients_nb_tickets."&lien=https://desk.hosteur.pro/tickets/ticket_reply.php?id_ticket=".$ticketinsert["_id"];
        $S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
        $S_SUBJECT= "Ticket reçu - ".$ticketinsert["object"];
        $S_MAIL = array();	
        $S_MAIL['S_FROM'] = $S_FROM;
        $S_MAIL['S_NAME_FROM'] = $S_FROM." <support@desk.com>"; 
        $S_MAIL['S_REPLYTO_EMAIL'] = "support@desk.com";
        $S_MAIL['S_TO_NAME'] =$ticketinsert["nom"];
        $S_MAIL['S_TO'] =$ticketinsert["email"];
        $S_MAIL['S_SUBJECT'] = base64_encode(urlencode ($S_SUBJECT)); 
        $S_MAIL['S_BODY'] = base64_encode(urlencode ($S_TEMPLATE));
        $S_MAIL['S_BODYTXT'] = "";
        $S_MAIL = json_encode ($S_MAIL);		
        $URLP = "http://trs.emailsolar.net/webservice/index.php";
        $POSTVALUE= "fct=EmailPush&S_MAIL=".$S_MAIL."&B_POOL_DESK=1";
        $resultat= curl_do_post($URLP,$POSTVALUE);	
        $tt=json_decode($resultat);
        $tt=(array) $tt;
       /* if($tt["success"]==1)
        {
          $emails["DATE_ADD_EMAIL"]=date('y-m-d');
          $emails["TIME_ADD_EMAIL"]=date('h:i:s');
          $emails["receiver_email"]=$ticketinsert["email"];
          $emails["receiver_nom"]=$ticketinsert["nom"];
          $emails["object"]=$S_SUBJECT;
          $emails["contenu"]=$ticketinsert["nom"];
          $emails["id_ticket"]=$ticketinsert["_id"];
          $emails["idUser"]=$ticketinsert["idUser"];
          $email->insert($emails);
            echo "ok";
        }*/

        //ajout de real time Notification lors de la creation d'une ticket...........

         
        $notification["notification_subject"]="Ticket pour".$ticketinsert["nom"];
        $notification["notification_text"]="Le client" .$ticketinsert["nom"]." a envoyé une demande ";
        $notification["status"]=0;
        $notification["ip"]=$clientip;
        $notification["date_creation"]=date('y-m-d h:i:s');
        $notification["ticket_id"]=$ticketinsert["_id"];
        $notification["pk_user"]=$pk_user;

        $noti->insert($notification);

       


    
    }



    if($_REQUEST['fct']=='Emails_List'){

      $pk_user=$_REQUEST["PK_USER"];
        $tt=$ticket->find()->count();
        if($tt==1){
            $emails= $email->findOne(array('idUser'=>intval($pk_user)));
        }
        else{
            $emails= $email->find(array('idUser'=>intval($pk_user)));
            }
        $result=[];
        if($tt==1)
        {
            $email_id =  json_decode(json_encode($tickets["_id"]), true);
            $id= $email_id['$id'];
            $array_email["_id"]=$id;
            $array_email["receiver_email"]=$emails["receiver_email"];
            $array_email["object"]=$emails["object"];
            $array_email["contenu"]=$emails["contenu"];
            $array_email["DATE_ADD_Email"]=$emails["DATE_ADD_TICKET"];
            $array_email["time"]=$emails["time"];
            array_push($result,$arrayTicket);

        } else {
        foreach($tickets as $document)
            {

                $ticket_id =  json_decode(json_encode($document["_id"]), true);
                $id= $ticket_id['$id'];
                $arrayTicket["_id"]=$id;
                $arrayTicket["email"]=$document["email"];
                $arrayTicket["object"]=$document["object"];
                $arrayTicket["status"]=$document["status"];
                $arrayTicket["DATE_ADD_TICKET"]=$document["DATE_ADD_TICKET"];
                $arrayTicket["time"]=$document["time"];
                array_push($result,$arrayTicket);
            }
        
        }

        echo json_encode($result);




    }


    if($_REQUEST['fct'] =="TicketList"){

        $pk_user=$_REQUEST["PK_USER"];
        $tt=$ticket->find()->count();
        if($tt==1){
            $tickets= $ticket->findOne(array('idUser'=>intval($pk_user)));
        }
        else{
            $tickets= $ticket->find(array('idUser'=>intval($pk_user)));
            }
        $result=[];
        if($tt==1)
        {
            $ticket_id =  json_decode(json_encode($tickets["_id"]), true);
            $id= $ticket_id['$id'];
            $arrayTicket["_id"]=$id;
            $arrayTicket["email"]=$tickets["email"];
            $arrayTicket["object"]=$tickets["object"];
            $arrayTicket["status"]=$tickets["status"];
            $arrayTicket["DATE_ADD_TICKET"]=$tickets["DATE_ADD_TICKET"];
            $arrayTicket["time"]=$tickets["time"];
            if(array_key_exists('source',$tickets))
            {
              $arrayTicket["source"]=$tickets["source"];
            }
            else{
              $arrayTicket["source"]="Website";

            }
    
            array_push($result,$arrayTicket);

        } else {
        foreach($tickets as $document)
            {

                $ticket_id =  json_decode(json_encode($document["_id"]), true);
                $id= $ticket_id['$id'];
                $arrayTicket["_id"]=$id;
                $arrayTicket["email"]=$document["email"];
                $arrayTicket["object"]=$document["object"];
                $arrayTicket["status"]=$document["status"];
                $arrayTicket["DATE_ADD_TICKET"]=$document["DATE_ADD_TICKET"];
                $arrayTicket["time"]=$document["time"];
                if(array_key_exists('source',$document))
                {
                  $arrayTicket['source']=$document["source"];
                }
                else{
                  $arrayTicket["source"]="Website";
    
                }
        
                array_push($result,$arrayTicket);
            }
        
        }
      
        echo json_encode($result);
    }



    if($_REQUEST['fct'] == "GetMessageTicket")
    {
        $id_ticket=$_REQUEST["id_ticket"];
        $ticket_info=$ticket->findOne(array('_id'=> new MongoId($id_ticket)));
        $result=[];
        $arrayTicket["_id"]=$id_ticket;
        $arrayTicket["email"]=$ticket_info["email"];
        $arrayTicket["object"]=$ticket_info["object"];
        $arrayTicket["body"]=$ticket_info["body"];

        $arrayTicket["status"]=$ticket_info["status"];
        $arrayTicket["DATE_ADD_TICKET"]=$ticket_info["DATE_ADD_TICKET"];
        $arrayTicket["time"]=$ticket_info["time"];
        $arrayTicket["nom"]=$ticket_info["nom"];
        $arrayTicket["prenom"]=$ticket_info["prenom"];
        $arrayTicket["idUser"]=$ticket_info["idUser"];




        //array_push($result,$arrayTicket);
       echo json_encode($arrayTicket);
    }

    if($_REQUEST['fct']=="TicketReplyAdd"){
        $message=$_REQUEST["message"];
        $ticket_id=$_REQUEST["id_ticket"];
        $ticket_info=$ticket->findOne(array('_id'=> new MongoId($ticket_id)));
        $sqllog = $sqlserver->prepare("select * from t_user where PK_USER = ?");
        $sqllog->execute(array($ticket_info['idUser'])) or die (print_r($sqllog->errorInfo()));
        $sqlres1 = $sqllog->fetchObject();
        $sqllog->closeCursor();  
        $commenter=$sqlres1->S_NAME;
        $Reply=[];
        $Reply["id_ticket"]=$ticket_id;
        $Reply["body"]=$message;
        $Reply["DATE_ADD_REPLY"]=date('y-m-d');
        $Reply["time"]=date('h:i:s');
        $Reply["ticket_client_key"]=generateRandomString(50);
        $Reply["sender"]=$_REQUEST["sender"];
        $Reply["idUser"]=$ticket_info["idUser"];

         if($_REQUEST["sender"]=="admin"){
           if($ticket_info["status"]==1 || $ticket_info["status"]==3){
            $ticket_info["status"]=3;
            $ticket_info["DATE_MODIF_TICKET"]=date('y-m-d');
            $ticket_info["TIME_MODIF_TICKET"]=date('h:i:s');

            $cursor = $ticket->update(
                array('_id'=> new MongoId($ticket_id)),
                array(
                    '$set' => $ticket_info
                )
            );
           }
         }
         else{
            if($ticket_info["status"]==3 || $ticket_info["status"]==4){
                $ticket_info["status"]=4;
                $ticket_info["DATE_MODIF_TICKET"]=date('y-m-d');
                $ticket_info["TIME_MODIF_TICKET"]=date('h:i:s');
                $cursor = $ticket->update(
                    array('_id'=> new MongoId($ticket_id)),
                    array(
                        '$set' => $ticket_info
                    )
                );
               }
         }
       


        $result_insert=$ticketReply->insert($Reply);
        if($result_insert){
            if($_REQUEST["sender"]=="admin"){
            $URLP= "https://www.yestravaux.com/webservice/crm/mail_ticket.php";  
            $S_FROM = "";
            $POSTVALUE= "name=".$ticket_info["nom"]."&message=TicketReply"."&url=https://desk.hosteur.pro/tickets/ticket_reply.php?tic_client_key=".$Reply["ticket_client_key"]."&body=".$message."&commenter=".$commenter;
            $S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
            $S_SUBJECT= "Retour a votre reclamations";
            $S_MAIL = array();	
            $S_MAIL['S_FROM'] = $S_FROM;
            $S_MAIL['S_NAME_FROM'] = $S_FROM." <support@desk.com>"; 
            $S_MAIL['S_REPLYTO_EMAIL'] = "support@desk.com";
            $S_MAIL['S_TO_NAME'] =$ticket_info["nom"];
            $S_MAIL['S_TO'] =$ticket_info["email"];
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
        else{
            echo "ok"; 
        }

            }
        }


    if($_REQUEST['fct']=="GetMessagesTicket")
    {
        $id_ticket=$_REQUEST["id_ticket"];
        $tt=$ticketReply->find()->count();
        if($tt==1){
            $message_reply=$ticketReply->findOne(array('id_ticket'=>$id_ticket));
        }
        else{
            $message_reply=$ticketReply->find(array('id_ticket'=>$id_ticket));
        }
        $result=[];
        if($tt==1)
        {
            $message_id =  json_decode(json_encode($message_reply["_id"]), true);
            $id= $message_id['$id'];
            $ReplyTicket["_id"]=$id;
            $ReplyTicket["id_ticket"]=$message_reply["id_ticket"];
            $ReplyTicket["sender"]=$message_reply["sender"];
            $ReplyTicket["body"]=$message_reply["body"];
            $ReplyTicket["DATE_ADD_REPLY"]=$message_reply["DATE_ADD_REPLY"];
            $ReplyTicket["time"]=$message_reply["time"];

            array_push($result,$ReplyTicket);

        } else {
        foreach($message_reply as $document)
            {

            $message_id =  json_decode(json_encode($document["_id"]), true);
            $id= $message_id['$id'];
            $ReplyTicket["_id"]=$id;
            $ReplyTicket["id_ticket"]=$document["id_ticket"];
            $ReplyTicket["sender"]=$document["sender"];
            $ReplyTicket["body"]=$document["body"];
            $ReplyTicket["DATE_ADD_REPLY"]=$document["DATE_ADD_REPLY"];
            $ReplyTicket["time"]=$document["time"];
            array_push($result,$ReplyTicket);
            }    
        }

        echo json_encode($result);
           


    }


    //get ticket associated to the client key
    if($_REQUEST['fct']=="GetTickets")
    {
        $tic_client_key=$_REQUEST['tic_client_key'];
        $reply=$ticketReply->findOne(array('ticket_client_key'=>$tic_client_key));
        echo json_encode($reply);

    }

// get lists tickets for client by his email
    if($_REQUEST['fct']=="GetList_tickets"){
      $id_ticket=$_REQUEST["id_ticket"];


      $ticket_found=$ticket->findOne(array('_id'=> new MongoId($id_ticket)));

      $list_ticket=$ticket->find(array('email'=>$ticket_found["email"]));
    $tab=[];
      foreach($list_ticket as $doc)
      {
        $ticket_id =  json_decode(json_encode($doc["_id"]), true);
        $ticid= $ticket_id['$id'];


        $result["id_ticket"]=$ticid;
        $result["nom"]=$doc["nom"];
        $result["prenom"]=$doc["prenom"];
        $result["Ticket_Creation_Date"]=$doc["DATE_ADD_TICKET"];
        $result["status"]=$doc["status"];
        $result["time"]=$doc["time"];
        $result["object"]=$doc["object"];
        $result["slug"]=$doc["slug"];

        array_push($tab,$result);

      }
      echo json_encode($tab);

    }
    


     //update status of ticket...........................
    if($_REQUEST['fct']=="UpdateTicketStatus"){
        $ticket_id=$_REQUEST["ticket_id"];
        $status_val=$_REQUEST["status_ticket"];
        $cursor_ticket = $ticket->findOne(array('_id' => new MongoId($ticket_id)));
        $cursor_ticket["status"]=intval($status_val);
        $cursor_ticket["DATE_MODIF_TICKET"]=date('y-m-d');
        $cursor_ticket["TIME_MODIF_TICKET"]=date('h:i:s');
        $cursor=$ticket->update(
                          array('_id'=> new MongoId($ticket_id)),
                            array(
                            '$set' =>$cursor_ticket
                            ));

                if($cursor != null){
                    echo json_encode(array("result"=>"ok"));          
                }
       
    }

    //statistique sur le tickets nouveau,en cour et ouvert
    if($_REQUEST['fct']=="GetNumberTicket"){ // get today status tickets.......
        $pk_user=intval($_REQUEST['PK_USER']);
        $total_ticket=$ticket->find(array('idUser'=>$pk_user))->count();
        $annee=date('y');
        $mois=date('m');
        $day=date('d'); 
        $new_ticket=$ticket->find(array('idUser'=>$pk_user,'status'=>1,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$day))->count();
        $pending_ticket=$ticket->find(array('idUser'=>$pk_user,'status'=>3,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$day))->count();
        $opening_ticket=$ticket->find(array('idUser'=>$pk_user,'status'=>4,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$day))->count();
        $resolved_ticket=$ticket->find(array('idUser'=>$pk_user,'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$day))->count();
        $result=[];
        $result["total"]=$total_ticket;
        $result["new"]=$new_ticket;
        $result["pending"]=$pending_ticket;
        $result["opened"]=$opening_ticket;
        $result["resolved"]=$resolved_ticket;

        echo json_encode($result);
    }

    // fetch data resolved ticket this week.................. 
    
    if($_REQUEST['fct']=='FetchDataTicketThisWeek')
    {
    
    $tickets=$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
    $TicketResult=[];
    $result=[];
    $resultConverted=[];
    foreach($tickets as $doc)
    {
    
        $ticket_id =  json_decode(json_encode($doc["_id"]), true);
          $ticid= $ticket_id['$id'];
          $debut_fin_semaine = get_lundi_dimanche_from_week(date('W'), date('Y'));
          $firstjoursem= intval($debut_fin_semaine[0]);
          $nbjoursemaine=intval($debut_fin_semaine[1]);
          $mois1=$debut_fin_semaine[2];
          $mois2=$debut_fin_semaine[3];
          $annee1=$debut_fin_semaine[4];
          $annee2=$debut_fin_semaine[5];
          $sum=0;
        /* for($i=$firstjoursem;$i<=$nbjoursemaine;$i++){
            if($i<10){
              $day='0'.$i;
            }
            else{
              $day=''.$i;
            }
          $tasks=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
          $sum+=$leads;}
          $doc["leads_converted"]=$sum;
          array_push($resultConverted,$doc);*/
    
          if($annee1==$annee2)
          {
            if($mois1==$mois2){
          //$annee=date('y');
          $listcount=[];
    
          for($i=$firstjoursem;$i<=$nbjoursemaine;$i++)
          {
            if($i<10)
            {
              $day='0'.$i;
            }
            else{
              $day=''.$i;
            }
    
            $ticket_found=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
              
            array_push($listcount,$ticket_found);
          }
          
        }
        else{
          $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois1),$annee1);
          $listcount=[];
    
          for($i=$firstjoursem;$i<=$nbjour;$i++)
          {
            if($i<10)
            {
              $day='0'.$i;
            }
            else{
              $day=''.$i;
            }
    
            $ticket_found=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_ADD_TICKET'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
              
            array_push($listcount,$ticket_found);
          }
          for($j=1;$j<=$nbjoursemaine;$j++)
          {
            if($j<10)
            {
              $day='0'.$j;
            }
            else{
              $day=''.$j;
            }
    
            $ticket_found=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_ADD_TICKET'=>''.$annee1.'-'.$mois2.'-'.$day))->count();
              
            array_push($listcount,$ticket_found);
          }
    
        }
        // fin if annee egalite
        }
        
        else{
          $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois1),$annee1);
          $listcount=[];
    
          for($i=$firstjoursem;$i<=$nbjour;$i++)
          {
            if($i<10)
            {
              $day='0'.$i;
            }
            else{
              $day=''.$i;
            }
    
            $ticket_found=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_ADD_TICKET'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
              
            array_push($listcount,$ticket_found);
          }
          for($j=1;$j<=$nbjoursemaine;$j++)
          {
            if($j<10)
            {
              $day='0'.$j;
            }
            else{
              $day=''.$j;
            }
    
            $ticket_found=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE__TICKET'=>''.$annee2.'-'.$mois2.'-'.$day))->count();
              
            array_push($listcount,$ticket_found);
          }
    
        }
          $TicketResult["ticketRef"]="Ticket #".$doc["slug"];
          $TicketResult["count_ticket"]=$listcount;
          array_push($result,$TicketResult);
        }

        $data=array( 'result'=>$result);
        echo json_encode($data);
    
      }
      if($_REQUEST['fct']=='FetchDataTicketLastWeek')
      {
      
      $tickets=$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
      $TicketResult=[];
      $result=[];
      $resultConverted=[];
      foreach($tickets as $doc)
      {
      
          $ticket_id =  json_decode(json_encode($doc["_id"]), true);
            $ticid= $ticket_id['$id'];
            $debut_fin_semaine = getlast_lundi_dimanche_from_week(date('W'), date('Y'));
            $firstjoursem= intval($debut_fin_semaine[0]);
            $nbjoursemaine=intval($debut_fin_semaine[1]);
            $mois1=$debut_fin_semaine[2];
            $mois2=$debut_fin_semaine[3];
            $annee1=$debut_fin_semaine[4];
            $annee2=$debut_fin_semaine[5];
            $sum=0;
          /* for($i=$firstjoursem;$i<=$nbjoursemaine;$i++){
              if($i<10){
                $day='0'.$i;
              }
              else{
                $day=''.$i;
              }
            $tasks=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
            $sum+=$leads;}
            $doc["leads_converted"]=$sum;
            array_push($resultConverted,$doc);*/
      
            if($annee1==$annee2)
            {
              if($mois1==$mois2){
            //$annee=date('y');
            $listcount=[];
      
            for($i=$firstjoursem;$i<=$nbjoursemaine;$i++)
            {
              if($i<10)
              {
                $day='0'.$i;
              }
              else{
                $day=''.$i;
              }
      
              $ticket_found=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
                
              array_push($listcount,$ticket_found);
            }
            
          }
          else{
            $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois1),$annee1);
            $listcount=[];
      
            for($i=$firstjoursem;$i<=$nbjour;$i++)
            {
              if($i<10)
              {
                $day='0'.$i;
              }
              else{
                $day=''.$i;
              }
      
              $ticket_found=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
                
              array_push($listcount,$ticket_found);
            }
            for($j=1;$j<=$nbjoursemaine;$j++)
            {
              if($j<10)
              {
                $day='0'.$j;
              }
              else{
                $day=''.$j;
              }
      
              $ticket_found=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee1.'-'.$mois2.'-'.$day))->count();
                
              array_push($listcount,$ticket_found);
            }
      
          }
          // fin if annee egalite
          }
          
          else{
            $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois1),$annee1);
            $listcount=[];
      
            for($i=$firstjoursem;$i<=$nbjour;$i++)
            {
              if($i<10)
              {
                $day='0'.$i;
              }
              else{
                $day=''.$i;
              }
      
              $ticket_found=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
                
              array_push($listcount,$ticket_found);
            }
            for($j=1;$j<=$nbjoursemaine;$j++)
            {
              if($j<10)
              {
                $day='0'.$j;
              }
              else{
                $day=''.$j;
              }
      
              $ticket_found=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee2.'-'.$mois2.'-'.$day))->count();
                
              array_push($listcount,$ticket_found);
            }
      
          }
          $TicketResult["ticketRef"]="Ticket #".$doc["slug"];
            $TicketResult["count_ticket"]=$listcount;
            array_push($result,$TicketResult);
          }
  
          $data=array( 'result'=>$result);
          echo json_encode($data);
      
        }
        if($_REQUEST['fct']=='FetchDataTicketThisMonth'){
          $tickets=$ticket->find(array('idUser'=>intval($_REQUEST["PK_USER"])));
          $result=[];
          $mois=date('m');
          $annee=date('y');
          $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),$annee);

         foreach($tickets as $doc)
         {
           $ticket_id=json_decode(json_encode($doc["_id"]),true);
           $ticid=$ticket_id['$id'];
           $listcount=[];
           for($i=1;$i<=$nbjour;$i++){
            if($i<10){
              $i='0'.$i;
            }
            else{
              $i=''.$i;
            }
            $ticketfound=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$i));
            array_push($listcount,$ticketfound->count());


          }
          $TicketResult["ticketRef"]="Ticket #".$doc["slug"];
          $TicketResult["count_ticket"]=$listcount;
          array_push($result,$TicketResult);
         }
          $data=array('result'=>$result);
          echo json_encode($data);
       
        }

if($_REQUEST['fct']=='FetchDataTicketLastMonth'){
    $this_month=date('m');
    $resultConverted=[];
    if(intval($this_month) != 1)
    {
      $tickets=$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
      $result=[];
      //for the error of februray sur le  -1 month
      if(date('m')=="03"){
        $mois="02";
      }else{
      $mois=date("m", strtotime("-1 month"));
    }
      $annee=date('y');
      $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee); // get number days  of the given year and month
      foreach($tickets as $doc)
      {
        $ticket_id =  json_decode(json_encode($doc["_id"]), true);
        $ticid= $ticket_id['$id'];
        $listcount=[];
        $sum=0;
        for($i=1;$i<=$nbjour;$i++)
        {
          if($i<10){
            $i='0'.$i;
          }
          else{
            $i=''.$i;
          }
          
        $ticketfound=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$i));
        //$leads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i))->count();
        //$sum+=$leads;
        array_push($listcount,$ticketfound->count());
        }
        //$doc["leads_converted"]=$sum;
        //array_push($resultConverted,$doc);
        $TicketResult["ticketRef"]="Ticket #".$doc["slug"];
        $TicketResult["count_ticket"]=$listcount;
        array_push($result,$TicketResult);
    
      }
    
    }
    else{
      $tickets=$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
      $result=[];
      $mois=date("m", strtotime("last month"));// get last month
      $annee=date("y",strtotime("last year"));// get last year
      $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
      foreach($tickets as $doc)
      {
        $ticket_id =  json_decode(json_encode($doc["_id"]), true);
        $ticid= $ticket_id['$id'];
        $listcount=[];
        $sum=0;
        for($i=1;$i<=$nbjour;$i++)
        {
          if($i<10){
            $i='0'.$i;
          }
          else{
            $i=''.$i;
          }
          
          $ticketfound=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$i));
        array_push($listcount,$ticketfound->count());
        }
        //$doc["leads_converted"]=$sum;
        //array_push($resultConverted,$doc);
        $TicketResult["ticketRef"]="Ticket #".$doc["slug"];
        $TicketResult["count_ticket"]=$listcount;
        array_push($result,$TicketResult);
    
      }
    
    }
    
    //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
        'result'=>$result,    
      );
    
    echo json_encode($data);

  }


  if($_REQUEST['fct']=="FetchDataTicketByLastThreeMonth"){
    $result=[];
    $tickets =$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
    foreach($tickets as $doc)
    {
      $ticket_id =  json_decode(json_encode($doc["_id"]), true);
      $ticid= $ticket_id['$id'];
      $listcount=[];
      for ($i = -3; $i <0; $i++){
        $k=$i+1;
        if(date('m', strtotime("$i month"))== date('m', strtotime("$k month"))){
          $mois="02";
  
        }
        else{
          $mois=date('m', strtotime("$i month"));
  
        }
        $annee=date('y',strtotime("$i month"));
        $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),$annee);
        $sum=0;
        for($j=1;$j<=$nbjour;$j++)
        {
          if($j<10){
            $j='0'.$j;
          }
          else{
            $j=''.$j;
          }
          $ticketfound=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$j));
          $sum+=$ticketfound->count();
        }
        array_push($listcount,$sum);
        }
        //$doc["leads_converted"]=$sumpermonth;
        //array_push($resultConverted,$doc);
        $TicketResult["ticketRef"]="Ticket #".$doc["slug"];
        $TicketResult["count_ticket"]=$listcount;
        array_push($result,$TicketResult);
    }
    //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
        'result'=>$result,
      );
      echo json_encode($data);
  }
  if($_REQUEST['fct']=="FetchDataTicketByLastSixMonth"){
    $result=[];
    $tickets =$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
    foreach($tickets as $doc)
    {
      $ticket_id =  json_decode(json_encode($doc["_id"]), true);
      $ticid= $ticket_id['$id'];
      $listcount=[];
      for ($i = -6; $i <0; $i++){
        $k=$i+1;
        if(date('m', strtotime("$i month"))== date('m', strtotime("$k month"))){
          $mois="02";
  
        }
        else{
          $mois=date('m', strtotime("$i month"));
  
        }
        $annee=date('y',strtotime("$i month"));
        $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),$annee);
        $sum=0;
        for($j=1;$j<=$nbjour;$j++)
        {
          if($j<10){
            $j='0'.$j;
          }
          else{
            $j=''.$j;
          }
          $ticketfound=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$j));
          $sum+=$ticketfound->count();
        }
        array_push($listcount,$sum);
        }
        //$doc["leads_converted"]=$sumpermonth;
        //array_push($resultConverted,$doc);
        $TicketResult["ticketRef"]="Ticket #".$doc["slug"];
        $TicketResult["count_ticket"]=$listcount;
        array_push($result,$TicketResult);
    }
    //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
        'result'=>$result,
      );
      echo json_encode($data);
  }
  if($_REQUEST['fct']=="FetchDataTicketThisYear"){
    $result=[];
    $tickets = $ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
    $annee=date('y');
    $campanyName=[];
    $campanycount=[];
  foreach($tickets as $campdoc){
    $ticket_id =  json_decode(json_encode($campdoc["_id"]), true);
    $ticid= $ticket_id['$id'];
    $listcount=[];
    $taskcampany=[];
    $sumpermonth=0;
    for($i=1;$i<=12;$i++){
      if($i<10){
        $mois='0'.$i;
      }
      else{
        $mois=''.$i;
      }
      $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),$annee);
      $sum=0;
      for($j=1;$j<=$nbjour;$j++){
        if($j<10){
          $j='0'.$j;
        }
        else{
          $j=''.$j;
        }
        $ticketfound=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$j));
        $sum+=$ticketfound->count();
      }
    array_push($listcount,$sum);
    //$sumpermonth+=$sum;
        }
        //$campdoc["leads_converted"]=$sumpermonth;
      //array_push($resultConverted,$campdoc);
      $TicketResult["ticketRef"]="Ticket #".$campdoc["slug"];
      $TicketResult["count_ticket"]=$listcount;
      array_push($result,$TicketResult);
  
  }
// $outputconverted=CountConvertedLeads($resultConverted);
  
    $data=array('result'=>$result);
  
  echo json_encode($data);
  }

  if($_REQUEST['fct']=="FetchDataTicketLastYear"){
    $result=[];
    $tickets = $ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
    $annee=date("y",strtotime("last year"));
    $campanyName=[];
    $campanycount=[];
  foreach($tickets as $campdoc){
    $ticket_id =  json_decode(json_encode($campdoc["_id"]), true);
    $ticid= $ticket_id['$id'];
    $listcount=[];
    $taskcampany=[];
    $sumpermonth=0;
    for($i=1;$i<=12;$i++){
      if($i<10){
        $mois='0'.$i;
      }
      else{
        $mois=''.$i;
      }
      $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),$annee);
      $sum=0;
      for($j=1;$j<=$nbjour;$j++){
        if($j<10){
          $j='0'.$j;
        }
        else{
          $j=''.$j;
        }
        $ticketfound=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$j));
        $sum+=$ticketfound->count();
      }
    array_push($listcount,$sum);
    //$sumpermonth+=$sum;
        }
        //$campdoc["leads_converted"]=$sumpermonth;
      //array_push($resultConverted,$campdoc);
      $TicketResult["ticketRef"]="Ticket #".$campdoc["slug"];
      $TicketResult["count_ticket"]=$listcount;
      array_push($result,$TicketResult);
  
  }
// $outputconverted=CountConvertedLeads($resultConverted);
  
    $data=array('result'=>$result);
  
  echo json_encode($data);

  }


  if($_REQUEST['fct']=="FetchDataTicketByMonth")
  {
    $tickets=$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
    $result=[];
    $mois=$_REQUEST['mois'];
    $annee=$_REQUEST['year'];
    $annee=intval($annee)%1000;
    $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
    foreach($tickets as $doc)
    {
      $ticket_id = json_decode(json_encode($doc["_id"]), true);
      $ticid= $ticket_id['$id'];
      $listcount=[];
      $sum=0;
      for($i=1;$i<=$nbjour;$i++)
      {
        if($i<10){
          $i='0'.$i;
        }
        else{
          $i=''.$i;
        }   
        $ticketfound=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$i));
      $sum+=$ticketfound->count();
      array_push($listcount,$ticketfound->count());
      }
      //$doc["leads_converted"]=$sum;
      //array_push($resultConverted,$doc);
      $TicketResult["ticketRef"]="Ticket #".$doc["slug"];
      $TicketResult["count_ticket"]=$listcount;
      array_push($result,$TicketResult);
    }

    $data=array('result'=>$result);

  echo json_encode($data);

  }


  if($_REQUEST['fct']=='FetchDataTicketByYear')
  {

    $result=[];
    $tickets=$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
    
    $annee=$_REQUEST['year'];
    $annee=intval($annee)%1000;
    $campanyName=[];
    $campanycount=[];
  foreach($tickets as $doc){
    $ticket_id =  json_decode(json_encode($doc["_id"]), true);
    $ticid= $ticket_id['$id'];
    $listcount=[];
    for($i=1;$i<=12;$i++){
      if($i<10){
        $mois='0'.$i;
      }
      else{
        $mois=''.$i;
      }
      $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),$annee);
      $sum=0;
      for($j=1;$j<=$nbjour;$j++){
        if($j<10){
          $j='0'.$j;
        }
        else{
          $j=''.$j;
        }
        $ticketfound=$ticket->find(array('_id'=>new MongoId($ticid),'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$j));
        $sum+=$ticketfound->count();
      }
    array_push($listcount,$sum);
        }

        $TicketResult["ticketRef"]="Ticket #".$doc["slug"];
        $TicketResult["count_ticket"]=$listcount;
        array_push($result,$TicketResult);
  }

  //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array('result'=>$result );
  echo json_encode($data);
  }


if($_REQUEST['fct'] =='LoadTicketStatus'){

  $result =[];

  $user_id =  $_REQUEST['user_id'];


  $newticket = $ticket->find(array('idUser' => intval($user_id),'status'=>1))->count();
  $pendingticket = $ticket->find(array('idUser' => intval($user_id),'status'=>3))->count();
  $openedticket = $ticket->find(array('idUser' => intval($user_id),'status'=>4))->count();
  $closedticket = $ticket->find(array('idUser' => intval($user_id),'status'=>2))->count();

  $doc["new"]=$newticket;
  $doc["pending"]=$pendingticket;
  $doc["opened"]=$openedticket;
  $doc["solved"]=$closedticket;


  echo json_encode($doc);//doc is a object

  }


  
if($_REQUEST['fct'] =="LoadTicketClient"){

    $result =[];

    $user_id =  $_REQUEST['user_id'];
    $tickets=$ticket->find(array('idUser'=>intval($user_id)));
    $tab=[];
    $ListClient=[];
    foreach($tickets as $doc)
    {
    if(!in_array($doc["email"],$tab)) {
    $result["NomPrenom"]= $doc["nom"]." ".$doc["prenom"];
    $result["nbTic"]=$ticket->find(array('email'=>$doc["email"]))->count();
    array_push($tab,$doc["email"]);
    array_push($ListClient,$result);
    }
    }
    $output='';
    $result2=[];
    $arraycolor=["#FF4961", "#FF9149","#8a2be2", "#462be2","#c49e36","#c0c0c0","#2be23a","#2f8049", "#FF3061", "#689f38","#650f38", "#FF4961", "#2f8049"];
    if(count($ListClient)<=10)
    {
    for($i=0;$i<count($ListClient);$i++){
    $output.=	'<li>'.$ListClient[$i]["NomPrenom"]. '<span class="badge  ms-2" style="background:'.$arraycolor[$i].'">'.$ListClient[$i]["nbTic"].'</span></li>';

    }
    $result2=$ListClient;
    }
    else
    {
    for($i=0;$i<=10;$i++){
    $output.=	'<li>'.$ListClient[$i]["NomPrenom"]. '<span class="badge ms-2" style="background:'.$arraycolor[$i].'">'.$ListClient[$i]["nbTic"].'</span></li>';
    array_push($result2,$ListClient[$i]);
    }

    }

    echo json_encode(array('output'=>$output,'result'=>$result2));

    }

if($_REQUEST['fct']=="FetchTicketStatByMonth")
{
 // $tickets=$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])));
  $result=[];
  $mois=$_REQUEST['mois'];
  $annee=date('y');
  $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),$annee);
  /*foreach($tickets as $doc)
  {
    $ticket_id = json_decode(json_encode($doc["_id"]), true);
    $ticid= $ticket_id['$id'];
    $listcount=[];
    $sum=0;*/
    $listcount1=[];
    $listcount2=[];
    $listcount3=[];
    $listcount4=[];
    $listcount5=[];
  $admin_id=intval($_REQUEST['PK_USER']);


      for($i=1;$i<=$nbjour;$i++)
      {
        if($i<10){
          $i='0'.$i;
        }
        else{
          $i=''.$i;
        }   
        $ticket_resolved=$ticket->find(array('idUser'=>$admin_id,'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$i));
        $ticket_new=$ticket->find(array('idUser'=>$admin_id,'status'=>1,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$i));
        $ticket_pending=$ticket->find(array('idUser'=>$admin_id,'status'=>3,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$i));
        $ticket_opened=$ticket->find(array('idUser'=>$admin_id,'status'=>4,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$i));
        $ticket_received=$ticket->find(array('idUser'=>$admin_id,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$i));

    // $sum+=$ticketfound->count();
      array_push($listcount1,$ticket_resolved->count());
      array_push($listcount2,$ticket_new->count());
      array_push($listcount3,$ticket_pending->count());
      array_push($listcount4,$ticket_opened->count());
      array_push($listcount5,$ticket_received->count());

      }

      $TicketResult["count_ticket_resolved"]=$listcount1;
      $TicketResult["count_ticket_new"]=$listcount2;
      $TicketResult["count_ticket_pending"]=$listcount3;
      $TicketResult["count_ticket_opened"]=$listcount4;

      $today=$ticket->find(array('DATE_MODIF_TICKET'=>date('y-m-d')))->count();

      $stat_month["nb_resolved"]=array_sum($listcount1);
      $stat_month["nb_new"]=array_sum($listcount2);
      $stat_month["nb_pending"]=array_sum($listcount3);
      $stat_month["nb_opened"]=array_sum($listcount4);
      $stat_month["nb_received"]=array_sum($listcount5);
      $stat_month["nb_total"]=$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])))->count();

      array_push($result,$TicketResult);
    

    $data=array('result'=>$result,'stat'=>$stat_month);

    echo json_encode($data);

  }




  if($_REQUEST['fct']=='FetchTicketStatByYear'){

    $result=[];
    $annee=intval($_REQUEST['year'])%1000;
    //$annee=date('y');
    /*foreach($tickets as $doc)
    {
      $ticket_id = json_decode(json_encode($doc["_id"]), true);
      $ticid= $ticket_id['$id'];
      $listcount=[];
      $sum=0;*/
      $listcount1=[];
      $listcount2=[];
      $listcount3=[];
      $listcount4=[];
      $listcount5=[];
    $admin_id=intval($_REQUEST['PK_USER']);
  
  
        for($i=1;$i<=12;$i++)
        {
          if($i<10){
            $mois='0'.$i;
          }
          else{
            $mois=''.$i;
          }
          $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),$annee);
          $sum_resolved=0;
          $sum_new=0;
          $sum_pending=0;
          $sum_opened=0;
          $sum_received=0;




            for($j=1;$j<=$nbjour;$j++)
            {
              $ticket_resolved=$ticket->find(array('idUser'=>$admin_id,'status'=>2,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$j));
              $ticket_new=$ticket->find(array('idUser'=>$admin_id,'status'=>1,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$j));
              $ticket_pending=$ticket->find(array('idUser'=>$admin_id,'status'=>3,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$j));
              $ticket_opened=$ticket->find(array('idUser'=>$admin_id,'status'=>4,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$j));
              $ticket_received=$ticket->find(array('idUser'=>$admin_id,'DATE_MODIF_TICKET'=>''.$annee.'-'.$mois.'-'.$j));
              $sum_resolved+=$ticket_resolved->count();
              $sum_new+=$ticket_new->count();
              $sum_pending+=$ticket_pending->count();
              $sum_opened+=$ticket_opened->count();
              $sum_received+=$ticket_received->count();

            }
        
  
      // $sum+=$ticketfound->count();
        array_push($listcount1,$sum_resolved);
        array_push($listcount2,$sum_new);
        array_push($listcount3,$sum_pending);
        array_push($listcount4,$sum_opened);
        array_push($listcount5,$sum_received);
  
        }
  
        $TicketResult["count_ticket_resolved"]=$listcount1;
        $TicketResult["count_ticket_new"]=$listcount2;
        $TicketResult["count_ticket_pending"]=$listcount3;
        $TicketResult["count_ticket_opened"]=$listcount4;
  
        $today=$ticket->find(array('DATE_MODIF_TICKET'=>date('y-m-d')))->count();
  
        $stat_month["nb_resolved"]=array_sum($listcount1);
        $stat_month["nb_new"]=array_sum($listcount2);
        $stat_month["nb_pending"]=array_sum($listcount3);
        $stat_month["nb_opened"]=array_sum($listcount4);
        $stat_month["nb_received"]=array_sum($listcount5);
        $stat_month["nb_total"]=$ticket->find(array('idUser'=>intval($_REQUEST['PK_USER'])))->count();
  
        array_push($result,$TicketResult);
      
  
      $data=array('result'=>$result,'stat'=>$stat_month);
  
      echo json_encode($data);



  }

if($_REQUEST['fct']=='CreateTicketFromEmail')
{
  $tickets_list=$ticket->find();
$email=$_REQUEST['email'];
$subject=$_REQUEST['subject'];
$body=$_REQUEST['body'];
$nomPrenom=$_REQUEST['nomPrenom'];
$nom=substr($nomPrenom,0,strpos($nomPrenom,' '));
$prenom=substr($nomPrenom,strpos($nomPrenom,' '));
$ticketinsert=[];
$ticketinsert["nom"]=$nom;
$ticketinsert["prenom"]=$prenom;
$ticketinsert["email"]=$email;
$ticketinsert["object"]=$subject;
$ticketinsert["body"]=$body;
$ticketinsert["status"]=1;// donnee le status new a votre ticket par default
$ticketinsert["idUser"]=intval($_REQUEST["user_id"]);
$ticketinsert["DATE_ADD_TICKET"]=date('y-m-d');
$ticketinsert["DATE_MODIF_TICKET"]=date('y-m-d');
$ticketinsert["time"]=date('h:i:s');
$ticketinsert["TIME_MODIF_TICKET"]=date('h:i:s');
$ticketinsert["slug"]=generateSlug(10);
$ticketinsert["DATE_SEND_EMAIL"]=$_REQUEST['date'];

$ticketinsert["source"]="Email";
// foreach($tickets_list as $doc)
// {

// }

$test=false;
foreach($tickets_list as $doc)
{
    if($doc["nom"]==$nom && $doc["prenom"]==$prenom && $doc["email"]==$email && $doc["object"]==$subject && $doc["body"]==$body && array_key_exists('DATE_SEND_EMAIL', $doc) && $doc['DATE_SEND_EMAIL']==$_REQUEST['date']){

   $test=true;
  }
}
if($test==false)
{
  $gg=$ticket->insert($ticketinsert);
  $clients_nb_tickets=$ticket->find(array('email'=>$email))->count();
  $URLP= "https://www.yestravaux.com/webservice/crm/mail_ticket.php";  
  $S_FROM = "";
  $POSTVALUE= "name=".$nomPrenom."&message=TicketCreations&nb_demande=".$clients_nb_tickets."&lien=https://desk.hosteur.pro/tickets/ticket_reply.php?id_ticket=".$ticketinsert["_id"];
  $S_TEMPLATE= curl_do_post($URLP,$POSTVALUE);
  $S_SUBJECT= "Ticket reçu - ".$subject;
  $S_MAIL = array();	
  $S_MAIL['S_FROM'] = $S_FROM;
  $S_MAIL['S_NAME_FROM'] = $S_FROM." <support@desk.com>"; 
  $S_MAIL['S_REPLYTO_EMAIL'] = "support@desk.com";
  $S_MAIL['S_TO_NAME'] =$ticketinsert["nom"];
  $S_MAIL['S_TO'] =$ticketinsert["email"];
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
    //ajout de real time notifications...............................
    $notification["notification_subject"]="Ticket pour ".$nomPrenom;
    $notification["notification_text"]="Le client" .$nomPrenom." a envoyé une demande par email ";
    $notification["status"]=0;
    $notification["ip"]=$clientip;
    $notification["date_creation"]=date('y-m-d h:i:s');
    $notification["ticket_id"]=$ticketinsert["_id"];
    $notification["pk_user"]=$_REQUEST["user_id"];
    
    $noti->insert($notification);
  
    echo json_encode('1');
  }

}
else{
  echo json_encode("not existe");
}
}


if($_REQUEST['fct']=='DeleteTicket')
{

$tab_ticket_id=$_REQUEST['ticket_id_tab'];
$result=[];
$tab_ticket_id=(array) $tab_ticket_id;
$test=false;
$pk_user=$_REQUEST['pk_user'];
$browser=$_REQUEST['browser'];
for($i=0;$i<count($tab_ticket_id);$i++)
{
  $Detail_ticket=$ticket->findOne(array('_id'=>new MongoId($tab_ticket_id[$i])));

  $deleteresult=$ticket->remove(array('_id'=>new MongoId($tab_ticket_id[$i])));
  if($deleteresult==true)
  {

  /*$List_Ticket_Message=$ticketReply->find(array('id_ticket'=>$tab_ticket_id[$i]));

  if($List_Ticket_Message!=null)
  {

  foreach($List_Ticket_Message as $message)
  {
    $_id =  json_decode(json_encode($doc["_id"]), true);
    $ticid= $ticket_id['$id'];


  }*/
  $value="Ticket Pour ".$Detail_ticket["nom"]." ".$Detail_ticket["prenom"]." a été supprimé avec succès";
  insertLog($value,null,$pk_user,$browser);

  $res=$ticketReply->remove(array('id_ticket'=>$tab_ticket_id[$i]));

  $test=true;

  }
  }
  if($test){
    echo json_encode("All Fine");
  }
  }




    $b->close();


?>