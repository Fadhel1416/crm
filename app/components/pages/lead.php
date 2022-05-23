<?php 
namespace App;
	/*if(isset($_REQUEST["notemessage"])){

		$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
	$data = array('message' =>htmlspecialchars($_POST["notemessage"]),
		'id_lead'  =>$_REQUEST["id"],'operateur'=>htmlspecialchars($_POST["userlead"]),'datepublish'=>date('d-m-y'));
	// $data={"companyName":$_POST["firstName"],"userId":"1"};
	
	$data=json_encode($data);
		$POSTVALUE  = 'fct=addnote&data='.$data;
		
		$datacamp =curl_do_post($URL,$POSTVALUE); 

		header("Refresh:0");

	}*/
	session_start();

	if(!isset($_SESSION["PK_USER"])){

		echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
	  
	  }
	  
	$clientBrowser = $_SERVER['HTTP_USER_AGENT'];

	function diff_date($date1, $date2) {  
		$second = floor($date1 - $date2);
		if ($second == 0) return "0";

		return array("an"         => (date('Y', $second)-1970)-1, 
				"mois"      => date('m', $second)-1,
				"semaine" => floor((date('d', $second)-1)/7),
				"jour"	 => (date('d', $second))%7,
				"heure"     => date('H', $second)-1, 
				"minute"   => date('i', $second), 
				"seconde" => date('s', $second)
				);
	}
$lead_id =$_REQUEST["id"];
$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
$POSTVALUE  = 'fct=InfoLead&lead_id='.$lead_id;
$datalead = curl_do_post($URL,$POSTVALUE);
$datalead = json_decode($datalead);
$datalead = (array) $datalead;
$dataleadid = (array) $datalead['_id'];
$datalead['_id'] = $dataleadid['$id'];


$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
$POSTVALUE  = 'fct=GetTask&lead_id='.$lead_id;
$dataTASK = curl_do_post($URL,$POSTVALUE);
$dataTASK = json_decode($dataTASK);
$dataTASK = (array) $dataTASK;
$URL= 'https://www.yestravaux.com/webservice/crm/lead.php';
$POSTVALUE  = 'fct=GetFinishedTask&lead_id='.$lead_id;
$datafinishTASK = curl_do_post($URL,$POSTVALUE);
$datafinishTASK = json_decode($datafinishTASK);
$datafinishTASK = (array) $datafinishTASK;
//var_dump($dataTASK);
$tabscale=[120,300,480,600,780,960,1020,1200,1380,1500,1680];

/*$date1 = strtotime("22-02-10");
$date2 = strtotime(date('y-m-d'));
 
// On récupère la différence de timestamp entre les 2 précédents
$nbJoursTimestamp = $date2 - $date1;
 
// ** Pour convertir le timestamp (exprimé en secondes) en jours **
// On sait que 1 heure = 60 secondes * 60 minutes et que 1 jour = 24 heures donc :
$nbJours = $nbJoursTimestamp/86400;
var_dump($nbJours);*/


?>

	  <div class="container-full">
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Campanies</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Leads</li>
								<li class="breadcrumb-item active" aria-current="page">Profile</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Main content -->
		<section class="content">

			<div class="row">
				<div class="col-12 col-lg-7 col-xl-8">
					
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						
					<li><a href="#settings" data-bs-toggle="tab" class="active">Info</a></li>
					<li><a href="#usertimeline" data-bs-toggle="tab">Notes</a></li>
					<li><a href="#usersequence" data-bs-toggle="tab">Séquences Programmés</a></li>
					<li><a href="#userhistorique" data-bs-toggle="tab">Historique de séquences</a></li>
					
				</ul>

				<div class="tab-content">


				<div class="tab-pane" id="usersequence">
					<?php
										
					$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
					$POSTVALUE  = 'fct=GetTask&lead_id='.$lead_id;
					$dataTASK = curl_do_post($URL,$POSTVALUE);
					$dataTASK = json_decode($dataTASK);
					$dataTASK = (array) $dataTASK;
					?>
						<div class="row">
						<div class="col-md-12">
						<div class="">
							<section class="cd-horizontal-timeline loaded" style="margin:0">
								<div class="timeline">
									<div class="events-wrapper">
										<div class="events" style="width: 1800px;">
											<ol>

												<?php 
												if(strtotime($dataTASK[0]->date) >= strtotime(date('y-m-d'))){?>
											<li><a href="#1" data-date="<?php echo $dataTASK[0]->date;?>" class="selected" style="left: 120px;"><?php echo date('y M d',strtotime($dataTASK[0]->date));?></a></li>
										<?php } ?>
											<?php for($i=1;$i<count($dataTASK);$i++){ $j=$i+1;
											if(strtotime($dataTASK[$i]->date) >=strtotime(date('y-m-d'))){
											?>
											<li><a href="#1" data-date="<?php echo $dataTASK[$i]->date;?>" style="left: <?php echo $tabscale[$i];?>px;"><?php echo date('y M d',strtotime($dataTASK[$i]->date));?></a></li>
											

												<?php 
												}
											}
											if($dataTASK[0]->date <date('y-m-d') || $dataTASK==null) {?>
											<li><a href="#1" data-date="27/10/1996" class="selected" style="left: 120px;"></a></li>
										<?php }?>

                                                



											</ol> <span class="filling-line" aria-hidden="true" style="transform: scaleX(0.0785243);"></span> </div>
										<!-- .events -->
									</div>
									<!-- .events-wrapper -->
									<ul class="cd-timeline-navigation">
										<li><a href="#1" class="prev inactive">Prev</a></li>
										<li><a href="#1" class="next">Next</a></li>
									</ul>
									<!-- .cd-timeline-navigation -->
								</div>
								<!-- .timeline -->
								<div class="events-content">
									<ol>
									
									<?php if(strtotime($dataTASK[0]->date)>=strtotime(date('y-m-d'))){?>

									<li class="selected" data-date="<?php echo $dataTASK[0]->date;?>">
										<?php if($dataTASK[0]->action_type==1){
											$action="EMAIL";
											$spanclass="info-box-icon bg-info rounded";
										$iconClass="ti-email";
										}
										else if($dataTASK[0]->action_type==2){
											$action="SMS";
											$spanclass="info-box-icon bg-warning rounded";
										$iconClass="ti-comment-alt";
										}
										else{
										$action="CALL";
										$spanclass="info-box-icon bg-danger rounded";
										$iconClass="mdi mdi-phone-in-talk";
										}?>
										<h2><span class="<?php echo $spanclass;?>"><i class="<?php echo $iconClass;?>"></i></span> <span style="padding-left:15px"><?php echo $action;?><br><small style="padding-left:15px"><?php echo date('y M d',strtotime($dataTASK[0]->date));?></small></span></h2>
										<hr class="my-30">
										
									</li>
									<?php }?>
									<?php for($i=1;$i<count($dataTASK);$i++){
											$j=$i+1;
											if($dataTASK[$i]->action_type==1){
											$action="EMAIL";
											$spanclass="info-box-icon bg-info rounded";
											$iconClass="ti-email";
										}
									else if($dataTASK[$i]->action_type==2){
										$action="SMS";
										$spanclass="info-box-icon bg-warning rounded";
										$iconClass="ti-comment-alt";
									}
										else{
											$action="CALL";
											$spanclass="info-box-icon bg-danger rounded";
										$iconClass="mdi mdi-phone-in-talk";
										}
										if(strtotime($dataTASK[$i]->date) >=strtotime(date('y-m-d'))){
											?>

										<li data-date="<?php echo $dataTASK[$i]->date;?>">
										<h2><span class="<?php echo $spanclass;?>"><i class="<?php echo $iconClass;?>"></i></span> <span style="padding-left:15px"><?php echo $action;?><br><small style="padding-left:15px"><?php echo date('y M d',strtotime($dataTASK[$i]->date));?></small><br></span></h2>
											<hr class="my-30">
											
										</li>
										<?php }}
										if($dataTASK[0]->date <date('y-m-d') || $dataTASK==null){?>
										<li data-date="27/10/1996">
										<hr class="my-30">	
										</li>
										<?php }?>
										
									
									</ol>
								</div>
								<!-- .events-content -->
							</section>
						</div>          
						</div>
						<!-- /.col -->
					</div>
                    <div class="row">
						<div class="col-xl-12 connectedSortable ui-sortable">
						<div class="box">
							<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
							<h4 class="box-title text-info">Actions à effecturer </h4>

							<ul class="box-controls pull-right">
								<li><a class="box-btn-close" href="#"></a></li>
								<li><a class="box-btn-slide" href="#"></a></li>	
								<li><a class="box-btn-fullscreen" href="#"></a></li>
							</ul>
							</div>
							<div class="box-body p-0">
							<ul class="todo-list ui-sortable">
							<?php if(strtotime($dataTASK[0]->date)< strtotime(date('y-m-d'))){?>
								<!--span class="badge text-danger">No tasks prévues for this lead</!--span-->
								<span class="box bg-warning-light box-header " style="font-size:20px">Aucun tache à traité</span>

								<?php }?>
							<?php for($i=0;$i<count($dataTASK);$i++){

								if(strtotime($dataTASK[$i]->date) == strtotime(date('y-m-d'))){
								$date1 =strtotime(date('y-m-d'));
								$date2 = strtotime($dataTASK[$i]->date);
									
									// On récupère la différence de timestamp entre les 2 précédents
									$nbJoursTimestamp = $date2 - $date1;
									
									// ** Pour convertir le timestamp (exprimé en secondes) en jours **
									// On sait que 1 heure = 60 secondes * 60 minutes et que 1 jour = 24 heures donc :
								$nbJours = $nbJoursTimestamp/86400;
								$day=date("y",strtotime($dataTASK[$i]->date));
								$mois=date("m",strtotime($dataTASK[$i]->date));
								$annee=date("d",strtotime($dataTASK[$i]->date));
								$dateDifference = abs(strtotime($dataTASK[$i]->date)-strtotime(date('y-m-d')));
								$years  = round($dateDifference / (365 * 60 * 60 * 24));
								$months = round(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
								$days =round(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
                                if($days==0){
								if($dataTASK[$i]->action_type==1){
									$action="EMAIL";
									$spanclass="info-box-icon bg-info rounded";
									$iconClass="ti-email";
									$background="bg-info";
									$textcolor="text-info";
									$data=$datalead["email"];

								}
								else if($dataTASK[$i]->action_type==2){
									$action="SMS";
									$spanclass="info-box-icon bg-warning rounded";
									$iconClass="ti-comment-alt";
									$background="bg-warning";
									$textcolor="text-warning";
									$data=$datalead["phone"];
								}
								else{
									$action="CALL";
									$spanclass="info-box-icon bg-danger rounded";
									$iconClass="mdi mdi-phone-in-talk";
									$background="bg-danger";
									$textcolor="text-danger";
									$data=$datalead["phone"];
								}
								$URL= 'https://www.yestravaux.com/webservice/crm/lead.php';
								$POSTVALUE='fct=VerifTask&lead_id='.$dataTASK[$i]->leadID.'&type='.$dataTASK[$i]->action_type.'&seq_id='.$dataTASK[$i]->seq_id;
								$dataleadtask=curl_do_post($URL,$POSTVALUE);
								$dataleadtask=json_decode($dataleadtask);
								$dataleadtask=(array) $dataleadtask;
						        if($dataleadtask==null){


								?>
								<li id="<?php echo $i;?>">
								<!-- drag handle -->
								<span class="handle ui-sortable-handle">
										<i class="fa fa-ellipsis-v"></i>
										<i class="fa fa-ellipsis-v"></i>
									</span>
								<!-- checkbox -->
								
								<!-- todo text -->
								<span class="text-line <?php echo $textcolor;?>"><i class="<?php echo $iconClass;?>"></i> <?php echo $action;?><br><span class="text-fade"style="padding-left:30px;font-size:10px"><?php echo $dataTASK[$i]->date;?> at <?php echo $dataTASK[$i]->time;?></span></span>
								<!-- Emphasis label -->
                                 <?php if($dataTASK[$i]->action_type==3){?>
								<a class="badge <?php echo $background;?> pull-right" style="margin-left:200px" onclick="AddTask('<?php echo $dataTASK[$i]->action_type;?>','<?php echo $dataTASK[$i]->camp_id;?>','<?php echo $dataTASK[$i]->leadID;?>','<?php echo $i;?>','<?php echo $dataTASK[$i]->seq_id;?>')">Terminer</a>
								
								<?php }?>
								
								<small class="text-info" style="margin-left:100px"><i class="<?php echo $iconClass;?>"></i> <?php echo $data;?></small>

								<small class="badge <?php echo $background;?> pull-right" style="margin-left:200px"><i class="fa fa-clock-o"></i> today</small>
								<!-- General tools such as edit or delete-->
								<div class="tools">
									<i class="fa fa-edit"></i>
									<i class="fa fa-trash-o"></i>
								</div>
								</li>
				                <?php }}}}?>
							</ul>
							</div>
							<!-- /.box-body -->
						</div>
						</div>
		
						<div class="col-xl-12 connectedSortable ui-sortable">
						<div class="box">
							<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
							<h4 class="box-title text-info">Actions prévues</h4>

							<ul class="box-controls pull-right">
								<li><a class="box-btn-close" href="#"></a></li>
								<li><a class="box-btn-slide" href="#"></a></li>	
								<li><a class="box-btn-fullscreen" href="#"></a></li>
							</ul>
							</div>
							<div class="box-body p-0">
							<ul class="todo-list ui-sortable">
							<?php if(strtotime($dataTASK[0]->date)< strtotime(date('y-m-d'))){?>
								<!--span class="badge text-danger">No tasks prévues for this lead</!--span-->
								<span class="box bg-warning-light box-header " style="font-size:20px">Aucun taches prévues</span>

								<?php }?>
				
							<?php for($i=0;$i<count($dataTASK);$i++){
								$k=0;
								if(strtotime($dataTASK[$i]->date) > strtotime(date('y-m-d'))){

								$date1 =strtotime(date('y-m-d'));
								$date2 = strtotime($dataTASK[$i]->date);
								 
								// On récupère la différence de timestamp entre les 2 précédents
								$nbJoursTimestamp = $date2 - $date1;
								 
								// ** Pour convertir le timestamp (exprimé en secondes) en jours **
								// On sait que 1 heure = 60 secondes * 60 minutes et que 1 jour = 24 heures donc :
								$nbJours = $nbJoursTimestamp/86400;
								$day=date("y",strtotime($dataTASK[$i]->date));
								$mois=date("m",strtotime($dataTASK[$i]->date));
								$annee=date("d",strtotime($dataTASK[$i]->date));
								$dateDifference = abs(strtotime($dataTASK[$i]->date)-strtotime(date('y-m-d')));
								$years  = round($dateDifference / (365 * 60 * 60 * 24));
								$months = round(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
								$days =round(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
                                if($days!=0){
								if($dataTASK[$i]->action_type==1){
									$action="EMAIL";
									$spanclass="info-box-icon bg-info rounded";
									$iconClass="ti-email";
									$background="bg-info";
									$textcolor="text-info";
									$data=$datalead["email"];
								}
								else if($dataTASK[$i]->action_type==2){
									$action="SMS";
									$spanclass="info-box-icon bg-warning rounded";
									$iconClass="ti-comment-alt";
									$background="bg-warning";
									$textcolor="text-warning";
									$data=$datalead["phone"];
								}
								else{
									$action="CALL";
									$spanclass="info-box-icon bg-danger rounded";
									$iconClass="mdi mdi-phone-in-talk";
									$background="bg-danger";
									$textcolor="text-danger";
									$data=$datalead["phone"];
								}
								
								?>
								<li>
								<!-- drag handle -->
								<span class="handle ui-sortable-handle">
										<i class="fa fa-ellipsis-v"></i>
										<i class="fa fa-ellipsis-v"></i>
									</span>
								<!-- checkbox -->
								
								<!-- todo text -->
								<span class="text-line <?php echo $textcolor;?>"><i class="<?php echo $iconClass;?>"></i> <?php echo $action;?><br><span class="text-fade"style="padding-left:30px;font-size:10px"><?php echo $dataTASK[$i]->date;?> at <?php echo $dataTASK[$i]->time;?></span></span>
								<!-- Emphasis label -->
								<small class="text-info text-line <?php echo $textcolor;?>" style="margin-left:100px"><i class="<?php echo $iconClass;?>"></i> <?php echo $data;?></small>

								<small class="badge <?php echo $background;?> pull-right" ><i class="fa fa-clock-o"></i> <?php echo $days;?> Jours</small>
								<!-- General tools such as edit or delete-->
								<div class="tools">
									<i class="fa fa-edit"></i>
									<i class="fa fa-trash-o"></i>
								</div>
								</li>
								
								<?php }}}?>
									
								</ul>
								</div>
								<!-- /.box-body -->
							</div>
							</div>	
			</div>
					</div>

				<div class="tab-pane" id="userhistorique">
							<div class="row">
						<div class="col-md-12">
						<div class="box">
							<section class="cd-horizontal-timeline loaded" style="margin:0">
								<div class="timeline">
									<div class="events-wrapper">
										<div class="events" style="width: 1800px;">
											<ol>
												<?php if($datafinishTASK!=null){?>
											<li><a href="#0" data-date="<?php echo $datafinishTASK[0]->date;?>" class="selected" style="left: 120px;"><?php echo date('y M d',strtotime($datafinishTASK[0]->date));?></a></li>

													<?php for($i=1;$i<count($datafinishTASK);$i++){ $j=$i+1;?>
													<li><a href="#0" data-date="<?php echo $datafinishTASK[$i]->date;?>" style="left: <?php echo $tabscale[$i];?>px;"><?php echo date('y M d',strtotime($datafinishTASK[$i]->date));?></a></li>


													<?php }}?>

											</ol> <span class="filling-line" aria-hidden="true" style="transform: scaleX(0.0785243);"></span> </div>
										<!-- .events -->
									</div>
									<!-- .events-wrapper -->
									<ul class="cd-timeline-navigation">
										<li><a href="#0" class="prev inactive">Prev</a></li>
										<li><a href="#0" class="next">Next</a></li>
									</ul>
									<!-- .cd-timeline-navigation -->
								</div>
								<!-- .timeline -->
								<div class="events-content">
								
									<ol>
									<?php if(array_key_exists("nom_prenom",$datalead)){
												$nom=$datalead['nom_prenom'];
											}
											else{
												$nom=$datalead['nom']." ".$datalead['prenom'];

											}?>
									<?php if($datafinishTASK !=null){?>

										<li class="selected" data-date="<?php echo $datafinishTASK[0]->date;?>">
											<?php if($datafinishTASK[0]->action_type==1){
												$action="EMAIL";
												$spanclass="info-box-icon bg-info rounded";
												$iconClass="ti-email";
												$data=$datalead["email"];
												$textcolor="text-info";


											}
											else if($datafinishTASK[0]->action_type==2){
												$action="SMS";
												$spanclass="info-box-icon bg-warning rounded";
												$iconClass="ti-comment-alt";
												$data=$datalead["phone"];
												$textcolor="text-warning";


											}
											else{
												$action="CALL";
												$spanclass="info-box-icon bg-danger rounded";
												$iconClass="mdi mdi-phone-in-talk";
												$data=$datalead["phone"];
												$textcolor="text-danger";


											}?>
												<h2><span class="<?php echo $spanclass;?>"><i class="<?php echo $iconClass;?>"></i></span> <span style="padding-left:15px"><?php echo $action;?><br><small style="padding-left:15px"><?php echo date('y M d',strtotime($datafinishTASK[0]->date));?></small></span></h2>
												<hr class="my-30">
												<span class="<?php echo $textcolor;?>"><i class="<?php echo $iconClass;?>"></i><span><?php echo $data;?></span>
											
												<span class="text-fade" style="padding-left:30px"><?php echo date('y M d',strtotime($datafinishTASK[0]->date));?>-<?php echo $datafinishTASK[0]->time;?></span>
												<span class="<?php echo $textcolor;?>" style="padding-left:30px"><?php echo $nom;?></span>
												<span class="badge bg-success pull-right" ><?php echo $datafinishTASK[0]->status;?></span>
										</span>
												
										
											
										</li>

											<?php 
											for($i=1;$i<count($datafinishTASK);$i++){
												$j=$i+1;
												if($datafinishTASK[$i]->action_type==1){
													$action="EMAIL";
													$spanclass="info-box-icon bg-info rounded";
													$iconClass="ti-email";
													$data=$datalead["email"];
												$textcolor="text-info";
												}
												else if($datafinishTASK[$i]->action_type==2){
													$action="SMS";
													$spanclass="info-box-icon bg-warning rounded";
													$iconClass="ti-comment-alt";
													$data=$datalead["phone"];
													$textcolor="text-warning";
												}
												else{
												$action="CALL";
												$spanclass="info-box-icon bg-danger rounded";
												$iconClass="mdi mdi-phone-in-talk";
												$data=$datalead["phone"];
												$textcolor="text-danger";
												}
												?>

											<li data-date="<?php echo $datafinishTASK[$i]->date;?>">
											<h2><span class="<?php echo $spanclass;?>"><i class="<?php echo $iconClass;?>"></i></span> <span style="padding-left:15px"><?php echo $action;?><br><small style="padding-left:15px"><?php echo date('y M d',strtotime($datafinishTASK[$i]->date));?></small><br></span></h2>
												<hr class="my-30">
											<span class="<?php echo $textcolor;?>"><i class="<?php echo $iconClass;?>"></i><span><?php echo $data;?></span>
											
											<span class="text-fade" style="padding-left:30px"><?php echo date('y M d',strtotime($datafinishTASK[$i]->date));?>-<?php echo $datafinishTASK[$i]->time;?></span>
											<span class="<?php echo $textcolor;?>" style="padding-left:30px"><?php echo $nom;?></span>
											<span class="badge bg-success pull-right"><?php echo $datafinishTASK[$i]->status;?></span>
										</span>
											
											</li>
											<?php }}?>
										</ol>
									</div>
								<!-- .events-content -->
							</section>
						</div>          
						</div>
						<!-- /.col -->
					</div>
					</div>

					<div class="tab-pane" id="usertimeline">
						<div class="publisher publisher-multi bg-white b-1 mb-30">
						<form action="#" method="POST" id="formaddnote">
						<textarea class="textarea" id="mytextarea" placeholder="Add your own note" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

						<input type="hidden" name="idlead" id="idlead" value="<?php echo $datalead['_id'];?>">
						
						<input type="hidden" name="userlead" id="userlead" value="<?php echo $datalead['nom_prenom'];?>">

						
						<div class="flexbox">
							<div class="gap-items">
							
							
							</div>
							<br>
							<input type="button"  value="Ajouter" class="btn btn-sm bg-success  rounded"  style="margin-top:2px"name="Ajouter" id="AddNote">

							</form>
						</div>
					</div> 
					<div class="box p-15"> 
						<div class="timeline timeline-single-column timeline-single-full-column" id="idtimeline">
							
							<span class="timeline-label">
								<span class="badge badge-info badge-pill">Notes</span>
							</span>
                            <?php 
								$URL    ='https://www.yestravaux.com/webservice/crm/lead.php';
								$POSTVALUE  ='fct=ListNoteByLead&lead_id='.$datalead['_id'];
								$listnote_bylead=curl_do_post($URL,$POSTVALUE);
								$listnote_bylead=json_decode($listnote_bylead);
								$listnote_bylead=(array) $listnote_bylead;
								?>
								<?php for($i=count($listnote_bylead)-1;$i>=0;$i--) { 
									
									/*$d=mktime(11, 14, 54, 8, 12, 2014);
								echo "Created date is " . date("Y-m-d h:i:sa", $d);*/
									?>
							
							<div class="timeline-item">
								<div class="timeline-point timeline-point-info">
									<i class="ion ion-chatbubble-working"></i>
								</div>
								<div class="timeline-event">
									<div class="timeline-heading">
										<h4 class="timeline-title"><a href="#"><?php echo $listnote_bylead[$i]->operateur;?></a><small> a ajouté cette note</small></h4>
										<small class="text-fade spanchart-content"><i class="fa fa-calendar"></i><?php echo date("y, M d",strtotime($listnote_bylead[$i]->datepublish)) .' '.date('h:i:s',strtotime($listnote_bylead[$i]->time));?></small>
									</div>
									<div class="timeline-body">
										<p><?php echo $listnote_bylead[$i]->message;?></p>									
									</div>
									<div class="timeline-footer">
									<?php 
									$day=date("y",strtotime($listnote_bylead[$i]->datepublish));
									$mois=date("m",strtotime($listnote_bylead[$i]->datepublish));
									$annee=date("d",strtotime($listnote_bylead[$i]->datepublish));
									$dateDifference = abs(strtotime(date('y-m-d')) - strtotime($annee.'-'.$mois.'-'.$day));
									$years  = floor($dateDifference / (365 * 60 * 60 * 24));
									$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
									$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
									if($years != 0)
									{
									$class="badge bg-danger";
									$date=$years;
									$cle="année";
									}
									else{
									if($months != 0)
									{
									if($months <12)
									{
									$class="badge bg-warning";
									$date=$months;
									$cle="mois";
									}
									else{
									$class="badge bg-danger";
									$date=1;
									$cle="année";
									}
									}
									else{
									if($days != 0){
									if($days>=7 && $days<=27)
									{
									$date=$days/7;
									$class="badge bg-info";
									if(strpos($date,'.')!== false){
									$date=strstr($date, '.', true);
									}
									$cle="semaine";
									}
									else if($days>=28)
									{
									$class="badge bg-warning";
									$date=1;
									$cle="mois";
									}
									else{
									$date=$days;
									$class="badge bg-primary";

									$cle="jour";
									}
									}
									else{
									$date=0;
									$class="badge bg-primary";

									$cle="jour";
									}
									}
									}
									?>                                
									<p class="pull-right" style="padding-bottom:3px"><small  class="<?php echo $class;?>"><i class="fa fa-clock-o"></i> <?php echo $date;?> <?php echo $cle;?></small></p>

								</div>
								</div></div>
							<?php }?>		
							<span class="timeline-label">
								<button class="btn btn-danger"><i class="fa fa-clock-o"></i></button>
							</span>
						</div>
					</div>  
					</div>    
					<div class="tab-pane active" id="settings">		
					
						<div class="box no-shadow">		
							<form class="form-horizontal form-element col-12" id="formUpdateLead">
							<?php foreach($datalead as $cle => $valeur) {  
								if($cle =='_id' or $cle == 'campaign_id' or $cle == 'campaign_id' or $cle=='companyName'){ $disabled="disabled " ;} else {$disabled ="";}
								if($cle =='email'){ $type='email';} else if ($cle=='phone') {$type ="tel";}else{ $type="text";}
								if($cle != 'status') {

									?>
								
							<div class="form-group row">
								<label for="<?php echo $cle ; ?>" class="col-sm-2 form-label"><?php echo $cle ; ?></label>

								<div class="col-sm-10">
								<input type="<?php echo $type; ?>" class="form-control" id="<?php echo $cle ; ?>" name="<?php echo $cle ; ?>" placeholder="" value="<?php echo $valeur ; ?>" <?php echo $disabled; ?>>
								</div> 
							</div>

							<?php } } ?> 
							
							
							</form>
							<div class="form-group row">
								<div class="ms-auto col-sm-10">
								<button type="submit" class="btn btn-success" id="SaveInfoLead">Enregistrer</button>
								</div>
							</div>
						</div>			  
					</div>
					<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.nav-tabs-custom -->
				</div>
			<!-- /.col -->		
				<?php     
				if($datalead['converted']==0){
					$class="btn bg-gradient-ubuntu";
					$value="Convert";
				}
				else{
					$class="btn bg-gradient-oceansky";
					$value="Converted";

				}
				?>
				<div class="col-12 col-lg-5 col-xl-4">
					<div class="box box-widget widget-user">
						<!-- Add the bg color to the header using any of the bg-* classes -->
						<div class="widget-user-header bg-img bbsr-0 bber-0" style="background: url('../images/gallery/full/10.jpg') center center;" data-overlay="5">
						<?php if(array_key_exists("nom_prenom",$datalead)){
							$nom=$datalead['nom_prenom'];
						}
						else{
							$nom=$datalead['nom']." ".$datalead['prenom'];

						}?>
						<h3 class="widget-user-username text-white"><?php echo $nom;?></h3>
						<!--h6 class="widget-user-desc text-white"><?php echo $datalead['_id'];?></h6-->
						<h6 class="widget-user-desc text-white"><?php echo $datalead['societe'];?></h6>
						<h6 class="widget-user-desc text-white pull-right"><button id="leadconvert" class="<?php echo $class;?> px-15 py-15 rounded20" onClick="ConvertLead('<?php echo $datalead['_id'];?>');"><?php echo $value;?></button></h6>

						</div>
						<div class="widget-user-image">
						<img class="rounded-circle" src="../images/user3-128x128.jpg" alt="User Avatar">
						</div>
						<div class="box-footer">
						<div class="row">
							<div class="col-sm-4">
							<div class="description-block">
								<h5 class="description-header">Campagne</h5>
								<span class="description-text"><?php echo $datalead['companyName']; ?></span>
							</div>
							<!-- /.description-block -->
							</div>
							<!-- /.col -->
							<div class="col-sm-4 be-1 bs-1" id="updatestatusid">
							<div class="description-block">
							<h5 class="description-header">Status</h5>
							<?php 
							$lead_id =$_REQUEST["id"];
							$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
							$POSTVALUE  = 'fct=InfoLead&lead_id='.$lead_id;
							$datalead = curl_do_post($URL,$POSTVALUE);
							$datalead = json_decode($datalead);
							$datalead = (array) $datalead;
							$dataleadid = (array) $datalead['_id'];
							$datalead['_id'] = $dataleadid['$id'];

							if($datalead['status'] == 2){

								$class="btn-success";}
								elseif($datalead['status'] == 1){
									$class="btn-danger";
								}
								else{
									$class="btn-warning";
								}
								?>
								<select class="custom-select <?php echo $class ;?>" id="<?php echo 'statelead2'.$datalead['_id'];?>" onChange="UpdateStatusLead('<?php echo $datalead['_id'];?>');">
								<option value="2" <?php if($datalead['status'] == 2){ echo "selected" ;}?>>Traité</option>
								<option value="1" <?php if($datalead['status'] == 1){ echo "selected" ;}?>>En cour</option>
								<option value="0" <?php if($datalead['status'] == 0){ echo "selected" ;}?>>Nouveau</option>
								</select> 
								
							</div>
							<!-- /.description-block -->
							</div>
							<!-- /.col -->
							<div class="col-sm-4">
							<div class="description-block">
								<h5 class="description-header">Site</h5>
								<span class="description-text"> <?php echo $datalead['site']; ?></span>
							</div>
							<!-- /.description-block -->
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
						</div>
					</div>
					
				
				</div>

			</div>
			<!-- /.row -->

			</section>
			<!-- /.content -->
		</div>
		<div class="modal center-modal fade" id="modal-converted1">
			<div class="modal-dialog">
				<div class="modal-content bg-success">
				<div class="modal-header">
					<h5 class="modal-title"><b>Convertie</b></h5>
					<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
				</div>
				<div class="modal-body">	
				Félicitations ! Votre lead est converter avec succès  
		</div>
		<input type="hidden" id="k_keyAdd" value="<?php echo $_SESSION['K_KEY'];?>">
						<input type="hidden" id="pk_userAdd" value="<?php echo $_SESSION['PK_USER'];?>">
						<input type="hidden" id="user_browser" value="<?php echo $clientBrowser;?>">
		</div>
	</div>
	</div>
	<div class="modal center-modal fade" id="modal-converted2">
			<div class="modal-dialog">
				<div class="modal-content bg-danger">
				<div class="modal-header">
					<h5 class="modal-title"><b>Not Convertie</b></h5>
					<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
				</div>
					<div class="modal-body">	
					Votre lead n'est pas convertie
			</div>
			
			</div>
		</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	
	<script>
	// initialiser the editor wysiwyg html5..................................
	$(function() {
	$('.textarea').wysihtml5();		

	});
$('#SaveInfoLead').click(function(){
	var form=document.getElementById('formUpdateLead');
	USER_KEY=$('#k_keyAdd').val();
	PK_USER=$('#pk_userAdd').val();
	BROWSER=$('#user_browser').val();
	var data={};
	var elems=form.children;
	for(let i=0;i<elems.length;i++)
	{
		var items=((elems[i].children)[1]).children;
		var idElem=(items[0]).id;
		data[""+idElem+""]=$('#'+idElem).val();
	}
	var dataString=JSON.stringify(data);
	console.log(dataString);
	$.ajax({
			url:'https://www.yestravaux.com/webservice/crm/lead.php',
			type: "POST",
			dataType: "html",
			data: {fct:'UpdateLead',lead_id:data["_id"],data:dataString,pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
			async: true,
			success:function(data){	
			console.log(data);
			$.toast({
			heading: 'Félicitations',
			text: 'Votre lead est modifié avec succès.',
			position: 'top-right',
			loaderBg: '#ff6849',
			icon: 'success',
			hideAfter: 5000
			});

			}
		});
});
    // function for update the lead status.......................................
	function UpdateStatusLead(id) {
		USER_KEY=$('#k_keyAdd').val();
		PK_USER=$('#pk_userAdd').val();
		BROWSER=$('#user_browser').val();
		var element=document.getElementById('statelead2'+id);
		var idx=element.selectedIndex;
		var val=element.options[idx].value;
		var content=element.options[idx].innerHTML;
		val=parseInt(val);
		var selectoption="";
		if(val == 2){
			selectoption="custom-select btn-success";
		}
		else if(val == 1){
			selectoption="custom-select btn-danger";

		}
		else{
			selectoption="custom-select btn-warning";

		}

		$.ajax({
					url:'https://www.yestravaux.com/webservice/crm/lead.php',
					type: "POST",
					dataType: "html",
	
					data: {fct:'UpdateLeadStatus',lead_id:id,statuslead:parseInt(val),pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
					async: true,
					success:function(data){	
						console.log(data);
						element.className=selectoption;
						element.options[idx].selected='selected';
						$('settings').html();
					}
				});
				
				$("#settings").load(location.href+" #settings>*","");  
				return true;
			
	}
		// define lead as converted....................................
		function ConvertLead(id){

			$.ajax({
					url:'https://www.yestravaux.com/webservice/crm/lead.php',
					type: "POST",
					dataType: "json",
					data: {fct:'ConvertLead',lead_id:id},
					async: true,
					success:function(data){	
						if(data.convertedvalue==1){
							$('#modal-converted2').modal('hide');
							$('#modal-converted1').modal('show');
							document.getElementById('leadconvert').className="btn bg-gradient-oceansky px-15 py-15 rounded20";
							document.getElementById('leadconvert').innerHTML='Converted';	
						}
						else{
							$('#modal-converted1').modal('hide');
							$('#modal-converted2').modal('show');
							document.getElementById('leadconvert').className="btn bg-gradient-ubuntu px-15 py-15 rounded20";
							document.getElementById('leadconvert').innerHTML='Convert';
						}
						$('#leadconvert').html();
					}
				});
				return true;
	}
		
        // add note for the current lead..............................................
		$('#AddNote').click(function(){
		var formaddnote=document.getElementById('formaddnote');
		var mytextarea=document.getElementById('mytextarea').value;
		var idlead=document.getElementById('idlead').value;
		var userlead=document.getElementById('userlead').value;
		USER_KEY=$('#k_keyAdd').val();
		PK_USER=$('#pk_userAdd').val();
		BROWSER=$('#user_browser').val();
		var datastring={};
		if(mytextarea=="")
		{		
		$.toast({
			heading: 'Erreur',
			text: 'Merci de remplir le champ.',
			position: 'top-right',
			loaderBg: '#ff6849',
			icon: 'error',
			hideAfter: 5000
			});
		}
		else{
			datastring["message"]=mytextarea;
			datastring["id_lead"]=idlead;
			datastring["operateur"]=userlead;
			datastring["datepublish"]=<?php echo json_encode(date('d-m-y'));?>;
			var data=JSON.stringify(datastring);
       $.ajax({
			url:'https://www.yestravaux.com/webservice/crm/lead.php',
			type: "POST",
			dataType: "html",
			data: {fct:'addnote',data:data,pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
			async: true,
			success:function(data){	
				formaddnote.reset();
				$('#mytextarea').val('');
				$('#idtimeline').html();
				$('#updatestatusid').html();
				$("#idtimeline").load(location.href+" #idtimeline>*","");
				$("#updatestatusid").load(location.href+" #updatestatusid>*","");  
				$.toast({
				heading: 'Félicitations',
				text: 'Votre note est ajouté avec succès.',
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'success',
				hideAfter: 5000

        });
        
		}	});
	}
});


$(document).ready(function () {



});

 function AddTask(type,campid,leadid,idcheckbox,seqid){
	$.ajax({
			url:'https://www.yestravaux.com/webservice/crm/lead.php',
			type: "POST",
			dataType: "html",
			data: {fct:'addtask',type:type,camp_id:campid,lead_id:leadid,seq_id:seqid},
			async: true,
			success:function(data){	
				
			data=JSON.parse(data);
			if(data.result=="ok"){
			var checkbox=document.getElementById(''+idcheckbox);
			checkbox.className="done";
			$.toast({
			heading: 'Félicitations',
			text: 'task marquer comme traité.',
			position: 'top-right',
			loaderBg: '#ff6849',
			icon: 'success',
			hideAfter: 3000
			});
			setTimeout(() => {
			location.reload();
			}, 1000);
			}
}})
}
   </script>
	
	
	

