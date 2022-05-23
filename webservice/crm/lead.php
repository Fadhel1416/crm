<?php
    header('Access-Control-Allow-Origin: *');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "Auth.php";
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
    $ticketReply=$db->t_ticket_reply;



    global $sqlserver;

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

  /*$data = '{"campaign_id":"1","email":"Hendricks","companyName":"Piedpiper","icebreaker":"Icebreaker text",
      "phone":"(555) 555-1234","picture":"https://piedpiper.com/richard-hendricks.jpg",
      "linkedinUrl":"https://www.linkedin.com/in/richard-hendricks/"}';*/
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

// Get dates for this week..........................................
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

  function CountConvertedLeads($result)
  {
    $convertedLead=[];
    for($i=0;$i<count($result);$i++)
  {
    $max=$result[$i]["leads_converted"];
    for($j=$i+1;$j<count($result);$j++){
      if($result[$j]["leads_converted"] > $max){
        $aux=$max;
        $max=$result[$j]->leads_converted;
        $result[$j]->leads_converted=$aux;
      }
    }
  }
  if(count($result) > 5){

    for($j=0;$j<5;$j++){
    array_push($convertedLead,$result[$j]);    
  }

  }
  else
  {
    $convertedLead=$result;
  }
  if(count($convertedLead)>0){
    $output='';
  foreach($convertedLead as $row)
  {
    if ($row["leads_converted"]>0){
      $class="border-success";
    }
    else{
      $class="border-danger";
    }
    
    $output .= '<a class="media media-single bg-lightest" href="#">
    <div class="media-body ps-15 bs-4 rounded '.$class.'">
    <p class="text-bold">'.$row["companyName"].'.</p>
    </div>
    <div class="media-right">
    <span style="width:85px" class="">'.$row["leads_converted"].'</span>
  </div>

  </a>';
  }
  }
  else{
      $output .= '<a class="media media-single" href="#">
      <div class="media-body ps-15 bs-5 rounded border-dark text-bold">
      You dont have campagnies yet
      </div>
    </a>';
  }


  return $output;

  }

  $clientip=getIpAdresse();


  function VerifUserKey($ApiKey)
  {
    global $sqlserver;
    $sqllog = $sqlserver->prepare("select * from t_user where S_API_KEY=?");
    $sqllog->execute(array($ApiKey)) or die (print_r($sqllog->errorInfo()));
    $sqlres1 = $sqllog->fetchObject();
    $sqllog->closeCursor();
    if($sqlres1==null)
    {
      $result="api key does not exist";
    }
    else
    {
      $result="ok";

    }
  return $result;

  }

if($_REQUEST['fct'] == 'addlead')
{
    $data = $_POST['data'];
    $notification=[];
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    // Convert JSON to a PHP array
    $leadinsert= json_decode($data);
    echo "<pre>";
    var_dump($leadinsert);
    echo "</pre>";
    $pk_user=$_REQUEST['pk_user'];
    $browser=$_REQUEST['browser'];
    $campany = $camp->findOne(array('_id' =>new MongoId($_POST['cmpid'])));
    $leadinsert=(array) $leadinsert;
   // $leadinsert["campaign_id"]=$_POST['cmpid'];
    //$leadinsert["companyName"]=$campany['companyName'];
    $leadinsert["status"]=0;
    $leadinsert["DATE_ADD_LEAD"]=date('y-m-d');
    $leadinsert["DATE_MODIF_LEAD"]=date('y-m-d');

    $leadinsert["time"]=date('h:i:s');
    $leadinsert["time_MODIF_LEAD"]=date('h:i:s');

    $leadinsert["ip"]=$clientip;
    $leadinsert["converted"]=0;
    $notification["notification_subject"]=$leadinsert["companyName"];
    $notification["notification_text"]="Lead pour " .$leadinsert["companyName"]. " a été créé avec succès";
    $notification["status"]=0;
    $notification["ip"]=$leadinsert["ip"];
    $notification["date_creation"]=date('y-m-d h:i:s');
    $notification["pk_user"]=$pk_user;


    if(!array_key_exists("campaign_id",$leadinsert)){
      $cursorlead=$camp->findOne(array('companyName'=>$leadinsert["companyName"]));
      $campaign_id = json_decode(json_encode($cursorlead["_id"]), true);
      $campid=$campaign_id['$id'];
      $leadinsert["campaign_id"]=$campid;
    }
    $lead->insert($leadinsert);
    $idlead=$lead->find(array('ip'=>$leadinsert["ip"]))->sort(array('_id'=>-1))->limit(1)->skip(0);
    foreach($idlead as $doc){
      $lead_id =  json_decode(json_encode($doc["_id"]), true);
      $id= $lead_id['$id'];
    }
    $notification["idlead"]=$id;
    $noti->insert($notification);

    $value="Nouvelle lead pour campagne  ".$leadinsert["companyName"]." a été créé avec succès";
    insertLog($value,$leadinsert["campaign_id"],$pk_user,$browser);
    }

// add note for specific lead......................................
if($_REQUEST['fct'] == 'addnote')
{
    $data = $_POST['data'];
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    $note= json_decode($data);
    echo "<pre>";
    var_dump($note);
    echo "</pre>";
    $notes->insert($note);
    $leadnote=(array) $note;
    $lead_id=$leadnote["id_lead"];
    $leadfound=$lead->findOne(array('_id'=>new MongoId($lead_id)));
    $leadfound["status"]=1;
    $cursor = $lead->update(
      array('_id'=> new MongoId($lead_id)),
      array(
      '$set' => $leadfound
      )
    );
    $value="Nouvelle lead note pour le campagne ".$leadfound["companyName"]." a été ajouté avec succès";
    $pk_user=$_REQUEST['pk_user'];
    $browser=$_REQUEST['browser'];
    insertLog($value,$leadfound["campaign_id"],$pk_user,$browser);
}
//fetch list leads............................................
if($_REQUEST['fct'] == 'ListLead')
{   
    
    $result =[];

    $campaign_id =  $_POST['campaign_id'];

    $cursor = $lead->find(array('campaign_id' => $campaign_id))->sort(array('DATE_ADD_LEAD'=>-1));
                          
      foreach ($cursor as $document) 
            {
              $id =  json_decode(json_encode($document["_id"]), true);
              array_push($result,$document);
  
            }
      echo json_encode($result);
}
// fetch list notes of lead..................................
if($_REQUEST['fct'] == 'ListNoteByLead')
{   
    
    $result =[];

    $lead_id =  $_POST['lead_id'];
    $cursor = $notes->find(array('id_lead' => $lead_id));
                          
      foreach ($cursor as $document) 
        {
          array_push($result,$document);                                                    
        }
                          
      echo json_encode($result);
}
// fetch list campaignes................................
if($_REQUEST['fct'] == 'ListCampaign')
{   
    
    $result =[];

    $user_id =  $_REQUEST['user_id'];

    $cursor = $camp->find(array('userId' => $user_id));
                          
      foreach ($cursor as $document) 
                            {  
                              
                              $campaign_id =  json_decode(json_encode($document["_id"]), true);
                              $campid= $campaign_id['$id'];
                              $cursor2 = $lead->find(array('campaign_id' => $campid));
                              $nbleads =$cursor2->count();
                              $document["companyLeads"] = $nbleads;
                              array_push($result,$document);
                            

                            }
     // $result = (object) $result;
      echo json_encode($result);
}
if($_REQUEST['fct'] =='LoadLeadsTreatedByCampany'){

  $result =[];

  $user_id =  $_REQUEST['user_id'];

  $cursor = $camp->find(array('userId' => $user_id));
  $output='';                    
    foreach ($cursor as $document) 
              {  
                          
          $campaign_id =  json_decode(json_encode($document["_id"]), true);
          $campid= $campaign_id['$id'];
          $cursor2 = $lead->find(array('campaign_id' => $campid,'status'=>2));
          $nbleads =$cursor2->count();
          $document["companyLeads"] = $nbleads;
          array_push($result,$document);
              }
      for($i=0;$i<count($result);$i++)
      {
        $max=$result[$i]["companyLeads"];
        for($j=$i+1;$j<count($result);$j++){
          if($result[$j]["companyLeads"] > $max){
            $aux=$max;
            $max=$result[$j]->companyLeads;
            $result[$j]->companyLeads=$aux;
          }
        }
      }
  $arraycolor=["#689f38", "#FF4961", "#FF9149","#8a2be2", "#462be2","#c49e36","#c0c0c0","#2be23a","#2f8049", "#FF3061", "#FF2049","#650f38", "#FF4961", "#2f8049"];
for($i=0;$i<count($result);$i++)
{

  $output.='<li>'.$result[$i]["companyName"].' <span class="badge  ms-2" style="background:'.$arraycolor[$i].'">'.$result[$i]["companyLeads"].'</span></li>'; 
  
}
  

$data=array(
  'result'=>$result,
  'output'=>$output
);

  echo json_encode($data);

  }

  if($_REQUEST['fct'] == 'InfoLead')
  {   
      
      $lead_id =  $_REQUEST['lead_id'];
    
      $cursor = $lead->findOne(array('_id' => new MongoId($lead_id)));
                            
      echo json_encode($cursor);
  }

if($_REQUEST['fct'] == 'UpdateLead')
{   
    
    $data = $_POST['data'];
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    // Convert JSON to a PHP array
    $leadinfo = json_decode($data);
    echo "<pre>";
    var_dump($leadinfo);
    echo "</pre>";
    $lead_id =  $_REQUEST['lead_id'];
    $cursorfound = $lead->findOne(array('_id' => new MongoId($lead_id)));
    
    $leadinfo=(array) $leadinfo;
    $leadinfo["DATE_MODIF_LEAD"]=date('y-m-d');
    $leadinfo["_id"]=new MongoId($leadinfo["_id"]);

    $leadinfo["time_MODIF_DATE"]=date('h:i:s');
    $leadinfo["status"]=$cursorfound["status"];
    $cursor = $lead->update(
                      array('_id'=> new MongoId($lead_id)),
                      array(
                    '$set' => $leadinfo
                    )
                    );
    $value="Lead pour le compagne ".$leadinfo["companyName"]." a été modifié avec succès";
    $pk_user=$_REQUEST['pk_user'];
    $browser=$_REQUEST['browser'];
    
    insertLog($value,$leadinfo["campaign_id"],$pk_user,$browser);


}
if($_REQUEST['fct'] == 'UpdateLeadStatus')
{   

    $lead_id = $_REQUEST['lead_id'];
    $cursorlead = $lead->findOne(array('_id' => new MongoId($lead_id)));
    $cursorlead["status"]=intval($_REQUEST['statuslead']);
    $cursorlead["DATE_MODIF_LEAD"]=date('y-m-d');
    $cursorlead["time_MODIF_DATE"]=date('h:i:s');


    $campfound=$camp->findOne(array('_id'=>new MongoId($cursorlead["campaign_id"])));

    $cursor=$lead->update(
                      array('_id'=> new MongoId($lead_id)),
                      array(
                    '$set' =>$cursorlead
                    ));

$value="Etat de lead pour le compagne ".$campfound["companyName"]." a été modifié avec succès";
$pk_user=$_REQUEST['pk_user'];
$browser=$_REQUEST['browser'];

insertLog($value,$cursorlead["campaign_id"],$pk_user,$browser);                   

echo json_encode($cursor);
}

if($_POST['fct'] == 'DeleteLead')
{  
	$lead_id =$_POST['lead_id'];
  $leadfound=$lead->findOne(array('_id'=>new MongoId($lead_id)));
  $campfound=$camp->findOne(array('_id'=>new MongoId($leadfound["campaign_id"])));
  $value="Lead pour le compagne".$campfound["companyName"]." a été supprimé avec succès";
  $deleteResult =$lead->remove(array('_id' => new MongoId($lead_id)));
  $pk_user=$_REQUEST['pk_user'];
  $browser=$_REQUEST['browser'];
  
  insertLog($value,$leadfound["campaign_id"],$pk_user,$browser);

  echo json_encode($deleteResult);
}

if($_REQUEST['fct'] == 'CountLeadByCampanyByMois')
{  
  $result=[];
  $camplist = $camp->find(array('userId'=>''.$_REQUEST['PK_USER']));
  
  $mois=$_REQUEST['mois'];
  $annee=$_REQUEST['annee'];
  $campanyName=[];
  $campanycount=[];
  $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);

 
    /*$retval = $lead->group(
      array('companyName'=>true), // field(s) to group by
      array('count' => 0), 
      new MongoCode('function(doc, prev) {prev.count += 1 }'), 
      array('status'=> '2')
        ); */
      foreach($camplist as $campdoc){
        $campaign_id =  json_decode(json_encode($campdoc["_id"]), true);
        $campid= $campaign_id['$id'];
        $listcount=[];
        $leadcampany=[];
        for($i=1;$i<=$nbjour;$i++){
          $annee=$annee % 1000;
          /*if(intval($mois)<10){
            $mois='0'.$mois;
          }*/
          if($i<10){
            $i='0'.$i;
          }
          else{
            $i=''.$i;
          }
          
        $leadfound=$lead->find(array('campaign_id'=>$campid,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i));
        array_push($listcount,$leadfound->count());
      }
      array_push($campanycount,$listcount);
      $leadcampany["count"]=$listcount;
      $leadcampany["companyName"]=$campdoc["companyName"];
      array_push($result,$leadcampany);
    }
  echo json_encode($result);
}

if($_REQUEST['fct'] == 'CountLeadByCampany')
{
  $result=[];
  $leadcampany=[];
  $camplist=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
    $mois=date('m');
    $annee=date('y');
        foreach($camplist as $doccamp){
          $campaign_id =json_decode(json_encode($doccamp["_id"]), true);
          $campid= $campaign_id['$id'];
          $listcount=[];

          $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),intval($annee));
            $sum=0;
            for($j=1;$j<=$nbjour;$j++){
              if($j<10){
                $day='0'.$j;
              }
              else{
                $day=''.$j;
              }
            $leadcount=$lead->find(array('campaign_id'=>$campid,'status'=>2,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$day))->count();
            $sum+=$leadcount;
            }
          $leadcampany["count"]=$sum;
          $leadcampany["companyName"]=$doccamp["companyName"];
          array_push($result,$leadcampany);

        }


      
      echo json_encode($result);


}
if($_REQUEST['fct'] == 'CountLeadByCampanyByYear')
{  
  $result=[];
  $camplist = $camp->find(array('userId'=>$_REQUEST['PK_USER']));
  
  $annee=$_REQUEST['annee'];
  $campanyName=[];
  $campanycount=[];
  $annee=$annee % 1000;

 
    /*$retval = $lead->group(
      array('companyName'=>true), // field(s) to group by
      array('count' => 0), 
      new MongoCode('function(doc, prev) {prev.count += 1 }'), 
      array('status'=> '2')
        ); */
      foreach($camplist as $campdoc){
        $campaign_id =  json_decode(json_encode($campdoc["_id"]), true);
        $campid= $campaign_id['$id'];
        $listcount=[];
        $leadcampany=[];
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
            $leadfound=$lead->find(array('campaign_id'=>$campid,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$j))->count();
            $sum+=$leadfound;
          }
        array_push($listcount,$sum);
      }
      $leadcampany["count"]=$listcount;
      $leadcampany["companyName"]=$campdoc["companyName"];
      array_push($result,$leadcampany);
    }
echo json_encode($result);
}
if($_REQUEST['fct'] == 'ListDernierLead')
{   
    
    $result =[];
    $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
    foreach($campanies as $campdoc)
    {
      $campaign_id =  json_decode(json_encode($campdoc["_id"]), true);
      $campid= $campaign_id['$id'];
      $cursor = $lead->find(array('campaign_id'=>$campid))->sort(array('DATE_ADD_LEAD'=>-1));
      foreach ($cursor as $document) 
                              {
                                array_push($result,$document);
                              
                              }
                            }
                          // krsort($result);
                            //array_multisort("DATE_ADD_LEAD", SORT_DESC, $result);
                            echo json_encode($result);
    }
      
    

if($_REQUEST['fct'] == 'CountLeadWithStatus')
{   
    
    $result =[];
    $annee=date('y');
    $mois=date('m');
    $day=date('d');
    $leadstatus=[];
    $camp_list=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
    $traite=0;
    $encour=0;
    $nouveau=0;
    $archived=0;
    foreach($camp_list as $doc)
    {
      $campaign_id = json_decode(json_encode($doc["_id"]), true);
      $campid= $campaign_id['$id'];
      $traite+= $lead->find(array('campaign_id'=>$campid,'status'=>2,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$day))->count();
      $encour+= $lead->find(array('campaign_id'=>$campid,'status'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$day))->count();
      $nouveau+= $lead->find(array('campaign_id'=>$campid,'status'=>0,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$day))->count();
      $archived+= $lead->find(array('campaign_id'=>$campid,'status'=>4,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$day))->count();
    }
    $leadstatus["nouveau"]=$nouveau;
    $leadstatus["encour"]=$encour;
    $leadstatus["traite"]=$traite;
    $leadstatus["archived"]=$archived;
    array_push($result,$leadstatus);      
    echo json_encode($result);
}

// count lead by campany by day.......................................
if($_REQUEST['fct']=='CountLeadByCampanyByDay')
{
  $result=[];
  $leadcampany=[];
  $camplist=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
    $mois=date('m');
    $annee=intval(date('y'));
    $day=date('d');
        foreach($camplist as $doccamp){
          $campaign_id =  json_decode(json_encode($doccamp["_id"]), true);
          $campid= $campaign_id['$id'];
          $listcount=[];

          //$nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),intval($annee));
          $leadcount=$lead->find(array('campaign_id'=>$campid,'status'=>'2','DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$day))->count();
        
        $leadcampany["count"]=$leadcount;
        $leadcampany["companyName"]=$doccamp["companyName"];
        array_push($result,$leadcampany);

      }
      echo json_encode($result);
}




// get the  last 5 notifications of connected user.........................................
if($_REQUEST['fct']=='FetchNotifications')
{
  $ip=$_SERVER['REMOTE_ADDR'];

  if(isset($_POST['view'])){
  if($_POST['view'] != '')
    {
      $notification=$noti->find(array('status'=>0,'pk_user'=>$_REQUEST['PK_USER']));
      foreach($notification as $doc){
        $cursorupdate = $noti->update(
          array('status'=>0),
          array(
        '$set' =>array('status'=>1)
        ));
      }
    
      
    }
    $cursor =$noti->find(array('pk_user'=>$_REQUEST['PK_USER']))->sort(array('_id'=>-1))->limit(5)->skip(0);
    $output = '';
    if($cursor->count()>0)
    {
    foreach($cursor as $row)
    {
      if($row["status"]==0){
        $class="label-warning";
      }
      else{
        $class="label-success";
      }

      if(array_key_exists('idlead',$row)){
        $output .= '
        <li class="">
                <a href="index.php?page=lead&id='.$row["idlead"].'" target="_blank">
                  
                  <span class="details">
                                                      
                      <span class="label label-sm label-icon '.$class.'">
                          <i class="fa fa-bell"></i>
                      </span><span style="font-size:10px;white-space:pre-line;padding-left:2px"class="text-primary">'.$row["notification_subject"].'</span></span><br>
                      
                          <p style="font-size:9px; white-space:pre-line;padding-left:25px;height:100%;display:block" class="text-fade">'.$row["notification_text"].'</p>
                          <span style="font-size:9px;font-style:italic;padding-left:25px"class="text-info"><i class="fa fa-calendar"></i>'.$row["date_creation"].'</span></span>
              </a>
          </li>';
      }
      else{
        $output .= '
      <li>
              <a href="index.php?page=details_ticket&id_ticket='.$row["ticket_id"].'" target="_blank">
                
              
                                                    
                    <span class="label label-sm label-icon '.$class.'">
                        <i class="fa fa-bell"></i>
                    </span><span style="font-size:10px;white-space:pre-line;padding-left:2px"class="text-primary">'.$row["notification_subject"].'</span></span><br>
                    
                        <p style="font-size:9px;white-space:pre-line;padding-left:25px;height:100%;display:block;padding-right:-10px" class="text-fade">'.$row["notification_text"].'</p>
                        <span style="font-size:9px;font-style:italic;padding-left:25px"class="text-info"><i class="fa fa-calendar"></i>'.$row["date_creation"].'
            </a>
        </li>';
      }
  }
  }
  else{
      $output .= '<li><a href="#" class="text-bold text-italic">No Notifications Found</a></li>';
  }
  $status_query = $noti->find(array('status'=>0,'pk_user'=>$_REQUEST['PK_USER']));
  $allNotifications = $noti->find(array('pk_user'=>$_REQUEST['PK_USER']))->count();
  $data =array(
      'notification' => $output,
      'unseen_notification'  =>$status_query->count(),
      'allnotifications'=>$allNotifications
  );
  echo json_encode($data);
  }
} 



// fetch all notifications in database for user ....................................
if($_REQUEST['fct']=='FetchAllNotifications'){

  $cursor =$noti->find(array('pk_user'=>$_REQUEST['PK_USER']))->sort(array('_id'=>-1));
  if(isset($_REQUEST["pagenotification_number"])){
    $currentPage =intval($_REQUEST["pagenotification_number"]);
  }else{
    $currentPage = 1;
  }
  $nbnotifications=$cursor->count();
  $parPage = 5;
  
  // On calcule le nombre de pages total
  $pages = ceil($nbnotifications / $parPage);
  $premier = ($currentPage * $parPage) - $parPage;
  $cursor1=$cursor->limit($parPage)->skip($premier);

  $output = '';
  if($cursor->count()>0)
  {
  foreach($cursor1 as $row)
  {
    if($row["status"]==0){
      $class="border-warning";
    }
    else{
      $class="border-success";
    }
   if(array_key_exists('idlead',$row)){
    $output .= '<a class="media media-single bg-lightest" href="index.php?page=lead&id='.$row["idlead"].'"" target="_blank">
    <div class="media-body ps-15 bs-4 rounded '.$class.'">
    <p class="text-bold">'.$row["notification_subject"].'.</p>
    <span class="text-fade">'.$row["notification_text"].'</span><br>
    <span style="font-size:9px;"class="text-info"><i class="fa fa-calendar"></i>'.$row["date_creation"].'</span>

    </div>
  </a>';
   }
   else{
    $output .= '<a class="media media-single bg-lightest" href="index.php?page=details_ticket&id_ticket='.$row["ticket_id"].'"" target="_blank">
    <div class="media-body ps-15 bs-4 rounded '.$class.'">
    <p class="text-bold">'.$row["notification_subject"].'.</p>
    <span class="text-fade">'.$row["notification_text"].'</span><br>
    <span style="font-size:9px;"class="text-info"><i class="fa fa-calendar"></i>'.$row["date_creation"].'</span>

    </div>
  </a>';
   }
  }
  }
  else{
      $output .= '<a class="media media-single" href="#">
      <div class="media-body ps-15 bs-5 rounded border-dark text-bold">
      No Notifications found
      </div>
    </a>';
  }


  if($cursor->count()>5){
  $output1="";
  $test1="";
  $test2="";
if($currentPage == 1){
  $tt=$currentPage - 1;

  $test1='<li class="page-item disabled">
  <a href="#" onClick="nextNotificationPage('.$tt.');" class="page-link border-dark" style="width:100px;height:50px;display:inline-block;border-radius: 5px;border: 4px double #cccccc;
  text-color:white;
  text-align: center">Précédente</a>
</li>';
}
else{
  $tt=$currentPage - 1;

  $test1='<li class="page-item">
  <a href="#" onClick="nextNotificationPage('.$tt.');" class="page-link border-dark" style="width:100px;height:50px;display: inline-block;border-radius: 5px;border: 4px double #cccccc;
  text-color:white;
  text-align: center;marign-bottom:10px;">Précédente</a>
</li>';
}

for($page=1;$page<=$pages; $page++){
  if($currentPage == $page){
  $output1.='<li class="page-item active">
        <a href="#" onClick="nextNotificationPage('.$page.');" class="button-pagination page-link border-white" style="width:40px;height:50px;display: inline-block;border-radius: 5px;border: 4px double #cccccc;
        text-color:white;
        text-align: center;marign-bottom:30px">'.$page.'</a>
    </li>';}
    else{
      $output1.='<li class="page-item">
      <a href="#" onClick="nextNotificationPage('.$page.');" class="button-pagination page-link" style="width:40px;height:50px;display: inline-block;border-radius: 5px;border: 4px double ;
      text-color:white;
      text-align: center;marign-bottom:30px">'.$page.'</a>
  </li>';
    }
} 
if($currentPage == $pages){
  $tt1=$currentPage + 1;
  $test2= '<li class="page-item disabled">
  <a href="#" onClick="nextNotificationPage('.$tt1.');" class="page-link border-dark" style="width:100px;height:50px;display: inline-block;border-radius: 5px;border: 4px double #cccccc;
  text-color:white;
  text-align: center;marign-bottom:30px">Suivante</a>
</li>';
}
else{
  $tt1=$currentPage + 1;
  $test2= '<li class="page-item ">
  <a href="#" onClick="nextNotificationPage('.$tt1.');" class="page-link border-dark" style="width:100px;height:50px;display: inline-block;border-radius: 5px;border: 4px double #cccccc;
  text-color:white;
  text-align: center;marign-bottom:30px">Suivante</a>
</li>';
}
$output.='<br><div class="row "><div class="col-lg-2"><input type="hidden"></div>
<div class="col-lg-4"><ul class="pagination pull-center">
    ';
    $output.=$test1;
    $output.=$output1;
    $output.=$test2;
    $output.='</ul></div>
';
  }

  $data=array(
    'notification'=>$output,
    'count_all_notification'=>$cursor->count()
  );
  echo json_encode($data);
  }

// convert lead web service..........................................

if($_REQUEST['fct']=='ConvertLead'){

  $lead_id = $_REQUEST['lead_id'];
    $cursorlead = $lead->findOne(array('_id' => new MongoId($lead_id)));
    if( $cursorlead["converted"]==0 || (!array_key_exists("converted",$cursorlead)) ){
    $cursorlead["converted"]=1;
  }
  else{
      $cursorlead["converted"]=0;
    }
    $cursorlead["DATE_MODIF_LEAD"]=date('y-m-d');
    $cursorlead["time_MODIF_LEAD"]=date('h:i:s');

      $cursor=$lead->update(
                            array('_id'=> new MongoId($lead_id)),
                            array(
                            '$set' =>$cursorlead
                          ));
    $data=array(
        'cursor'=>$cursor,
        'convertedvalue'=>intval($cursorlead["converted"])
      );

    echo json_encode($data);
}
//convert all leads..............................
/*
if($_REQUEST['fct']=='ConvertAllLead'){

    $cursorlead = $lead->find();

    foreach($cursorlead as $doc){
      if($doc["converted"]==0){
        $doc["DATE_MODIF_LEAD"]=$doc["DATE_ADD_LEAD"];
      }
        else{
          $doc["DATE_MODIF_LEAD"]=date('y-m-d');

        }
        $lead_id =  json_decode(json_encode($doc["_id"]), true);
        $leadid= $lead_id['$id'];
        $cursor = $lead->update(
          array('_id'=> new MongoId($leadid)),
          array(
          '$set' =>$doc
          ));
          
        
      }
    
    echo json_encode("this fine");
}
*/

if($_REQUEST['fct']=='FetchArchivedLeads'){

  $camp_id = $_REQUEST['camp_id'];

if(isset($_REQUEST["pagearchivednumber"])){
  $currentPage =intval($_REQUEST["pagearchivednumber"]);
}else{
  $currentPage = 1;
}
  $cursor = $lead->find(array('campaign_id' => $camp_id,'status'=>3))->sort(array('_id'=>-1));

  $nbarchivedleads=$cursor->count();
  $parPage = 5;
  
  // On calcule le nombre de pages total
  $pages = ceil($nbarchivedleads / $parPage);
  $premier = ($currentPage * $parPage) - $parPage;
  $cursorlead=$cursor->limit($parPage)->skip($premier);


  $output='';
  if($cursorlead->count()>0){
  foreach($cursorlead as $doc)
  {
    $lead_id =  json_decode(json_encode($doc["_id"]), true);
    $leadid= $lead_id['$id'];
  
    if(!array_key_exists("societe",$doc)){
      $doc["societe"]=$doc["companyName"];
    }
    if(array_key_exists("nom",$doc)){
      $nom=$doc["nom"];
    }
    else{
      $nom="";
    }
    if(array_key_exists("prenom",$doc)){
      $prenom=$doc["prenom"];
    }
    else{
      $prenom="";
    }
    if(array_key_exists("converted",$doc)){
        if($doc["converted"]==1){
      $class="badge badge-success";
      $value="Converted";
      }
    else{

      $class="badge badge-warning";
      $value="Not Converted";
    }
    }
    else{

      $class="badge badge-warning";
      $value="Not Converted";
    }
    $output.='<div class="box bg-lightest no-shadow">
            
              <div class="box-body p-2">
                
                <div class="media-list bb-1 bb-dashed border-light">
                  <div class="media align-items-center">
                    
                    <div class="media-body">

                      <ul class="nav d-block nav-stacked">
                        <li class="nav-item"><h5>
                          <a class="hover-primary" href="index.php?page=lead&id='.$leadid.'"><strong>'.$doc["societe"].'.</strong></a>
                          </h5></li>
                        <li class="nav-item"><label class="text-info">'.$doc["email"].'</label></li>
                        <li class="nav-item"><label class="text-info">'.$nom.' '.$prenom.'</label></li>
                        <li class="nav-item"><small class="text-fade"><i class="fa fa-calendar"></i>'.$doc["DATE_ADD_LEAD"].'</small> </li>
                      </ul>
                    </div>
                    <div class="media-right">
                      <span class="'.$class.'">'.$value.'</span>
                    </div>
                  </div>          
                  
                </div>
                
              </div>
          </div>';
  }}
  else{
    $output .= '<a class="media media-single" href="#">
    <div class="media-body ps-15 bs-5 rounded border-danger text-bold">
    Aucun lead trouvé pour cette compagnie
    </div>
  </a>';
  }

  $output1="";
  $test1="";
  $test2="";
  if($pages>1){

  if($currentPage == 1){
    $tt=$currentPage - 1;
  
    $test1='<li class="paginate_button page-item  previous disabled  " id="productorder_previous">
    <a href="#" onClick="nextArchivedPage('.$tt.');" class="page-link height30" >Previous</a>
  </li>';
  }
  else{
    $tt=$currentPage - 1;
  
    $test1='<li class="paginate_button page-item previous" id="productorder_previous">
    <a href="#" onClick="nextArchivedPage('.$tt.');"  class="page-link  height30" >Previous</a>
  </li>';
  }
  
  for($page=1;$page<=$pages; $page++){
    if($currentPage == $page){
    $output1.='<li class="paginate_button page-item active">
          <a href="#" onClick="nextArchivedPage('.$page.');" class="page-link  height30">'.$page.'</a>
      </li>';}
      else{
        $output1.='<li class="paginate_button page-item">
        <a href="#" onClick="nextArchivedPage('.$page.');" class="page-link height30">'.$page.'</a>
    </li>';
      }
  } 
  if($currentPage == $pages){
    $tt1=$currentPage + 1;
    $test2= '<li class="paginate_button page-item next disabled" id="productorder_next">
    <a href="#" onClick="nextArchivedPage('.$tt1.');"  class="page-link height30">Next</a>
  </li>';
  }
  else{
    $tt1=$currentPage + 1;
    $test2= '<li class="paginate_button page-item next" id="productorder_next">
    <a href="#" onClick="nextArchivedPage('.$tt1.');"  class="page-link height30" >Next</a>
  </li>';
  }
  $output.='<div class="row"><div class="col-lg-2 col-md-2 col-sm-2"></div><div class="col-lg-5 col-md-6 col-sm-6"><div class="dataTables_paginate paging_simple_numbers " id="example1_paginate">
                <ul class="pagination ">
      ';
      $output.=$test1;
      $output.=$output1;
        $output.=$test2;
        
    $output.='</ul></div></div></div>';

    }
    $data=array(
        'ArchivedLeads'=>$output,
        'count_archived_lead'=>$cursor->count()
      );

    echo json_encode($data);
}




if($_REQUEST['fct']=='FetchArchivedLeadsBySearch'){
  $id_comp=$_REQUEST['camp_id'];
  if(isset($_REQUEST["pagearchivednumber"])){
    $currentPage =intval($_REQUEST["pagearchivednumber"]);
  }else{
    $currentPage = 1;
  }
  $searchterm=$_REQUEST['search_Term'];
  $cursor = $lead->find(array('campaign_id' => $id_comp,'status'=>3,'$or'=>array(
    array('societe' => new MongoRegex('^'.$searchterm.'/')),
  array('email' => new MongoRegex('^'.$searchterm.'/')),
  
  array('nom' => new MongoRegex('^'.$searchterm.'/')),
  array('prenom' => new MongoRegex('^'.$searchterm.'/'))
  )))->sort(array('_id'=>-1));
  $nbarchivedleads=$cursor->count();
  $parPage = 5;
  
  // On calcule le nombre de pages total
  $pages = ceil($nbarchivedleads / $parPage);
  $premier = ($currentPage * $parPage) - $parPage;
  $cursorlead=$cursor->limit($parPage)->skip($premier);
  $output='';
  if($cursorlead->count()>0){
  foreach($cursorlead as $doc)
  {
    $lead_id =  json_decode(json_encode($doc["_id"]), true);
    $leadid= $lead_id['$id'];
    if(!array_key_exists("societe",$doc)){
      $doc["societe"]=$doc["companyName"];
    }
    if(array_key_exists("nom",$doc)){
      $nom=$doc["nom"];
    }
    else{
      $nom="";
    }
    if(array_key_exists("prenom",$doc)){
      $prenom=$doc["prenom"];
    }
    else{
      $prenom="";
    }
    if(array_key_exists("converted",$doc)){
        if($doc["converted"]==1){
      $class="badge badge-success";
      $value="Converted";
      }
    else{
      $class="badge badge-warning";
      $value="Not Converted";
    }
    }
    else{
      $class="badge badge-warning";
      $value="Not Converted";
    }
    $output.='<div class="box bg-lightest no-shadow">
            
                              <div class="box-body p-2">
                                
                                  <div class="media-list bb-1 bb-dashed border-light">
                                    <div class="media align-items-center">
                                    
                                    <div class="media-body">

                                      <ul class="nav d-block nav-stacked">
                                        <li class="nav-item"><h5>
                                          <a class="hover-primary" href="index.php?page=lead&id='.$leadid.'"><strong>'.$doc["societe"].'.</strong></a>
                                          </h5></li>
                                        <li class="nav-item"><label class="text-info">'.$doc["email"].'</label></li>
                                        <li class="nav-item"><label class="text-info">'.$nom.' '.$prenom.'</label></li>
                                        <li class="nav-item"><small class="text-fade"><i class="fa fa-calendar"></i>'.$doc["DATE_ADD_LEAD"].'</small> </li>
                                      </ul>
                                    </div>
                                    <div class="media-right">
                                      <span class="'.$class.'">'.$value.'</span>
                                    </div>
                                  </div>          
                                  
                                </div>
                                
                              </div>
                          </div>';
  }}
  else{
    $output .= '<a class="media media-single" href="#">
    <div class="media-body ps-15 bs-5 rounded border-danger text-bold">
    No Archived leads found for this campany
    </div>
  </a>';
  }

  if($pages>1){
    $output1="";
    $test1="";
    $test2="";
    if($currentPage == 1){
      $tt=$currentPage - 1;
    
      $test1='<li class="paginate_button page-item  previous disabled  " id="productorder_previous">
      <a href="#" onClick="nextArchivedSearchPage('.$tt.');" class="page-link height30" >Previous</a>
    </li>';
    }
    else{
      $tt=$currentPage - 1;
    
      $test1='<li class="paginate_button page-item previous" id="productorder_previous">
      <a href="#" onClick="nextArchivedSearchPage('.$tt.');"  class="page-link  height30" >Previous</a>
    </li>';
    }
    
    for($page=1;$page<=$pages; $page++){
      if($currentPage == $page){
      $output1.='<li class="paginate_button page-item active">
            <a href="#" onClick="nextArchivedSearchPage('.$page.');" class="page-link  height30">'.$page.'</a>
        </li>';}
        else{
          $output1.='<li class="paginate_button page-item">
          <a href="#" onClick="nextArchivedSearchPage('.$page.');" class="page-link height30">'.$page.'</a>
      </li>';
        }
    } 
    if($currentPage == $pages){
      $tt1=$currentPage + 1;
      $test2= '<li class="paginate_button page-item next disabled" id="productorder_next">
      <a href="#" onClick="nextArchivedSearchPage('.$tt1.');"  class="page-link height30">Next</a>
    </li>';
    }
    else{
      $tt1=$currentPage + 1;
      $test2= '<li class="paginate_button page-item next" id="productorder_next">
      <a href="#" onClick="nextArchivedSearchPage('.$tt1.');"  class="page-link height30" >Next</a>
    </li>';
    }
    $output.='<div class="row"><div class="col-lg-2 col-md-2 col-sm-2"></div><div class="col-lg-5 col-md-6 col-sm-6"><div class="dataTables_paginate paging_simple_numbers " id="example1_paginate">
    <ul class="pagination ">
        ';
        $output.=$test1;
        $output.=$output1;
          $output.=$test2;
          
      $output.='</ul></div></div></div>
      ';
    }
    

    $data=array(
        'ArchivedLeads'=>$output,
        'count_archived_lead'=>$cursor->count()
      );

    echo json_encode($data);

}

if($_REQUEST['fct']=='FetchConvertedLeads'){
  $result=[];
  $campinfo=[];
  $convertedLead=[];
  $annee=date('y');
  $mois=date('m');
  $jour=date('d');
  $camp_lists=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
  foreach($camp_lists as $campdoc)
  {
    $camp_id =  json_decode(json_encode($campdoc["_id"]), true);
    $campid= $camp_id['$id'];
    $leads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$jour))->count();
    $campdoc["leads_converted"]=$leads;
    array_push($result,$campdoc);
  }
$output=CountConvertedLeads($result);
$data=array('converted_leads'=>$output);
echo json_encode($data);
}



//load data converted lead by week.......................
if($_REQUEST['fct']=='FetchDataThisWeek')
{

$campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
$leadcampany=[];
$result=[];
$resultConverted=[];
foreach($campanies as $doc)
{

  $camp_id =  json_decode(json_encode($doc["_id"]), true);
    $campid= $camp_id['$id'];
    $debut_fin_semaine = get_lundi_dimanche_from_week(date('W'), date('Y'));
      $firstjoursem= intval($debut_fin_semaine[0]);
      $nbjoursemaine=intval($debut_fin_semaine[1]);
    $mois1=$debut_fin_semaine[2];
    $mois2=$debut_fin_semaine[3];
    $annee1=$debut_fin_semaine[4];
    $annee2=$debut_fin_semaine[5];
    $sum=0;
    for($i=$firstjoursem;$i<=$nbjoursemaine;$i++){
      if($i<10){
        $day='0'.$i;
      }
      else{
        $day=''.$i;
      }
    $leads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
      $sum+=$leads;}
      $doc["leads_converted"]=$sum;
      array_push($resultConverted,$doc);

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

        $lead_found=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
          
        array_push($listcount,$lead_found);
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

      $lead_found=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
          
        array_push($listcount,$lead_found);
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

        $lead_found2=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee1.'-'.$mois2.'-'.$day))->count();
          
        array_push($listcount,$lead_found2);
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

      $lead_found=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
          
        array_push($listcount,$lead_found);
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

        $lead_found2=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee2.'-'.$mois2.'-'.$day))->count();
          
        array_push($listcount,$lead_found2);
      }

    }
      $leadcampany["companyName"]=$doc["companyName"];
      $leadcampany["count_converted"]=$listcount;
      array_push($result,$leadcampany);
    }
    $outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
    'result'=>$result,
    'outputconverted'=>$outputconverted
  
    );
    echo json_encode($data);

}

// load data converted lead by last week............................
if($_REQUEST['fct']=='FetchDataLastWeek')
{
  $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
  $leadcampany=[];
  $result=[];
  $resultConverted=[];
  foreach($campanies as $doc)
  {
  
    $camp_id =  json_decode(json_encode($doc["_id"]), true);
      $campid= $camp_id['$id'];
      $debut_fin_semaine = getlast_lundi_dimanche_from_week(date('W'), date('Y'));
      $firstjoursem= intval($debut_fin_semaine[0]);
      $nbjoursemaine=intval($debut_fin_semaine[1]);
      $mois1=$debut_fin_semaine[2];
      $mois2=$debut_fin_semaine[3];
      $annee1=$debut_fin_semaine[4];
      $annee2=$debut_fin_semaine[5];
      $sum=0;
      for($i=$firstjoursem;$i<=$nbjoursemaine;$i++){
        if($i<10){
          $day='0'.$i;
        }
        else{
          $day=''.$i;
        }
        $leads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
        $sum+=$leads;}
        $doc["leads_converted"]=$sum;
        array_push($resultConverted,$doc);
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
    
          $lead_found=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
            
          array_push($listcount,$lead_found);
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
    
          $lead_found=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
            
          array_push($listcount,$lead_found);
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
    
          $lead_found2=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee1.'-'.$mois2.'-'.$day))->count();
            
          array_push($listcount,$lead_found2);
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
  
        $lead_found=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
            
          array_push($listcount,$lead_found);
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
    
          $lead_found2=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee2.'-'.$mois2.'-'.$day))->count();
            
          array_push($listcount,$lead_found2);
        }
    
      }
      $leadcampany["companyName"]=$doc["companyName"];
      $leadcampany["count_converted"]=$listcount;
      array_push($result,$leadcampany);
    }

    $outputconverted=CountConvertedLeads($resultConverted);
      $data=array(
        'result'=>$result,
        'outputconverted'=>$outputconverted
      
      );

      echo json_encode($data);


}
//load data converted lead by this month......................................
if($_REQUEST['fct']=='FetchDataThisMonth'){
  $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
  $result=[];
  $mois=date('m');
  $annee=date('y');
  $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
$resultConverted=[];
  foreach($campanies as $doc)
  {
    $camp_id =  json_decode(json_encode($doc["_id"]), true);
    $campid= $camp_id['$id'];
    $listcount=[];
    $leadcampany=[];
    $sum=0;
    for($i=1;$i<=$nbjour;$i++)
    {
      if($i<10){
        $i='0'.$i;
      }
      else{
        $i=''.$i;
      }
      
    $leadfound=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i));
    $leads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i))->count();
    $sum+=$leads;
    array_push($listcount,$leadfound->count());
    }
      
    
      $doc["leads_converted"]=$sum;
      array_push($resultConverted,$doc);
      $leadcampany["count_converted"]=$listcount;
      $leadcampany["companyName"]=$doc["companyName"];
      array_push($result,$leadcampany);
    }
    $outputconverted=CountConvertedLeads($resultConverted);

    $data=array(
      'result'=>$result,
      'outputconverted'=>$outputconverted
    
    );

echo json_encode($data);

}

// load data converted lead by last month
if($_REQUEST['fct']=='FetchDataLastMonth'){
$this_month=date('m');
$resultConverted=[];
if(intval($this_month) != 1)
{
  $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
  $result=[];
  if(date('m')=="03"){
    $mois="02";
  }else{
  $mois=date("m", strtotime("-1 month"));
}
  $annee=date('y');
  $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
  foreach($campanies as $doc)
  {
    $camp_id =  json_decode(json_encode($doc["_id"]), true);
    $campid= $camp_id['$id'];
    $listcount=[];
    $leadcampany=[];
    $sum=0;
    for($i=1;$i<=$nbjour;$i++)
    {
      if($i<10){
        $i='0'.$i;
      }
      else{
        $i=''.$i;
      }
      
    $leadfound=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i));
    $leads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i))->count();
    $sum+=$leads;
    array_push($listcount,$leadfound->count());
    }
    $doc["leads_converted"]=$sum;
    array_push($resultConverted,$doc);
    $leadcampany["count_converted"]=$listcount;
    $leadcampany["companyName"]=$doc["companyName"];
    array_push($result,$leadcampany);

  }

}
else{
  $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
  $result=[];
  $mois=date("m", strtotime("last month"));
  $annee=date("y",strtotime("last year"));
  $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
  foreach($campanies as $doc)
  {
    $camp_id =  json_decode(json_encode($doc["_id"]), true);
    $campid= $camp_id['$id'];
    $listcount=[];
    $leadcampany=[];
    $sum=0;
    for($i=1;$i<=$nbjour;$i++)
    {
      if($i<10){
        $i='0'.$i;
      }
      else{
        $i=''.$i;
      }
      
    $leadfound=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i));
    $leads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i))->count();
    $sum+=$leads;
    array_push($listcount,$leadfound->count());
    }
    $doc["leads_converted"]=$sum;
    array_push($resultConverted,$doc);
    $leadcampany["count_converted"]=$listcount;
    $leadcampany["companyName"]=$doc["companyName"];
    array_push($result,$leadcampany);

  }

}

$outputconverted=CountConvertedLeads($resultConverted);

  $data=array(
    'result'=>$result,
  'outputconverted'=>$outputconverted

  );

echo json_encode($data);
}



//fetch data converted leads by this year
if($_REQUEST['fct']=='FetchDataThisYear')
{
  $result=[];
  $camplist = $camp->find(array('userId'=>$_REQUEST['PK_USER']));
  
  $annee=date('y');
  $campanyName=[];
  $campanycount=[];
  $resultConverted=[];
foreach($camplist as $campdoc){
  $campaign_id =  json_decode(json_encode($campdoc["_id"]), true);
  $campid= $campaign_id['$id'];
  $listcount=[];
  $leadcampany=[];
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
      $leadfound=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$j))->count();
      $sum+=$leadfound;
    }
  array_push($listcount,$sum);
  $sumpermonth+=$sum;
      }
      $campdoc["leads_converted"]=$sumpermonth;
    array_push($resultConverted,$campdoc);
  $leadcampany["count_converted"]=$listcount;
  $leadcampany["companyName"]=$campdoc["companyName"];
  array_push($result,$leadcampany);

}
$outputconverted=CountConvertedLeads($resultConverted);

  $data=array(
    'result'=>$result,
    'outputconverted'=>$outputconverted
    
    );

echo json_encode($data);
}

//fetch data converted leads by last year............................................................. 

if($_REQUEST['fct']=='FetchDataLastYear')
{

  $result=[];
  $camplist = $camp->find(array('userId'=>$_REQUEST['PK_USER']));
  
  $annee=date("y",strtotime("last year"));
  $campanyName=[];
  $campanycount=[];
  $resultConverted=[];
foreach($camplist as $campdoc){
  $campaign_id =  json_decode(json_encode($campdoc["_id"]), true);
  $campid= $campaign_id['$id'];
  $listcount=[];
  $leadcampany=[];
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
      $leadfound=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$j))->count();
      $sum+=$leadfound;
    }
      array_push($listcount,$sum);
      $sumpermonth+=$sum;
      }
      $campdoc["leads_converted"]=$sumpermonth;
      array_push($resultConverted,$campdoc);
      $leadcampany["count_converted"]=$listcount;
      $leadcampany["companyName"]=$campdoc["companyName"];
      array_push($result,$leadcampany);

}

$outputconverted=CountConvertedLeads($resultConverted);

  $data=array(
    'result'=>$result,
    'outputconverted'=>$outputconverted
    
    );

echo json_encode($data);
}

// fetch data converted leads by month...........................
if($_REQUEST['fct']=='FetchDataConvertedLeadByMonth')
{

  $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
  $result=[];
  $mois=$_REQUEST['mois'];
  $annee=$_REQUEST['year'];
  $annee=intval($annee)%1000;
  $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
  $resultConverted=[];
  foreach($campanies as $doc)
  {
    $camp_id =  json_decode(json_encode($doc["_id"]), true);
    $campid= $camp_id['$id'];
    $listcount=[];
    $leadcampany=[];
    $sum=0;
    for($i=1;$i<=$nbjour;$i++)
    {
      if($i<10){
        $i='0'.$i;
      }
      else{
        $i=''.$i;
      }
      
    $leadfound=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i));
    $sum+=$leadfound->count();
    array_push($listcount,$leadfound->count());
    }
    $doc["leads_converted"]=$sum;
    array_push($resultConverted,$doc);
    $leadcampany["count_converted"]=$listcount;
    $leadcampany["companyName"]=$doc["companyName"];
    array_push($result,$leadcampany);
  }

  $outputconverted=CountConvertedLeads($resultConverted);
  $data=array(
    'result'=>$result,
      'outputconverted'=>$outputconverted
    );

  echo json_encode($data);

}


//fetch data converted leads by year.........................
if($_REQUEST['fct']=='FetchDataConvertedLeadByYear')
{

  $result=[];
  $camplist = $camp->find(array('userId'=>$_REQUEST['PK_USER']));
  
  $annee=$_REQUEST['year'];
  $annee=intval($annee)%1000;
  $campanyName=[];
  $campanycount=[];
  $resultConverted=[];
foreach($camplist as $campdoc){
  $campaign_id =  json_decode(json_encode($campdoc["_id"]), true);
  $campid= $campaign_id['$id'];
  $listcount=[];
  $leadcampany=[];
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
      $leadfound=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$j))->count();
      $sum+=$leadfound;
    }
  array_push($listcount,$sum);
  $sumpermonth+=$sum;
      }
      $campdoc["leads_converted"]=$sumpermonth;
    array_push($resultConverted,$campdoc);
  $leadcampany["count_converted"]=$listcount;
  $leadcampany["companyName"]=$campdoc["companyName"];
  array_push($result,$leadcampany);

}

$outputconverted=CountConvertedLeads($resultConverted);
  $data=array(
    'result'=>$result,
      'outputconverted'=>$outputconverted
    );
  echo json_encode($data);
  }

  //fetch data converted leads on last 3 month ............................................
  if($_REQUEST['fct']=='FetchDataByLastThreeMonth')
  {
  $result=[];
  $camplist =$camp->find(array('userId'=>$_REQUEST['PK_USER']));
  $resultConverted=[];
  foreach($camplist as $doc)
  {
    $campaign_id =  json_decode(json_encode($doc["_id"]), true);
    $campid= $campaign_id['$id'];
    $listcount=[];
    $leadcampany=[];
    $sumpermonth=0;
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
        $leadfound=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$j))->count();
        $sum+=$leadfound;
      }
      array_push($listcount,$sum);
      $sumpermonth+=$sum;
      }
      $doc["leads_converted"]=$sumpermonth;
      array_push($resultConverted,$doc);
      $leadcampany["count_converted"]=$listcount;
      $leadcampany["companyName"]=$doc["companyName"];
      array_push($result,$leadcampany);
  }
  $outputconverted=CountConvertedLeads($resultConverted);
  $data=array(
      'result'=>$result,
      'outputconverted'=>$outputconverted
    );
      echo json_encode($data);
  }

// fetch data converted leads on last 6 month.................

if($_REQUEST['fct']=='FetchDataByLastSixMonth')
{
  $result=[];
  $camplist =$camp->find(array('userId'=>$_REQUEST['PK_USER']));
  $resultConverted=[];
  foreach($camplist as $doc)
  {
    $campaign_id =  json_decode(json_encode($doc["_id"]), true);
    $campid= $campaign_id['$id'];
    $listcount=[];
    $leadcampany=[];
    $sumpermonth=0;
    for ($i = -6; $i <0; $i++){
      //$mois=date('m', strtotime("$i month"));
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
        $leadfound=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$j))->count();
        $sum+=$leadfound;
      }
      array_push($listcount,$sum);
      $sumpermonth+=$sum;
      }
      $doc["leads_converted"]=$sumpermonth;
      array_push($resultConverted,$doc);
      $leadcampany["count_converted"]=$listcount;
      $leadcampany["companyName"]=$doc["companyName"];
      array_push($result,$leadcampany);
  }

  $outputconverted=CountConvertedLeads($resultConverted);
  $data=array(
      'result'=>$result,
      'outputconverted'=>$outputconverted
    );
    echo json_encode($data);

}

//count converted leads by the current date............................................
if($_REQUEST['fct']=='CountConvertedLeadsToday')
{
  $annee=date('y');
  $mois=date('m');
  $day=date('d');
  $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
  $sum=0;
  foreach($campanies as $campdoc)
  {
    $camp_id =  json_decode(json_encode($campdoc["_id"]), true);
    $campid= $camp_id['$id'];
    $countconvertedleads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$day))->count();
    $sum+=$countconvertedleads;
    }
    $data=array(
        'countconvertedleads'=>$sum
    );
  echo json_encode($data);
  }

  /*
  if($_REQUEST['fct']=='addnotetime')
  {
    $noteslist=$notes->find();

    foreach($noteslist as $notedoc)
    {
      $note_id =  json_decode(json_encode($notedoc["_id"]), true);
      $noteid= $note_id['$id'];
    $notedoc["time"]=date('h:i:s');
    $cursor=$notes->update(array('_id'=>new MongoId($noteid)),
    array('$set'=>$notedoc)
    );
    }
    $noteslist=$notes->find();

    echo json_encode($noteslist);
}
*/
if($_REQUEST['fct']=="LeadAdd")
{
  if(isset($_REQUEST['data'])){
  $result=[];
  $data = $_REQUEST['data'];

  $leadinsert= json_decode($data);

  $leadinsert=(array) $leadinsert;
  $UserExist=VerifUserKey($leadinsert["api_key"]);

if($UserExist=="ok")
{
  $companyFound=$camp->findOne(array('_id'=>new MongoId($leadinsert["campaign_id"])));

  if($companyFound !=null){
  $leadinsert["status"]=0;
  $leadinsert["DATE_ADD_LEAD"]=date('y-m-d');
  $leadinsert["DATE_MODIF_LEAD"]=date('y-m-d');
  $leadinsert["time_ADD_LEAD"]=date('h:i:s');
  $leadinsert["time_MODIFY_LEAD"]=date('h:i:s');
  $leadinsert["ip"]=$clientip;
  $leadinsert["converted"]=0;
    $lead->insert($leadinsert);
  echo json_encode(array("success"=>"Lead has been added successfully"));
}
else {
  echo json_encode(array("error"=>"campany does not exist"));
}

}
else{
  echo json_encode(array("error"=>$UserExist));
}
}
  else{
    $UserExist=VerifUserKey($_REQUEST["api_key"]);

    if($UserExist=="ok")
    {
      $companyFound=$camp->findOne(array('_id'=>new MongoId($_REQUEST['camp_id'])));

      if($companyFound!=null){
    $leadinsert=[];
    $leadinsert["status"]=0;
    $leadinsert["DATE_ADD_LEAD"]=date('y-m-d');
    $leadinsert["DATE_MODIF_LEAD"]=date('y-m-d');
    $leadinsert["time_ADD_LEAD"]=date('h:i:s');
    $leadinsert["time_MODIFY_LEAD"]=date('h:i:s');
    $leadinsert["ip"]=$clientip;
    $leadinsert["converted"]=0;
    $leadinsert["campaign_id"]=$_REQUEST['camp_id'];
    $leadinsert["email"]=$_REQUEST['email'];
    $leadinsert["nom"]=$_REQUEST['nom'];
    $leadinsert["prenom"]=$_REQUEST['prenom'];
    $leadinsert["phone"]=$_REQUEST['phone'];
    $lead->insert($leadinsert);
    echo json_encode(array("success"=>"Lead has been added successfully"));
  }
  else{
    echo json_encode(array("error"=>"company does not exist"));
  }

}
else{
  echo json_encode(array("error"=>$UserExist));

}
  }

}
if($_REQUEST['fct']=='GetTask')
{
  $result=[];
  $LeadID=$_REQUEST['lead_id'];
  $leadfound=$lead->findOne(array('_id'=>new MongoId($LeadID)));

    $cursor =$sequence->find(array('CAMP_ID'=>$leadfound["campaign_id"]));
    
      foreach ($cursor as $document) 
      {  
        $seq_id =  json_decode(json_encode($document["_id"]), true);
        $seqid= $seq_id['$id'];
        $tasklist=$task->findOne(array('lead_id'=>$LeadID,'seq_id'=>$seqid));
        if($tasklist==null){
        $doc=[];
        $id =  json_decode(json_encode($document["_id"]), true);
        //$datelead=$document["DATE_ADD_LEAD"];
        $date=date('y-m-d',strtotime($leadfound["DATE_ADD_LEAD"].'+'.$document["NB_JOURS"].' day'));
        //$newdate=date('y M',strtotime($date));
        $doc["date"]=$date;
        $doc["action_type"]=$document['ACTION_TYPE'];
        $doc['camp_id']=$document['CAMP_ID'];
        $doc['datelead']=$leadfound["DATE_ADD_LEAD"];
        $doc['time']=$leadfound["time"];
        $doc['leadID']=$LeadID;
        $doc['seq_id']=$seqid;
        array_push($result,$doc);
        }
      }
    echo json_encode($result);

}

if($_REQUEST['fct']=="addtask"){
$TYPE=$_REQUEST['type'];
$CAMP_ID=$_REQUEST['camp_id'];
$LEAD_ID=$_REQUEST['lead_id'];
$SEQ_ID=$_REQUEST['seq_id'];
$doc=[];
$doc["campaign_id"]=$CAMP_ID;
$doc["lead_id"]=$LEAD_ID;
$doc["status"]="traité";
$doc["action_type"]=$TYPE;
if(intval($TYPE)==1){
  $doc["action"]="EMAIL";
} 
else if(intval($TYPE)==2){
  $doc["action"]="SMS";
}
else{
  $doc["action"]="CALL";
}
$doc["DATE_ADD_TASK"]=date('y-m-d');
$doc["DATE_MODIF_TASK"]=date('y-m-d');

$doc["time"]=date('h:i:s');
$doc["seq_id"]=$SEQ_ID;

$resultinsert=$task->insert($doc);
//var_dump($resultinsert);

if($resultinsert["err"]==null && $resultinsert["ok"]==1){

  echo json_encode(array("result"=>"ok"));

}

}
if($_REQUEST['fct']=="VerifTask")
{
  $TYPE=$_REQUEST['type'];
$LEAD_ID=$_REQUEST['lead_id'];
$seqid=$_REQUEST['seq_id'];

$tasklist=$task->findOne(array('lead_id'=>$LEAD_ID,'action_type'=>$TYPE,'seq_id'=>$seqid));
echo json_encode($tasklist);

}

if($_REQUEST['fct']=="CronTask")
{
$campanoies=$camp->find();
foreach($campanoies as $document)
{
$camp_id =  json_decode(json_encode($document["_id"]), true);
$campid= $camp_id['$id'];
$cursorsequence =$sequence->find(array('CAMP_ID'=>$campid));
$cursorleads =$lead->find(array('campaign_id'=>$campid));

foreach ($cursorleads as $doclead) 
    {  
    $lead_id =  json_decode(json_encode($doclead["_id"]), true);
    $leadid= $lead_id['$id'];
    foreach($cursorsequence as $docseq){
      $seq_id =  json_decode(json_encode($docseq["_id"]), true);
      $seqid= $seq_id['$id'];
      $date=date('y-m-d',strtotime($doclead["DATE_ADD_LEAD"].'+'.$docseq["NB_JOURS"].' day'));
        if(strtotime(date('y-m-d'))==strtotime($date)){
        $tasklist=$task->findOne(array('lead_id'=>$leadid,'action_type'=>$docseq["ACTION_TYPE"],'seq_id'=>$seqid));
          
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

            }
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
    else if(strtotime(date('y-m-d')) >strtotime($date))
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

  if($_REQUEST['fct']=='GetFinishedTask')
  {
    $result=[];
    $LeadID=$_REQUEST['lead_id'];
    $leadfound=$lead->findOne(array('_id'=>new MongoId($LeadID)));

    $cursor =$sequence->find(array('CAMP_ID'=>$leadfound["campaign_id"]));
    
      foreach ($cursor as $document) 
      {  
        $seq_id =  json_decode(json_encode($document["_id"]), true);
        $seqid= $seq_id['$id'];
        $tasklist=$task->findOne(array('lead_id'=>$LeadID,'seq_id'=>$seqid));
        if($tasklist!=null){
        $doc=[];
        $id =  json_decode(json_encode($document["_id"]), true);
        //$datelead=$document["DATE_ADD_LEAD"];
        $date=date('y-m-d',strtotime($leadfound["DATE_ADD_LEAD"].'+'.$document["NB_JOURS"].' day'));
        //$newdate=date('y M',strtotime($date));
        $doc["date"]=$date;
        $doc["action_type"]=$document['ACTION_TYPE'];
        $doc['camp_id']=$document['CAMP_ID'];
        $doc['datelead']=$leadfound["DATE_ADD_LEAD"];
        $doc['time']=$tasklist["time"];
        $doc['leadID']=$LeadID;
        $doc['seq_id']=$seqid;
        $doc['status']=$tasklist["status"];

        array_push($result,$doc);
        }
      }
    echo json_encode($result);

  }

if($_REQUEST['fct']=='GetTodayTask')
{
  $result=[];
  $UserID=$_REQUEST['PK_USER'];
  $campanyfound=$camp->find(array('userId'=>$UserID));
  foreach($campanyfound as $doc)
  {
    $camp_id =  json_decode(json_encode($doc["_id"]), true);
    $campid= $camp_id['$id'];
    $cursor =$sequence->find(array('CAMP_ID'=>$campid));
    $leads=$lead->find(array('campaign_id'=>$campid));
    foreach($leads as $leaddoc)
    {
    $lead_id =  json_decode(json_encode($leaddoc["_id"]), true);
    $leadid= $lead_id['$id'];
    foreach($cursor as $seqdoc)
    {
    $seq_id =  json_decode(json_encode($seqdoc["_id"]), true);
    $seqid= $seq_id['$id'];
    $date=date('y-m-d',strtotime($leaddoc["DATE_ADD_LEAD"].'+'.$seqdoc["NB_JOURS"].' day'));
    if(strtotime(date('y-m-d'))==strtotime($date)){
    $tasklist=$task->findOne(array('lead_id'=>$leadid,'seq_id'=>$seqid));
    if($tasklist==null)
    {
        $docR=[];
        $docR["date"]=$date;
        $docR["action_type"]=$seqdoc['ACTION_TYPE'];
        $docR['camp_id']=$seqdoc['CAMP_ID'];
        $docR['datelead']=$leaddoc["DATE_ADD_LEAD"];
        $docR['email']=$leaddoc["email"];
        $docR['phone']=$leaddoc["phone"];

        $docR['companyName']=$doc["companyName"];

        $docR['time']=$leaddoc["time"];
        $docR['leadID']=$leadid;
        $docR['seq_id']=$seqid;
        array_push($result,$docR);

      }


      }

      }

      }


    }

    echo json_encode($result);

}



if($_REQUEST['fct']=="GetHistoryTask"){

$pk_user=$_REQUEST["PK_USER"];
$campanies=$camp->find(array('userId'=>$pk_user));
$result=[];
foreach($campanies as $doc)
{
  $camp_id =  json_decode(json_encode($doc["_id"]), true);
  $campid= $camp_id['$id'];
  $task_list=$task->find(array('campaign_id'=>$campid));
  if($task_list!=null)
  {
    foreach($task_list as $doctask)
    {
      $leadfound=$lead->findOne(array('_id'=>new MongoId($doctask["lead_id"])));
      $doctask["companyName"]=$leadfound["companyName"];
      $doctask["email"]=$leadfound["email"];
      $doctask["phone"]=$leadfound["phone"];
      array_push($result,$doctask);
    }
    
  }

}
echo json_encode($result);

}



if($_REQUEST['fct']=="GetHistoryTaskBydate")
{
  $pk_user=$_REQUEST['PK_USER'];
  $dateSearch=$_REQUEST['date_search'];
  $month=substr($dateSearch,6,7);
  $day=substr($dateSearch,9,10);
  $year=substr($dateSearch,0,3);
  $year=intval($year)%1000;
  $date=substr($dateSearch,2,strlen($dateSearch));


  $campanies=$camp->find(array('userId'=>$pk_user));
  $result=[];
  foreach($campanies as $doc)
  {
    $camp_id =  json_decode(json_encode($doc["_id"]), true);
    $campid= $camp_id['$id'];
    $task_list=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>$date));
    if($task_list!=null)
    {
      foreach($task_list as $doctask)
      {
        $leadfound=$lead->findOne(array('_id'=>new MongoId($doctask["lead_id"])));
        $doctask["companyName"]=$leadfound["companyName"];
        $doctask["email"]=$leadfound["email"];
        $doctask["phone"]=$leadfound["phone"];
        array_push($result,$doctask);
      }
      
    }
  
  }
  echo json_encode($result);



}
if($_REQUEST['fct']=='FetchDataTaskThisWeek')
{

$campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
$leadcampany=[];
$result=[];
$resultConverted=[];
foreach($campanies as $doc)
{

    $camp_id =  json_decode(json_encode($doc["_id"]), true);
      $campid= $camp_id['$id'];
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

        $task_found=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
          
        array_push($listcount,$task_found);
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

        $task_found=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
          
        array_push($listcount,$task_found);
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

        $task_found2=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee1.'-'.$mois2.'-'.$day))->count();
          
        array_push($listcount,$task_found2);
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

        $task_found=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
          
        array_push($listcount,$task_found);
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

        $task_found2=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee2.'-'.$mois2.'-'.$day))->count();
          
        array_push($listcount,$task_found2);
      }

    }
      $taskcampany["companyName"]=$doc["companyName"];
      $taskcampany["count_task"]=$listcount;
      array_push($result,$taskcampany);
    }
    //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
    'result'=>$result,
  
    );
    echo json_encode($data);

  }


  if($_REQUEST['fct']=='FetchDataTaskLastWeek')
  {

  $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
  $leadcampany=[];
  $result=[];
  $resultConverted=[];
  foreach($campanies as $doc)
  {

    $camp_id =  json_decode(json_encode($doc["_id"]), true);
      $campid= $camp_id['$id'];
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

        $task_found=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
          
        array_push($listcount,$task_found);
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

        $task_found=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
          
        array_push($listcount,$task_found);
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

        $task_found2=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee1.'-'.$mois2.'-'.$day))->count();
          
        array_push($listcount,$task_found2);
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

        $task_found=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee1.'-'.$mois1.'-'.$day))->count();
          
        array_push($listcount,$task_found);
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

        $task_found2=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee2.'-'.$mois2.'-'.$day))->count();
          
        array_push($listcount,$task_found2);
      }

    }
      $taskcampany["companyName"]=$doc["companyName"];
      $taskcampany["count_task"]=$listcount;
      array_push($result,$taskcampany);
    }
    //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
    'result'=>$result,
  
    );
    echo json_encode($data);

  }

  //fetch data task this month.........................................
  if($_REQUEST['fct']=='FetchDataTaskThisMonth'){
    $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
    $result=[];
    $mois=date('m');
    $annee=date('y');
    $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
  $resultConverted=[];
    foreach($campanies as $doc)
    {
      $camp_id =  json_decode(json_encode($doc["_id"]), true);
      $campid= $camp_id['$id'];
      $listcount=[];
      $leadcampany=[];
      $sum=0;
      for($i=1;$i<=$nbjour;$i++)
      {
        if($i<10){
          $i='0'.$i;
        }
        else{
          $i=''.$i;
        }
        
      $taskfound=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee.'-'.$mois.'-'.$i));
      //$leads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i))->count();
      //$sum+=$leads;
      array_push($listcount,$taskfound->count());
      }
      
    
      //$doc["leads_converted"]=$sum;
      //array_push($resultConverted,$doc);
      $leadcampany["count_task"]=$listcount;
      $leadcampany["companyName"]=$doc["companyName"];
      array_push($result,$leadcampany);
    }
    //$outputconverted=CountConvertedLeads($resultConverted);

    $data=array(
      'result'=>$result,
    
    );

  echo json_encode($data);

  }
  //fetch data task last month........................
  if($_REQUEST['fct']=='FetchDataTaskLastMonth'){
    $this_month=date('m');
    $resultConverted=[];
    if(intval($this_month) != 1)
    {
      $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
      $result=[];
      if(date('m')=="03"){
        $mois="02";
      }else{
      $mois=date("m", strtotime("-1 month"));}
      $annee=date('y');
      $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
      foreach($campanies as $doc)
      {
        $camp_id =  json_decode(json_encode($doc["_id"]), true);
        $campid= $camp_id['$id'];
        $listcount=[];
        $leadcampany=[];
        $sum=0;
        for($i=1;$i<=$nbjour;$i++)
        {
          if($i<10){
            $i='0'.$i;
          }
          else{
            $i=''.$i;
          }
          
        $taskfound=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee.'-'.$mois.'-'.$i));
        //$leads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i))->count();
        //$sum+=$leads;
        array_push($listcount,$taskfound->count());
        }
        //$doc["leads_converted"]=$sum;
        //array_push($resultConverted,$doc);
        $taskcampany["count_task"]=$listcount;
        $taskcampany["companyName"]=$doc["companyName"];
        array_push($result,$taskcampany);
    
      }
    
    }
    else{
      $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
      $result=[];
      $mois=date("m", strtotime("last month"));
      $annee=date("y",strtotime("last year"));
      $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
      foreach($campanies as $doc)
      {
        $camp_id =  json_decode(json_encode($doc["_id"]), true);
        $campid= $camp_id['$id'];
        $listcount=[];
        $leadcampany=[];
        $sum=0;
        for($i=1;$i<=$nbjour;$i++)
        {
          if($i<10){
            $i='0'.$i;
          }
          else{
            $i=''.$i;
          }
          
          $taskfound=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee.'-'.$mois.'-'.$i));
          //$leads=$lead->find(array('campaign_id'=>$campid,'converted'=>1,'DATE_MODIF_LEAD'=>''.$annee.'-'.$mois.'-'.$i))->count();
        //$sum+=$leads;
        array_push($listcount,$taskfound->count());
        }
        //$doc["leads_converted"]=$sum;
        //array_push($resultConverted,$doc);
        $taskcampany["count_task"]=$listcount;
        $taskcampany["companyName"]=$doc["companyName"];
        array_push($result,$taskcampany);
    
      }
    
    }
    
    //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
        'result'=>$result,    
      );
    
    echo json_encode($data);

    }
    //fetch data task this year.................................................
    if($_REQUEST['fct']=='FetchDataTaskThisYear')
    {
      $result=[];
      $camplist = $camp->find(array('userId'=>$_REQUEST['PK_USER']));
      
      $annee=date('y');
      $campanyName=[];
      $campanycount=[];
      $resultConverted=[];
    foreach($camplist as $campdoc){
      $campaign_id =  json_decode(json_encode($campdoc["_id"]), true);
      $campid= $campaign_id['$id'];
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
          $taskfound=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee.'-'.$mois.'-'.$j))->count();
          $sum+=$taskfound;
        }
      array_push($listcount,$sum);
      //$sumpermonth+=$sum;
          }
          //$campdoc["leads_converted"]=$sumpermonth;
        //array_push($resultConverted,$campdoc);
      $taskcampany["count_task"]=$listcount;
      $taskcampany["companyName"]=$campdoc["companyName"];
      array_push($result,$taskcampany);
    
    }
  // $outputconverted=CountConvertedLeads($resultConverted);
    
      $data=array(
        'result'=>$result,
      
      );
    
    echo json_encode($data);
    }
    //fetch data task last year..............................................
    if($_REQUEST['fct']=='FetchDataTaskLastYear')
    {
      $result=[];
      $camplist = $camp->find(array('userId'=>$_REQUEST['PK_USER']));
      
      $annee=date("y",strtotime("last year"));
      $campanyName=[];
      $campanycount=[];
      $resultConverted=[];
    foreach($camplist as $campdoc){
      $campaign_id =  json_decode(json_encode($campdoc["_id"]), true);
      $campid= $campaign_id['$id'];
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
          $taskfound=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee.'-'.$mois.'-'.$j))->count();
          $sum+=$taskfound;
        }
      array_push($listcount,$sum);
      //$sumpermonth+=$sum;
          }
          //$campdoc["leads_converted"]=$sumpermonth;
        //array_push($resultConverted,$campdoc);
      $taskcampany["count_task"]=$listcount;
      $taskcampany["companyName"]=$campdoc["companyName"];
      array_push($result,$taskcampany);
    
    }
  // $outputconverted=CountConvertedLeads($resultConverted);
    
      $data=array(
        'result'=>$result,
      );
    
    echo json_encode($data);

    }

    if($_REQUEST['fct']=='FetchDataTaskByLastThreeMonth')
    {
    $result=[];
    $camplist =$camp->find(array('userId'=>$_REQUEST['PK_USER']));
    $resultConverted=[];
    foreach($camplist as $doc)
    {
      $campaign_id =  json_decode(json_encode($doc["_id"]), true);
      $campid= $campaign_id['$id'];
      $listcount=[];
      $taskcampany=[];
      $sumpermonth=0;
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
          $taskfound=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee.'-'.$mois.'-'.$j))->count();
          $sum+=$taskfound;
        }
        array_push($listcount,$sum);
        $sumpermonth+=$sum;
        }
        //$doc["leads_converted"]=$sumpermonth;
        //array_push($resultConverted,$doc);
        $taskcampany["count_task"]=$listcount;
        $taskcampany["companyName"]=$doc["companyName"];
        array_push($result,$taskcampany);
    }
    //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
        'result'=>$result,
      );
      echo json_encode($data);
    }
  
    if($_REQUEST['fct']=='FetchDataTaskByLastSixMonth')
    {
    $result=[];
    $camplist =$camp->find(array('userId'=>$_REQUEST['PK_USER']));
    $resultConverted=[];
    foreach($camplist as $doc)
    {
      $campaign_id =json_decode(json_encode($doc["_id"]), true);
      $campid= $campaign_id['$id'];
      $listcount=[];
      $taskcampany=[];
      $sumpermonth=0;
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
          $taskfound=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee.'-'.$mois.'-'.$j))->count();
          $sum+=$taskfound;
        }
        array_push($listcount,$sum);
        $sumpermonth+=$sum;
        }
        //$doc["leads_converted"]=$sumpermonth;
        //array_push($resultConverted,$doc);
        $taskcampany["count_task"]=$listcount;
        $taskcampany["companyName"]=$doc["companyName"];
        array_push($result,$taskcampany);
    }
    //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
        'result'=>$result,
      );
      echo json_encode($data);
    }

    if($_REQUEST['fct'] =='FetchDataTaskByMonth')
  {

    $campanies=$camp->find(array('userId'=>$_REQUEST['PK_USER']));
    $result=[];
    $mois=$_REQUEST['mois'];
    $annee=$_REQUEST['year'];
    $annee=intval($annee)%1000;
    $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
    $resultConverted=[];
    foreach($campanies as $doc)
    {
      $camp_id = json_decode(json_encode($doc["_id"]), true);
      $campid= $camp_id['$id'];
      $listcount=[];
      $taskcampany=[];
      $sum=0;
      for($i=1;$i<=$nbjour;$i++)
      {
        if($i<10){
          $i='0'.$i;
        }
        else{
          $i=''.$i;
        }   
      $taskfound=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee.'-'.$mois.'-'.$i));
      $sum+=$taskfound->count();
      array_push($listcount,$taskfound->count());
      }
      //$doc["leads_converted"]=$sum;
      //array_push($resultConverted,$doc);
      $taskcampany["count_task"]=$listcount;
      $taskcampany["companyName"]=$doc["companyName"];
      array_push($result,$taskcampany);
    }

    //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
      'result'=>$result,
    );

  echo json_encode($data);

  }

  if($_REQUEST['fct']=='FetchDataTaskByYear')
  {

    $result=[];
    $camplist = $camp->find(array('userId'=>$_REQUEST['PK_USER']));
    
    $annee=$_REQUEST['year'];
    $annee=intval($annee)%1000;
    $campanyName=[];
    $campanycount=[];
    $resultConverted=[];
  foreach($camplist as $campdoc){
    $campaign_id =  json_decode(json_encode($campdoc["_id"]), true);
    $campid= $campaign_id['$id'];
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
        $taskfound=$task->find(array('campaign_id'=>$campid,'DATE_ADD_TASK'=>''.$annee.'-'.$mois.'-'.$j))->count();
        $sum+=$taskfound;
      }
    array_push($listcount,$sum);
    $sumpermonth+=$sum;
        }
        //$campdoc["leads_converted"]=$sumpermonth;
      //array_push($resultConverted,$campdoc);
    $taskcampany["count_task"]=$listcount;
    $taskcampany["companyName"]=$campdoc["companyName"];
    array_push($result,$taskcampany);
  }

  //$outputconverted=CountConvertedLeads($resultConverted);
    $data=array(
      'result'=>$result,
    );
  echo json_encode($data);
  }






  

  //call for function api......................
  if($_REQUEST['fct']=="LeadList")
  {
    $campaign_id=$_REQUEST['campaign_id'];
    $api_key=$_REQUEST['api_key'];
    $UserExist=VerifUserKey($api_key);

    if($UserExist=="ok")
    {
      $companyFound=$camp->findOne(array('_id'=>new MongoId($campaign_id)));
    
    if($companyFound !=null){
      $result=[];
      $leadlist=$lead->find(array('campaign_id'=>$campaign_id));
    foreach($leadlist as $doc)
    {
      array_push($result,$doc);
    }
      echo json_encode($result);
    }
    else {
      echo json_encode('{"error"=>"campany does not exist"}');
    }
    
    }
    else{
      echo json_encode('{"error"=>'.$UserExist.'}');
    }

  }
  if($_REQUEST['fct']=="LeadDelete")
  {
    $lead_id=$_REQUEST['lead_id'];
    $api_key=$_REQUEST['api_key'];
    $UserExist=VerifUserKey($api_key);

    if($UserExist=="ok")
    {
      $leadFound=$lead->findOne(array('_id'=>new MongoId($lead_id)));
    
    if($leadFound !=null){
      $campfound=$camp->findOne(array('_id'=>new MongoId($leadFound["campaign_id"])));
      $sqllog = $sqlserver->prepare("select * from t_user where S_API_KEY=?");
      $sqllog->execute(array($api_key)) or die (print_r($sqllog->errorInfo()));
      $sqlres1 = $sqllog->fetchObject();
      $sqllog->closeCursor();
      if($sqlres1->PK_USER==$campfound["userId"])
      {
        $deleteResult =$lead->remove(array('_id' => new MongoId($lead_id)));
        echo json_encode('{"success"=>"lead has been deleting successffully"}');
      }
      else {
        echo json_encode('{"error"=>"You dont have permission"}');
      }
      
    }
    else {
      echo json_encode('{"error"=>"lead does not exist"}');
    }
    
    }
    else{
      echo json_encode('{"error"=>'.$UserExist.'}');
    }

  }



  if($_REQUEST['fct']=='FetchDataMessageTicket')
  {
    $tickets_messages=$ticketReply->find(array('idUser'=>$_REQUEST['PK_USER']));
    $result=[];
    $mois=$_REQUEST['mois'];
    $annee=date('y');
    $nbjour=cal_days_in_month(CAL_GREGORIAN,$mois,$annee);
   
      $MessageIncommingCount=[];
      $MessageOutgoingCount=[];

      $leadcampany=[];
      $sum=0;
      for($i=1;$i<=$nbjour;$i++)
      {
        if($i<10){
          $i='0'.$i;
        }
        else{
          $i=''.$i;
        }
        
      $outgoing_message=$ticketReply->find(array('sender' =>"admin",'DATE_ADD_REPLY'=>''.$annee.'-'.$mois.'-'.$i))->count();
      $incoming_message=$ticketReply->find(array('sender'=>array('$ne' =>"admin"),'DATE_ADD_REPLY'=>''.$annee.'-'.$mois.'-'.$i))->count();
      array_push($MessageIncommingCount,$incoming_message);
      array_push($MessageOutgoingCount,$outgoing_message);

      }
        
      
        $message["outgoing_message"]=$MessageOutgoingCount;
        $message["incoming_message"]=$MessageIncommingCount;
        array_push($result,$message);
      
  
   
  
  echo json_encode($result);

  }


  if($_REQUEST['fct']=='FetchDataMessageTicketByYear'){

    $tickets_messages=$ticketReply->find(array('idUser'=>$_REQUEST['PK_USER']));
    $result=[];
    $annee=$_REQUEST['year'];
    $annee=intval($annee)%1000;
    $MessageIncommingCount=[];
    $MessageOutgoingCount=[];
    for($j=1;$j<=12;$j++){
       if($j<10){
         $mois="0".$j;
       }
       else{
         $mois="".$j;
       }

    $nbjour=cal_days_in_month(CAL_GREGORIAN,intval($mois),$annee);
    $sum_inc=0;
    $sum_out=0;
    for($i=1;$i<=$nbjour;$i++)
    {
      if($i<10){
        $i='0'.$i;
    }
    else{
      $i=''.$i;
    }
      
    $outgoing_message=$ticketReply->find(array('sender' =>"admin",'DATE_ADD_REPLY'=>''.$annee.'-'.$mois.'-'.$i))->count();
    $incoming_message=$ticketReply->find(array('sender'=>array('$ne' =>"admin"),'DATE_ADD_REPLY'=>''.$annee.'-'.$mois.'-'.$i))->count();
    $sum_inc=$sum_inc+$incoming_message;
    $sum_out=$sum_out+$outgoing_message;
    }

    array_push($MessageIncommingCount,$sum_inc);
    array_push($MessageOutgoingCount,$sum_out);
    }  
     
  
    $message["outgoing_message"]=$MessageOutgoingCount;
    $message["incoming_message"]=$MessageIncommingCount;
    array_push($result,$message);
  
  
  echo json_encode($result);

  }



  $b->close();




?>