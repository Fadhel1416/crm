<?php
// exec("php php-socket.php");
header('Access-Control-Allow-Origin: *');

session_start ();

if((!empty( $_SERVER['HTTP_X_FORWARDED_HOST'])) || (!empty( $_SERVER['HTTP_X_FORWARDED_FOR'])) ) {
    $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
    $_SERVER['HTTPS'] = 'on';
}
if(!isset($_SESSION["PK_USER"])){

    echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
  
  }
  
include_once "../../config.inc.php";
global $sqlserver;

$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
$POSTVALUE= "fct=GetInvitedUsers2&PK_USER=".$_SESSION['PK_USER'];
$resultat2 = curl_do_post($URLP,$POSTVALUE);
$invited_users= (array)json_decode($resultat2, true);
$clientBrowser=$_SERVER['HTTP_USER_AGENT'];

$URLP= "https://api.hosteur.pro/webservice/crm/chat.php";
$POSTVALUE= "fct=GetListRooms&pk_user=".$_SESSION['PK_USER'];
$resultat = curl_do_post($URLP,$POSTVALUE);
$List_Room=(array)json_decode($resultat);

//var_dump($invited_users);

//var_dump($_SERVER['DOCUMENT_ROOT']);
//exec("del php-socket.php");
$URL='https://www.yestravaux.com/webservice/crm/Auth.php';
	$POSTVALUE  = 'fct=UserProfil&pk_user='.$_SESSION['PK_USER'].'&kkey='.$_SESSION[ 'K_KEY'];
	$connectedUser = curl_do_post($URL, $POSTVALUE);
	$connectedUser = json_decode($connectedUser);
	if($connectedUser->S_IMAGE !=null){
		$urlimage="https://www.yestravaux.com/pro/manager/photos/".$connectedUser->S_IMAGE;}
		else{
			$urlimage="images/Guest2.png";
		
		}
    
    //exec("php  php-socket.php");

?>
    
    <!-- Content Wrapper. Contains page content -->
	<section class="content">
			<div class="row">
				<div class="col-lg-3 col-12">
                <div class="box">
								<div class="box-header no-border">
									<h4 class="box-title text-info">
										Mes Rooms
									</h4>
									
								</div>
							
								<div class="box-body p-0">
									<div class="events-side">
										<div class="media-list media-list-hover">
                                            <?php for($i=0;$i<count($List_Room);$i++){?>
											<div class="media media-single">
											  <div class="media-body">
												<h6 class="fw-600 text-success"><a href="#"><?php echo $List_Room[$i]->name;  ?></a></h6>
												<p class="text-fader">Créé en <?php echo $List_Room[$i]->created_on;  ?></p>
											  </div>
											</div>
                                            <?php }?>
											
										</div>
									</div>
									<div class="text-center bt-1 border-light p-10">
										<a class="text-uppercase d-block" href="#" data-bs-toggle="modal" data-bs-target="#modal-room">Ajouter Room</a>
                                        <input type="hidden" id="room_id" value="<?php echo $List_Room[0]->room_id;?>">
								    </div>
								</div>
							</div>
					
				</div>
				<div class="col-lg-9 col-12">
					<div class="row">
						<div class="col-xxxl-8 col-lg-7 col-12">
							<div class="box">
							  <div class="box-header">
								<div class="media align-items-top p-0">
								  <a class="avatar avatar-lg mx-0" href="#">
                                  <img class="rounded-circle" alt="254367925" src="https://t4.ftcdn.net/jpg/02/54/36/79/240_F_254367925_sBZOnoCGBHjjUENteg7VYmxhWPaGqP1Z.jpg">	
	
                                  <div class="d-lg-flex d-block justify-content-between align-items-center w-p100">
								  </a>
										<div class="media-body ">
											<p class="">
											  <a class="hover-primary text-danger" href="#" style="margin-left:0px"><strong>Home</strong></a>
											</p>
											  <p class="fs-12"></p>
										</div>
										<div>
											<!--ul class="list-inline mb-0 fs-18">
												<li class="list-inline-item"><a href="#" class="hover-primary"><i class="fa fa-phone"></i></a></li>
												<li class="list-inline-item"><a href="#" class="hover-primary"><i class="fa fa-video-camera"></i></a></li>
												<li class="list-inline-item"><a href="#" class="hover-primary"><i class="fa fa-ellipsis-h"></i></a></li>
											</-ul-->
										</div>
									</div>				  
								</div>             
							  </div>
							  <div class="box-body">
								  <div class="chat-box-one2" id="ChatListMessage">
									
								
								  </div>
							  </div>
							  <div class="box-footer no-border">
								 <div class="d-md-flex d-block justify-content-between align-items-center bg-white p-5 rounded10 b-1 overflow-hidden">
								 <form name="frmChat" id="frmChat">
                                <div id="chat-box"></div>
                                
							
										<div class="d-flex justify-content-between align-items-center mt-md-0 mt-30">
											<!--button type="button" class="waves-effect waves-circle btn btn-circle me-10 btn-outline-secondary">
												<i class="mdi mdi-link"></i>
											</!--button>
											<button type="button" class="waves-effect waves-circle btn btn-circle me-10 btn-outline-secondary">
												<i class="mdi mdi-face"></i>
											</button>
											<button-- type="button" class="waves-effect waves-circle btn btn-circle me-10 btn-outline-secondary">
												<i class="mdi mdi-microphone"></i>
											</button-->
											<input type="text" name="chat-message" id="chat-message" class="form-control b-0 py-10" size="100" placeholder="Say something..." required />

											<button type="submit" class="waves-effect waves-circle btn btn-circle btn-primary pull-right" style="margin-right:0px" id="btnSend" >
												<i class="mdi mdi-send"></i>
											</button>
										</div>
									</div>
									</form>

							  </div>
							</div>
						</div>
						<div class="col-xxxl-4 col-lg-5 col-12">
                        <div class="box">
						<div class="box-header">
							<ul class="nav nav-tabs customtab nav-justified" role="tablist">
								<!--li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#messages" role="tab">Users </a> </!--li-->
								<li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#contacts" role="tab">Utilisateur</a> </li>
							</ul>
						</div>
						<div class="box-body">
							<!-- Tab panes -->
							<div class="tab-content">
								<!--div class="tab-pane active" id="messages" role="tabpanel">
									<div class="chat-box-one-side3">
										<div class="media-list media-list-hover">
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/2.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Mical Clark</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>

											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/3.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Colin Nathan</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/4.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Nathan Johen</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/5.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Semi Doe</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/6.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Mical</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/7.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Johen Doe</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/2.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Nathan</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/2.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Mical Clark</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>

											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/3.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Colin Nathan</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/4.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Nathan Johen</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/5.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Semi Doe</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/6.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Mical</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/7.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Johen Doe</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
											
											<div class="media">
											  <a class="align-self-center me-0" href="#"><img class="avatar avatar-lg" src="../images/avatar/2.jpg" alt="..."></a>
											  <div class="media-body">
												<p>
												  <a class="hover-primary" href="#"><strong>Nathan</strong></a>
												  <span class="float-end fs-10">10:00pm</span>
												</p>
												<p>Nullam facilisis velit.</p>
											  </div>
											</div>
										</div>
									</div>
								</!--div-->
								<div class="tab-pane active" id="contacts" role="tabpanel">	

									<div class="chat-box-one-side3">
										<div class="media-list media-list-hover" id="UserLists">
                                        <?php  
									
                                    if($invited_users !=null){
                                    for($i=0;$i<count($invited_users);$i++){

										if($invited_users[$i]['K_KEY'] != $_SESSION['K_KEY']){
                                        if($invited_users[$i]['S_IMAGE']!=null){
                                            $urlimage="https://www.yestravaux.com/pro/manager/photos/".$invited_users[$i]['S_IMAGE'];}
                                            else{
                                                $urlimage="../images/Guest2.png";
                                            
                                            }
                                        
                                        if($invited_users[$i]["FK_ROLE"]==2 ||$invited_users[$i]["FK_ROLE"]==NULL ){
                                            $role="Admin";
                                            $class="bg-gradient-grey rounded";
                                            $class3="btn-primary-light";
                                        }
                                        else if($invited_users[$i]["FK_ROLE"]==3){
                                            $role="User";
                                            $class="bg-gradient-ubuntu rounded";
                                            $class3="btn-danger-light";

                                        }
                                        if($invited_users[$i]["S_ETAT_ROLE"]=="sended"){
                                            $etat="sended";
                                            $class2="badge badge-warning";
                                        }
                                        else if($invited_users[$i]["S_ETAT_ROLE"]=="accepted"){
                                            $etat="accepted";
                                            $class2="badge badge-success-light";

                                        } 
										if($invited_users[$i]["S_USER_STATUS"]==NULL || $invited_users[$i]["S_USER_STATUS"]==0){
                                            $classImage="";
                                        }
										else{
											$classImage="status-success";

										}
										
                                        ?>
											<div class="media py-10 px-0 align-items-center">
											  <a class="avatar avatar-lg <?php echo $classImage;  ?>" href="#">
												<img src="<?php echo $urlimage;?>" alt="...">
											  </a>
											  <div class="media-body">
												<p class="fs-16">
												  <a class="hover-primary" href="#"><?php echo $invited_users[$i]['S_NAME'];?></a>
                                                  <span class="<?php echo $class;?> text-white pull-right"><?php echo $role;?></span>
												</p>
											  </div>
											</div>
                                            <?php }}}?>

											<!--div class="media py-10 px-0 align-items-center">
											  <a class="avatar avatar-lg status-danger" href="#">
												<img src="../images/avatar/2.jpg" alt="...">
											  </a>
											  <div class="media-body">
												<p class="fs-16">
												  <a class="hover-primary" href="#">Tommy Nash</a>
												</p>
											  </div>
											</!--div>

											<div class="media py-10 px-0 align-items-center">
											  <a class="avatar avatar-lg status-warning" href="#">
												<img src="../images/avatar/3.jpg" alt="...">
											  </a>
											  <div class="media-body">
												<p class="fs-16">
												  <a class="hover-primary" href="#">Kathryn Mengel</a>
												</p>
											  </div>
											</div>

											<div class="media py-10 px-0 align-items-center">
											  <a class="avatar avatar-lg status-primary" href="#">
												<img src="../images/avatar/4.jpg" alt="...">
											  </a>
											  <div class="media-body">
												<p class="fs-16">
												  <a class="hover-primary" href="#">Mayra Sibley</a>
												</p>
											  </div>
											</div>			

											<div class="media py-10 px-0 align-items-center">
											  <a class="avatar avatar-lg status-success" href="#">
												<img src="../images/avatar/1.jpg" alt="...">
											  </a>
											  <div class="media-body">
												<p class="fs-16">
												  <a class="hover-primary" href="#">Tommy Nash</a>
												</p>
											  </div>
											</div>

											<div-- class="media py-10 px-0 align-items-center">
											  <a class="avatar avatar-lg status-danger" href="#">
												<img src="../images/avatar/2.jpg" alt="...">
											  </a>
											  <div class="media-body">
												<p class="fs-16">
												  <a class="hover-primary" href="#">Williemae Lagasse</a>
												</p>
											  </div>
											</div-->
										  </div>
									</div>
								</div>
							</div>
						</div>
					</div>
						</div>
					</div>

				</div>
			</div>
            <div class="modal center-modal fade" id="modal-room">
                <div class="modal-dialog">
                    <div class="modal-content bg-lightest  modal-content2" >
                        <div class="modal-header bg-lightest modal-header2" style="text-align:center">
                        <h5 class=" text-Success" style="text-align:center"><b><span>Ajouter Room</span></b></h5>
                            <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                        </div>
                        <div class="modal-body">
                        
							<form action="#" class="" id="formusers">
                            <div class="form-group row">

                            <div class="col-sm-12">
                                <input type="text"class="form-control modal-input2 required" id="name_room" name="name_room" placeholder="Enter Your Name Room" required>
                            </div>
                            </div>
                            <div class="form-group row" >
                       
                            <input type="hidden" id="kkey" value="<?php echo $_SESSION['K_KEY'];?>">
                            <input type="hidden" id="pk_user" value="<?php echo $_SESSION['PK_USER'];?>">
                            <input type="hidden" id="user_browser" value="<?php echo $clientBrowser;?>">
							<input type="hidden" id="user_name" value="<?php echo $connectedUser->S_NAME;?>">
                            <input type="hidden" id="user_photo" value="<?php echo $urlimage;?>">

                            <?php $link="https://yestravaux.com/crm2/app/components/pages/accepte_invitation.php?email=";?>
							</form>
						
		
						<div class="modal-footer modal-footer-uniform">
                            <!--div style="margin-left:170px" class="pull-right" id="confirmCopy"></div-->

							<button style="" class="btn btn-sm bg-gradient-grey" style="padding-left:100px" name="Send" id="" onClick="CreateRoom()">Ajouter</button>

						</div>
					</div>
				</div>
			</div>
		</section>
    <!-- /.content-wrapper -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
	function showMessage(messageHTML) {
		
		$('#chat-box').append(messageHTML);
	}

	$(document).ready(function(){
		
	setTimeout(() => {
		    var room_id=document.getElementById('room_id').value;
            var pk_user=document.getElementById('pk_user').value;
            var k_key=document.getElementById('kkey').value;	
		$.ajax({
					url:'https://api.hosteur.pro/webservice/crm/chat.php',
					type: "POST",
					dataType: "html",
					data: {fct:'GetMessages',room_id:room_id,pk_user:pk_user,k_key:k_key},
					async: true,
					success:function(data){	
						//console.log(data);
						document.getElementById('ChatListMessage').innerHTML=data;
						$('#ChatListMessage').scrollTop($('#ChatListMessage').height())
						document.getElementById("ChatListMessage").scrollTop= document.getElementById("ChatListMessage").scrollHeight;
					}
				});


				 
	},500);
	});

	$(document).ready(function(){
		//var websocket = new WebSocket("ws://desk.hosteur.pro:8090/app/components/pages/php-socket.php"); 

		var websocket = new WebSocket("wss://185.148.76.20:8090/"); 
		websocket.onopen = function(event) { 
		console.log("opeening connection to websocket");
		
		}

		websocket.onmessage = function(event) {
			var id_room=document.getElementById('room_id').value;
            var pkuser=document.getElementById('pk_user').value;
            var kkey=document.getElementById('kkey').value;	
			var user_name=document.getElementById('user_name').value;	
			var user_photo=document.getElementById('user_photo').value;	


			var Data = JSON.parse(event.data);
			//showMessage("<div class='"+Data.message_type+"'>"+Data.message+""+Data.room_id+" "+Data.pk_user+" "+Data.k_key+"</div>");
            var message=Data.message;
			var room_id=Data.room_id;
			var pk_user=Data.pk_user;
			var k_key=Data.k_key;
			// $.ajax({
			// 		url:'https://api.hosteur.pro/webservice/crm/chat.php',
			// 		type: "POST",
			// 		dataType: "html",

			// 		data: {fct:'GetMessages',room_id:room_id,pk_user:pk_user,k_key:k_key},
			// 		async: true,
			// 		success:function(data){	
			// 			console.log(data);
			// 			//$('#chat-box').append(data.output);
			// 			//$('#ChatListMessage').html('');

			// 			$('#ChatListMessage').html(data);

					
			// 		}
			// 	});

			
				$.ajax({
					url:'https://www.yestravaux.com/webservice/crm/Auth.php',
					type: "POST",
					dataType: "html",

					data: {fct:'UserProfil',pk_user:pk_user,kkey:k_key},
					async: true,
					success:function(data){	
						data=JSON.parse(data);
						//console.log(data);
						//$('#chat-box').append(data.output);
						// $('#ChatListMessage').html('data');

						// $('#ChatListMessage').append(data);
						if(data.S_IMAGE !=null){
				var urlimage="https://www.yestravaux.com/pro/manager/photos/"+data.S_IMAGE;}
				else{
					var urlimage="images/Guest2.png";
				
				}
				if(k_key==kkey){

				$('#ChatListMessage').append('<div class="mb-3 float-end me-2 max-w-p80"><div class="position-absolute pt-1 pe-2 r-0"><span class="text-extra-small"></span> </div> <div class="card-body"> <div class="chat-text-start ps-55"> <p class="mb-0 text-semi-muted bg-light rounded text-info">'+message+'</p></div> </div> </div><div class="clearfix"></div>');
				document.getElementById("ChatListMessage").scrollTop= document.getElementById("ChatListMessage").scrollHeight;

			}
				else{
					$('#ChatListMessage').append('<div class="mb-3 float-start no-shadow me-2 max-w-p80"><div class="position-absolute pt-1 pe-2 r-0"><span class="text-extra-small"></span> </div> <div class="card-body"><div class="d-flex flex-row pb-2"><a class="d-flex" href="#"> <img alt="Profile" src="'+urlimage+'" class="avatar me-10"> </a><div class="d-flex flex-grow-1 min-width-zero">  <div class="m-2 ps-0 align-self-center d-flex flex-column flex-lg-row justify-content-between"> <div class="min-width-zero">  <p class="mb-0 fs-16 text-dark">'+data.S_NAME+'</p> </div> </div> </div> </div> <div class="chat-text-start ps-55"> <p class="mb-0 text-semi-muted  rounded text-fade">'+message+'</p></div> </div> </div><div class="clearfix"></div>');
					document.getElementById("ChatListMessage").scrollTop= document.getElementById("ChatListMessage").scrollHeight;

				}
				$('#ChatListMessage').scrollTop($('#ChatListMessage').height());
				document.getElementById("ChatListMessage").scrollTop= document.getElementById("ChatListMessage").scrollHeight;


					
					}
				});

			
			         

			$('#chat-message').val('');
		};
		
		websocket.onerror = function(event){
			showMessage("<div class='error'>Problem due to some Error</div>");
			console.log(event);
		};
		websocket.onclose = function(event){
			showMessage("<div class='chat-connection-ack'>Connection Closed</div>");
			console.log(event.code);
			console.log(event.reason);

		}; 
		
		$('#frmChat').on("submit",function(event){
			event.preventDefault();
			$('#chat-user').attr("type","hidden");
            var id_room=document.getElementById('room_id').value;
            var pkuser=document.getElementById('pk_user').value;
            var kkey=document.getElementById('kkey').value;		
            console.log(pkuser);
            console.log(kkey);

		
			var messageJSON = {
				chat_user: "Test",
				chat_message: $('#chat-message').val(),
                room_id:id_room,
                pk_user:pkuser,
                k_key:kkey

			};
			$.ajax({
					url:'https://api.hosteur.pro/webservice/crm/chat.php',
					type: "POST",
					dataType: "html",

					data: {fct:'InsertMessage',message: $('#chat-message').val(),room_id:id_room,pk_user:pkuser,k_key:kkey},
					async: true,
					success:function(data){	
						console.log(data);
						//$('#chat-box').append(data.output);
						// $('#ChatListMessage').html('data');

						// $('#ChatListMessage').append(data);

					
					}
				});
			websocket.send(JSON.stringify(messageJSON));

			
		});
	});




</script>