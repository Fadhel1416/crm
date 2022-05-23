
<?php 
$session='';
session_start();

if(!isset($_SESSION["PK_USER"])){

	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
  
  }

$clientBrowser = $_SERVER['HTTP_USER_AGENT'];

if(isset($_REQUEST["Enregister"]) ){

	$data = array('campaign_id'=>htmlspecialchars($_POST["selectedname"]),'nom'=>htmlspecialchars($_POST["nom"]),'prenom'=>htmlspecialchars($_POST["prenom"]),'email' =>htmlspecialchars($_POST["email"]),
		'phone'=>htmlspecialchars($_POST["phone"]),
		'societe'=>htmlspecialchars($_POST["societe"]),
		'ip'  =>$_SERVER['REMOTE_ADDR'],
		);
	$lengthchamp=(int) $_POST['hiddenval'];
		for($i=0;$i<$lengthchamp;$i++) {
		$data[$_POST["champ".$i]]=$_POST["value".$i];
				
	}
		$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
		$data=json_encode($data);
		$POSTVALUE  = 'fct=addlead&data='.$data.'&cmpid='.$_POST["selectedname"]; 
		$datacamp =curl_do_post($URL,$POSTVALUE); 
	}
		$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
		$POSTVALUE  = 'fct=ListCampaign&user_id='.$_SESSION['PK_USER'];
		$datacamp = curl_do_post($URL,$POSTVALUE);
		$datacamp = json_decode($datacamp);
		$datacamp = (array) $datacamp;
		$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
		$POSTVALUE  = 'fct=LoadLeadsTreatedByCampany&user_id='.$_SESSION['PK_USER'];
		$dataleadconverted=curl_do_post($URL,$POSTVALUE);
		$dataleadconverted=json_decode($dataleadconverted);
		$dataleadconverted=(array)$dataleadconverted;
        $stringvalue='';
		foreach($dataleadconverted["result"] as $row)
		{
			$stringvalue.=$row->companyLeads.',';
		}
		$stringvalue=substr($stringvalue,0,strlen($stringvalue)-1);
	
?>

	
	<!-- Content Wrapper. Contains page content -->
	
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
								<li class="breadcrumb-item" aria-current="page">Leads</li>
							
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Main content -->
		<section class="content" id="reloadcontent">

			<div class="row">
				<div class="col-lg-3 col-12">
				
					<div class="col-lg-12 col-12">
					<div class="box">
						<div class="box-header with-border">
							<h5 class="box-title">Leads par companie</h5>
							<div class="box-tools pull-right">
								<ul class="card-controls">
								<li class="dropdown">
									<a data-bs-toggle="dropdown" href="#"><i class="ion-android-more-vertical"></i></a>
									<div class="dropdown-menu dropdown-menu-end">
									<a class="dropdown-item active" href="#">Aujourd'hui</a>
									<a class="dropdown-item" href="#">Hier</a>
									<a class="dropdown-item" href="#">Semaine dernière</a>
									<a class="dropdown-item" href="#">Mois dernier</a>
									</div>
								</li>
								<li><a href="" class="link card-btn-reload" data-bs-toggle="tooltip" title="" data-bs-original-title="Refresh"><i class="fa fa-circle-thin"></i></a></li>
								</ul>
							</div>
						</div>
						<?php 
						$arrayname=[];
						$arraycount=[];
						for($i=0;$i<count($datacamp);$i++) { 
								
								array_push($arraycount,$datacamp[$i]->companyLeads);
								array_push($arrayname,$datacamp[$i]->companyName);
								} ?>
						<div class="box-body">
							<div class="text-center">                  
								<div  id="donut1" style="text-align:center;" data-peity='{ "fill": ["#fc4b6c", "#ffb22b", "#398bf7"], "radius": 50, "innerRadius": 40  }' > 
							</div>
						</div>

						<ul class="list-inline">

							<?php for($i=0;$i<count($datacamp);$i++) { 
								$campid = (array) $datacamp[$i]->_id;
								$idcamp = $campid['$id'];
								
								?>
							<li class="flexbox mb-5" id="libg<?php echo $idcamp;?>" onClick="FindLeadByCompanyId('<?php echo $idcamp;?>');"  onmouseover="MouseEventOver('<?php echo $idcamp;?>');" onmouseout="MouseEventOut('<?php echo $idcamp;?>');">
							<div>
								<span class="badge badge-dot badge-lg me-1 bg-<?php echo $i; ?>" ></span>
								<span><a href="#"><?php echo $datacamp[$i]->companyName;?></a></span>
								</div>
								<div><?php echo $datacamp[$i]->companyLeads;?></div>
							</li>

							<?php } ?>
							<!--li class="flexbox mb-5">
								<div>
								<span class="badge badge-dot badge-lg me-1" style="background-color: #fc4b6c"></span>
								<span>Technical</span>
								</div>
								<div>8952</div>
							</li>

							<li class="flexbox mb-5">
								<div>
								<span class="badge badge-dot badge-lg me-1" style="background-color: #ffb22b"></span>
								<span>Accounts</span>
								</div>
								<div>7458</div>
							</li>

							<li class="flexbox">
								<div>
								<span class="badge badge-dot badge-lg me-1" style="background-color: #398bf7"></span>
								<span>Other</span>
								</div>
								<div>3254</div>
							</li-->
							</ul>
						</div>
						</div>
				</div>
				<div class="col-lg-12 col-12">
					<div class="box">
						<div class="box-header with-border">
							<h5 class="box-title">Leads traités par companie</h5>

							<div class="box-tools pull-right">
								<ul class="card-controls">
								<li class="dropdown">
									<a data-bs-toggle="dropdown" href="#"><i class="ion-android-more-vertical"></i></a>
									<div class="dropdown-menu dropdown-menu-end">
									<a class="dropdown-item active" href="#">Aujourd'hui</a>
									<a class="dropdown-item" href="#">Hier</a>
									<a class="dropdown-item" href="#">Semaine dernière</a>
									<a class="dropdown-item" href="#">Mois dernier</a>
									</div>
								</li>
								<li><a href="" class="link card-btn-reload" data-bs-toggle="tooltip" title="" data-bs-original-title="Refresh"><i class="fa fa-circle-thin"></i></a></li>
								</ul>
							</div>
						</div>
							<input type="hidden" id="hiddensession">
						<div class="box-body">
						<div class="flexbox mt-10">
							<div class="bar" id="valuebar2" data-peity='{ "fill":["#689f38", "#FF4961", "#FF9149","#8a2be2", "#462be2","#c49e36","#c0c0c0","#2be23a","#2f8049", "#FF3061", "#FF2049","#650f38", "#FF4961", "#2f8049"], "height": 268, "width": 120, "padding":0.2 }'>
								<?php echo $stringvalue;?>
						</div>
					<ul class="list-inline align-self-end text-muted text-end mb-0" id="list-inline">
					
						<!--li>Chloe <span class="badge badge-danger ms-2">854</span></li>
						<li>Daniel <span class="badge badge-warning ms-2">215</span></li-->
					</ul>
					</div>

				</div>
			</div>
		</div>
		</div>
	
		<div class="col-9">
				<div class="col-12">
					<div class="box">
						<div class="box-header with-border">						
							<!--h6 class="box-title">Listes des companies</h6-->
							<div class="nav-tabs-custom" >
				<ul class="nav nav-tabs" id="myTabs">
				<li><a href="#leadstabb" data-bs-toggle="tab" class="active">Leads</a></li>

					<li><a href="#leadarchivestab" data-bs-toggle="tab">Leads archivés</a></li>
					<li><a href="#leadNewtab" data-bs-toggle="tab">Nouveaux leads</a></li>
					<li><a href="#leadCourtab" data-bs-toggle="tab">Leads en cours</a></li>
					<li><a href="#leadTreatedtab" data-bs-toggle="tab">Leads traités</a></li>

					<li><a href="#leadConvertedtab" data-bs-toggle="tab">Leads convertis</a></li>

			
				</ul>
				
			<div class="tab-content" id="ggg_change">
			<?php 
						session_start();
							if($_REQUEST['campaign_id']){
								$campaign_idd=$_REQUEST['campaign_id'];
							}
							else{
							$campid = (array) $datacamp[0]->_id;
							$campaign_idd = $campid['$id'];

							}


                                    if (empty($_SESSION['compony'])){
                                        $URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
                                        $POSTVALUE  = 'fct=ListLead&campaign_id='.$campaign_idd;
                                        $dataleadresult = curl_do_post($URL, $POSTVALUE);
                                        $dataleadresult = json_decode($dataleadresult);
                                        $dataleadresult = (array) $dataleadresult;
                                    }
									else{
                                        $URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
                                        $POSTVALUE  = 'fct=ListLead&campaign_id='.$_SESSION['compony'];
                                        $dataleadresult = curl_do_post($URL, $POSTVALUE);
                                        $dataleadresult = json_decode($dataleadresult);
                                        $dataleadresult = (array) $dataleadresult;
									}  ?>
				
								<div class="tab-pane " id="leadNewtab">
								<div class="box-body p-15">						
							<div class="table-responsive" id="verifidnew">
							

						<table id="ticketsnew" class="table mt-0 table-hover no-wrap"  >
								<thead>
									<tr>
									<th>Date Création</th>

										<th>Companie</th>
										<th>Nom/Prénom</th>

										<th>Email</th>
										<th>Status</th>
										<th>Tél</th>
										<th>IP</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									
									<?php
									for($i=0; $i < count($dataleadresult); $i++) { 
										
										$dataleadid = (array) $dataleadresult[$i]->_id;
										$id = $dataleadid['$id'];
										if(intval($dataleadresult[$i]->status) == 0){

										?>

										<tr>
										<td><?php echo $dataleadresult[$i]->DATE_ADD_LEAD;?></td>

											<td class="text-info"><?php echo $dataleadresult[$i]->companyName;?></td>
											<td>
											<?php if(array_key_exists('nom',$dataleadresult[$i]) && array_key_exists('prenom',$dataleadresult[$i])){?>
											<a href="#"><?php echo $dataleadresult[$i]->nom.''. $dataleadresult[$i]->prenom;?></a>
											<?php } else {?>
												<a href="#"><?php echo $dataleadresult[$i]->nom_prenom;?></a>
											<?php } ?>
											</td>
											<td><?php echo $dataleadresult[$i]->email;?></td>
											<td> <a class="btn-rounded bg-warning-light px-10">Nouveau</a></td>
							
											<td class="text-fade small"><?php echo $dataleadresult[$i]->phone;?></td>
											<td><?php echo $dataleadresult[$i]->ip;?></td>
											
											<td>
												<a href="index.php?page=lead&id=<?php echo $id;?>" class="text-success" data-bs-toggle="tooltip" data-bs-original-title="Details"><i class="ti-write" aria-hidden="true"></i></a>
	
												<a  class="text-danger" data-bs-toggle="tooltip" data-bs-original-title="Delete"  onClick="Supprimer('<?php echo $id;?>');"><i class="ti-trash" aria-hidden="true"></i></a>

										
										
											</td>
										</tr>

									<?php }} ?>
									</tbody>
								</table>


							</div></div>	


								</div>

								<div class="tab-pane " id="leadCourtab">
								<div class="box-body p-15">						
							<div class="table-responsive" id="verifidprogress">
								<table id="ticketsprogress" class="table mt-0 table-hover no-wrap"  >
									<thead>
										<tr>
										<th>Date création</th>

											<th>Companie</th>
											<th>Nom/Prénom</th>

											<th>Email</th>
											<th>Status</th>
											<th>Tél</th>
											<th>IP</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									
									<?php
									for($i=0; $i < count($dataleadresult); $i++) { 
										
										$dataleadid = (array) $dataleadresult[$i]->_id;
										$id = $dataleadid['$id'];
										if(intval($dataleadresult[$i]->status) == 1){

										?>

										
									<tr>
									<td><?php echo $dataleadresult[$i]->DATE_ADD_LEAD;?></td>

										<td class="text-info"><?php echo $dataleadresult[$i]->companyName;?></td>
										<td>
										<?php if(array_key_exists('nom',$dataleadresult[$i]) && array_key_exists('prenom',$dataleadresult[$i])){
												?>
											<a href="#"><?php echo $dataleadresult[$i]->nom.''. $dataleadresult[$i]->prenom;?></a>
											<?php } else {?>
												<a href="#"><?php echo $dataleadresult[$i]->nom_prenom;?></a>
											<?php } ?>
											</td>
											<td><?php echo $dataleadresult[$i]->email;?></td>
											<td><a class="btn-rounded bg-danger-light px-10 "><small>En cours</small></a></td>
											<!--td>Elijah</td-->
											<td class="text-fade small"><?php echo $dataleadresult[$i]->phone;?></td>
											<td><?php echo $dataleadresult[$i]->ip;?></td>
											
											<td>
												<a href="index.php?page=lead&id=<?php echo $id;?>" class="text-success" data-bs-toggle="tooltip" data-bs-original-title="Details"><i class="ti-write" aria-hidden="true"></i></a>
	
												<a  class="text-danger" data-bs-toggle="tooltip" data-bs-original-title="Delete"  onClick="Supprimer('<?php echo $id;?>');"><i class="ti-trash" aria-hidden="true"></i></a>

										
										
											</td>
										</tr>

									<?php }} ?>
									</tbody>
								</table>


							</div></div>	





								</div>

							<div class="tab-pane " id="leadTreatedtab">
							<div class="box-body p-15">						
						<div class="table-responsive" id="verifidtreated">
						

									<table id="ticketstreated" class="table mt-0 table-hover no-wrap"  >
									<thead>
										<tr>
										<th>Date création</th>

											<th>Companie</th>
											<th>Nom/Prénom</th>

											<th>Email</th>
											<th>Status</th>
											<th>Tél</th>
											<th>IP</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									
									<?php
									for($i=0; $i < count($dataleadresult); $i++) { 
										
										$dataleadid = (array) $dataleadresult[$i]->_id;
										$id = $dataleadid['$id'];
										if(intval($dataleadresult[$i]->status) == 2){

									?>

										
									<tr>
									<td><?php echo $dataleadresult[$i]->DATE_ADD_LEAD;?></td>

										<td class="text-info"><?php echo $dataleadresult[$i]->companyName;?></td>
										<td>
										<?php if(array_key_exists('nom',$dataleadresult[$i]) && array_key_exists('prenom',$dataleadresult[$i])){
												?>
											<a href="#"><?php echo $dataleadresult[$i]->nom.''. $dataleadresult[$i]->prenom;?></a>
											<?php } else {?>
												<a href="#"><?php echo $dataleadresult[$i]->nom_prenom;?></a>
											<?php } ?>
											</td>
											<td><?php echo $dataleadresult[$i]->email;?></td>
											<td><a class="btn-rounded bg-primary-light px-10 "><small>Traité</small></a></td>
											<!--td>Elijah</td-->
											<td class="text-fade small"><?php echo $dataleadresult[$i]->phone;?></td>
											<td><?php echo $dataleadresult[$i]->ip;?></td>
											
											<td>
												<a href="index.php?page=lead&id=<?php echo $id;?>" class="text-success" data-bs-toggle="tooltip" data-bs-original-title="Details"><i class="ti-write" aria-hidden="true"></i></a>
	
												<a  class="text-danger" data-bs-toggle="tooltip" data-bs-original-title="Delete"  onClick="Supprimer('<?php echo $id;?>');"><i class="ti-trash" aria-hidden="true"></i></a>

										
										
											</td>
										</tr>

									<?php }} ?>
									</tbody>
								</table>


							</div></div>	
	
								

								</div>

								<div class="tab-pane " id="leadConvertedtab">
							
							<div class="box-body p-15">						
						<div class="table-responsive" id="verifidconverted">
						

									<table id="ticketsconverted" class="table mt-0 table-hover no-wrap"  >
								<thead>
										<tr>
										<th>Date création</th>

											<th>Companie</th>
											<th>Nom/Prénom</th>

											<th>Email</th>
											<th>Status</th>
											<th>Tél</th>
											<th>IP</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									
									<?php
									for($i=0; $i < count($dataleadresult); $i++) { 
									
										$dataleadid = (array) $dataleadresult[$i]->_id;
										$id = $dataleadid['$id'];
										if(intval($dataleadresult[$i]->converted) == 1){

									?>

										
									<tr>
									<td><?php echo $dataleadresult[$i]->DATE_ADD_LEAD;?></td>

										<td class="text-info"><?php echo $dataleadresult[$i]->companyName;?></td>
										<td>
											<?php if(array_key_exists('nom',$dataleadresult[$i]) && array_key_exists('prenom',$dataleadresult[$i])){
												?>
											<a href="#"><?php echo $dataleadresult[$i]->nom.''. $dataleadresult[$i]->prenom;?></a>
											<?php } else {?>
											<a href="#"><?php echo $dataleadresult[$i]->nom_prenom;?></a>
											<?php } ?></td>
											<td><?php echo $dataleadresult[$i]->email;?></td>
											<td><a class="btn-rounded bg-info-light px-10 "><small>Convertie</small></a></td>
											<!--td>Elijah</td-->
											<td class="text-fade small"><?php echo $dataleadresult[$i]->phone;?></td>
											<td><?php echo $dataleadresult[$i]->ip;?></td>
											
											<td>
												<a href="index.php?page=lead&id=<?php echo $id;?>" class="text-success" data-bs-toggle="tooltip" data-bs-original-title="Details"><i class="ti-write" aria-hidden="true"></i></a>
	
												<a  class="text-danger" data-bs-toggle="tooltip" data-bs-original-title="Delete"  onClick="Supprimer('<?php echo $id;?>');"><i class="ti-trash" aria-hidden="true"></i></a>

										
										
											</td>
										</tr>

									<?php }} ?>
									</tbody>
								</table>


							</div></div>



							</div>


				
				<div class="tab-pane" id="leadarchivestab">
						<div class="b-1 mb-30">
						<div class="col-sm-10">
								<div class="form-group form-group-float">

							<!--select class="custom-select btn-md" id="listleadcmp" onChange="FindLeadByCompany();">
							<?php for($i=0;$i<count($datacamp);$i++) { 
								$campid = (array) $datacamp[$i]->_id;
								$idcamp = $campid['$id'];
							
							?>

							<option value="<?php echo $idcamp;?>"><?php echo $datacamp[$i]->companyName;?></option>

						<?php }?>
							
						</select-->
					</div>
							</div>
							
							<div class="box-body p-15">						
						<div class="table-responsive" id="verifid1">
						

									<table id="tickets1" class="table mt-0 table-hover no-wrap"  >
								<thead>
										<tr>
										<th>Date création</th>

											<th>Companie</th>
											<th>Nom/Prénom</th>

											<th>Email</th>
											<th>Société</th>
											
											<th>Status</th>
											<!--th>Ass. to</th-->
											<th>Tél</th>
											<th>IP</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									
									<?php
									for($i=0; $i < count($dataleadresult); $i++) { 
										
										$dataleadid = (array) $dataleadresult[$i]->_id;
										$id = $dataleadid['$id'];
										if(intval($dataleadresult[$i]->status) == 3){

									?>

										
									<tr>
									<td><?php echo $dataleadresult[$i]->DATE_ADD_LEAD;?></td>

										<td class="text-info"><?php echo $dataleadresult[$i]->companyName;?></td>
										<td>
										<?php if(array_key_exists('nom',$dataleadresult[$i]) && array_key_exists('prenom',$dataleadresult[$i])){
												?>
												<a href="#"><?php echo $dataleadresult[$i]->nom.''. $dataleadresult[$i]->prenom;?></a>
												<?php } else {?>
													<a href="#"><?php echo $dataleadresult[$i]->nom_prenom;?></a>
													<?php } ?>
											</td>
											<td><?php echo $dataleadresult[$i]->email;?></td>
											<td><?php echo $dataleadresult[$i]->societe;?></td>
											
											<td>
											
										    <?php if($dataleadresult[$i]->status == 2){
											$class="btn-success";}
											elseif($dataleadresult[$i]->status == 1){
												$class="btn-danger";
											}
											elseif($dataleadresult[$i]->status == 0){
												$class="btn-warning";
											}
											else{
												$class="btn-dark";
											}
											?>
										<select class="custom-select <?php echo $class ;?>" id="<?php echo 'stateleadarchive'.$id;?>" onChange="UpdateStatusLeadArchive('<?php echo $id;?>');">
										<option value="2" <?php if($dataleadresult[$i]->status == 2){ echo "selected" ;}?>>Traité</option>
										<option value="1" <?php if($dataleadresult[$i]->status == 1){ echo "selected" ;}?>>En cour</option>
										<option value="0" <?php if($dataleadresult[$i]->status == 0){ echo "selected" ;}?>>Nouveau</option>
										<option value="3" <?php if($dataleadresult[$i]->status == 3){ echo "selected" ;}?>>Archiver</option>

										</select> 
											</td>
											<!--td>Elijah</td-->
											<td class="text-fade small"><?php echo $dataleadresult[$i]->phone;?></td>
											<td><?php echo $dataleadresult[$i]->ip;?></td>
											
											<td>
												<a href="index.php?page=lead&id=<?php echo $id;?>" class="text-success" data-bs-toggle="tooltip" data-bs-original-title="Details"><i class="ti-write" aria-hidden="true"></i></a>
	
												<a  class="text-danger" data-bs-toggle="tooltip" data-bs-original-title="Delete"  onClick="Supprimer('<?php echo $id;?>');"><i class="ti-trash" aria-hidden="true"></i></a>

										
										
											</td>
										</tr>

									<?php }} ?>
									</tbody>
								</table>


							</div></div>
								
						</div>
					</div>
				<div class="tab-pane active" id="leadstabb">
					
					<div class="b-1 mb-30">
					<div class="row">
							<div class="col-sm-10">
							<div class="form-group form-group-float">

						<!--select class="custom-select btn-md" id="listleadcmp" onChange="FindLeadByCompany();">
						<?php for($i=0;$i<count($datacamp);$i++) { 
								$campid = (array) $datacamp[$i]->_id;
								$idcamp = $campid['$id'];
							
							?>

							<option value="<?php echo $idcamp;?>"><?php echo $datacamp[$i]->companyName;?></option>

						<?php }?>
							
						</select-->
					</div>
							</div>
							<div class="col-sm-2">
							<a href="#" class=" btn bg-gradient-purple pull-right modal-center2-btn" data-bs-toggle="modal" data-bs-target="#modal-center2">Ajouter </a>

							</div>
					<div class="box-body p-15">						
							<div class="table-responsive" id="verifid">
							

								
							
								<table id="tickets" class="table mt-0 table-hover no-wrap"  >
									<thead>
										<tr>
										<th>Date création</th>

											<th>Companie</th>
											<th>Nom/Prénom</th>

											<th>Email</th>
											<th>Société</th>
											
											<th>Status</th>
											<!--th>Ass. to</th-->
											<th>Tél</th>
											<th>IP</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									
									<?php
									for($i=0; $i < count($dataleadresult); $i++) { 
									
										$dataleadid = (array) $dataleadresult[$i]->_id;
										$id = $dataleadid['$id'];
										if(intval($dataleadresult[$i]->status) != 3){

									?>

										
									<tr>
									<td><?php echo $dataleadresult[$i]->DATE_ADD_LEAD;?></td>

										<td class="text-info"><?php echo $dataleadresult[$i]->companyName;?></td>
										<td>
											<?php if(array_key_exists('nom',$dataleadresult[$i]) && array_key_exists('prenom',$dataleadresult[$i])){
												?>
												<a href="#"><?php echo $dataleadresult[$i]->nom.''. $dataleadresult[$i]->prenom;?></a>
												<?php } else {?>
													<a href="#"><?php echo $dataleadresult[$i]->nom_prenom;?></a>
													<?php } ?>
											</td>
											<td><?php echo $dataleadresult[$i]->email;?></td>
											<td><?php echo $dataleadresult[$i]->societe;?></td>
											
											<td>
											<?php if($dataleadresult[$i]->status == 2){
											$class="btn-success";}
											elseif($dataleadresult[$i]->status == 1){
												$class="btn-danger";
											}
											else{
												$class="btn-warning";
											}
											?>
										<select class="custom-select <?php echo $class ;?>" id="<?php echo 'statelead'.$id;?>" onChange="UpdateStatusLead('<?php echo $id;?>');">
										<option value="2" <?php if($dataleadresult[$i]->status == 2){ echo "selected" ;}?>>Traité</option>
										<option value="1" <?php if($dataleadresult[$i]->status == 1){ echo "selected" ;}?>>En cour</option>
										<option value="0" <?php if($dataleadresult[$i]->status == 0){ echo "selected" ;}?>>Nouveau</option>
										</select> 
										
												</td>
											<!--td>Elijah</td-->
											<td class="text-fade small"><?php echo $dataleadresult[$i]->phone;?></td>
											<td><?php echo $dataleadresult[$i]->ip;?></td>
											
											<td>
												<a href="index.php?page=lead&id=<?php echo $id;?>" class="text-success" data-bs-toggle="tooltip" data-bs-original-title="Details"><i class="ti-write" aria-hidden="true"></i></a>
	
												<a  class="text-danger" data-bs-toggle="tooltip" data-bs-original-title="Delete"  onClick="verif('<?php echo $id;?>');"><i class="ti-trash" aria-hidden="true"></i></a>
												<a  class="text-dark" data-bs-toggle="tooltip" data-bs-original-title="Archive" alt="archive" onClick="ArchiveLead('<?php echo $id;?>');"><i class="mdi mdi-archive" aria-hidden="true"></i></a>

											</td>
										</tr>

									<?php }} ?>
									</tbody>
								</table>

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
			<!-- /.row -->

			</section>
			<!-- /.content -->
		</div>

	<!-- /.content-wrapper -->
	
	<!-- Modal -->
	<div class="modal center-modal fade" id="modal-center2">
		<div class="modal-dialog">
			<div class="modal-content  bg-lightest modal-content2">
			<div class="modal-header bg-lightest modal-header2">
				<h5 class="modal-title"><b>Ajouter lead</b></h5>
				<a href="#" class="btn-close" data-bs-dismiss="modal" style="color:white;" aria-label="Close"></a>
			</div>
			<div class="modal-body">
			<form action="index.php?page=leads" id="formid" method="POST"  class="">
			<div class="form-group row" id="div1">
				<label for="Nom" class="col-sm-3 form-label">Nom</label>

				<div class="col-sm-9">
					<input type="text"  class="form-control modal-input2 required" id="nomlead" name="nom" placeholder="Entrer Votre Nom" required>
				</div>
				</div>
				<div class="form-group row" id="div2">
				<label for="email" class="col-sm-3 form-label">Prénom</label>

				<div class="col-sm-9">
					<input type="text" class="form-control modal-input2 required" id="prenomlead" name="prenom" placeholder="Entrer Votre Prenom" required>
				</div>
				</div>
				<div class="form-group row" id="div3">
				<label for="email" class="col-sm-3 form-label">Email</label>

				<div class="col-sm-9">
					<input type="email" class="form-control modal-input2 required" id="emaillead" name="email" placeholder="Entrer Votre Email" required>
				</div>
				</div>
				<div class="form-group row" id="div4">
				<label for="phone" class="col-sm-3 form-label">Tél</label>

				<div class="col-sm-9">
					<input type="text" class="form-control modal-input2 required" id="phonelead" name="phone" placeholder="Entrer Votre Tel" required>
				</div>
				</div>
				
				<div class="form-group row" id="div5">
				<label for="societe" class="col-sm-3 form-label">Sociéte</label>

				<div class="col-sm-9">
					<input type="text"  class="form-control modal-input2 required" id="societelead" name="societe" placeholder="Entrer Votre Nom Sociéte" required>
				</div>
				</div>
				<div class="form-group row" id="div6">
				<label for="campanyname" class="col-sm-3 form-label">Nom companie</label>

				<div class="col-sm-9">
				<select class="form-select modal-input2 required" id="cmpnamelead" name="selectedname" required="required">
							<option value="" selected>Selectionnez le nom de companie</option>
						
					<?php for($i=0;$i<count($datacamp);$i++) { 
						$datacampid = (array) $datacamp[$i]->_id;
						$id = $datacampid['$id'];
				?>
					<option value=<?php echo $id;?>><?php echo $datacamp[$i]->companyName;?></option>
							<?php }?>
							</select>
				</div>
				</div>  
				</div>
				<div class="form-group row" id="div7">
				<div class="col-sm-5">
				<input type="hidden" class="form-control" value="">

				</div>
				<div class="col-sm-3">
				<a for="addchamp" id="ggg" class="waves-effect waves-light btn btn-success-light mb-5" onClick="addField();"><i class="si-plus si" width="30" height="50"></i></a>
				</div></div>
				<div class="form-group row" id="div8">
				<div class="col-sm-3">
				<input type="hidden" class="form-control" id="hiddenval" name="hiddenval" value="">

				</div>
				<div class="col-sm-8">
				<span class="alert text-danger" id="errorval" name="errorval" ></span>
				</div></div>
				
				<div class="form-group row" id="champs">

				
				</div>

				<div class="form-group row" id="div8">
				<div class="col-sm-3">
				<input type="hidden" class="form-control" id="hiddenval2" name="hiddenval" value="">

				</div>
				<div class="col-sm-8">
				<b><span class="box box-inverse box-primary" id="successval" name="successval"></span></b>
				</div></div>
				</form>

			<div class="modal-footer modal-footer-uniform">
					
			<a href="#" data-bs-dismiss="modal" aria-label="Close" id="tttt1" class="btn bg-gradient-grey-dark modal-center2-footer">Retour</a>

			<button class="btn bg-gradient-purple camp-btn-style" name="Enregister" id="tttt2" onClick="addleadjs();">Enregister</button>
		
					
				</div>
					

				</div>
				
				</div>
			</div>
			</div>
			<div class="modal center-modal fade" id="modal-center3">
			<div class="modal-dialog">
				<div class="modal-content bg-success">
				<div class="modal-header">
					<h5 class="modal-title"><b>Confirmation Lead</b></h5>
					<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
				</div>
				<div class="modal-body">
				
				Félicitations ! Votre lead est créé avec succès



		</div>
		<form action="">
		<input type="hidden" id="k_keyAdd" value="<?php echo $_SESSION['K_KEY'];?>">
		<input type="hidden" id="pk_userAdd" value="<?php echo $_SESSION['PK_USER'];?>">
		<input type="hidden" id="user_browser" value="<?php echo $clientBrowser;?>">
		</form>
		
		</div>
	</div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

						<!-- /.modal -->
	<script>
		$(document).ready(function(){
			$('#ticketsconverted').DataTable({
		paging:true,
		order: [[0, "desc" ]],
		"language": {
		"sProcessing": "Traitement en cours ...",
		"sLengthMenu": "Afficher _MENU_ Leads",
		"sZeroRecords": "Aucun lead trouvé",
		"sEmptyTable": "Aucune donnée disponible",
		"sInfo": "_START_ à _END_ sur _TOTAL_ Leads",
		"sInfoEmpty": "Aucune ligne affichée",
		"sInfoFiltered": "(Filtrer un maximum de _MAX_)",
		"sInfoPostFix": "",
		"sSearch": "Chercher:",
		"sUrl": "",
		"sInfoThousands": ",",
		"sLoadingRecords": "Chargement...",
		"oPaginate": {
		"sFirst": "Premier", "sLast": "Dernier", "sNext": "Suivant", "sPrevious": "Précédent"
		},
		"oAria": {
		"sSortAscending": ": Trier par ordre croissant", "sSortDescending": ": Trier par ordre décroissant"
				}
			}
		});
		});
	</script>	
				

	<script>
		    var k="";
			var i=0;
			var form=document.getElementById('formid');
			var div = document.getElementById('champs');
			function addInput(name1,name2){
			var div1=document.createElement("div");
			div1.className="col-sm-3";
			var input1 = document.createElement("input");
			input1.name = name1;
			input1.className="form-control modal-input2 required";
			input1.placeholder="Nom Champ";
			input1.id="Idc"+i;
			input1.required="required";
			var div2=document.createElement("div");
			div2.className="col-sm-9";
			var input2 = document.createElement("input");
			input2.name = name2;
			input2.className="form-control modal-input2 required";
			input2.placeholder="Valeur Champ";
			input2.id="Idv"+i;
			input2.required="required";
			div1.appendChild(input1);
			div2.appendChild(input2);
			div.appendChild(div1);
			div.appendChild(div2);
			form.appendChild(div);
			i=i+1;
			document.getElementById('hiddenval').value=i;
			}

		function addField() {
			addInput("champ"+i,"value"+i);
			div.appendChild(document.createElement("br"));
			div.appendChild(document.createElement("br"));
			}

		/*function load_unseen_notification(view = '')
		{
			let dropdownmenu=document.getElementById('dropdownoti');
			let countnotifications=document.getElementById('idcountnoti');
			$.ajax({
			url:"https://www.yestravaux.com/webservice/crm/lead.php",
			method:"POST",
			data:{fct:'FetchNotifications',view:view},
			dataType:"json",
			success:function(data)
			{
				console.log(data);
				dropdownmenu.innerHTML=data.notification;
			if(data.unseen_notification > 0)
			{
				countnotifications.className='btn-sm label-pill label-danger count';
				countnotifications.innerHTML=data.unseen_notification;
			}
			}
			});
			
		}*/	

	
		

		function addleadjs()
		{
			var form=document.getElementById('formid');

			var namelead=document.getElementById('nomlead').value;
			var prenomlead=document.getElementById('prenomlead').value;
			var emaillead=document.getElementById('emaillead').value;
			var phonelead=document.getElementById('phonelead').value;
			var societelead=document.getElementById('societelead').value;
			var cmpnamelead=document.getElementById('cmpnamelead').value;
			var nbchamps=Number(document.getElementById('hiddenval').value);
			var errorval=document.getElementById('errorval');
			USER_KEY=$('#k_keyAdd').val();
			PK_USER=$('#pk_userAdd').val();
			BROWSER=$('#user_browser').val();

			if(namelead =="" || prenomlead =="" || emaillead =="" || phonelead =="" || societelead =="" || cmpnamelead ==""){
			//errorval.innerHTML="Veuillez entrez tout les champs";
			$.toast({
			heading: 'error',
			text: 'Enter all required fileds please.',
			position: 'bottom-right',
			loaderBg: '#ff6849',
			icon: 'error',
			hideAfter: 5000
			});
			errorval.focus(); 
		}
		
		else {
			$.ajax({
					url:'https://www.yestravaux.com/webservice/crm/campaign.php',
					type: "POST",
					dataType: "html",

					data: {fct:'InfoCampagne',camp_id:cmpnamelead },
					async: true,
					success:function(data){
					console.log(data);
					console.log("fine");
					var datastring={};
					datastring['campaign_id']=cmpnamelead;
					datastring['companyName']=(JSON.parse(data))["companyName"];
					datastring['nom']=namelead;
					datastring['prenom']=prenomlead;
					datastring['email']=emaillead;
					datastring['phone']=phonelead;
					datastring['societe']=societelead;

					for(i=0;i<nbchamps;i++){

					champi=document.getElementById('Idc'+i).value;
					valuei=document.getElementById('Idv'+i).value;
					if( champi=="" || valuei ==""){
						errorval.innerHTML="Veuillez entrez tout les champs";
						errorval.focus(); 
					}
					datastring[champi]=valuei;
				}
				var div = document.getElementById('champs');
                    if(div != null){
					div.innerHTML='';
					div.parentNode.removeChild(div);}
					form.reset();
					document.getElementById('hiddenval').value=0;
					i=0;
					datajson=JSON.stringify(datastring);
			$.ajax({
					url:'https://www.yestravaux.com/webservice/crm/lead.php',
					type: "POST",
					dataType: "html",

					data: {fct:'addlead',data:datajson,cmpid:cmpnamelead,pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
					async: true,
					success:function(data){
						console.log(data);
						console.log("fine");
					}});
					$.fn.dataTable.ext.errMode = 'none';
					$('#tickets').DataTable({
					paging:true,
					order: [[ 0, "desc" ]]
					});
					$('ggg_change').html();		 
					$("#ggg_change").load(location.href+" #ggg_change>*","");			
					$('#modal-center2').modal('hide');
					load_unseen_notification();
					$('#modal-center3').modal('show');
					
		}
				});

		}
		return false;
	}

		</script>
		<script type="text/javascript">
		function verif(id){
			USER_KEY=$('#k_keyAdd').val();
			PK_USER=$('#pk_userAdd').val();
			BROWSER=$('#user_browser').val();
			swal({
		title: 'Etes-vous sûr ?',
		text: "Voulez vous supprimer ce lead!",
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
			'Votre lead est supprimée.',
			'success'
			).then(function(){
					$.ajax({
							url:'https://www.yestravaux.com/webservice/crm/lead.php',
							type: "POST",
							dataType: "html",
							data: {fct:'DeleteLead',lead_id:id,pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
							async: true,
							success:function(data){
								console.log(data);
								console.log("fine");
				}});
				
				$.fn.dataTable.ext.errMode = 'none';
				$('#tickets').DataTable({
				paging:true,
				order: [[ 0, "desc" ]]
				});
				$('ggg_change').html();		 
		        $("#ggg_change").load(location.href+" #ggg_change>*","");

		})
	},function (dismiss) {
	if (dismiss === 'cancel') {
		swal(
		'Annulée',
		'la suppression a été annulée :)',
		'error'
		)
	}})
		return false;
		}
		function UpdateStatusLead(id) {
		USER_KEY=$('#k_keyAdd').val();
		PK_USER=$('#pk_userAdd').val();
		BROWSER=$('#user_browser').val();
		var element=document.getElementById('statelead'+id);
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
		console.log(parseInt(val));
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

					}
				});
				$.fn.dataTable.ext.errMode = 'none';
				$('#tickets').DataTable({
				paging:true,
				order: [[ 0, "desc" ]]
				});
				$('ggg_change').html();		 
				$("#ggg_change").load(location.href+" #ggg_change>*","");			
			return true;		
	}
	/*function FindLeadByCompany() {
		var element=document.getElementById('listleadcmp');

		var idx=element.selectedIndex;
		var val=element.options[idx].value;
		element.options[idx].selected='selected';
		$.ajax({
					url:'components/pages/componySession.php',
					type: "POST",
					dataType: "html",
					data: {campaign_id:val},
					async: true
				});

				$('verifid').html();
				$("#tickets").load(location.href+" #tickets>*","");  

			
				return true;
		
	}*/
	function FindLeadByCompanyId(id) {

		$.ajax({
				url:'components/pages/componySession.php',
				type: "POST",
				dataType: "html",
				data: {campaign_id:id},
				});
				$('ggg_change').html();		 
				$("#ggg_change").load(location.href+" #ggg_change>*","");
				$.fn.dataTable.ext.errMode = 'none';
				$('#tickets').DataTable({
				paging:true,
				order: [[ 0, "desc" ]]
				});
				$('#tickets1').DataTable({
					paging:true,
				order: [[ 0, "desc" ]]
				});
	}

	function MouseEventOver(id)
	{
		document.getElementById('libg'+id).className="flexbox mb-5 bg-light";
	}
	
	function MouseEventOut(id)
	{
		document.getElementById('libg'+id).className="flexbox mb-5";
	}

	$(document).ready(function(){
	var hash=window.location.hash;
	if(hash.substring(1) != '')
	{

	$('.nav-tabs .active').removeClass('active');
	$('.nav-tabs a[href="' + hash + '"]').addClass('active');
	$('.tab-pane ').removeClass('active');
	$(''+hash).addClass('active');
	}
	else
	{
	$('.nav-tabs a[href="#leadstabb"]').addClass('active');
	$('#leadstabb').addClass('active');
	}
	
	$('#modal-center2').on('show.bs.modal', function (e) {
	if(document.getElementById('champs') != null){

	document.getElementById('champs').innerHTML="";
	document.getElementById('champs').parentNode.removeChild(document.getElementById('champs'));
	document.getElementById('formid').reset();}
	else{
		document.getElementById('formid').reset();
	}
})



	});




	</script>
	<script>
		$(document).ready(function(){
			$.fn.dataTable.ext.errMode = 'none';
			$('#tickets').DataTable({
				processing:true,
				order:[[ 2, 'desc' ]],
				paging:true,
				searching:true,
			});
					var optionDonut = {
				chart: {
					type: 'donut',
					width: '350'
				},
				dataLabels: {
				enabled: false,
				},
				plotOptions: {
				pie: {
					donut: {
					size: '35%',
					},
					offsetY: 0,
				},
				stroke: {
					colors: undefined
				}
				},
				responsive: [{
					breakpoint: 1500,
					options: {	
						chart: {
								width: '94%'
							},
					},
				}],
				responsive: [{
					breakpoint: 1400,
					options: {	
						chart: {
								width: '100%'
							},
					},
				}],
				responsive: [{
					breakpoint: 1350,
					options: {	
						chart: {
								width: '100%'
							},
					},
						}],
				colors:["#fc4b6c", "#8a2be2", "#462be2","#c49e36", "#e22b34", "#2be23a","#fc5b6c", "#ffb42b", "#348bf7"],
				
				series: <?php echo json_encode($arraycount);?>,
				labels:<?php echo json_encode($arrayname);?>,
				legend: {
				position: 'bottom',
				}
			}

			var donut = new ApexCharts(
				document.querySelector("#donut1"),
				optionDonut
			);
			donut.render();
			document.querySelector(".apexcharts-legend").innerHTML='';
			PK_USER=$('#pk_userAdd').val();

			$.ajax({
				url:"https://www.yestravaux.com/webservice/crm/lead.php",
				method:"POST",
				data:{fct:'LoadLeadsTreatedByCampany',user_id:PK_USER},
				dataType:"json",
				success:function(data)
				{
					var listInline=document.getElementById('list-inline');

					listInline.innerHTML=data.output;
					/*var result=[];
					var listvalue='';
					data.result.forEach(doc=>{
						result.push(doc.companyLeads);
						listvalue+=doc.companyLeads+',';
					});
					var list=listvalue.substring(0,listvalue.length-1);
					console.log(list,typeof list);
					document.getElementById('valuebar2').innerHTML=list;*/
					}
					
				});



				} );
// function to make lead as archived...........................
 function ArchiveLead(id){
	USER_KEY=$('#k_keyAdd').val();
	PK_USER=$('#pk_userAdd').val();
	BROWSER=$('#user_browser').val();
		swal({
	title: 'Etes-vous sûr ?',
	text: "Voulez vous Archiver ce lead!",
	type: "info",
	imageWidth: '400',
	imageHeight: '150',
	showCancelButton: true,
	confirmButtonColor: '#2196f3 ',
	cancelButtonColor: '#673ab7 ',
	confirmButtonText: 'Oui, je confirme',
	cancelButtonText: 'Non',
	confirmButtonClass: ' btn-primary ',
	cancelButtonClass: 'btn-dark',
	buttonsStyling: true
	}).then(function(){
		swal(
		'Archiver!',
		'Votre lead est archivée.',
		'success'
		).then(function(){
			$.ajax({
					url:'https://www.yestravaux.com/webservice/crm/lead.php',
					type: "POST",
					dataType: "html",

					data: {fct:'UpdateLeadStatus',lead_id:id,statuslead:3,pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
					async: true,
					success:function(data){
						console.log(data);
						console.log("fine");
					}});

					$.fn.dataTable.ext.errMode = 'none';
					$('#tickets').DataTable({
					paging:true,
					order: [[ 0, "desc" ]]
					});
					$('#tickets1').DataTable({
					paging:true,
					order: [[ 0, "desc" ]]
					});
					
			$('ggg_change').html();		 
			$("#ggg_change").load(location.href+" #ggg_change>*","");		   
			
		})

	},function (dismiss) {
	if (dismiss === 'cancel') {
		swal(
		'Annulée',
		'l\'archivage a été annulée :)',
		'error'
		)
	}
	})
		return false;
		}

// tab archive
function Supprimer(id){
	USER_KEY=$('#k_keyAdd').val();
	PK_USER=$('#pk_userAdd').val();
	BROWSER=$('#user_browser').val();
		swal({
	title: 'Etes-vous sûr ?',
	text: "Voulez vous supprimer ce lead!",
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
		'Votre lead est supprimée.',
		'success'
		).then(function(){
			$.ajax({
					url:'https://www.yestravaux.com/webservice/crm/lead.php',
					type: "POST",
					dataType: "html",

					data: {fct:'DeleteLead',lead_id:id,pk_user:PK_USER,k_key:USER_KEY,browser:BROWSER},
					async: true,
					success:function(data){
						console.log(data);
						console.log("fine");
			           // $('verifid1').html();
		}
				});
				
				$.fn.dataTable.ext.errMode = 'none';
				$('#tickets1').DataTable({
					paging:true,
				order: [[ 0, "desc" ]]
				});
				$('#tickets2').DataTable({
					paging:true,
				order: [[ 0, "desc" ]]
				});



				//$("#tickets1").load(location.href+" #tickets1>*","");  
			$('ggg_change').html();		 
			$("#ggg_change").load(location.href+" #ggg_change>*","");


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

		function UpdateStatusLeadArchive(id) {
		USER_KEY=$('#k_keyAdd').val();
		PK_USER=$('#pk_userAdd').val();
		BROWSER=$('#user_browser').val();
		var element=document.getElementById('stateleadarchive'+id);
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
		else if(val==0){
			selectoption="custom-select btn-warning";
		}
		else{
			selectoption="custom-select btn-dark";
		}
		console.log(parseInt(val));
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
					}
				});
				$.fn.dataTable.ext.errMode = 'none';
				$('ggg_change').html();		 
		        $("#ggg_change").load(location.href+" #ggg_change>*","");  
				return true;
			
	}
	
	
	</script>
