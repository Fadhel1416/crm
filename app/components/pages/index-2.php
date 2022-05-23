<?php 
header('Access-Control-Allow-Origin: *');
session_start();
//var_dump($_SESSION['PK_USER']);

if(!isset($_SESSION["PK_USER"])){

	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";

}


?>

  <!-- Content Wrapper. Contains page content -->

	  <div class="container-full">
		<!-- Main content -->
		<section class="content">
			
					
			<div class="row">
			<?php   

					$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
					$POSTVALUE  = 'fct=CountLeadWithStatus&PK_USER='.$_SESSION['PK_USER'];
					$statusresult = curl_do_post($URL, $POSTVALUE);
					$statusresult = json_decode($statusresult);
					$statusresult = (array) $statusresult;
					$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
					$POSTVALUE  = 'fct=ListDernierLead&PK_USER='.$_SESSION['PK_USER'];
					$leadresult = curl_do_post($URL, $POSTVALUE);
					$leadresult = json_decode($leadresult);
					$leadresult = (array) $leadresult;
					$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
					$POSTVALUE  = 'fct=GetTodayTask&PK_USER='.$_SESSION['PK_USER'];
					$taskresult = curl_do_post($URL, $POSTVALUE);
					$taskresult = json_decode($taskresult);
					$taskresult = (array) $taskresult;
					//var_dump($taskresult);

					$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
					$POSTVALUE  = 'fct=GetNumberTicket&PK_USER='.$_SESSION['PK_USER'];
					$TicketResult = curl_do_post($URL, $POSTVALUE);
					$TicketResult = json_decode($TicketResult);
					//$TicketResult = (array) $TicketResult;
                     
                      // var_dump($TicketResult);
               

					?>
					
                	<div class="col-xl-3 col-12">
					<a href="index.php?page=leads#leadNewtab">

					<div class="info-box bg-gradient-school text-white">
					<span class="info-box-icon rounded"><i class="ion ion-stats-bars"></i></span>
					<div class="info-box-content">
						<span class="info-box-number"><?php  echo $statusresult[0]->nouveau;?></span>
						<span class="info-box-text">Nouveaux leads</span>
					</div>
					</div>
					</a>
					</div>
					<div class="col-xl-3 col-12">
					<a href="index.php?page=leads#leadCourtab">

					<div class="info-box bg-gradient-ubuntu text-white">
					<span class="info-box-icon rounded"><i class="ion ion-stats-bars"></i></span>
					<div class="info-box-content">
						<span class="info-box-number"><?php  echo $statusresult[0]->encour;?></span>
						<span class="info-box-text">Leads en cours</span>
					</div>
					</div>
					</a>
					</div>
					<div class="col-xl-3 col-12">
					<a href="index.php?page=leads#leadTreatedtab">

					<div class="info-box bg-gradient-leaf text-white">
					<span class="info-box-icon rounded"><i class="ion ion-stats-bars"></i></span>
					<div class="info-box-content">
						<span class="info-box-number"><?php  echo $statusresult[0]->traite;?></span>
						<span class="info-box-text">Leads traités</span>
					</div>
					</div>
					</a>
					</div>
					<div class="col-xl-3 col-12">
					<a href="index.php?page=leads#leadarchivestab">

					<div class="info-box bg-gradient-oceansky-dark text-white">
					<span class="info-box-icon rounded"><i class="ion ion-stats-bars"></i></span>
					<div class="info-box-content">
						<span class="info-box-number"><?php  echo $statusresult[0]->archived;?></span>
						<span class="info-box-text">Leads archivés</span>
					</div>
					</div>
						</a>
					</div>
					<div class="row">
						<div class="col-xl-2 col-md-3 col-12">
						<a class="box box-link-shadow text-center" href="index.php?page=tickets">
							<div class="box-body" style="height:80px">
								<div class="fs-24"><?php echo $TicketResult->total;?></div>
								<span>Tickets total</span>
							</div>
							<div class="box-body bg-dark btsr-0 bter-0" style="height:70px">
								<p>
									<span class="mdi mdi-ticket-confirmation fs-30"></span>
								</p>
							</div>
						  </a>
						</div>
						<div class="col-xl-2 col-12">
						<a class="box box-link-shadow text-center" href="index.php?page=tickets">
							<div class="box-body" style="height:80px">
								<div class="fs-24"><?php echo $TicketResult->new;?></div>
								<span>Nouveaux tickets</span>
							</div>
							<div class="box-body bg-danger btsr-0 bter-0" style="height:70px">
								<p>
									<span class="mdi mdi-ticket fs-30"></span>
								</p>
							</div>
						  </a>
						</div>
						<div class="col-xl-2 col-12">
						<a class="box box-link-shadow text-center" href="index.php?page=tickets">
							<div class="box-body" style="height:80px">
								<div class="fs-24"><?php echo $TicketResult->pending;?></div>
								<span>Tickets en attente</span>
							</div>
							<div class="box-body bg-warning btsr-0 bter-0" style="height:70px">
								<p>
									<span class="mdi mdi-ticket fs-30"></span>
								</p>
							</div>
						  </a>
						</div>
						<div class="col-xl-3 col-12">
						<a class="box box-link-shadow text-center" href="index.php?page=tickets">
							<div class="box-body" style="height:80px">
								<div class="fs-24"><?php echo $TicketResult->resolved;?></div>
								<span>Tickets résolu</span>
							</div>
							<div class="box-body bg-success btsr-0 bter-0" style="height:70px">
								<p>
									<span class="mdi mdi-message-reply-text fs-30"></span>
								</p>
							</div>
						  </a>
						</div>
						<div class="col-xl-3 col-12">
						<a class="box box-link-shadow text-center" href="index.php?page=tickets">
							<div class="box-body" style="height:80px">
								<div class="fs-24"><?php echo $TicketResult->opened;?></div>
								<span>Tickets ouverts</span>
							</div>
							<div class="box-body bg-info btsr-0 bter-0" style="height:70px">
								<p>
									<span class="mdi mdi-message-reply-text fs-30"></span>
								</p>
							</div>
						  </a>
						</div>
					</div>
					<div class="col-12 col-xl-8">	
					<div class="box">
						<div class="box-header with-border">
							<h4 class="box-title">Récentes leads</h4>
							</div>
							<div class="box-body">
							<div class="table-responsive">
								<table id="invoice-list" class="table table-hover no-wrap" data-page-size="10">
									<thead>
										<tr>
											<th>Companie</th>

											<th>Nom/Prénom</th>		
											<th>Status</th>
											<th>Société</th>
											<th>Vue</th>
										</tr>
									</thead>
									<tbody>


									<?php
									
									$leadresult=array_reverse($leadresult);
									for($i=0;$i<count($leadresult);$i++) { 
											
											$dataleadid = (array) $leadresult[$i]->_id;
											$id = $dataleadid['$id'];

										?>


										<tr>
											<td><?php echo $leadresult[$i]->companyName;?></td>
											<td>
											<?php if(array_key_exists('nom',$leadresult[$i]) && array_key_exists('prenom',$leadresult[$i])){
													?>
											<a href="#"><?php echo $leadresult[$i]->nom.''. $leadresult[$i]->prenom;?></a>
											<?php } else {?>
												<a href="#"><?php echo $leadresult[$i]->nom_prenom;?></a>
											<?php } ?>
										</td>
										<td>
										<?php if($leadresult[$i]->status == 2){
											$class="btn-rounded btn-primary-light px-10";
										    $value="Traité";
										}
											elseif($leadresult[$i]->status == 1){
												$class="btn-rounded btn-danger-light px-10";
												$value="En cour";
											}
											else{
												$class="btn-rounded btn-warning-light px-10";
												$value="Nouveau";
											}
											?>
											<span class="<?php echo $class;?> myspanstyle"><?php echo $value;?></span>
										
										
										</td>
										<td><?php echo $leadresult[$i]->societe;?></td>
										<td>
											<a href="index.php?page=leads&campaign_id=<?php echo $leadresult[$i]->campaign_id;?>"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									
								<?php }?>
								</tbody>
							</table>
						</div>
						</div>
					</div>	
					<div class="box">
					<div class="box-header with-border">
						<h4 class="box-title">Principales tâches à effectuer</h4>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="invoice-list1" class="table table-hover no-wrap" data-page-size="10">
								<thead>
									<tr>
										<th>Date Tâche</th>

										<th>Type</th>		
										<th>Nom Companie</th>
										<th>Email lead</th>
										<th>Téléphone lead</th>

									</tr>
								</thead>
								<tbody>


								<?php
								$taskresult=array_reverse($taskresult);
								if(count($taskresult)<10){
									$count=count($taskresult);
								}
								else{
									$count=10;
								}

								for($i=0;$i<$count;$i++) { 
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
										<td><?php echo $taskresult[$i]->date;?></td>
									
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
									
									</tr>
									
								<?php }?>
								</tbody>
							</table>
						</div>
						<a href="index.php?page=task" target="_blank" class="btn btn-sm btn-success pull-left">Voir tout</a>
						</div>
					</div>	
				</div>
				
				<div class="col-12 col-xl-4">
				<a href="index.php?page=leads#leadConvertedtab">

					<div class="box">	
						<div class="box-header no-border">
							<h4> Leads total convertis aujourd'hui</h4> 
						</div>
						<div class="box-body pb-40">
							<h1 class="text-center"><span class="text-center fs-50"  id="totalconvertedleadsToday"></span> Leads</h1> 
						</div>
						<div class="box-body p-0 overflow-h">					  	
							<div id="spark4"></div>
						</div>
					</div></a>	
					<div class="box">
						<div class="box-header with-border">
							<h4 class="">Leads convertis en <span id="month_year"></span></h4>
							<div class="box-controls pull-right">
							<form>
								
								<select id="monthName-index2Id" class="custom-select badge-dark " onChange="LoadConvertedLeadsByMonth();">
								<option value="01" <?php if(date('m')=="01") echo "selected";?> >Janvier</option>
								<option value="02" <?php if(date('m')=="02") echo "selected";?> >Février</option>
								<option value="03" <?php if(date('m')=="03") echo "selected";?>>Mars</option>
								<option value="04" <?php if(date('m')=="04") echo "selected";?>>Avril</option>
								<option value="05" <?php if(date('m')=="05") echo "selected";?>>Mai</option>
								<option value="06" <?php if(date('m')=="06") echo "selected";?>>Juin</option>
								<option value="07" <?php if(date('m')=="07") echo "selected";?>>Juillet</option>
								<option value="08" <?php if(date('m')=="08") echo "selected";?>>Août</option>
								<option value="09" <?php if(date('m')=="09") echo "selected";?>>Septembre</option>
								<option value="10" <?php if(date('m')=="10") echo "selected";?>>Octobre</option>
								<option value="11" <?php if(date('m')=="11") echo "selected";?>>Novembre</option>
								<option value="12" <?php if(date('m')=="12") echo "selected";?>>Décembre</option>
								</select>
								<?php 
									$year=date('Y');
									$startyear=intval('2021');
									$arrayyear=[];
									for($i=$startyear+1;$i<=intval($year);$i++){
										array_push($arrayyear,$i);
									}
								?>
							<select id="yearName-index2Id" class="custom-select badge-dark " onChange="LoadConvertedLeadsByYear();">
							<option value="2021" <?php if(date('Y')=="2021") echo "selected";?> >2021</option>
							<?php for($i=0;$i<count($arrayyear);$i++) { ?>
								<option value="<?php echo $arrayyear[$i];?>" <?php if(date('Y')==$arrayyear[$i]) echo "selected";?> ><?php echo $arrayyear[$i];?></option>
								<?php }?>
							</select>
								</form></div>
						</div>
						
						<div class="box-body chart-responsive">
							<div id="fetchChilds2" style="height:400px">

							</div>
							
						</div>
					</div>
				</div>
			
				<div class="row">
						<div class ="col-md-8">

<!--div id="mybar" width="30" height="20"></div-->
					<div class="box">
					<div class="box-header with-border">
					<h4 class="box-title">Leads companie par mois</h4>
					<ul class="box-controls pull-right">
						<li><a class="box-btn-close" href="#"></a></li>
						<li><a class="box-btn-slide" href="#"></a></li>	
						<li><a class="box-btn-fullscreen" href="#"></a></li>
						<li><form>
							
						<select id="monthName" class="custom-select badge-dark " onChange="LoadCampanyByMonth();">
						<option value="01" <?php if(date('m')=="01") echo "selected";?> >Janvier</option>
						<option value="02" <?php if(date('m')=="02") echo "selected";?> >Février</option>
						<option value="03" <?php if(date('m')=="03") echo "selected";?>>Mars</option>
						<option value="04" <?php if(date('m')=="04") echo "selected";?>>Avril</option>
						<option value="05" <?php if(date('m')=="05") echo "selected";?>>Mai</option>
						<option value="06" <?php if(date('m')=="06") echo "selected";?>>Juin</option>
						<option value="07" <?php if(date('m')=="07") echo "selected";?>>Juillet</option>
						<option value="08" <?php if(date('m')=="08") echo "selected";?>>Août</option>
						<option value="09" <?php if(date('m')=="09") echo "selected";?>>Septembre</option>
						<option value="10" <?php if(date('m')=="10") echo "selected";?>>Octobre</option>
						<option value="11" <?php if(date('m')=="11") echo "selected";?>>Novembre</option>
						<option value="12" <?php if(date('m')=="12") echo "selected";?>>Décembre</option>
						</select>

							</form></li>
							</ul>
						</div>
						<div class="box-body chart-responsive">
						<div class="chart">
						<div id="mybar" class="h-500 mybarstyle">
						</div>
						

						</div>
						</div>
				</div>


			</div> 

						<div class="col-lg-4 col-12">
						<div class="box">
						<div class="box-header with-border">
							<h4 class="box-title">Leads traiter par campanie par mois</h4>
								<ul class="box-controls pull-right">
								<li><a class="box-btn-close" href="#"></a></li>
								<li><a class="box-btn-slide" href="#"></a></li>	
								<li><a class="box-btn-fullscreen" href="#"></a></li>
								</ul>
							</div>
							<div class="box-body boxPosition">
							<div id="myspark" class="mysparkstyle">

							</div>
							</div>
					</div>
						</div>
					<div class="col-12 col-xxxl-8 col-xl-6">
						<div class="box">
							<div class="box-header with-border">
							<h4 class="box-title">Leads companie par année</h4>

							<ul class="box-controls pull-right">
								<li><a class="box-btn-close" href="#"></a></li>
								<li><a class="box-btn-slide" href="#"></a></li>	
								<li><a class="box-btn-fullscreen" href="#"></a></li>
								<li><form>
									<?php 
									$year=date('Y');
									$startyear=intval('2021');
									$arrayyear=[];
									for($i=$startyear+1;$i<=intval($year);$i++){
										array_push($arrayyear,$i);
									}
										?>
							<select id="yearName" class="custom-select badge-dark " onChange="ChangeChartYear();">
							<option value="2021" <?php if(date('Y')=="2021") echo "selected";?> >2021</option>
							<?php for($i=0;$i<count($arrayyear);$i++) { ?>
								<option value="<?php echo $arrayyear[$i];?>" <?php if(date('Y')==$arrayyear[$i]) echo "selected";?> ><?php echo $arrayyear[$i];?></option>
								<?php }?>
							</select>

								</form></li>
							</ul>
							</div>
							<div class="box-body">
								<div id="baryear"></div>	
							</div>
						</div>
					</div>
					<div class="col-12 col-xxxl-4 col-xl-6">
						<div class="box">
							<div class="box-header with-border">
							<h4 class="box-title">Leads traités par companie par jour</h4>
								<ul class="box-controls pull-right">
								<li><a class="box-btn-close" href="#"></a></li>
								<li><a class="box-btn-slide" href="#"></a></li>	
								<li><a class="box-btn-fullscreen" href="#"></a></li>
								</ul>
							</div>
							<div class="box-body">
								<div id="donutday"></div>
							</div>
						</div>	
					</div>	
					<!--div class="col-12">
						<div class="box">
							<div class="box-header with-border">
								<h4 class="box-title">Monthly Top Sale</h4>
							</div>
							<div class="box-body chart-responsive">
								<div class="chart">
									<div id="myChart" class="h-500"></div>
								</div>	
							</div>
						</div>				
					</div-->
			
					
				</div>      
	
								<!--div class="col-lg-4 col-12">
						<div class="box bg-primary bg-food-dark pull-up">
						<div class="box-body">
							<h5 class="mb-0">
								<span class="text-uppercase">ORDER</span>
								<span class="float-end"><a class="btn btn-rounded btn-white btn-outline" href="#">View</a></span>
							</h5>
							<br>
							<small>Todays Order</small>
							<div class="d-flex justify-content-between">
								<p class="fs-26">516k</p>
								<div><i class="ion-arrow-graph-up-right text-white me-1"></i> %18 decrease from last month</div>					
							</div>
						</div>
						<div class="box-body p-0" style="position: relative;">
							<div id="spark11" style="min-height: 500px;">
						</div>
					</div-->
				
				<form action="#">

				<input type="hidden" id="pk_user" value="<?php echo $_SESSION['PK_USER'];?>">
				</form>
			</section>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	
			<script>

		function getRandomInt(min, max) 
		{
		return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		function NombreJourMois(iMonth, iYear)
		{
		target = new Date(iYear, iMonth, 0);
		nbJour = target.getDate();
		return nbJour;
		}

		function Loadchart(mois,ArrayJour){
			let xhr = new XMLHttpRequest();
			var PK_USER=document.getElementById('pk_user').value;
			xhr.open("GET", "https://www.yestravaux.com/webservice/crm/lead.php?fct=CountLeadByCampanyByMois&PK_USER="+PK_USER+"&mois="+mois+"&annee="+new Date().getFullYear(), true);
			xhr.onload = ()=>{
			if(xhr.readyState === XMLHttpRequest.DONE){
				if(xhr.status === 200){
            var data = xhr.response;
			datastring=data.substr(data.indexOf('['),data.length);
			resultcount=[];
			resultcampany=[];
			serieslists=new Array();
			colorarray=[];
			zendseries=[];
			dateresult=[];
			datecampresult=[];
			datastring=JSON.parse(datastring);
			for(i=0;i<datastring.length;i++){
				resultcount.push((datastring[i])['count']);
				dateresult.push((datastring[i])['companyName']);
			}
				
			
		for(j=0;j<resultcount.length;j++){
			var r = getRandomInt(0, 255);
			var g = getRandomInt(0, 255);
			var b = getRandomInt(0, 255);
		
			var object={'values':resultcount[j],'text':dateresult[j],"line-color":"rgb(" + r + "," + g + "," + b + ")","line-width": "3px","shadow": 2, "marker": {"background-color": "#fff","size": 3,"border-width": 1,"border-color": "#38649f", "shadow": 0},"palette": j,"visible": 1};
			zendseries.push(object);
			}

			for(k=0;k<resultcount.length;k++){
				var stringvalue={'data':resultcount[k],'name':dateresult[k]};
			serieslists.push(stringvalue);
			var r = getRandomInt(0, 255);
			var g = getRandomInt(0, 255);
			var b = getRandomInt(0, 255);
			colorarray.push("rgb(" + r + "," + g + "," + b + ")");
				}    
		
		var myConfig = {
			"type": "line",
			"utc": true,
			"plot": {
			"animation": {
				"delay": 500,
				"effect": "ANIMATION_SLIDE_LEFT"
			}
			},
			"plotarea": {
			"margin": "50px 25px 70px 46px"
			},
			"scale-y": {
			"values": "0:40:10",
			"line-color": "none",
			"guide": {
				"line-style": "solid",
				"line-color": "#d2dae2",
				"line-width": "1px",
				"alpha": 0.5
			},
			"tick": {
				"visible": false
			},
			"item": {
				"font-color": "#8391a5",
				"font-family": "Arial",
				"font-size": "10px",
				"padding-right": "5px"
			}
			},
			"scale-x": {
			"line-color": "#d2dae2",
			"line-width": "2px",
			"values": ArrayJour,

			"tick": {
				"line-color": "#d2dae2",
				"line-width": "1px"
			},
			"guide": {
				"visible": false
			},
			"item": {
				"font-color": "#8391a5",
				"font-family": "Arial",
				"font-size": "10px",
				"padding-top": "5px"
			}
			},
			"legend": {
			"layout": "x7",
			"background-color": "none",
			"shadow": 0,
			"margin": "auto auto 15 auto",
			"border-width": 0,
			"item": {
				"font-color": "#707d94",
				"font-family": "Arial",
				"padding": "0px",
				"margin": "0px",
				"font-size": "10px"
			},
			"marker": {
				"show-line": "true",
				"type": "match",
				"font-family": "Arial",
				"font-size": "10px",
				"size": 4,
				"line-width": 2,
				"padding": "3px"
			}
			},
			"crosshair-x": {
			"lineWidth": 1,
			"line-color": "#707d94",
			"plotLabel": {
				"shadow": false,
				"font-color": "#000",
				"font-family": "Arial",
				"font-size": "15px",
				"padding": "5px 10px",
				"border-radius": "5px",
				"alpha": 1
			},
			"scale-label": {
				"font-color": "#ffffff",
				"background-color": "#707d94",
				"font-family": "Arial",
				"font-size": "10px",
				"padding": "5px 10px",
				"border-radius": "5px"
			}
			},
			"tooltip": {
			"visible": true
			},
			"series":zendseries
		};
		zingchart.render({
		id: 'mybar',
		data: myConfig,
		height: 500,
		width: '100%'
		});	
		
			}
		}
	}
	xhr.send();
	}



//  function load data chart  by year ;
function LoadChartByYear(ArrayMois,annee)
{
	var PK_USER=document.getElementById('pk_user').value;

	let xhr = new XMLHttpRequest();
	xhr.open("GET", "https://www.yestravaux.com/webservice/crm/lead.php?fct=CountLeadByCampanyByYear&annee="+annee+"&PK_USER="+PK_USER, true);
	xhr.onload = ()=>{
		if(xhr.readyState === XMLHttpRequest.DONE){
			if(xhr.status === 200){
			var data = xhr.response;  
			datastring=data.substr(data.indexOf('['),data.length);
			resultcount=[];
			colorarray=[];
			zendseries=[];
			dateresult=[];
			datastring=JSON.parse(datastring);
			for(i=0;i<datastring.length;i++){
				resultcount.push((datastring[i])['count']);
				dateresult.push((datastring[i])['companyName']);
            }            
		for(j=0;j<resultcount.length;j++){
			var r = getRandomInt(0, 255);
			var g = getRandomInt(4, 255);
			var b = getRandomInt(5, 255);
			//var randomColor = (Math.random() * 0xfffff * 12521563).toString(16);
		
			var object={'values':resultcount[j],'text':dateresult[j],"line-color":"rgb(" + r + "," + g + "," + b + ")","line-width": "3px","shadow": 2, "marker": {"background-color": "#fff","size": 3,"border-width": 1,"border-color": "#38649f", "shadow": 0},"palette": j,"visible": 1};
			zendseries.push(object);
			}
	
		var myConfig = {
        "type": "line",
		"utc": true,
        "plot": {
			"animation": {
				"delay": 500,
				"effect": "ANIMATION_SLIDE_LEFT"
			}
			},
			"plotarea": {
			"margin": "50px 25px 70px 46px"
			},
			"scale-y": {
			"values": "0:40:10",
			"line-color": "none",
			"guide": {
				"line-style": "solid",
				"line-color": "#d2dae2",
				"line-width": "1px",
				"alpha": 0.5
			},
			"tick": {
				"visible": false
			},
			"item": {
				"font-color": "#8391a5",
				"font-family": "Arial",
				"font-size": "10px",
				"padding-right": "5px"
			}
			},
			"scale-x": {
			"line-color": "#d2dae2",
			"line-width": "2px",
			"values": ArrayMois,

			"tick": {
				"line-color": "#d2dae2",
				"line-width": "1px"
			},
			"guide": {
				"visible": false
			},
			"item": {
				"font-color": "#8391a5",
				"font-family": "Arial",
				"font-size": "10px",
				"padding-top": "5px"
			}
			},
			"legend": {
			"layout": "x7",
			"background-color": "none",
			"shadow": 0,
			"margin": "auto auto 15 auto",
			"border-width": 0,
			"item": {
				"font-color": "#707d94",
				"font-family": "Arial",
				"padding": "0px",
				"margin": "0px",
				"font-size": "10px"
			},
			"marker": {
				"show-line": "true",
				"type": "match",
				"font-family": "Arial",
				"font-size": "10px",
				"size": 4,
				"line-width": 2,
				"padding": "10px"
			}
			},
			"crosshair-x": {
			"lineWidth": 1,
			"line-color": "#707d94",
			"plotLabel": {
				"shadow": false,
				"font-color": "#000",
				"font-family": "Arial",
				"font-size": "15px",
				"padding": "5px 10px",
				"border-radius": "5px",
				"alpha": 1
			},
			"scale-label": {
				"font-color": "#ffffff",
				"background-color": "#707d94",
				"font-family": "Arial",
				"font-size": "10x",
				"padding": "5px 10px",
				"border-radius": "5px"
			}
			},
			"tooltip": {
			"visible": true
			},
			"series":zendseries
		};
		zingchart.render({
		id: 'baryear',
		data: myConfig,
		height: 510,
		width: '100%'
		});	


			

		
				
			}
		}
	}
	xhr.send();
	}

function LoadDataConvertedChart(fctvalue,arraylabels,converted_mois,converted_annee)
        {
			var companylabel=[];
			var countdata=[];
			var datasetResult=[];
			var PK_USER=document.getElementById('pk_user').value;

		
		$.ajax({
		url:"https://www.yestravaux.com/webservice/crm/lead.php",
		method:"POST",
		data:{fct:fctvalue,mois:converted_mois,year:converted_annee,PK_USER:PK_USER},
		dataType:"json",
		success:function(data)
		{

			var div=document.getElementById("fetchChilds2");
			div.innerHTML="";
			var canvas=document.createElement("canvas");
			canvas.id="mybar-chartindex2";
			canvas.height="350px";
			div.appendChild(canvas);
                this.barChart = new Chart(document.getElementById('mybar-chartindex2').getContext("2d"), {
			type: 'bar',
			data: {
			labels:arraylabels,
			},
			options: {
				tooltips: {
					mode:"label"
				},
				scales: {
					yAxes: [{
						beginAtZero: true,
						stacked: true,
						display:true,
						gridLines: {
							color: "rgba(135,135,135,0)",
						},
						ticks: {
							beginAtZero: true,
						    min: 0,
							fontFamily: "Nunito Sans",
							fontColor:"#878787"
						}
					}],
					xAxes: [{
						stacked: true,
						gridLines: {
							color: "rgba(135,135,135,0)",
						},
						ticks: {
							fontFamily: "Nunito Sans",
							fontColor:"#878787",
						}
					}],
					
				},
				elements:{
					point: {
						hitRadius:40
					}
				},
				animation: {
					duration:	3000
				},
				responsive: true,
				legend: {
					display: true,
					position:'bottom',
				},
				
				tooltip: {
					backgroundColor:'rgba(33,33,33,1)',
					cornerRadius:0,
					footerFontFamily:"'Nunito Sans'"
							}
							
						}
			});
            


				data.result.forEach(doc=>{
					var color=(Math.random()*0xFFFFFF<<0).toString(16);

					var object={label:doc.companyName,backgroundColor:"#"+color,borderColor:"#"+color,data:doc.count_converted}
					datasetResult.push(object);
                    this.barChart.data.datasets.push(object);
	
						this.barChart.update();
								});
										
							}
						});

			return true;
		}

$(document).ready(function() {
	$('#invoice-list').DataTable({
                paging:true,
                order: [[0, "desc" ]],
                "language": {
                    "sProcessing": "Traitement en cours ...",
                    "sLengthMenu": "Afficher _MENU_ Leads",
                    "sZeroRecords": "Aucun résultat trouvé",
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




				$('#invoice-list1').DataTable({
                paging:true,
                order: [[0, "desc" ]],
                "language": {
                    "sProcessing": "Traitement en cours ...",
                    "sLengthMenu": "Afficher _MENU_ Tâches ",
                    "sZeroRecords": "Aucun résultat trouvé",
                    "sEmptyTable": "Aucune donnée disponible",
                    "sInfo": "_START_ à _END_ sur _TOTAL_ Tâches ",
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
			$('#invoice-list').DataTable({
			order: [[ 4, "desc" ]]
			})
			$('#invoice-list1').DataTable({
			order: [[ 0, "desc" ]]
			})
	fct="CountLeadByCampanyByMois";
    ArrayJour=[];
	var nbjour=NombreJourMois(new Date().getMonth()+1,new Date().getFullYear());
	var arraydate=[];
	for(let t=1;t<=nbjour;t++){
	ArrayJour.push(t);
	var date=''+new Date().getFullYear()+'-'+new Date().getMonth()+1+'-'+t;
	arraydate.push(date);
	}

	mois=new Date().getMonth()+1;
	if(mois<10){
		mois="0"+mois;
	}

 // function to load chart by month ;
    Loadchart(mois,ArrayJour);

	var PK_USER=document.getElementById('pk_user').value;

	let xhr1 = new XMLHttpRequest();

	xhr1.open("GET", "https://www.yestravaux.com/webservice/crm/lead.php?fct=CountLeadByCampany&PK_USER="+PK_USER, true);
	xhr1.onload = ()=>{
    if(xhr1.readyState === XMLHttpRequest.DONE){
        if(xhr1.status === 200){
        var data1 = xhr1.response;
		datastring1=data1.substr(data1.indexOf('['),data1.length);
			result1count=[];
			resultcampany1=[];
			series=[];
			datastring1=JSON.parse(datastring1);
			for(let k=0;k<datastring1.length;k++){
				result1count.push((datastring1[k])['count']);
				resultcampany1.push((datastring1[k])['companyName']);
			}
							
			

			var optionDonut = {
		chart: {
			type: 'donut',
			width: '475'
		},
		dataLabels: {
			enabled: false,
		},
		plotOptions: {
			pie: {
			donut: {
				size: '45%',
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
		colors:['#ff8f00', '#389f99', '#38649f', '#689f38', '#ee1044','#262626','#5BC0DE','#B388FF','#00B74A','#B388FF','#c0c0c0','#ee5214'],
		
		series: result1count,
		labels: resultcampany1,
		legend: {
			position: 'bottom'
		}
		}

		var donut = new ApexCharts(
		document.querySelector("#myspark"),
		optionDonut
	);
	donut.render();
}
}}
xhr1.send();




//load data chart by the current year...............................................................

	ArrayMois=["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "aoû", "Sep", "Oct", "Nov", "Déc"];

	LoadChartByYear(ArrayMois,new Date().getFullYear());


	// load data chart of threated leads by current day..............................................


		let xhr2 = new XMLHttpRequest();
		var PK_USER=document.getElementById('pk_user').value;

		xhr2.open("GET", "https://www.yestravaux.com/webservice/crm/lead.php?fct=CountLeadByCampanyByDay&PK_USER="+PK_USER, true);
		xhr2.onload = ()=>{
		if(xhr2.readyState === XMLHttpRequest.DONE){
			if(xhr2.status === 200){
			var data2 = xhr2.response;
			datastring2=data2.substr(data2.indexOf('['),data2.length);
			result2count=[];
			resultcampany2=[];
			datastring2=JSON.parse(datastring2);
			for(let k=0;k<datastring2.length;k++){
			result2count.push((datastring2[k])['count']);
							
			resultcampany2.push((datastring2[k])['companyName']);
				}
							

			var optionDonut2 = {
		chart: {
			type: 'donut',
			width: '475'
		},
		dataLabels: {
			enabled: false,
		},
		plotOptions: {
			pie: {
			donut: {
				size: '45%',
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
		colors:['#ff8f00', '#389f99', '#38649f', '#689f38', '#ee1044','#262626','#5BC0DE','#B388FF','#00B74A','#B388FF','#c0c0c0','#00B90B','#ee5214'],
		
		series: result2count,
		labels: resultcampany2,
		legend: {
			position: 'bottom'
		}
		}

		var donut2 = new ApexCharts(
		document.querySelector("#donutday"),
		optionDonut2
	);
	donut2.render();
}
}}
xhr2.send();

	$.ajax({
	url:"https://www.yestravaux.com/webservice/crm/lead.php",
	method:"POST",
	data:{fct:'CountConvertedLeadsToday',PK_USER:PK_USER},
	dataType:"json",
	success:function(data)
	{
		$('#totalconvertedleadsToday').html(data.countconvertedleads);
	}
	});


var elementmonth=document.getElementById('monthName-index2Id');
var elementyear=document.getElementById('yearName-index2Id');
var idx_month=elementmonth.selectedIndex;
var val_month=elementmonth.options[idx_month].value;
var idx_year=elementyear.selectedIndex;
var val_year=elementyear.options[idx_year].value;
$('#month_year').html(elementmonth.options[idx_month].innerHTML + ' ' + val_year)
var ArrayJour_con=[];
			var nbjour=NombreJourMois(Number(val_month),Number(val_year));
			for(let t=1;t<=nbjour;t++){
				ArrayJour_con.push(''+val_year+'-'+val_month +'-'+t);
			}
			
LoadDataConvertedChart('FetchDataConvertedLeadByMonth',ArrayJour_con,val_month,val_year);	
});
// end of document ready

//Load chart data with the selected month.........................................
function LoadCampanyByMonth()
{

var element=document.getElementById('monthName');

var idx=element.selectedIndex;
var val=element.options[idx].value;
element.options[idx].selected='selected';
	
	
	ArrayJour=[];
		var nbjour=NombreJourMois(Number(val),new Date().getFullYear());
		for(let t=1;t<=nbjour;t++){
			ArrayJour.push(t);
		}
		
	Loadchart(val,ArrayJour);
}
// change chart data with the selected year.........................................
function ChangeChartYear()
{
	var Yearelement=document.getElementById('yearName');

	var indice=Yearelement.selectedIndex;
	var yearval=Yearelement.options[indice].value;
	Yearelement.options[indice].selected='selected';

	ArrayMois=["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "aoû", "Sep", "Oct", "Nov", "Déc"];

	LoadChartByYear(ArrayMois,Number(yearval));
}


// load data converted leads by month...............................................
function LoadConvertedLeadsByMonth()
{
var elementmonth=document.getElementById('monthName-index2Id');
var elementyear=document.getElementById('yearName-index2Id');
var idx_month=elementmonth.selectedIndex;
var val_month=elementmonth.options[idx_month].value;
var idx_year=elementyear.selectedIndex;
var val_year=elementyear.options[idx_year].value;
$('#month_year').html(elementmonth.options[idx_month].innerHTML + ' ' + val_year)
var ArrayJour_con=[];
var nbjour=NombreJourMois(Number(val_month),Number(val_year));
	for(let t=1;t<=nbjour;t++){
	ArrayJour_con.push(''+val_year+'-'+val_month +'-'+t);
	}
LoadDataConvertedChart('FetchDataConvertedLeadByMonth',ArrayJour_con,val_month,val_year);

}

//load data converted leads by year..................................................
function LoadConvertedLeadsByYear()
{
var elementmonth=document.getElementById('monthName-index2Id');
var elementyear=document.getElementById('yearName-index2Id');
var idx_month=elementmonth.selectedIndex;
var val_month=elementmonth.options[idx_month].value;
var idx_year=elementyear.selectedIndex;
var val_year=elementyear.options[idx_year].value;
var ArrayJour_con=["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "aoû", "Sep", "Oct", "Nov", "Déc"];
$('#month_year').html(' ' + val_year)

LoadDataConvertedChart('FetchDataConvertedLeadByYear',ArrayJour_con,'',val_year);
	
}
</script>	
	
	
	
