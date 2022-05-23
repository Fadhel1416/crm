<?php
session_start ();
include_once "../../config.inc.php";
include_once "../../commun.inc.php";

global $sqlserver;
$k=0;



$iduser="";

if(isset($_REQUEST["id_ticket"])){

    $id_ticket=$_REQUEST["id_ticket"];
    $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
    $POSTVALUE='fct=GetMessageTicket&id_ticket='.$id_ticket;
    $ticketresult = curl_do_post($URL, $POSTVALUE);
    $ticketresult =json_decode($ticketresult);

    $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
    $POSTVALUE='fct=GetList_tickets&id_ticket='.$id_ticket;
    $ticketList = curl_do_post($URL, $POSTVALUE);
    $ticketList =json_decode($ticketList);
    $ticketList=(array) $ticketList;
      //var_dump($ticketList);


    $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
    $POSTVALUE='fct=GetMessagesTicket&id_ticket='.$id_ticket;
    $Message_Reply_result = curl_do_post($URL, $POSTVALUE);
    $Message_Reply_result =json_decode($Message_Reply_result);
    $Message_Reply_result=(array) $Message_Reply_result;

   $URL='https://www.yestravaux.com/webservice/crm/Auth.php';
	$POSTVALUE  = 'fct=UserAccount&pk_user='.$ticketresult->idUser;
	$connectedUser = curl_do_post($URL, $POSTVALUE);
	$connectedUser = json_decode($connectedUser);
    if($connectedUser->S_IMAGE !=null){
		$urlimage="https://www.yestravaux.com/pro/manager/photos/".$connectedUser->S_IMAGE;}
		else{
			$urlimage="../images/Guest2.png";
		
		}
    $iduser=$ticketresult->idUser;
}
if(isset($_REQUEST["tic_client_key"])){
    $key_message=$_REQUEST["tic_client_key"];
    $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
    $POSTVALUE='fct=GetTickets&tic_client_key='.$key_message;
    $TicInfo = curl_do_post($URL, $POSTVALUE);
    $TicInfo =json_decode($TicInfo);
   //var_dump($TicInfo);
    $id_ticket=$TicInfo->id_ticket;
    $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
    $POSTVALUE='fct=GetMessageTicket&id_ticket='.$id_ticket;
    $ticketresult = curl_do_post($URL, $POSTVALUE);
    $ticketresult =json_decode($ticketresult);

    
    $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
    $POSTVALUE='fct=GetList_tickets&id_ticket='.$id_ticket;
    $ticketList = curl_do_post($URL, $POSTVALUE);
    $ticketList =json_decode($ticketList);
    $ticketList=(array) $ticketList;


    $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
    $POSTVALUE='fct=GetMessagesTicket&id_ticket='.$id_ticket;
    $Message_Reply_result = curl_do_post($URL, $POSTVALUE);
    $Message_Reply_result =json_decode($Message_Reply_result);
    $Message_Reply_result=(array) $Message_Reply_result;

   $URL='https://www.yestravaux.com/webservice/crm/Auth.php';
	$POSTVALUE  = 'fct=UserAccount&pk_user='.$ticketresult->idUser;
	$connectedUser = curl_do_post($URL, $POSTVALUE);
	$connectedUser = json_decode($connectedUser);
    if($connectedUser->S_IMAGE !=null){
		$urlimage="https://www.yestravaux.com/pro/manager/photos/".$connectedUser->S_IMAGE;}
		else{
			$urlimage="../images/Guest2.png";
		
		}
    $iduser=$ticketresult->idUser;


}
if(isset($_REQUEST["tic_client_key"]) || isset($_REQUEST["source"])){
    $sender=$ticketresult->email;
}
else{
    $sender="admin";
}




if($_POST && isset($_REQUEST["send"])){
   $ticket_message=htmlspecialchars($_POST["message_ticket"]);
    //$id_ticket=$_REQUEST["id_ticket"];
    
    $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
    $POSTVALUE='fct=TicketReplyAdd&id_ticket='.$id_ticket.'&message='.$ticket_message.'&pk_user='.$iduser.'&sender='.$sender;
    $ticketReply = curl_do_post($URL, $POSTVALUE);
    //$ticketReply =json_decode($ticketresult);
    //var_dump($ticketReply);
    if($ticketReply != null)
    {
        $k=1;
    }


}



//var_dump($ticketresult);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets Messages</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        body{margin-top:20px;
background:#eee;
}

/* ========================================================================
 * MESSAGES
 * ======================================================================== */


.message-wrapper {
  position: relative;
  padding: 0px;
  background-color: #f8f8f8;
  margin: 0px;
}
.message-wrapper .message-sideleft {
  vertical-align: top !important;
}
.message-wrapper .message-sideleft[class*="col-"] {
  padding-right: 0px;
  padding-left: 0px;
}
.message-wrapper .message-sideright {
  background-color: #f8f8f8;
}
.message-wrapper .message-sideright[class*="col-"] {
  padding: 30px;
}
.message-wrapper .message-sideright .panel {
  border-top: 1px dotted #DDD;
  padding-top: 20px;
}
.message-wrapper .message-sideright .panel:first-child {
  border-top: none;
  padding-top: 0px;
}
.message-wrapper .message-sideright .panel .panel-heading {
  border-bottom: none;
}
.message-wrapper .panel {
  background-color: transparent !important;
  -moz-box-shadow: none !important;
  -webkit-box-shadow: none !important;
  box-shadow: none !important;
}
.message-wrapper .panel .panel-heading, .message-wrapper .panel .panel-body {
  background-color: transparent !important;
}
.message-wrapper .media .media-body {
  font-weight: 300;
}
.message-wrapper .media .media-heading {
  margin-bottom: 0px;
}
.message-wrapper .media small {
  color: #999999;
  font-weight: 500;
}

.list-message .list-group-item {
  padding: 15px;
  color: #999999 !important;
  border-right: 3px solid #8CC152 !important;
}
.list-message .list-group-item.active {
  background-color: #EEEEEE;
  border-bottom: 1px solid #DDD !important;
}
.list-message .list-group-item.active p {
  color: #999999 !important;
}
.list-message .list-group-item.active:hover, .list-message .list-group-item.active:focus, .list-message .list-group-item.active:active {
  background-color: #EEEEEE;
}
.list-message .list-group-item small {
  font-size: 12px;
}
.list-message .list-group-item .list-group-item-heading {
  color: #999999 !important;
}
.list-message .list-group-item .list-group-item-text {
  margin-bottom: 10px;
}
.list-message .list-group-item:last-child {
  -moz-border-radius: 0px;
  -webkit-border-radius: 0px;
  border-radius: 0px;
  border-bottom: 1px solid #DDD !important;
}
.avatar{
    width:50px;
    height:50px;
}
.custom-scrollbar {
     height : auto; 
     width  : auto;
     background : #FFFFFF;
     overflow-y : scroll;
}
.custom-scrollbar::-webkit-scrollbar {
width: 10px;
}
.custom-scrollbar::-webkit-scrollbar-track { 
background : #FFFFFF;
border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb { 
background : rgba(255,255,255,0.5);
border-radius: 10px;
box-shadow:  0 0 6px rgba(0, 0, 0, 0.5);
}
input[type="submit"]{
		height:50px;
		width:100px;
	}

    </style>
</head>
<body>
  
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
<div class="row message-wrapper rounded shadow mb-20" id="dddd2" style="overflow: hidden; width: auto;height:auto" >
    <div class="col-md-4 message-sideleft" >
        <div class="panel" >
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Listes des Tickets</h3>
                </div>
                
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding" >
                <div class="list-group no-margin list-message" >

                <?php for($i=0;$i<count($ticketList);$i++){
                   $j=$i+1;
                  if($ticketList[$i]->status==1){
                    $status_name="New";
                    $className="badge badge-danger pull-right";
                  }
                  else if($ticketList[$i]->status==3){
                    $status_name="Pending";
                    $className="badge badge-warning pull-right";
                  }
                  else if($ticketList[$i]->status==4){
                    $status_name="Opened";
                    $className="badge badge-info pull-right";
                  }
                  else   if($ticketList[$i]->status==2){
                    $status_name="Solved";
                    $className="badge badge-success pull-right";
                  }
                
                    if($ticketList[$i]->id_ticket==$id_ticket){
                      $active="active";
                    }
                    else{
                      $active="";
                    }

                    

                ?>
                    <a href="https://desk.hosteur.pro/tickets/ticket_reply.php?id_ticket=<?php  echo $ticketList[$i]->id_ticket;?>" class="list-group-item <?php echo $active;?>">
                        <h4 class="list-group-item-heading"></h4>
                        <p class="list-group-item-text">
                            <span class="badge badge-dark">Ticket #<?php echo $j;?></span> : <strong><?php echo $ticketList[$i]->object;?></strong>
                        </p>
                        <small><?php echo date('M y ,d',strtotime( $ticketList[$i]->Ticket_Creation_Date));?> at <?php echo $ticketList[$i]->time;?></small>
                        <span class="<?php echo $className; ?>"><?php echo $status_name; ?></span>
                        <div class="clearfix"></div>
                    </a>
                   <?php  } ?>
                </div>
            </div>
        </div>
</div>

    <div class="col-8 message-sideright spinner">
        <div class="panel" >
            <div class="panel-heading">
                <div class="media" >
                    <a class="pull-left" href="#">
                        <!--img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="Rebecca Cabean" class="img-circle avatar"-->
                        <svg class="rounded-bottom" style="background-color:#957bbe"width="50" height="50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Example bottom rounded image: 75x75"><rect width="100%" height="100%" fill="#868e96" class="text-center"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em"><?php echo strtoupper(substr($ticketresult->email,0,1)); ?></text></svg>


                    </a>
                    <div class="media-body" >
                        <h4 class="media-heading" style="padding-left:4px"><?php echo ucfirst($ticketresult->nom)." " .ucfirst($ticketresult->prenom);?></h4>
                        <small class="text-fade" style="font-style:italic;padding-left:4px">le <?php echo date('d M y',strtotime($ticketresult->DATE_ADD_TICKET)) ." at ".  $ticketresult->time;?></small>
                    </div>
                </div>
            </div><!-- /.panel-heading -->
            <br>
            <div class="panel-body" >
                <p class="lead" style="padding-left:10px">
                   <b> Sujet :</b>  <span class="badge badge-info"><?php echo ucfirst( $ticketresult->object);?></span>
                   <?php /*if ($ticketresult->status ==3){?> 
                    <span class="badge badge-pill badge-warning text-white">Répondu</span>
                    <?php } else if($ticketresult->status== 1){?>
                      <span class="badge badge-success">Nouveau</span>
                      <?php } else {?>
                        <span class="badge badge-danger">Fermé</span>
                        <?php }?*/?>


                </p>
                <p class="lead text-dark"  style="padding-left:10px;">
                   <b>Contenu:</b> <?php echo nl2br($ticketresult->body);?>
                </p>
                <br>
                
            </div>
        </div>
        
        <?php 
        
    $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
    $POSTVALUE='fct=GetMessagesTicket&id_ticket='.$id_ticket;
    $Message_Reply_result = curl_do_post($URL, $POSTVALUE);
    $Message_Reply_result =json_decode($Message_Reply_result);
    $Message_Reply_result=(array) $Message_Reply_result;
    //var_dump($Message_Reply_result);
    if($Message_Reply_result[0]->_id != null ){
        for($i=0;$i<count($Message_Reply_result);$i++){
          if($Message_Reply_result[$i]->sender =="admin"){
            $name= ucfirst($connectedUser->S_NAME);
            $text_color="text-info";
          }
          else{
            $name=ucfirst($ticketresult->nom)." ".ucfirst($ticketresult->prenom);
            $text_color="text-dark";
          }
           
           ?>
        
        <div class="panel" style="background-color:cadetblue"> 
            <div class="panel-heading" >
                <div class="media">
                    <a class="pull-left" href="#" style="padding-left:5px">
                   

                       <?php  if($Message_Reply_result[$i]->sender =="admin"){ ?>
                        <img src="<?php echo $urlimage;?>" class="img-circle avatar rounded-bottom">
                        <?php } else { ?>
                          <svg class="rounded-bottom" style="background-color:#957bbe"width="50" height="50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Example bottom rounded image: 75x75"><rect width="100%" height="100%" fill="#868e96" class="text-center"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em"><?php echo strtoupper(substr($ticketresult->email,0,1)); ?></text></svg>
                         <?php }?>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"  style="padding-left:5px"><?php echo $name;?></h4>
                        <small class="text-fade" style="font-style:italic;padding-left:5px">le <?php echo date('d M y',strtotime($Message_Reply_result[$i]->DATE_ADD_REPLY)) ." at ".  $Message_Reply_result[$i]->time;?></small>
                    </div>
                </div>
            </div>
            <br>
            <div class="panel-body" style="padding-left:20px;">
                <p class="lead <?php echo $text_color ;?>" style="font-size:16px">
                   <?php echo nl2br($Message_Reply_result[$i]->body);?>

            </p>
                <hr>
               
            </div>
        <div>
            <?php }}?>
        <?php if($ticketresult->status != 2){?>
               <div class="col-12">
               <form action="" method="post">
               <?php if($k==1){?>
								<div class="col-md-12 alert-success rounded" style="padding:20px">
								Votre réponse est envoyée avec succès
								</div>
                                <br>
								<?php }?>
                    <textarea class="form-control" name="message_ticket" id="" cols="5" rows="3" placeholder="Entrez votre reponse ....."></textarea>
                    <br>
                    <input type="submit" class="btn btn-sm btn-info rounded" value="Envoyer" name="send">
                </form>

               </div>
               <?php } else {?>
                 <div class="col-12">
                 <div class="col-md-12 text-success rounded" style="padding:20px">
                 Ce ticket est bien résolu 
								</div>
                 </div>



              <?php }?>
            
    </div>
</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/perfect-scrollbar.min.js" integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
    $(document).ready(function(){
        new PerfectScrollbar('#dddd2', {
            handlers: ['click-rail', 'drag-thumb', 'keyboard', 'wheel', 'touch'],
scrollingThreshold: 3000,
wheelSpeed: 2,
wheelPropagation: false,
inScrollbarLength: null,
maxScrollbarLength: null,
useBothWheelAxes: false,
suppressScrollX: true,
suppressScrollY: false,
swipeEasing: true,

scrollXMarginOffset: 0,
scrollYMarginOffset: 0

});






    });





    </script>
</body>
</html>