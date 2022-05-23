<?php
		session_start();
		$sessioncamp="";

		//var_dump($_SESSION['PK_USER']);

		if(!isset($_SESSION["PK_USER"])){

			echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
		
		}

		$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
		$POSTVALUE  = 'fct=ListCampaign&user_id='.$_SESSION['PK_USER'];
		$datacamp = curl_do_post($URL,$POSTVALUE); 
		$datacamp = json_decode($datacamp);
		$datacamp = (array) $datacamp;
		if(isset($_REQUEST["pagenumber"])){
			$pagenumber=(int)$_REQUEST["pagenumber"];
		}
		else{
			$pagenumber=1;
		}
		if(isset($_REQUEST["pagearchivednumber"])){
			$pagearchivednumber=(int)$_REQUEST["pagearchivednumber"];
		}
		else{
			$pagearchivednumber=1;
		}
		if (empty($_SESSION['sessioncamp'])){
			$CMPid = (array) $datacamp[0]->_id;
			$CompanyID = $CMPid['$id'];
		}
		else {
			$CompanyID =$_SESSION['sessioncamp'];
		}
		$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
		$POSTVALUE1  = 'fct=ListSequence&user_id='.$_SESSION['PK_USER'].'&company_id='.$CompanyID;
		$dataseq = curl_do_post($URL,$POSTVALUE1); 
		$dataseq = json_decode($dataseq);
		$dataseq = (array) $dataseq;

		//print_r($dataseq);
		$clientBrowser = $_SERVER['HTTP_USER_AGENT'];

?>

<div class="container-full">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="d-flex align-items-center">
			<div class="me-auto">
				<h4 class="page-title">Companie</h4>
				<div class="d-inline-block align-items-center">
					<nav>
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
							<li class="breadcrumb-item" aria-current="page">Companie</li>
							<li class="breadcrumb-item active" aria-current="page">Ajouter companie</li>
						</ol>
					</nav>
				</div>
			</div>
			
		</div>
	</div>	  

	<!-- Main content -->
	<section class="content">
			<div class="row">

				<div class="col-xl-4 mx-auto col-sm-12">
					<div class="box" id="aaa">
						<div class="box-header with-border">
							<h4 class="box-title">Toutes vos companies</h4>
							<a href="index.php?page=add-campagne" data-bs-toggle="modal" data-bs-target="#modal-center5" class="waves-effect waves-light btn btn-success-light mb-5 pull-right"><i class="si-plus si" width="100" height="100"></i></a>

			
						</div>
						<!-- /.box-header -->
						<div class="box-body bg-lightest">
							<?php 
							for($i=0;$i<count($datacamp);$i++) { 				
								$datacampid = (array) $datacamp[$i]->_id;
								$id = $datacampid['$id'];
							?>
							<li class="flexbox mb-5" id="refrechdata<?php echo $id;?>" onmouseover="MouseEventOver('<?php echo $id;?>');" onmouseout="MouseEventOut('<?php echo $id;?>');">
								<div>
									<span class="badge badge-dot badge-lg me-1 bg-<?php echo $i; ?>" ></span>
									<span  onClick="LoadDataCamp('<?php echo $id;?>');"><a href="#" class=""><?php echo $datacamp[$i]->companyName;?></a></span>
								</div>
								<div>
									<?php if($datacamp[$i]->status==0) {?>
										<button onClick="verif('<?php echo $id ;?>');" class="btn btn-sm btn-toggle"   aria-pressed="true" autocomplete="off">
											<div class="handle"></div>
										</button>
									<?php } else {?>
										<button onClick="verif('<?php echo $id ;?>');" class="btn btn-sm btn-toggle active"  aria-pressed="true" autocomplete="off">
											<div class="handle"></div>
										</button>
									<?php } ?>

									<a href="#" class="text-success" data-bs-toggle="tooltip" data-bs-original-title="Details"><i class="ti-write" aria-hidden="true"></i></a>
		
									<a class="text-danger" data-bs-toggle="tooltip" data-bs-original-title="Delete"  onClick="SupprimerCamp('<?php echo $id;?>');"><i class="ti-trash" aria-hidden="true"></i></a>
								</div>
							</li>

							<?php } ?>
						</div>
					</div>
				</div>

				<!-- Validation wizard -->
				<div class="col-xl-8 mx-auto col-md-12">
					<div class="" id="boxid">
						<?php
							if (empty($_SESSION['sessioncamp'])){
							$datacampid = (array) $datacamp[0]->_id;
							$id = $datacampid['$id'];
							$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
							$POSTVALUE  = 'fct=InfoCampagne&camp_id='.$id;
							$datacamp = curl_do_post($URL,$POSTVALUE);
							$datacamp = json_decode($datacamp);
							$datacamp = (array) $datacamp;
							$datacampid = (array) $datacamp['_id'];
							$datacamp['_id'] = $datacampid['$id'];}
							else{
								$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
								$POSTVALUE  = 'fct=InfoCampagne&camp_id='.$_SESSION['sessioncamp'];
								$datacamp = curl_do_post($URL,$POSTVALUE);
								$datacamp = json_decode($datacamp);
								$datacamp = (array) $datacamp;
								$datacampid = (array) $datacamp['_id'];
								$datacamp['_id'] = $datacampid['$id'];
							}
							$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
							$POSTVALUE1  = 'fct=ListSequence&user_id='.$_SESSION['PK_USER'].'&company_id='.$CompanyID;
							$dataseq = curl_do_post($URL,$POSTVALUE1); 
							$dataseq = json_decode($dataseq);
							$dataseq = (array) $dataseq;
							//var_dump($_SESSION['PK_USER']);

						?>
						<input type="hidden" value="<?php echo $pagenumber;?>" id="idpagenumber">

						<div class="row" id="statusread" >

							<div class="col-12">
								<span class="box box-body">
								<div class="flexbox align-items-center">
									<div>
									<h6 class="mb-0">Companie</h6>
									<h4><?php echo $datacamp['companyName']; ?></h4>
									</div>
									<img class="avatar avatar-lg avatar-bordered border-primary" src="../images/avatar/4.jpg" alt="...">
								</div>
								</span>
							</div>

						<div class="col-12 ">				
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li><a href="#leadstab" data-bs-toggle="tab" class="active">Leads</a></li>
									<li><a href="#archivedleads" data-bs-toggle="tab">Leads archivés</a></li>

									<li><a href="#settings" data-bs-toggle="tab" >Info</a></li>
									<li><a href="#usertimeline" data-bs-toggle="tab">Réglages</a></li>
								</ul>

								<div class="tab-content">
									<div class="tab-pane" id="archivedleads">
            							<div class="box-header with-border">
											<input type="hidden" value="<?php echo $pagearchivednumber;?>" id="idpagearchivednumber">
											<input type="hidden" value="<?php echo $datacamp['_id'];?>" id="CampIDarchived">                        
                    						<h6 class="text-info">Vous avait <span id="countallarchived"></span> Leads archivés</h6>
											<!-- <div class="row">
												<div class="col-11">
													<input type="search" class="form-control" placeholder="Find Archived Leads....." id="input-searcharchived" onkeyup="myFunctionArchived();">

												</div>
												<div class="col-1">
													<button class="btn btn-dark-light pull-right" id="button-searcharchived"><i class="fas fa-search" id="search-icon"></i></button>	

												</div>

											</div> -->
												<div class="input-group">
													<input type="search" class="form-control" placeholder="Find Archived Leads....." id="input-searcharchived" onkeyup="myFunctionArchived();">
													<div class="input-group-append">
														<button class="btn" type="submit" id="button-searcharchived">
															<svg id="search-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle>
																<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
															</svg>
														</button>
													</div>
												</div>
											</div>
											<div class="box-body p-0">
												<div class="media-list media-list-hover" id="bararchived">

												</div>
											</div>
										</div>
									
	
									<div class="tab-pane" id="settings">	
										<div class="box no-shadow">		
											<form class="form-horizontal form-element col-7">
												<?php foreach($datacamp as $cle => $valeur) {  
														if($cle =='_id' or $cle == 'userId'){ $disabled="disabled " ;} else {$disabled ="";}
														if($cle =='companyName'){ $type='text';} 
														if($cle != 'status') {

												?>
							
													<div class="form-group row">
														<label for="<?php echo $cle ; ?>" class="col-sm-3 form-label"><?php echo $cle ; ?></label>

														<div class="col-sm-9">
															<input type="<?php echo $type; ?>" class="form-control" id="<?php echo $cle ; ?>" name="<?php echo $cle ; ?>" placeholder="" value="<?php echo $valeur ; ?>" <?php echo $disabled; ?>>
														</div>
													</div>

													<?php } } ?>
													<span id="hiddenconfirmupdate"></span>	
													<br>
												</form>
												<br>
												<div class="form-group row">
													<div class="ms-auto col-sm-10">
														<button onClick="UpdateCampInfo('<?php echo $datacamp['_id'];?>');" class="btn btn-primary">Enregistrer</button>
													</div>
												</div>
											</div>			  
										</div>
											
										<div class="tab-pane active" id="leadstab">			            
											<div class="box-header without-border">
												<input type="hidden" value="<?php echo $datacamp['_id'];?>" id="campidhidden">                        
												<h6 class="text-info">Vous avait <span id="nbleads"></span>  leads</h6>
											<!-- <div class="row">
												<div class="col-11">
													<input type="search" class="form-control" placeholder="Find Archived Leads....." id="input-searcharchived" onkeyup="myFunctionArchived();">
												</div>
												<div class="col-1">
													<button class="btn btn-dark-light pull-right" id="button-searcharchived">
														<i class="fas fa-search" id="search-icon"></i>
													</button>	
												</div>
											</div> -->
												<div class="input-group">
													<input type="search" class="form-control" placeholder="Find  Leads....." id="input-searchleads" onkeyup="myFunction();">
													<div class="input-group-append">
														<button class="btn" type="submit" id="button-searchleads">
															<svg id="search-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle>
																<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
															</svg>
														</button>
													</div>
													
												</div>
											
											</div>
											<div class="">
												<div class="" id="user-list">
												
												</div>
											</div>
						
										</div>
										
							
								<!-- <div class="div-res3">
									<div class="box box-widget widget-user">
										<div class="widget-user-header bg-img bbsr-0 bber-0" style="background: url('../images/gallery/full/10.jpg') center center;" data-overlay="5">
											<h3 class="widget-user-username text-white"><?php echo $datalead['nom_prenom'];?></h3>
											<h6 class="widget-user-desc text-white"><?php echo $datalead['societe'];?></h6>
										</div>
										<div class="widget-user-image">
											<img class="rounded-circle" src="../images/user3-128x128.jpg" alt="User Avatar">
										</div>
										<div class="box-footer">
											<div class="row">
												<div class="col-sm-3"></div>
												<div class="col-sm-5">
													<div class="description-block">
														<h5 class="description-header">Campagne</h5>
														<span class="description-text"><?php echo $datacamp['companyName']; ?></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div> -->
						<div class="tab-pane" id="usertimeline">
										<div class="mb-30">
											<div class="row">
													<div class="col-3 col-sm-4 connectedSortable" id="container-1">
														<ul class="todo-list" id="tablist">
															<?php
															for($i=0;$i<count($dataseq);$i++) { 						
																$dataseqid = (array) $dataseq[$i]->_id;
																$id = $dataseqid['$id'];
															?>
															<li class="p-5">
																<form>
																<div class="info-box p-15 mb-0 d-block bb-2 border-dark shadow">
																	<span class="handle">
																		<i class="fa fa-ellipsis-v"></i>
																		<i class="fa fa-ellipsis-v"></i>
																	</span>
																	<h3 class="fs-22 text-line" style="display: inline-block;">
																		<a id="Test-1" class="" href="#<?php echo $id; ?>"><?php echo $dataseq[$i]->ACTION_NAME; ?></a> 
																	</h3>

																	<div class="mt-5 ms-20 ps-5"><?php echo $dataseq[$i]->CONTENU; ?></div>

																</div>

																<div class="V-line border-dark">
																</div>

																<div class="">
																	<div class="box-body mb-0 pt-0 pb-10 pe-5 ps-5 d-block text-center" style="display: inline-block;">
																		<h6 class="text-line" style="display: inline-block;">Attendre  
																		<input class="form-control border-dark" id="nb_jour<?php echo $id; ?>" onchange="UpdateDelai('<?php echo $id; ?>')" type="text" placeholder="" value="<?php echo $dataseq[$i]->NB_JOURS; ?>" style="width: 25%;display: inline-block;">  days, then
																		</h6>
																	</div>
																</div>
															</form>
														</li>
														<?php
															} 
														?>
													</ul>
								
													<ul  class="todo-list">
														<li  class="p-15 text-center">
															<button type="button" class="btn btn-primary" id="Add_Step"><i class="fa fa-plus pe-5" aria-hidden="true"></i>Ajouter une nouvelle étape</button>
														</li>
													</ul>
													</div>
						
													<div class="col-9 col-sm-8" id="tab-conten">

														<div id="" class="box setid">
															<div  class="box-body">
																<div class="col-12">
																	
																</div>

																<form action="#" class="" id="FormSeqUPDATE">

																	<input type="hidden" name="" id="type" value="">
																	<input type="hidden" name="" id="TheID">

																	<div id="Mail-Seq" class="row">
																		<div class="p-15">
																			<div class="form-group">
																				<input class="form-control" id="nom-action" value="" placeholder="Action name:">
																			</div>
																			<div class="form-group">
																				<input class="form-control" id="sender" value="" placeholder="Sender:">
																			</div>
																			<div class="form-group">
																				<input class="form-control" id="objet" value="" placeholder="Subject:">
																			</div>
																			<div class="form-group">
																				<textarea id="editor2" class="editors" name="contenu" rows="10" cols="80">		
																				</textarea>
																			</div>
																			<!--div class="form-group">
																				<select class="form-select" id="email_langue" name="action_email_langue">
																					<option value="FR">Français</option>
																					<option value="EN">Anglais</option>
																					<option value="BG">Bulgare</option>
																				</select>
																			</div-->
																		</div>
																	</div>

																	<div id="Sms-Seq" class="row my-div" style="display: none;">
																		
																		<div class="p-15">
																			<div class="form-group">
																				<input class="form-control" maxlength="12" id="sms-action" name="nom-action" placeholder="Action name:">
																			</div>
																		<div class="form-group">
																				<input class="form-control" id="sms-sender" name="sender-sms" placeholder="Sender:">
																			</div>
																			<div class="form-group">
																				<textarea class="form-control" id="sms-contenu" onkeyup="GetLength()" maxlength="160" placeholder="" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
																			</div>
																			<!--div class="form-group">
																				<select class="form-select" id="sms_langue" name="action_sms_langue">
																					<option value="FR">Français</option>
																					<option value="EN">Anglais</option>
																					<option value="BG">Bulgare</option>
																				</select>
																			</div-->
																		</div>
																	</div>
																	<div id="Call-Seq" class="row my-div" style="display: none;">
																		
																		<div class="p-15">
																			<div class="form-group">
																				<input class="form-control" id="Call-action" name="Call-action" placeholder="Action name:">
																			</div>
																			<div class="form-group">
																				<label class="form-label">Date</label>
																				<input type="date" class="form-control" id="date-call">
																			</div>
																			<div class="form-group">
																				<label class="form-label">Temps</label>
																				<input type="time" class="form-control" id="time-call">
																			</div>
																			<div class="form-group">
																				<label class="form-label">Note</label>
																				<textarea class="form-control" id="note-call" max="20" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
																			</div>

																	</div>
																</div>

															</form>

															<div class="form-group box-footer text-end" id="UpdateSeqButton">
																<button id="Modifierseq" type="button" class="waves-effect waves-light btn btn-success mb-5" onClick="updateSeqjs();">Modifier</button>
																<button class="waves-effect waves-light btn btn-social btn-google mb-5" onClick="deleteSeqjs();">
																	<i class="fa fa-trash-o"></i> 
																</button>
															</div>

												</div>
											</div>
											
											<div id="" class="box NewID" style="display: none;">
												<div  class="box-body">

													<div  class="col-12" >

														<form action="#" class="" id="FormSeqID">

															<div id="SelectChoice" class="row">
																<div class="col-6">
																	<div class="info-box pull-up">
																		<input name="action_type" type="radio" id="radio_7" value="1" class="radio-col-info radioBtn" data-target-id="1">
																		<label for="radio_7" class="">
																			<span class="info-box-icon bg-info rounded"><i class="ti-email"></i></span>
																			<div class="info-box-content">
																				<span class="info-box-number">EMAIL</span>
																				
																			</div>
																		</label>
																	</div>
																</div>
																<div class="col-6">
																	<div class="info-box pull-up">
																		<input name="action_type" type="radio" id="radio_9" value="2" class="radio-col-warning radioBtn" data-target-id="2">
																		<label for="radio_9">
																			<span class="info-box-icon bg-warning rounded"><i class="ti-comment-alt"></i></span>
																			<div class="info-box-content">
																				<span class="info-box-number">SMS</span>
																				
																			</div>
																		</label>
																	</div>
																</div>
																<div class="col-6">
																	<div class="info-box pull-up">
																		<input name="action_type" type="radio" id="radio_10" value="3" class="radio-col-danger radioBtn" data-target-id="3">
																		<label for="radio_10">
																			<span class="info-box-icon bg-danger rounded"><i class="mdi mdi-phone-in-talk"></i></span>
																			<div class="info-box-content">
																				<span class="info-box-number">APPEL</span>
																				
																			</div>
																		</label>
																	</div>
																	</div>
																	<div class="col-6">
																		<div class="info-box pull-up">
																			<input name="action_type" type="radio" id="radio_12" value="4" class="radio-col-success radioBtn" data-target-id="4">
																			<label for="radio_12">
																				<span class="info-box-icon bg-success  rounded"><i class="ti-list"></i></span>
																				<div class="info-box-content">
																					<span class="info-box-number">TACHE</span>
																					
																				</div>
																			</label>
																		</div>
																	</div>
																</div>

																<div id="Form-1" data-target="1" class="row my-div" style="display: none;">
																	<div class="p-15">
																		<div class="form-group">
																			<input class="form-control" id="mail-nom-action" placeholder="Action name:">
																		</div>
																		<div class="form-group">
																			<input class="form-control" id="sender-mail" placeholder="Sender:">
																		</div>
																		<div class="form-group">
																			<input class="form-control" id="objet-mail" placeholder="Subject:">
																		</div>
																		<div class="form-group">
																			<textarea id="editor1" name="contenu-mail" rows="10" cols="80">
																					
																			</textarea>
																		</div>
																		<!--div class="form-group">
																			<select class="form-select" id="action_email_langue" name="action_email_langue">
																				<option value="FR" selected="selected">Français</option>
																				<option value="EN">Anglais</option>
																				<option value="BG">Bulgare</option>
																			</select>
																		</div-->
																	</div>
																</div>

																<div id="Form-2" data-target="2" class="row my-div" style="display: none;">
																	<div class="p-15">
																		<div class="form-group">
																			<input class="form-control" id="sms-nom-action" maxlength="12" name="nom-action" placeholder="Action name:">
																		</div>
																		<div class="form-group">
																			<input class="form-control" id="sender-sms" name="sender-sms" placeholder="Sender:">
																		</div>
																		<div class="form-group">
																			<textarea class="form-control" id="contenu-sms"  maxlength="160" max="20" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
																		</div>
																		<!--div class="form-group">
																			<select class="form-select" id="action_sms_langue" name="action_sms_langue">
																				<option value="FR">Français</option>
																				<option value="EN">Anglais</option>
																				<option value="BG">Bulgare</option>
																			</select>
																		</div-->
																	</div>
																</div>
																<div id="Form-3" data-target="3" class="row my-div" style="display: none;">
																	<div class="p-15">
																		<div class="form-group row">
																		<label class="col-form-label col-2">Titre</label>
																		<div class="col-10">

																			<input class="form-control" id="call-nom-action" name="" placeholder="Action name:">
																		</div></div>
																		
																	<div class="form-group row">
																			<label class="col-form-label col-2">Note</label>
																			<div class="col-10">
																			<textarea class="form-control" placeholder="Add note to call " id="note-call-add" max="20" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
																			</div>
																		</div>
																			
																		<div class="form-group row">
																			<label class="col-form-label col-2">Date</label>
																			<div class="col-10">
																				<input class="form-control" type="date" id="Call-date" name="date">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-form-label col-2">Temps</label>
																			<div class="col-10">
																				<input class="form-control" type="time" id="Call-time" name="time">
																			</div>
																		</div>
																	</div>
																</div>
																<div id="Form-4" data-target="4" class="row my-div" style="display: none;"></div>

																<input type="hidden" id="datacamp" name="datacamp" value="<?php echo $datacamp['_id']; ?>">

															</form>

															<div class="form-group box-footer text-end" id="AddSeqButton" style="display: none;">
																<button type="button" class="waves-effect waves-light btn btn-info mb-5" onClick="addSeqjs();">Enregistrer</button>
															</div>
														</div>

													</div>
												</div>

											</div>
										</div>
									</div>
								</div> 

					</div>
	
					<!-- /.box-body -->
				
					<!-- /.col -->		


	
					</div>
					
							</div>
						</div>

			<!--  </div> -->
			<div class="modal  fade " id="modal-center5">
				<div class="modal-dialog " >
					<div class="modal-content bg-lightest  modal-content2">
						<div class="modal-header bg-lightest modal-header2">
							<h5 class="modal-title"><b>Ajouter companie</b></h5>
							<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
						</div>
						<div class="modal-body ">
							<div class="box-body wizard-content ">
							<form action="#" class="" id="idformcamp">
							<!-- Step 1 -->
								<section>
									<div class="row">
										<div class="col-md-10">
											<div class="form-group">
												<label for="wfirstName2" class="form-label"> <b>Nom</b></label>
												<input type="text" class="form-control input-text-style required" placeholder="tapez le nom de companie" id="wcampagnename" name="firstName"> 
													<input type="hidden" id="k_keyAdd" value="<?php echo $_SESSION['K_KEY'];?>">
													<input type="hidden" id="pk_userAdd" value="<?php echo $_SESSION['PK_USER'];?>">
													<input type="hidden" id="user_browser" value="<?php echo $clientBrowser;?>">


											</div>
										</div>
										
									</div>
									
								</section>
							</form>
						</div>
		
						<div class="modal-footer modal-footer-uniform">
							<button class="btn bg-gradient-purple camp-btn-style" name="Enregister" id="tttt3" onClick="addCampjs();">Enregister</button>
						</div>
					</div>
				</div>
			</div>
		</div></div>
	</section>

		<!-- /.content -->
		<div class="modal center-modal fade" id="modal-center4">
			<div class="modal-dialog">
				<div class="modal-content bg-success">
					<div class="modal-header">
						<h5 class="modal-title"><b>Confirmation companie</b></h5>
						<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
					</div>
					<div class="modal-body height200">
						Félicitations ! Votre companie est modifier
					</div>
		
				</div>
			</div>
		</div>



	<div class="modal center-modal fade" id="modal-center6">
		<div class="modal-dialog">
			<div class="modal-header">
					<h5 class="modal-title"><b>Confirmation companie</b></h5>
					<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
			</div>
			<div class="modal-body">
				Félicitations ! Votre companie est créer
			</div>
			
		</div>
	</div>
	<!-- </div> -->	

	<div class="modal-content bg-success">


	</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
	
	// request avec XMLHTTPREQUEST for ajax ............
	function myFunction(){
		const searchBar =document.getElementById('input-searchleads');
		var usersList = document.getElementById('user-list');
		var idcamp=document.getElementById('campidhidden').value;
		dataleadfind={};

		let searchTerm = searchBar.value;
		if(searchTerm != ""){
			searchBar.classList.add("active");
		}else{
			searchBar.classList.remove("active");
			}
			let xhr = new XMLHttpRequest();
			xhr.open("POST", "app/components/pages/findleadSociete.php", true);
			xhr.onload = ()=>{
			if(xhr.readyState === XMLHttpRequest.DONE){
					if(xhr.status === 200){
					let data = xhr.response;
					data=JSON.parse(data);
					usersList.innerHTML = data.output;
					$('#nbleads').html(data.countleads);
					}
				}
			}
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		dataleadfind["searchTerm"]=searchTerm;
		dataleadfind["idcomp"]=idcamp;
		xhr.send("searchTermtab=" + JSON.stringify(dataleadfind));
		}


	// load archived leads by campany.......................

	function load_archived_leads()
		{
			let campid=document.getElementById('CampIDarchived');
			let pagearchivednumber=document.getElementById('idpagearchivednumber');
			
			$.ajax({
			url:"https://www.yestravaux.com/webservice/crm/lead.php",
			method:"POST",
			data:{fct:'FetchArchivedLeads',camp_id:campid.value,pagearchivednumber:pagearchivednumber.value},
			dataType:"json",
			success:function(data)
			{
				$('#bararchived').html(data.ArchivedLeads);
				$('#countallarchived').html(data.count_archived_lead);
				
			}
			});

		}

		//load archived leads by search.........................
		function myFunctionArchived(){
		let searchBararchive =document.getElementById('input-searcharchived');
		var idcamp=document.getElementById('CampIDarchived');
		let pagearchivednumber=document.getElementById('idpagearchivednumber');
		dataleadfind={};
			let searchTerm = searchBararchive.value;
				if(searchTerm !=''){
					$.ajax({
				url:"https://www.yestravaux.com/webservice/crm/lead.php",
				method:"POST",
				data:{fct:'FetchArchivedLeadsBySearch',camp_id:idcamp.value,search_Term:searchTerm,pagearchivednumber:pagearchivednumber.value},
				dataType:"json",
				success:function(data)
				{
					$('#bararchived').html(data.ArchivedLeads);
					$('#countallarchived').html(data.count_archived_lead);
					
				}
				}); }
	}
		setInterval(() =>{
			var idcamp=document.getElementById('campidhidden').value;
			var usersList = document.getElementById('user-list');
			var searchBar =document.getElementById('input-searchleads');
			var idpagenumber =document.getElementById('idpagenumber').value;

			let xhr = new XMLHttpRequest();
			xhr.open("GET", "app/components/pages/findleads.php?campaign_id="+idcamp+"&pagenumber="+ idpagenumber, true);
			xhr.onload = ()=>{
			if(xhr.readyState === XMLHttpRequest.DONE){
				if(xhr.status === 200){
					let data = xhr.response;
					data=JSON.parse(data);
					if(!searchBar.classList.contains("active")){
						$('#user-list').html(data.output);
						$('#nbleads').html(data.countleads);
					}          
				}
			}
					}
			xhr.send();
	let searchBararchive =document.getElementById('input-searcharchived');
				if(searchBararchive.value==''){
					load_archived_leads();
				}
				else{
					myFunctionArchived();
				}

		}, 2000);	
</script>

<script type="text/javascript">
	function SupprimerCamp(id){
		USER_KEY=$('#k_keyAdd').val();
		PK_USER=$('#pk_userAdd').val();
		BROWSER=$('#user_browser').val();

	    swal({
		title: 'Etes-vous sûr ?',
		text: "Voulez vous supprimer cette campagne!",
		type: "warning",
		imageWidth: '400',
		imageHeight: '150',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Oui, je confirme',
		cancelButtonText: 'Non',
		confirmButtonClass: ' btn-primary ',
		cancelButtonClass: 'btn-danger',
		buttonsStyling: true
		}).then(function(){
				swal(
				'Supprimée!',
				'Votre campagne est supprimée.',
				'succès'
				).then(function(){
						$.ajax({
							url:'https://www.yestravaux.com/webservice/crm/campaign.php',
							type: "POST",
							dataType: "html",
							data: {fct:'DeleteCampagne',camp_id:id,k_key:USER_KEY,pk_user:PK_USER,browser:BROWSER},
							async: true,
							success:function(data){
								console.log(data);
								console.log("fine");
								$.toast({
								heading: 'Congratulations',
								text: 'Votre campagnie a été supprimée avec succès.',
								position: 'bottom-right',
								loaderBg: '#ff6849',
								icon: 'success',
								hideAfter: 5000
								});
								$('aaa').html();
										$("#aaa").load(location.href+" #aaa>*","");  
					}
			});
						
				$("#aaa").load(location.href+" #aaa>*","");  
				

				})
			
			},function (dismiss) {

			if (dismiss === 'cancel') {
				swal(
				'Annulée',
				'la suppression a été annulée :)',
				'error'
				)
			}
			})
			return false;
		}

		function verif(id){         
			$.ajax({
						url:'https://www.yestravaux.com/webservice/crm/campaign.php',
						type: "POST",
						dataType: 'html',
						data:{fct:'verifcamp',camp_id:id},
						success:function(data){
							console.log(data);
							console.log("fine");
			},
			error:function(){
				console.log("error");
			}
					});
					//LoadDataCamp(id);
				$("#aaa").load(location.href+" #aaa>*","");

				return true;
		}

	function LoadDataCamp(id){

					$.ajax({
								url:'components/pages/companySession2.php',
								type: "POST",
								dataType: "html",
								data:{camp_id:id},
								async: true,
							success:function(data){
								console.log(data);
								console.log("fine");
								document.getElementById('campidhidden').value=id;
								location.reload();
			
					}
				});          
	}
	function UpdateCampInfo(id){
			var companyname=document.getElementById('companyName').value;
			var hiddenvalue=document.getElementById('hiddenconfirmupdate');
			var datastring={};
			datastring['companyName']=companyname;
			data_camp=JSON.stringify(datastring);
			USER_KEY=$('#k_keyAdd').val();
			PK_USER=$('#pk_userAdd').val();
			BROWSER=$('#user_browser').val();

				$.ajax({
						url:'https://www.yestravaux.com/webservice/crm/campaign.php',
						type: "POST",
						dataType: "html",
		
						data: {fct:'UpdateCamp',data:data_camp,camp_id:id,k_key:USER_KEY,pk_user:PK_USER,browser:BROWSER},
						async: true,
						success:function(data){	
							console.log(data);
							$.toast({
							heading: 'Congratulations',
							text: 'Votre campagnie a été mise à jour avec succès',
							position: 'bottom-right',
							loaderBg: '#ff6849',
							icon: 'warning',
							hideAfter: 5000
						});		
						},
						error:function(err){
							//hiddenvalue.innerHTML="something wrong";
							//hiddenvalue.className="style_span btn btn-danger";
							$.toast({
							heading: 'Error',
							text: 'Quelque chose s\'est mal passé',
							position: 'bottom-right',
							loaderBg: '#ff6849',
							icon: 'error',
							hideAfter: 5000
						});	
						}
					});
					$('aaa').html();
					$("#aaa").load(location.href+" #aaa>*","");  
					//$('#modal-center4').modal('show');
					

			return false;
		}

	function addCampjs()
	{
		var nomcompagne=document.getElementById('wcampagnename').value;
		var errorval=document.getElementById('errorval2');
		var form=document.getElementById('idformcamp');

		if(nomcompagne == ""){
	    //errorval.innerHTML="vous douvez choisir le nom de campagne";
		//errorval.focus();
		$.toast({
				heading: 'Erreur',
				text: 'Merci de remplir le champ',
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'error',
				hideAfter: 3000
        });
		}
			else{
				var datastring={};
				USER_KEY=$('#k_keyAdd').val();
				PK_USER=$('#pk_userAdd').val();
				BROWSER=$('#user_browser').val();
				datastring['userId']=PK_USER;
				datastring['companyName']=nomcompagne;
				datastring['status']=0;
				form.reset();
				datajson=JSON.stringify(datastring);
				$.ajax({
						url:'https://www.yestravaux.com/webservice/crm/campaign.php',
						type: "POST",
						dataType: "html",
						data: {fct:'addCamp',data:datajson,k_key:USER_KEY,pk_user:PK_USER,browser:BROWSER},
						async: true,
						success:function(data){
							console.log("fine");
						
							$('aaa').html();
							//$('#modal-center2').html();
							$("#aaa").load(location.href+" #aaa>*",""); 

						}
					});  

					$("#aaa").load(location.href+" #aaa>*",""); 
					$('#modal-center5').modal('hide');
					$.toast({
					heading: 'Félicitations',
					text: 'Votre compagne avec le '+nomcompagne+' a été créé avec succès',
					position: 'bottom-right',
					loaderBg: '#ff6849',
					icon: 'success',
					hideAfter: 5000
			});
					//$('#modal-center6').modal('show');
			}
		}

	function MouseEventOver(id)
	{
		document.getElementById('refrechdata'+id).className="flexbox mb-5 bg-light";
	}
	
	function MouseEventOut(id)
	{
		document.getElementById('refrechdata'+id).className="flexbox mb-5";
	}

</script>

<script type="text/javascript">

	$(function() {
		$('.editors').each(function(){
		    CKEDITOR.replace( $(this).attr('id'));
			
		});
	});

	$("#tab-conten > div").hide();

	$("#container-1 a[href]").click(function(){

		var _id = $(this).attr('href').substr(1);

		var Elem = document.querySelector(".setid");
		Elem.setAttribute("id", _id );

		$.ajax({

            url:'https://www.yestravaux.com/webservice/crm/campaign.php',
            type: "POST",
            dataType: "html",

            data: {fct:'SequenceInfo',Seq_id:_id},
            async: true,
            success:function(data){
				console.log("All GOOD");
				response = JSON.parse(data);
				console.log(response);
				//console.log(JSON.stringify(response._id.$id));
				$('#TheID').val(response._id.$id);

				$('#type').val(response.ACTION_TYPE);

				if (response.ACTION_TYPE == 1) {
					$('#Modifierseq').show();

					$("#Mail-Seq").show().siblings().hide();

					$('#nom-action').val(response.ACTION_NAME);
					$('#sender').val(response.SENDER);
					$('#objet').val(response.OBJET);
					
					CKEDITOR.instances.editor2.setData(response.CONTENU);

					/*if (response.LANGUE == 'FR') {
						$("#email_langue option[value='FR']").prop('selected', 'selected');
					} else if (response.LANGUE == 'EN') {
						$("#email_langue option[value='EN']").prop('selected', 'selected');
					}else if (response.LANGUE == 'BG') {
						$("#email_langue option[value='BG']").prop('selected', 'selected');
					}*/

					} else if (response.ACTION_TYPE == 2) {			
					$('#Modifierseq').show();

					$("#Sms-Seq").show().siblings().hide();

					$('#sms-action').val(response.ACTION_NAME);
					$('#sms-sender').val(response.SENDER);
					//$('iframe').contents().find('.wysihtml5-editor').html(response.CONTENU);
					$('#sms-contenu').val(response.CONTENU);


					/*if (response.LANGUE == 'FR') {
						$("#sms_langue option[value='FR']").prop('selected', 'selected');
					} else if (response.LANGUE == 'EN') {
						$("#sms_langue option[value='EN']").prop('selected', 'selected');
					}else if (response.LANGUE == 'BG') {
						$("#sms_langue option[value='BG']").prop('selected', 'selected');
					}*/

					
				} else if (response.ACTION_TYPE == 3) {		
					//$('#Modifierseq').hide();

					$("#Call-Seq").show().siblings().hide();
					
					$('#Call-action').val(response.ACTION_NAME);
					$('#date-call').val(response.DATE_CALL);
					$('#time-call').val(response.TIME_CALL);
					$('#note-call').val(response.NOTE_CALL);



				}
					
		    }
        });

        $("#tab-conten " + $(this).attr("href")).show().siblings().hide();

	});

	$(function() {

			$('.radioBtn').click(function(){
			
				var target = $(this).data('target-id');
				$('.my-div').hide(); 
				$('.my-div[data-target="'+target+'"]').show();  
				$('#AddSeqButton').show();
			}); 
		
		});

		$(function () {

			$('#Add_Step').click( function(){

				var tabs = $("#container-1").tab();
				var tabCounter = tabs.find('ul').first().children().length;
				var Contents = $("#tab-conten").tab();
				var ul = tabs.find( "ul#tablist" );
				var b = document.querySelector(".NewID");
				$('<form><li class="p-5"><div class="info-box p-15 mb-0 d-block bb-2 border-danger shadow"><span class="handle ui-sortable-handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span><h3 class="fs-22 text-line" style="display: inline-block;"><a id="Test-' + ++tabCounter + '" class="" href="#Style' + tabCounter + '">New Step</a></h3></div><div class="V-line border-danger"></div><div class=""><div class="box-body mb-0 pt-0 pb-10 pe-5 ps-5 d-block text-center"><h6 class="text-line" style="display: inline-block;">Wait for <input class="form-control border-danger" id="nb_jours" type="text" placeholder="" style="width: 25%;display: inline-block;">  days, then</h6></div></div></li></form>').appendTo( ul );

				b.setAttribute("id", "Style"+ tabCounter);
				$(b).show().siblings().hide();	
				$("#container-1 a[href]").click(function(){
					$("#tab-conten " + $(this).attr("href")).show().siblings().hide();
				});          

			});

		});

	function addSeqjs(){

		var form = document.getElementById('FormSeqID');
		var CAMP_ID = document.getElementById('datacamp').value;
		USER_KEY=$('#k_keyAdd').val();
		PK_USER=$('#pk_userAdd').val();
		BROWSER=$('#user_browser').val();

		var today = new Date();
		var DATE_ADD = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

		var radios = document.getElementsByName('action_type');
		var valeur;
		for(var i = 0; i < radios.length; i++){
			if(radios[i].checked){
			    valeur = radios[i].value;
			}
		}

		var ACTION_NB_JOUR = document.getElementById('nb_jours').value;
		var ACTION_TYPE = valeur;

		var tabs = $("#container-1").tab();
	    var tabCounter = tabs.find('ul').first().children().length;

		if (valeur == 1) {
			
			var ACTION_NAME = document.getElementById('mail-nom-action').value;
			var SENDER = document.getElementById('sender-mail').value;
			var OBJET = document.getElementById('objet-mail').value;
			var CONTENU = CKEDITOR.instances.editor1.getData();
			//var LANGUE = document.getElementById('action_email_langue').value;
	

		} else if (valeur == 2) {

			var ACTION_NAME = document.getElementById('sms-nom-action').value;
			var SENDER = document.getElementById('sender-sms').value;
			var OBJET = "";
			var CONTENU = document.getElementById('contenu-sms').value;  
			//var LANGUE = document.getElementById('action_sms_langue').value;


		} else if (valeur == 3) {

			var ACTION_NAME = document.getElementById('call-nom-action').value;
			var DATE_CALL = document.getElementById('Call-date').value;
			var TIME_CALL = document.getElementById('Call-time').value;
			var NOTE_CALL = document.getElementById('note-call-add').value;

			var SENDER = "";
			var OBJET = "";
			var CONTENU = "";  
			//var LANGUE = "";

		} else if (valeur == 4) {

		}
		if( (valeur!=3 && valeur!=2) && (ACTION_NAME=="" || SENDER=="" || OBJET=="" || CONTENU=="")){
				$.toast({
				heading: 'Erreur',
				text: 'Merci de remplir touts les champs',
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'error',
				hideAfter: 3000
        });  
			}
			else if( (valeur==3) && (ACTION_NAME=="" || DATE_CALL=="" || TIME_CALL=="")){

				$.toast({
				heading: 'Erreur',
				text: 'Merci de remplir touts les champs',
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'error',
				hideAfter: 3000
        });  


			}
			else if( (valeur==2) && (ACTION_NAME=="" || SENDER=="" || CONTENU=="")){

					$.toast({
					heading: 'Erreur',
					text: 'Merci de remplir touts les champs',
					position: 'top-right',
					loaderBg: '#ff6849',
					icon: 'error',
					hideAfter: 3000
					});  


					}
			else{

			var datastring={};
				datastring['ACTION_TYPE']=ACTION_TYPE;
				datastring['ACTION_NAME']=ACTION_NAME;
				datastring['DATE_CALL']=DATE_CALL;
				datastring['TIME_CALL']=TIME_CALL;
				datastring['SENDER']=SENDER;
				datastring['OBJET']=OBJET;
				datastring['CONTENU']=CONTENU;
				//datastring['LANGUE']=LANGUE;
				datastring['CAMP_ID']=CAMP_ID;
				datastring['DATE_ADD']=DATE_ADD;
				datastring['NB_JOURS']=ACTION_NB_JOUR;
				datastring['POSITION']=tabCounter++;
				datastring['userId']=PK_USER;
				datastring['NOTE_CALL']=NOTE_CALL;

			form.reset();
			datajson=JSON.stringify(datastring);

			console.log(datastring);

		$.ajax({

            url:'https://www.yestravaux.com/webservice/crm/campaign.php',
            type: "POST",
            dataType: "html",

            data: {fct:'addSeq',data:datajson,camp_id:CAMP_ID,k_key:USER_KEY,pk_user:PK_USER,browser:BROWSER},
            async: true,
            success:function(data){

				console.log("All GOOD");
				console.log(data);
				$.toast({
				heading: 'Congratulations',
				text: 'La nouvelle séquence a été créée avec succès',
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'success',
				hideAfter: 5000
        });  

				setTimeout(() => {
					location.reload();
				}, 2000);
				
		    }
        });  
	}
	}

	function updateSeqjs(){

		var SeqID = document.getElementById('TheID').value;
        USER_KEY=$('#k_keyAdd').val();
		PK_USER=$('#pk_userAdd').val();
		BROWSER=$('#user_browser').val();
		
		var ACTION_NB_JOUR = document.getElementById('nb_jour'+SeqID).value;
		console.log(ACTION_NB_JOUR);
		var ACTION_TYPE = document.getElementById('type').value;
		var today = new Date();
		var DATE_MODIF = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

		if (ACTION_TYPE == 1) {
			
			var ACTION_NAME = document.getElementById('nom-action').value;
			var SENDER = document.getElementById('sender').value;
			var OBJET = document.getElementById('objet').value;
			var CONTENU = CKEDITOR.instances.editor2.getData();
			//var LANGUE = document.getElementById('email_langue').value;

		} else if (ACTION_TYPE == 2) {

			var ACTION_NAME = document.getElementById('sms-action').value;
			var SENDER = document.getElementById('sms-sender').value;
			var OBJET = "";
		
			var CONTENU = document.getElementById('sms-contenu').value;  
			//var LANGUE = document.getElementById('sms_langue').value;


		} else if (ACTION_TYPE == 3) {

			var ACTION_NAME = document.getElementById('Call-action').value;
			var DATE_CALL = document.getElementById('date-call').value;
			var TIME_CALL = document.getElementById('time-call').value;
			var NOTE_CALL = document.getElementById('note-call').value;
			var SENDER = "";
			var OBJET = "";
		
			var CONTENU = "";  
			//var LANGUE = "";

		} else if (ACTION_TYPE == 4) {

		}
		
		var datastring={};
				datastring['ACTION_NAME']=ACTION_NAME;
				datastring['DATE_CALL']=DATE_CALL;
				datastring['TIME_CALL']=TIME_CALL;
				datastring['SENDER']=SENDER;
				datastring['OBJET']=OBJET;
				datastring['CONTENU']=CONTENU;
				//datastring['LANGUE']=LANGUE;
				datastring['NB_JOURS']=ACTION_NB_JOUR;
				datastring['NOTE_CALL']=NOTE_CALL;

				datastring['DATE_MODIF']=DATE_MODIF;

			data_seq=JSON.stringify(datastring);

			console.log(data_seq);

		$.ajax({
            url:'https://www.yestravaux.com/webservice/crm/campaign.php',
            type: "POST",
            dataType: "html",
            data: {fct:'UpdateSequence',data:data_seq,SeqID:SeqID,pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
            async: true,
            success:function(data){	
            	console.log("Sequence updated ! ");
                console.log(data);
				$.toast({
				heading: 'Congratulations',
				text: 'La nouvelle séquence a été mise à jour avec succès',
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'success',
				hideAfter: 3000
                });  
                setTimeout(() => {
				 location.reload(); 
				}, 2000); 	
			},
			error : function(jqXHR, textStatus, errorThrown){
				$.toast({
				heading: 'Erreur',
				text: ''+xhr.status,
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'error',
				hideAfter: 3000
                });  
				 alert(xhr.status);
			}
		});
			
		return false;
	}

	function deleteSeqjs(){
		var SeqID = document.getElementById('TheID').value;
		USER_KEY=$('#k_keyAdd').val();
		PK_USER=$('#pk_userAdd').val();
			BROWSER=$('#user_browser').val();
			swal({
			title: 'Etes-vous sûr ?',
			text: "Voulez vous supprimer cette séquence!",
			type: "warning",
			imageWidth: '200',
			imageHeight: '150',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Oui, je confirme',
			cancelButtonText: 'Non',
			confirmButtonClass: ' btn-primary ',
			cancelButtonClass: 'btn-danger',
			buttonsStyling: true
				}).then(function(){
				swal(
				'Supprimée!',
				'Votre sequence est supprimée.',
				'success'
				).then(function(){
					$.ajax({
							url:'https://www.yestravaux.com/webservice/crm/campaign.php',
							type: "POST",
							dataType: "html",
							data: {fct:'DeleteSequence',seq_id:SeqID,pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
							async: true,
							success:function(data){
								console.log(data);
								console.log("All good"); 

								location.reload();  
							}
						});

				})
			
			},function (dismiss) {

			if (dismiss === 'cancel') {
				swal(
				'Annulée',
				'la suppression a été annulée :)',
				'error'
				)
			}
			})
			return false;
		}

	$(document).ready(function () {

			var Items = $("#tablist li");

			$('#tablist').sortable({
				disabled: false,
				axis: 'y',
				forceHelperSize: true,
				update: function (event, ui) {

					var Newpos = ui.item.index();
					var _id = $("#Test-1").attr('href').substr(1);
					var datastring={};
					datastring['POSITION']=Newpos;
					data_seq=JSON.stringify(datastring);
					console.log("_id");
					console.log(_id);
					console.log(data_seq);
					USER_KEY=$('#k_keyAdd').val();
					PK_USER=$('#pk_userAdd').val();
					BROWSER=$('#user_browser').val();

					$.ajax({
						url:'https://www.yestravaux.com/webservice/crm/campaign.php',
						type: "POST",
						dataType: "html",
						data: {fct:'UpdatePosition',data:data_seq,SeqID:_id,pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
						async: true,
						success:function(data){	

							console.log("Sequence dropped ! ");
							console.log(data);
							
						},
						error : function(jqXHR, textStatus, errorThrown){
							alert(xhr.status);
						}
					});

				}
			}).disableSelection();



var textarea=$('.wysihtml5-editor').text().length;
console.log(textarea);




	});
	

	//pagination functions for leads and archived leads.............................
		function nextPage(numpage){  
		var idcamp=document.getElementById('campidhidden').value;
			var usersList = document.getElementById('user-list');
			var searchBar =document.getElementById('input-searchleads');
			document.getElementById('idpagenumber').value=numpage;
			var idpagenumber =document.getElementById('idpagenumber').value;

			let xhr = new XMLHttpRequest();
		xhr.open("GET", "components/pages/findleads.php?campaign_id="+idcamp+"&pagenumber="+ idpagenumber, true);
		xhr.onload = ()=>{
			if(xhr.readyState === XMLHttpRequest.DONE){
				if(xhr.status === 200){
				let data = xhr.response;
				data=JSON.parse(data);
				if(!searchBar.classList.contains("active")){
					usersList.innerHTML = data.output;
					document.getElementById('idpagenumber').value=numpage;
				}          
				}
			}
		}
		xhr.send();	
		}
		function nextPage2(numpage){
			
			dataleadfind={};

		var idcamp=document.getElementById('campidhidden').value;
			var usersList = document.getElementById('user-list');
				var searchBar =document.getElementById('input-searchleads');
				let searchTerm = searchBar.value;

				document.getElementById('idpagenumber').value=numpage;
				var idpagenumber =document.getElementById('idpagenumber').value;

				let xhr = new XMLHttpRequest();
		xhr.open("POST", "components/pages/findleadSociete.php", true);
		xhr.onload = ()=>{
			if(xhr.readyState === XMLHttpRequest.DONE){
				if(xhr.status === 200){
				let data = xhr.response;
				data=JSON.parse(data);
				usersList.innerHTML = data.output;
				}
			}
		}
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		dataleadfind["searchTerm"]=searchTerm;
		dataleadfind["idcomp"]=idcamp;
		dataleadfind["pagenumber"]=numpage;
		xhr.send("searchTermtab=" + JSON.stringify(dataleadfind));
		}

	function nextArchivedPage(numpage)
	{
		let campid=document.getElementById('CampIDarchived');
				let pagearchivednumber=document.getElementById('idpagearchivednumber');
				pagearchivednumber.value=numpage;
			$.ajax({
			url:"https://www.yestravaux.com/webservice/crm/lead.php",
			method:"POST",
			data:{fct:'FetchArchivedLeads',camp_id:campid.value,pagearchivednumber:numpage},
			dataType:"json",
			success:function(data)
			{
				$('#bararchived').html(data.ArchivedLeads);
				$('#countallarchived').html(data.count_archived_lead);
				
			}
			});
	}


	function nextArchivedSearchPage(numpage)
	{
		let searchBararchive =document.getElementById('input-searcharchived');
			var idcamp=document.getElementById('CampIDarchived');
			let pagearchivednumber=document.getElementById('idpagearchivednumber');
			dataleadfind={};
			let searchTerm = searchBararchive.value;
			pagearchivednumber.value=numpage;
		if(searchTerm !=''){
		$.ajax({
			url:"https://www.yestravaux.com/webservice/crm/lead.php",
			method:"POST",
			data:{fct:'FetchArchivedLeadsBySearch',camp_id:idcamp.value,search_Term:searchTerm,pagearchivednumber:numpage},
			dataType:"json",
			success:function(data)
			{
				$('#bararchived').html(data.ArchivedLeads);
				$('#countallarchived').html(data.count_archived_lead);
				
			}
			});
		}
		
	}

function UpdateDelai(id)
{
	USER_KEY=$('#k_keyAdd').val();
	PK_USER=$('#pk_userAdd').val();
	BROWSER=$('#user_browser').val();
	var delai=document.getElementById('nb_jour'+id);
	$.ajax({
            url:'https://www.yestravaux.com/webservice/crm/campaign.php',
            type: "POST",
            dataType: "html",
            data: {fct:'UpdateDelaiSequence',delai:delai.value,SeqID:id,pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
            async: true,
            success:function(data){	
            	console.log("Sequence updated ! ");
                console.log(data);
				$.toast({
				heading: 'Congratulations',
				text: 'Delai pour la séquence a été mis à jour avec succès',
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'success',
				hideAfter: 3000
                });  
              
			},
			error : function(jqXHR, textStatus, errorThrown){
				$.toast({
				heading: 'Erreur',
				text: ''+xhr.status,
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: 'error',
				hideAfter: 3000
                });  
				 alert(xhr.status);
			}
		});

}
/*
$(document).ready(function(){
	setTimeout(() => {
	console.log(document.querySelector('.wysihtml5-editor').children());
	}, 2000);
});*/


</script>