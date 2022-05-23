
<?php


// if(!isset($_SESSION["PK_USER"])){

// 	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
  
//   }

  

global $sqlserver;
$clientBrowser = $_SERVER['HTTP_USER_AGENT'];// get client browser

$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
$POSTVALUE  = 'fct=GetTodayTask&PK_USER='.$_SESSION['PK_USER'];
$taskresult = curl_do_post($URL, $POSTVALUE);
$taskresult =json_decode($taskresult);
$taskresult =(array) $taskresult;
?>

<!-- Content Wrapper. Contains page content -->
	<div class="container-full" >
	
	<!-- Content Header (Page header) -->	  
	<div class="content-header">
		<div class="d-flex align-items-center">
			<div class="me-auto">
				<h4 class="page-title">Tâche</h4>
				<div class="d-inline-block align-items-center">
					<nav>
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
							<li class="breadcrumb-item" aria-current="page">Tâche</li>
						</ol>
					</nav>
				</div>
			</div>
			
		</div>
	</div>

	<!-- Main content -->
	<section class="content" id="refresh-users">
	
		<div class="row">
		<div class="col-sm-10 col-xl-10">	
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				
				<li><a href="#tasktoday" data-bs-toggle="tab" >Task a effectuer</a></li>
				<li><a href="#hes_email" data-bs-toggle="tab">Historique EMAIL</a></li>
				<li><a href="#hes_sms" data-bs-toggle="tab">Historique SMS</a></li>
				<li><a href="#hes_call" data-bs-toggle="tab">Historique Appel</a></li>
			</ul>
			<div class="tab-content">
			<div class="tab-pane" id="tasktoday">
			<div class="box-body">
						<div class="table-responsive">
							<table id="invoice-list1" class="table table-hover no-wrap" data-page-size="10">
								<thead>
									<tr>
										<th>Date Tâche</th>
										<th>Type</th>		
										<th>Nom companie</th>
										<th>Email lead</th>
										<th>Téléphone lead</th>
										<th>Terminer</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								
						
								for($i=0;$i<count($taskresult);$i++) { 
									if($taskresult[$i]->action_type == 1){
										$type="EMAIL";
										$class="badge badge-info";
									}
										elseif($taskresult[$i]->action_type == 2){
											$type="SMS";
											$class="badge badge-warning";
										}
										else{
											$type="CALL";
											$class="badge badge-danger";
										}
										
									?>
								<tr>
									
									<td>
										
									<?php echo $taskresult[$i]->date;?> <?php echo $taskresult[$i]->time;?>
								
								</td>
								
									<td>
										<span class="<?php echo $class;?>"><?php echo $type;?></span>
							
									</td>
									<td>
									<?php echo $taskresult[$i]->companyName;?>
									</td>
									<td class="text-info">
									<?php echo $taskresult[$i]->email;?>
									</td>
									<td class="text-danger">
									<?php echo $taskresult[$i]->phone;?>
									</td>
									<td>
									<input type="checkbox" id="checkbox_10" value="single" onchange="AddTask('<?php echo $taskresult[$i]->leadID;?>','<?php echo $taskresult[$i]->camp_id;?>','<?php echo $taskresult[$i]->seq_id;?>','<?php echo $taskresult[$i]->action_type;?>');"class="filled-in chk-col-info">
									<label for="checkbox_10"></label>
									</td>
                                        <td>
                                        <a href="index.php?page=lead&lead_id=<?php echo $taskresult[$i]->leadID;?>" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										
                                        </td>	
									
									</tr>
									
								<?php }?>
								</tbody>
							</table>
					</div>
				</div></div>
			<div class="tab-pane" id="hes_email">
				<?php
				if(isset($_REQUEST["Search2"]) && $_REQUEST["date_search"]!=""){
				$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
				$POSTVALUE  = 'fct=GetHistoryTaskBydate&PK_USER='.$_SESSION['PK_USER']."&date_search=".$_REQUEST["date_search"];
				$taskcompletresult = curl_do_post($URL, $POSTVALUE);
				$taskcompletresult = json_decode($taskcompletresult);
				$taskcompletresult = (array) $taskcompletresult; 
					//var_dump($_REQUEST["date_search"]);
				}
				else{
				$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
				$POSTVALUE  = 'fct=GetHistoryTask&PK_USER='.$_SESSION['PK_USER'];
				$taskcompletresult = curl_do_post($URL, $POSTVALUE);
				$taskcompletresult = json_decode($taskcompletresult);
				$taskcompletresult = (array) $taskcompletresult;
				}
				?>
				<!--form action="?page=task#hes_email" method="post">
								<div class="row">
								<div class="col5  col-md-4  col-xs-3">
								</div>
									<div class="col4  col-md-3  col-xs-3">
								<input type="date" name="date_search" class="form-control" size=8></div>
								<div class="col5 col5 col-md-4  col-xs-3">
								<input type="submit" class="btn btn-sm btn-info"  name="Search2" value="Search">
								</div>
							</div>
							</form-->
			
			<div class="box-body">
			<form action="?page=task#hes_email" method="post">
								<div class="row">
								<div class="col5  col-md-4  col-xs-3">
								</div>
									<div class="col4  col-md-3  col-xs-3">
								<input type="date" name="date_search" class="form-control" size=8></div>
								<div class="col5 col5 col-md-4  col-xs-3">
								<input type="submit" class="btn btn-sm btn-info"  name="Search2" value="Search">
								</div>
							</div>
							</form>
						<div class="table-responsive">
							
							<table id="invoice-list2" class="table table-hover no-wrap" data-page-size="10">
								<thead>
									<tr>
										<th>Date Tâche</th>
										<th>Status</th>
										<th>Email lead</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								
						
								for($i=0;$i<count($taskcompletresult);$i++) { 
									if($taskcompletresult[$i]->action_type == 1){
										$type="EMAIL";
										$class="badge badge-info";
									
                                    if($taskcompletresult[$i]->status == "traité"){
										$value="traité";
										$class_status="badge badge-success-light";
									}
                                    else{
                                        $value="non traité";
										$class_status="badge badge-warning-light";
                                    }
									?>
								<tr>
									<td class="text-fade"><?php echo $taskcompletresult[$i]->DATE_ADD_TASK;?>-<?php echo $taskcompletresult[$i]->time;?></td>
								
									<td>
										<span class="<?php echo $class_status;?>"><?php echo $value;?></span>
							
									</td>
									
									<td class="text-info">
									<?php echo $taskcompletresult[$i]->email;?>
									</td>
				
									<td>
									<a href="index.php?page=lead&id=<?php echo $taskcompletresult[$i]->lead_id;?>" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

									</td>	
								
								</tr>
								
							<?php }}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="hes_sms">

			<?php
				if(isset($_REQUEST["Search3"]) && $_REQUEST["date_search3"]!=""){
				$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
				$POSTVALUE  = 'fct=GetHistoryTaskBydate&PK_USER='.$_SESSION['PK_USER']."&date_search=".$_REQUEST["date_search3"];
				$taskcompletresult = curl_do_post($URL, $POSTVALUE);
				$taskcompletresult = json_decode($taskcompletresult);
				$taskcompletresult = (array) $taskcompletresult; 
					//var_dump($_REQUEST["date_search"]);
				}
				else{
				$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
				$POSTVALUE  = 'fct=GetHistoryTask&PK_USER='.$_SESSION['PK_USER'];
				$taskcompletresult = curl_do_post($URL, $POSTVALUE);
				$taskcompletresult = json_decode($taskcompletresult);
				$taskcompletresult = (array) $taskcompletresult;
				}
				?>
			
			<div class="box-body">
			<!--form action="?page=task#hes_sms" style="margin-right:500px;margin-left:500px" method="post">
								<div class="row">
									<div class="col-xs-3">
								<input type="date" name="date_search3" class="form-control" size=8>
								<input type="submit" class="btn btn-sm btn-info" style="margin-top:-52px;margin-left:250px" name="Search3" value="Search">
								</div>
							</div>
							</form-->
							<form action="?page=task#hes_sms" method="post">
								<div class="row">
								<div class="col5  col-md-4  col-xs-3">
								</div>
									<div class="col4  col-md-3  col-xs-3">
								<input type="date" name="date_search3" class="form-control" size=8></div>
								<div class="col5 col5 col-md-4  col-xs-3">
								<input type="submit" class="btn btn-sm btn-info"  name="Search3" value="Search">
								</div>
							</div>
							</form>
					<div class="table-responsive">
						
						<table id="invoice-list3" class="table table-hover no-wrap" data-page-size="10">
							<thead>
								<tr>
									<th>Date Tâche</th>

									<th>Status</th>
									<th>Téléphone lead</th>
									<th>Action</th>

								</tr>
							</thead>
							<tbody>


							<?php
							
					
							for($i=0;$i<count($taskcompletresult);$i++) { 
								if($taskcompletresult[$i]->action_type == 2){
									$type="SMS";
									$class="badge badge-warning";
								
								if($taskcompletresult[$i]->status == "traité"){
									$value="traité";
									$class_status="badge badge-success-light";
								}
								else{
									$value="non traité";
									$class_status="badge badge-warning-light";

								}


									?>


									<tr>
										<td class="text-fade"><?php echo $taskcompletresult[$i]->DATE_ADD_TASK;?>-<?php echo $taskcompletresult[$i]->time;?></td>
									
										<td>
											<span class="<?php echo $class_status;?>"><?php echo $value;?></span>
								
										</td>
										
									    <td class="text-danger">
										<?php echo $taskcompletresult[$i]->phone;?>
									    </td>
					
                                        <td>
                                        <a href="index.php?page=lead&id=<?php echo $taskcompletresult[$i]->lead_id;?>" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

                                        </td>	
									
									</tr>
									
								<?php }}?>
								</tbody>
							</table>
					</div>
				</div>

			</div>
			<div class="tab-pane" id="hes_call">
			<?php
				if(isset($_REQUEST["Search4"]) && $_REQUEST["date_search4"]!=""){
				$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
				$POSTVALUE  = 'fct=GetHistoryTaskBydate&PK_USER='.$_SESSION['PK_USER']."&date_search=".$_REQUEST["date_search4"];
				$taskcompletresult = curl_do_post($URL, $POSTVALUE);
				$taskcompletresult = json_decode($taskcompletresult);
				$taskcompletresult = (array) $taskcompletresult; 
					//var_dump($_REQUEST["date_search"]);
				}
				else{
				$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
				$POSTVALUE  = 'fct=GetHistoryTask&PK_USER='.$_SESSION['PK_USER'];
				$taskcompletresult = curl_do_post($URL, $POSTVALUE);
				$taskcompletresult = json_decode($taskcompletresult);
				$taskcompletresult = (array)$taskcompletresult;
				}
				?>
				<!--form action="?page=task#hes_email" method="post">
								<div class="row">
								<div class="col5  col-md-4  col-xs-3">
								</div>
									<div class="col4  col-md-3  col-xs-3">
								<input type="date" name="date_search" class="form-control" size=8></div>
								<div class="col5 col5 col-md-4  col-xs-3">
								<input type="submit" class="btn btn-sm btn-info"  name="Search2" value="Search">
								</div>
							</div>
							</form-->
			
							<div class="box-body">
							<form action="?page=task#hes_call" method="post">
								<div class="row">
								<div class="col5  col-md-4  col-xs-3">
								</div>
									<div class="col4  col-md-3  col-xs-3">
								<input type="date" name="date_search4" class="form-control" size=8></div>
								<div class="col5 col5 col-md-4  col-xs-3">
								<input type="submit" class="btn btn-sm btn-info"  name="Search4" value="Search">
								</div>
							</div>
							</form>
						<div class="table-responsive">
							
							<table id="invoice-list4" class="table table-hover no-wrap" data-page-size="10">
								<thead>
									<tr>
										<th>Date Tâche</th>

										<th>Status</th>
										<th>Téléphone lead</th>
                                        <th>Action</th>

									</tr>
								</thead>
								<tbody>


								<?php
								
						
								for($i=0;$i<count($taskcompletresult);$i++) { 
									if($taskcompletresult[$i]->action_type == 3){
										$type="EMAIL";
										$class="badge badge-info";
									
                                    if($taskcompletresult[$i]->status == "traité"){
										$value="traité";
										$class_status="badge badge-success-light";
									}
                                    else{
                                        $value="non traité";
										$class_status="badge badge-warning-light";

                                    }
									?>


								<tr>
									<td class="text-fade"><?php echo $taskcompletresult[$i]->DATE_ADD_TASK;?>-<?php echo $taskcompletresult[$i]->time;?></td>
								
									<td>
										<span class="<?php echo $class_status;?>"><?php echo $value;?></span>
							
									</td>
									
									<td class="text-danger">
									<?php echo $taskcompletresult[$i]->phone;?>
									</td>
				
									<td>
									<a href="index.php?page=lead&id=<?php echo $taskcompletresult[$i]->lead_id;?>" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>

									</td>	
								
								</tr>				
							<?php }}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>

	</div>		

		</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/highlight.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
jQuery(document).ready(function() {
hljs.highlightAll();
});
$(document).ready(function() {



	$('#invoice-list1').DataTable({
		paging:true,
		order: [[0, "desc" ]],
		"language": {
			"sProcessing": "Traitement en cours ...",
			"sLengthMenu": "Afficher _MENU_ Tâche",
			"sZeroRecords": "Aucun résultat trouvé",
			"sEmptyTable": "Aucune donnée disponible",
			"sInfo": "_START_ à _END_ sur _TOTAL_ Tâches",
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


	$('#invoice-list2').DataTable({
		paging:true,
		order: [[0, "desc" ]],
		"language": {
			"sProcessing": "Traitement en cours ...",
			"sLengthMenu": "Afficher _MENU_ Email",
			"sZeroRecords": "Aucun résultat trouvé",
			"sEmptyTable": "Aucune donnée disponible",
			"sInfo": "_START_ à _END_ sur _TOTAL_ Email",
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





		$('#invoice-list3').DataTable({
		paging:true,
		order: [[0, "desc" ]],
		"language": {
			"sProcessing": "Traitement en cours ...",
			"sLengthMenu": "Afficher _MENU_ Message",
			"sZeroRecords": "Aucun résultat trouvé",
			"sEmptyTable": "Aucune donnée disponible",
			"sInfo": "_START_ à _END_ sur _TOTAL_ Message",
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




		$('#invoice-list4').DataTable({
		paging:true,
		order: [[0, "desc" ]],
		"language": {
			"sProcessing": "Traitement en cours ...",
			"sLengthMenu": "Afficher _MENU_ Appel",
			"sZeroRecords": "Aucun résultat trouvé",
			"sEmptyTable": "Aucune donnée disponible",
			"sInfo": "_START_ à _END_ sur _TOTAL_ Appel",
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



					









$.fn.dataTable.ext.errMode = 'none';
	$('#invoice-list1').DataTable({
	order: [[ 0, "desc" ]]
	})
	$.fn.dataTable.ext.errMode = 'none';
	$('#invoice-list2').DataTable({
	order: [[ 0, "desc" ]]
	})
	$.fn.dataTable.ext.errMode = 'none';
	$('#invoice-list3').DataTable({
	order: [[ 0, "desc" ]]
	})
	$.fn.dataTable.ext.errMode = 'none';
	$('#invoice-list4').DataTable({
	order: [[ 0, "desc" ]]
	})


	
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
	$('.nav-tabs a[href="#tasktoday"]').addClass('active');
	$('#tasktoday').addClass('active');
	}


});


function AddTask(leadid,campid,seqid,action_type)
{
	$.ajax({
			url:'https://www.yestravaux.com/webservice/crm/lead.php',
			type: "POST",
			dataType: "html",
			data: {fct:'addtask',type:action_type,camp_id:campid,lead_id:leadid,seq_id:seqid},
			async: true,
			success:function(data){	
			data=JSON.parse(data);
			if(data.result=="ok"){
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