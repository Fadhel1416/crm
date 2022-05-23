<?php
session_start ();
include_once "../../config.inc.php";
global $sqlserver;



if(!isset($_SESSION["PK_USER"])){

	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";

}



$k=0;
$client_image="../images/Guest2.png";
if(isset($_REQUEST["id_ticket"])){

    $id_ticket=$_REQUEST["id_ticket"];
    $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
    $POSTVALUE='fct=GetMessageTicket&id_ticket='.$id_ticket;
    $ticketresult = curl_do_post($URL, $POSTVALUE);
    $ticketresult =json_decode($ticketresult);


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
}

if($_POST && isset($_REQUEST["send"])){
    $ticket_message=htmlspecialchars($_POST["message_ticket"]);
     //$id_ticket=$_REQUEST["id_ticket"];
     
     $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
     $POSTVALUE='fct=TicketReplyAdd&id_ticket='.$id_ticket.'&message='.$ticket_message.'&pk_user='.$_SESSION["PK_USER"].'&sender=admin';
     $ticketReply = curl_do_post($URL, $POSTVALUE);
     //$ticketReply =json_decode($ticketresult);
     //var_dump($ticketReply);
     if($ticketReply != null)
     {
         $k=1;
     }
 
 
 }


?>
    
    <!-- Content Wrapper. Contains page content -->
        <div class="container-full" >
            
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Ticket Details</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="fa fa-ticket"></i></a></li>
								<li class="breadcrumb-item active" aria-current="page">Details</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Main content -->
		<section class="content" id="refresh-users">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
            <div class="row" id="dddd" style="overflow: hidden; width: auto; height: auto;">
            <div class="col-sm-10 col-xl-8">
            <div class="box no-shadow">				
					<!-- Post -->
                    <br>
					<div class="post">
					  <div class="user-block">
						<img class="img-bordered-sm rounded-circle" src="<?php echo $client_image;?>" alt="user image">

							<span class="username">
							  <a href="#"><b><?php echo ucfirst($ticketresult->nom);?></b></a>
							  <!--a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></!--a-->
							</span>
						<span class="description">le <?php echo date(' d M Y',strtotime($ticketresult->DATE_ADD_TICKET)) ." ".  $ticketresult->time;?></span>
					  </div>
					  <!-- /.user-block -->
					  <div class="activitytimeline">
                          <span class="badge badge-info">Sujet:</span> <span class="badge badge-dark" ><?php echo ucfirst( $ticketresult->object);?></span>
                          <?php if($ticketresult->status==2){?>
                        <span class="bg-success"><i class="fa fa-check"></i> </span>                           
                        <?php }?>
						 <p style="padding-top:20px">
							<?php echo $ticketresult->body;?>
						  </p>
					  </div>
					</div>
					<!-- /.post -->

		
					<!-- /.post -->

					<!-- Post -->
                    <?php 
                      $URL= 'https://www.yestravaux.com/webservice/crm/campaign.php';
                      $POSTVALUE='fct=GetMessagesTicket&id_ticket='.$id_ticket;
                      $Message_Reply_result = curl_do_post($URL, $POSTVALUE);
                      $Message_Reply_result =json_decode($Message_Reply_result);
                      $Message_Reply_result=(array) $Message_Reply_result;
                      //var_dump($Message_Reply_result);
                
                    if($Message_Reply_result[0]->_id != null){
                    for($i=0;$i<count($Message_Reply_result);$i++){
                        if($Message_Reply_result[$i]->sender =="admin"){
                            $name= ucfirst($connectedUser->S_NAME);
                            $text_color="text-info ";
                          }
                          else{
                            $name=ucfirst($ticketresult->nom)." ".ucfirst($ticketresult->prenom);
                            $text_color="";
                          }

                    ?>
					<div class="post clearfix">
					  <div class="user-block">

                      <?php  if($Message_Reply_result[$i]->sender =="admin"){ ?>

						<img class="img-bordered-sm rounded-circle" src="<?php echo $urlimage;?>" alt="user image">
                        <?php } else {?>
                            <img class="img-bordered-sm rounded-circle" src="<?php echo $client_image;?>" alt="user image">
                            <?php }?>





							<span class="username">
							  <a href="#"><?php echo $name;  ?></a>
							  <!--a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></!--a-->
							</span>
						<span class="description">le <?php echo date(' d M Y',strtotime($Message_Reply_result[$i]->DATE_ADD_REPLY)) ." ".  $Message_Reply_result[$i]->time;?></span>
					  </div>
					  <!-- /.user-block -->
						<div class="activitytimeline <?php echo $text_color;?>">
						  <p>
                          <?php echo $Message_Reply_result[$i]->body;?>
						  </p>

						 
						</div>
					</div>
					<!-- /.post -->
<?php }}?>

                       

<?php if($ticketresult->status != 2){?>


         <form action="" method="post">
         <div class="form-group row">
           <div class="col-sm-10 col-lg-10 col-md-8">
           <?php if($k==1){?>
								<div class="alert alert-success alert-dismissible ">
								Votre réponse est envoyée avec succès
								</div>
                                <br>
								<?php }?><br>
             <textarea  style="margin-left:20px" rows="3" class="form-control" placeholder="Entrez votre reponse" name="message_ticket"></textarea>
           </div></div>

           <br>
             <input style="margin-left:20px" type="submit" class="btn btn-danger " value="Envoyer" name="send">
       </form>
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
            <!-- /.row -->
		</section>
            <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        new PerfectScrollbar('#dddd', {
            handlers: ['click-rail', 'drag-thumb', 'keyboard', 'wheel', 'touch'],
scrollingThreshold: 3000,
wheelSpeed: 3,
wheelPropagation: true,
inScrollbarLength: null,
maxScrollbarLength: 900,
useBothWheelAxes: false,
suppressScrollX: true,
suppressScrollY: false,
swipeEasing: true,

scrollXMarginOffset: 0,
scrollYMarginOffset: 0

});
    });
    </script>