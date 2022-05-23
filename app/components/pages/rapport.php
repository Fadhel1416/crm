<?php

session_start();
include_once "config.inc.php";
include_once "commun.inc.php";
date_default_timezone_set('Europe/Paris');

if(!isset($_SESSION["PK_USER"])){

	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";

}



$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
$POSTVALUE  = 'fct=LoadTicketStatus&user_id='.$_SESSION['PK_USER'];
$ticket=curl_do_post($URL,$POSTVALUE);
$ticket=json_decode($ticket);

$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
$POSTVALUE  = 'fct=LoadTicketClient&user_id='.$_SESSION['PK_USER'];
$Result=curl_do_post($URL,$POSTVALUE);
$Result=json_decode($Result);
$Result=(array) $Result;

$stringvalue='';
foreach($Result["result"] as $row)
{
	$stringvalue.=$row->nbTic.',';
}
$stringvalue=substr($stringvalue,0,strlen($stringvalue)-1);//pour eliminer le derniere virugel.....




?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<div class="container-full">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="d-flex align-items-center">
            <div class="me-auto">
					<h4 class="page-title">Rapports</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item active" aria-current="page">Rapports</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>	  

		<!-- Main content -->
		<section class="content">

			<div class="col-12">
				<div class="box">
				<!-- /.box-header -->
						<?php
				//function for fetching dates for this week.......	
		     	function get_lundi_dimanche_from_week($week,$year,$format="d-m-Y") {

				$firstDayInYear=date("N",mktime(0,0,0,1,1,$year));
				if ($firstDayInYear<6)
				$shift=-($firstDayInYear-1)*86400;
				else
				$shift=(8-$firstDayInYear)*86400;
				if ($week>1) $weekInSeconds=($week-1)*604800; else $weekInSeconds=0;
				$timestamp=mktime(0,0,0,1,1,$year)+$weekInSeconds+$shift;
				$timestamp_dimanche=mktime(0,0,0,1,8,$year)+$weekInSeconds+$shift;
				
				return array(date("d M Y",$timestamp),date("d M Y",$timestamp_dimanche));
				
				}
				//function for fetching dates for last week.......	

				function getlast_lundi_dimanche_from_week($week,$year,$format="d-m-Y") {

				$firstDayInYear=date("N",mktime(0,0,0,1,1,$year));
				if ($firstDayInYear<7)
				$shift=-($firstDayInYear-1)*86400;
				else
				$shift=(8-$firstDayInYear)*86400;
				if ($week>1) $weekInSeconds=($week-1)*604800; else $weekInSeconds=0;
				$timestamp=mktime(0,0,0,1,1,$year)+$weekInSeconds+$shift;
				$timestamp_dimanche=mktime(0,0,0,1,7,$year)+$weekInSeconds+$shift;
				
				return array(date("d M Y",$timestamp),date("d M Y",$timestamp_dimanche));
				
				}
				$nbjour=cal_days_in_month(CAL_GREGORIAN,date('m'),date('y'));// function to get numbers days from month and year params
				$lastnbjour=cal_days_in_month(CAL_GREGORIAN,date("m", strtotime("-1 month")),date('y'));
				$annee_firstnbjour=cal_days_in_month(CAL_GREGORIAN,'01',date('y'));
				$annee_lastnbjour=cal_days_in_month(CAL_GREGORIAN,'12',date('y'));
				$date1="01-01-".date('y');
				$date2=$annee_lastnbjour."-12-".date('Y');
				$lastdate1="01-01-".date("Y", strtotime("-1 year"));
				$lastdate2=$annee_lastnbjour."-12-".date("Y", strtotime("-1 year"));
		

				$this_month='01'.' '. date('M').' '. date('Y') . ' - ' . $nbjour. ' '.date('M').' '.date('Y');
				if(date('m')=="03")
				{
					$last_month='01'.' '.'Feb'.' '.date('Y') . ' - ' . $lastnbjour.' '.'Feb'.' '.date('Y');

				}
				else{
					$last_month='01'.' '. date("M", strtotime("-1 month")).' '. date('Y') . ' - ' . $lastnbjour. ' '.date("M", strtotime("-1 month")).' '.date('Y');

				}
				$this_year='01'.' '. date("M", strtotime($date1)).' '. date('Y') . ' - ' . $annee_lastnbjour. ' '.date("M", strtotime($date2)).' '.date('Y');
				$last_year='01'.' '. date("M", strtotime($lastdate1)).' '.date("Y", strtotime("-1 year")) . ' - ' . $annee_lastnbjour. ' '.date("M", strtotime($lastdate2)).' '.date("Y", strtotime("-1 year"));

				$debut_fin_semaine = get_lundi_dimanche_from_week(date('W'), date('Y'));
				$last_semaine = getlast_lundi_dimanche_from_week(date('W'), date('Y'));
				$LastThreeMonth=[];
				$LastSixMonth=[];
				for ($i = -3; $i <0; $i++){
					$k=$i+1;
					if(date('m', strtotime("$i month"))== date('m', strtotime("$k month"))){
						array_push($LastThreeMonth,date('d M Y', strtotime("February 1")));

					}
					else{
						array_push($LastThreeMonth,date('d M Y', strtotime("$i month")));

					}
				  }
				  for ($i = -6; $i <0; $i++){
					$k=$i+1;
					if(date('m', strtotime("$i month"))== date('m', strtotime("$k month"))){
						array_push($LastSixMonth,date('d M Y', strtotime("February 1")));

					}

					else{array_push($LastSixMonth,date('d M Y', strtotime("$i month")));}
				  }
				?>
					<!-- Nav tabs -->
                    <div class="nav-tabs-custom" >
					<ul class="nav nav-tabs mb-0">
						<li class="nav-tabs-li"> <a href="#navpills-1" class="waves-effect waves-light  text-info  btn-flat mb-5 " data-bs-toggle="tab" aria-expanded="false">Aperçu</a> </li>
						<li class="nav-tabs-li"> <a href="#navpills-2" class="waves-effect waves-light  text-info btn-flat mb-5 active" data-bs-toggle="tab" aria-expanded="false">Companie</a> </li>
						<li class="nav-tabs-li"> <a href="#navpills-4" class="waves-effect waves-light  text-info btn-flat mb-5 " data-bs-toggle="tab" aria-expanded="false">Tâches </a> </li>

						<li class="nav-tabs-li"> <a href="#navpills-3" class="waves-effect waves-light  text-info btn-flat mb-5 " data-bs-toggle="tab" aria-expanded="false">Tickets</a> </li>

                  <div class="pull-right padding800">
      
                  <div class="dropdown">
									<button id="btnidlink" class="btn  border-warning dropdown-toggle mybtn-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width:270px"><?php echo $debut_fin_semaine[0] ." - " .$debut_fin_semaine [1];?></button>
									
									
									<div class="dropdown-menu border-warning mydropdown-menu" x-placement="bottom-start" id="dropmenuID" style="width:280px">		
									<a class="dropdown-item flexbox" id="thisweekid" href="#">
										<span class="spanchart"><b>Cette semaine</b></span>
										<span class="text-fade spanchart-content"><?php echo $debut_fin_semaine[0] ." - " .$debut_fin_semaine [1];?></span>
									  </a>
                                     <a class="dropdown-item flexbox" href="#" id="lastweekid">
										<span class="spanchart"><b>La semaine dernière</b></span>
										<span class="text-fade spanchart-content"><?php echo $last_semaine[0] ." - " .$last_semaine[1];?></span>
									  </a>
									  <a class="dropdown-item flexbox" href="#" id="thismonthid">
										<span class="spanchart"><b>Ce mois-ci</b></span>
										<span class="text-fade spanchart-content"><?php echo $this_month ;?></span>
									  </a>
                                    <a class="dropdown-item flexbox" href="#" id="lastmonthid">
										<span class="spanchart"><b>Le mois dernier</b></span>
										<span class="text-fade spanchart-content"><?php echo $last_month ;?></span>
									  </a>
									  <a class="dropdown-item flexbox" href="#" id="last3monthid">
										<span class="spanchart"><b>Les 3 derniers mois</b></span>
										<span class="text-fade spanchart-content"><?php echo $LastThreeMonth[0].'-'. $LastThreeMonth[2];?></span>
									  </a>
									  <a class="dropdown-item flexbox" href="#" id="last6monthid">
										<span class="spanchart"><b>Les 6 derniers mois</b></span>
										<span class="text-fade spanchart-content"><?php echo $LastSixMonth[0].'-'. $LastSixMonth[5];?></span>
									  </a>
								    <a class="dropdown-item flexbox" href="#" id="thisyearid">
										<span class="spanchart"><b>Cette année</b></span>
										<span class="text-fade spanchart-content"><?php echo $this_year ;?></span>
									  </a>
                                     <a class="dropdown-item flexbox" href="#" id="lastyearid">
										<span class="spanchart"><b>L'année dernière</b></span>
										<span class="text-fade spanchart-content"><?php echo $last_year ;?></span>
									  </a>
									  
									</div>
								
							</div>			
	                    	</div>
        
                      </ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div id="navpills-1" class="tab-pane ">
							
						</div>
						<div id="navpills-2" class="tab-pane active">
							<div class="row">
							<?php 
                                   $year=date('Y');
								   $startyear=intval('2021');
								  
								   $arrayyear=[];
								   for($i=$startyear+1;$i<=intval($year);$i++){
									   array_push($arrayyear,$i);
								   }

                                    ?>
					   <div class="col-lg-10 col-md-8">
					    <div class="box">
						<div class="box-body">
							<h4 class="box-title" id="titleid">Companie leads convertie cette semaine</h4>
                             <div class="pull-right">
								 <form>
								 <select id="monthNameId" class="custom-select badge-dark " onChange="LoadCampanyConvertedLeadByMonth();">
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
							     <select id="yearNameId" class="custom-select badge-dark" onChange="ChangeLeadConvertedChartYear();">
								<option value="2021" <?php if(date('Y')=="2021") echo "selected";?> >2021</option>
								<?php for($i=0;$i<count($arrayyear);$i++) { ?>
									<option value="<?php echo $arrayyear[$i];?>" <?php if(date('Y')==$arrayyear[$i]) echo "selected";?> ><?php echo $arrayyear[$i];?></option>
									<?php }?>
				     	         </select>

							</form>

							 </div>
							<div id="fetchChilds">
								<!--canvas id="barCan" height="120"></canvas-->
							</div>
						</div>
					</div>
				
		         	</div>
				<div class="col-lg-2 col-md-4">
				<div class="box">
					<div class="box-header with-border">

						<h5 class="box-title" id="titleconvertedleads"></h5>
           
					</div>
					<div class="box-body p-0">
					  <div class="media-list media-list-hover bg-lightest" id="barConverted">
                      <!--a class="media media-single bg-lightest" href="index.php?page=lead&id='.$leadid.'"">
                    <div class="media-body ps-15 bs-4 rounded border-dark">
                    <p class="text-bold">Hosteur</p>
                    <span class="text-success" style="font-size:9px;">alifadhel619@gmail.com</span><br>
                    <span style="font-size:8px;"class="text-info"><i class="fa fa-calendar"></i>24/10/1996 10:20:30</span>

                    </div>
                    </a-->

					  </div>
					</div>
		  <!-- /.row -->
                </div></div></div></div>
                <div id="navpills-3" class="tab-pane ">
				<div class="col-lg-10 col-md-8">
					    <div class="box">
						<div class="box-body">
							<h4 class="box-title" id="Ticket_id"> </h4>
                             <div class="pull-right">
								  <form>
							     <select id="Ticket_ChartMonthId" class="custom-select badge-dark" onChange="ChangeTicketCountMonth();">
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
								  <select id="Ticket_ChartYearId" class="custom-select badge-dark" onChange="ChangeTicketCountYear();">
								<option value="2021" <?php if(date('Y')=="2021") echo "selected";?> >2021</option>
								<?php for($i=0;$i<count($arrayyear);$i++) { ?>
									<option value="<?php echo $arrayyear[$i];?>" <?php if(date('Y')==$arrayyear[$i]) echo "selected";?> ><?php echo $arrayyear[$i];?></option>
									<?php }?>
				     	         </select>

							</form> 

							 </div>
							 <br>
							 <table class="table table-hover no-wrap" border="1" style="border-color:coral">
								 <tr>
									 <td>Résolue <br><i class="fa fa-fw fa-thumbs-up"></i><b><span id="nb_resolved" style="padding-left:3px"></span></b></td>
									 <td>Nouveau<br><i class="mdi mdi-ticket-account"></i> <b><span id="nb_new" style="padding-left:3px"></span></b></td>
									 <td>Ouvrir<br><i class="mdi mdi-ticket-confirmation fs-15"></i><b><span id="nb_opened" style="padding-left:3px"></span></b></td>
									 <td>En attente<br><span class="mdi mdi-ticket"></span><b><span id="nb_pending" style="padding-left:3px;"></span></b></td>
									 <td>A reçu<br><b><span id="nb_received"></span></b></td>
								 </tr>
								 </table>
								 
						<div class="col-xl-12">
					<div class="box">
						
						<div class="box-body">
							<div class="row">
								
								<div class="col-8">
									<div id="charts_widget_2_chart"></div>
								</div>


								<div class="col-4">
					<div class="box">
						<div class="box-body">
						<ul class="flexbox flex-justified align-items-center">
					  <li class="text-end">
						<div class="fs-20 text-success"><span id="resolved"></span></div>
						<small class="text-uppercase">Résolue</small>
					  </li>

					  <li class="text-center px-2">
						<div class="easypie" data-percent="53">
						  <span class="percent"></span>
						<canvas height="110" width="110"></canvas></div>

					  </li>

					  <li class="text-start">
						<div class="fs-20 text-warning"><span id="unresolved"></span></div>
						<small class="text-uppercase">Non résolu</small>
					  </li>

					  
					</ul>
					<ul class="flexbox flex-justified align-items-center">
					  <li class="text-end">
						<div class="fs-20 text-success"><span id="received"></span></div>
						<small class="text-uppercase">A reçu</small>
					  </li>

					  <li class="text-center px-2">
						<div class="easypie" data-percent="55">
						  <span class="percent">53</span>
						</div>

					  </li>

					  <li class="text-start">
						<div class="fs-20 text-primary"><span id="total"></span></div>
						<small class="text-uppercase">Totals</small>
					  </li>

					  
					</ul>
						
						</div>
					</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				
			

						</div>
				<div class="row">
							<?php 
                                   $year=date('Y');
								   $startyear=intval('2021');
								  
								   $arrayyear=[];
								   for($i=$startyear+1;$i<=intval($year);$i++){
									   array_push($arrayyear,$i);
								   }

                                    ?>
					   <div class="col-lg-12 col-md-8">
					    <div class="box">
						<div class="box-body">
							<h4 class="box-title" id="title3id">Liste des tickets résolus cette semaine</h4>
                             <div class="pull-right">
								 <form>
								 <select id="monthNameTicketId" class="custom-select badge-dark" onChange="LoadTicketByMonth();">
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
							     <select id="yearNameTicketId" class="custom-select badge-dark" onChange="ChangeTicketChartYear();">
								<option value="2021" <?php if(date('Y')=="2021") echo "selected";?> >2021</option>
								<?php for($i=0;$i<count($arrayyear);$i++) { ?>
									<option value="<?php echo $arrayyear[$i];?>" <?php if(date('Y')==$arrayyear[$i]) echo "selected";?> ><?php echo $arrayyear[$i];?></option>
									<?php }?>
				     	         </select>

							</form>

							 </div>
							<div id="fetchChildsTicket">
								<!--canvas id="barCan" height="120"></canvas-->
							</div>
						</div>
					</div>
				
		         	</div>
                </div>
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12">
				  <div class="box">
					  <div class="box-header with-border">
						<h5 class="box-title">Statut des tickets </h5>
						
					  </div>

					  <div class="box-body">
						<div class="text-center pb-25"> 
						<div class="donut" data-peity='{ "fill": ["#fc4b6c", "#ffb22b","#8a2be2", "#398bf7"], "radius": 86, "innerRadius": 50  }' ><?php echo $ticket->new.",".$ticket->pending.",".$ticket->opened.",".$ticket->solved;?></div>

						</div>

						<ul class="list-inline" id="list-inline">
						<li class="flexbox mb-5">
							<div>
							  <span class="badge badge-dot badge-lg me-1" style="background-color: #fc4b6c"></span>
							  <span>Nouveau</span>
							</div>
							<div><span class="badge badge-danger"><?php echo $ticket->new;?></span></div>
						  </li>
						
						  <li class="flexbox mb-5">
							<div>
							  <span class="badge badge-dot badge-lg me-1" style="background-color: #ffb22b"></span>
							  <span>En attente</span>
							</div>
							<div><span class="badge" style="background-color: #ffb22b"><?php echo $ticket->pending;?></span></div>
						  </li>
						  
						  <li class="flexbox mb-5">
							<div>
							  <span class="badge badge-dot badge-lg me-1" style="background-color: #8a2be2"></span>
							  <span>Ouverte</span>
							</div>
							<div><span class="badge" style="background-color: #8a2be2"><?php echo $ticket->opened;?></span></div>
						  </li>

						  <li class="flexbox mb-5">
							<div>
							  <span class="badge badge-dot badge-lg me-1" style="background-color: #398bf7"></span>
							  <span>Résolue</span>
							</div>
							<div><span class="badge" style="background-color:#398bf7"><?php echo $ticket->solved;?></span></div>
						  </li>
						
						</ul>
					  </div>
					</div>
			  </div>
			  <div class="col-lg-6 col-md-6 col-sm-12">
				  <div class="box">
					  <div class="box-header with-border">
						<h5 class="box-title">Tickets partagés par clients</h5>
					
					  </div>

					  
					  <div class="box-body">
						<div class="flexbox mt-10">
							<div class="bar" data-peity='{ "fill":["#FF4961", "#FF9149","#8a2be2", "#462be2","#c49e36","#c0c0c0","#2be23a","#2f8049", "#FF3061", "#689f38","#650f38", "#FF4961", "#2f8049"], "height": 268, "width": 120, "padding":0.2 }'><?php echo $stringvalue;?></div>
						  <ul class="list-inline align-self-end text-muted text-end mb-1" id="ListClient">
						
						  </ul>
						</div>

					  </div>
				  </div>
			  </div>
			  <div class="col-lg-12 col-md-8">
					    <div class="box">
						<div class="box-body">
							<h4 class="box-title" id="title3id">Messages de tickets entrants et sortants par mois</h4>
                             <div class="pull-right">
								 <form>
								 <select id="messageTicketMonthId" class="custom-select badge-dark" onChange="LoadMessageTicketByMonth();">
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
							   

							</form>

							 </div>
							<div id="fetchChilds_MessageTicket">
								<!--canvas id="barCan" height="120"></canvas-->
							</div>
						</div>
					</div>
				
		         	</div>
					 <div class="col-lg-12 col-md-8">
					    <div class="box">
						<div class="box-body">
							<h4 class="box-title" id="title3id">Messages de tickets entrants et sortants par année</h4>
                             <div class="pull-right">
								 <form>
							     <select id="messageTicketYearId" class="custom-select badge-dark" onChange="ChangeMessageTicketChartYear();">
								<option value="2021" <?php if(date('Y')=="2021") echo "selected";?> >2021</option>
								<?php for($i=0;$i<count($arrayyear);$i++) { ?>
									<option value="<?php echo $arrayyear[$i];?>" <?php if(date('Y')==$arrayyear[$i]) echo "selected";?> ><?php echo $arrayyear[$i];?></option>
									<?php }?>
				     	         </select>

							</form>

							 </div>
							<div id="fetchChilds_MessageTicketYear">
								<!--canvas id="barCan" height="120"></canvas-->
							</div>
						</div>
					</div>
				
		         	</div>

		
						
					</div>
				
		         	</div>
                </div>
							  <!--fin ticket user list-->

			 </div>
                <div id="navpills-4" class="tab-pane">
               
				<div class="row">
							<?php 
                                   $year=date('Y');
								   $startyear=intval('2021');
								  
								   $arrayyear=[];
								   for($i=$startyear+1;$i<=intval($year);$i++){
									   array_push($arrayyear,$i);
								   }

                                    ?>
					   <div class="col-lg-10 col-md-8">
					    <div class="box">
						<div class="box-body">
							<h4 class="box-title" id="title2id">Listes des tâches de cette semaine</h4>
                             <div class="pull-right">
								 <form>
								 <select id="monthNameTaskId" class="custom-select badge-dark" onChange="LoadCampanyTaskByMonth();">
									<option value="01" <?php if(date('m')=="01") echo "selected";?> >Janvier</option>
									<option value="02" <?php if(date('m')=="02") echo "selected";?> >Février</option>
									<option value="03" <?php if(date('m')=="03") echo "selected";?>>Mars</option>
									<option value="04" <?php if(date('m')=="04") echo "selected";?>>Avril</option>
									<option value="05" <?php if(date('m')=="05") echo "selected";?>>Mai</option>
									<option value="06" <?php if(date('m')=="06") echo "selected";?>>Juin</option>
									<option value="07" <?php if(date('m')=="07") echo "selected";?>>juillet</option>
									<option value="08" <?php if(date('m')=="08") echo "selected";?>>Août</option>
									<option value="09" <?php if(date('m')=="09") echo "selected";?>>Septembre</option>
									<option value="10" <?php if(date('m')=="10") echo "selected";?>>Octobre</option>
									<option value="11" <?php if(date('m')=="11") echo "selected";?>>Novembre</option>
									<option value="12" <?php if(date('m')=="12") echo "selected";?>>Décembre</option>
				     	         </select>
							     <select id="yearNameTaskId" class="custom-select badge-dark" onChange="ChangeTaskChartYear();">
								<option value="2021" <?php if(date('Y')=="2021") echo "selected";?> >2021</option>
								<?php for($i=0;$i<count($arrayyear);$i++) { ?>
									<option value="<?php echo $arrayyear[$i];?>" <?php if(date('Y')==$arrayyear[$i]) echo "selected";?> ><?php echo $arrayyear[$i];?></option>
									<?php }?>
				     	         </select>

							</form>

							 </div>
							<div id="fetchChildsTask">
								<!--canvas id="barCan" height="120"></canvas-->
							</div>
						</div>
					</div>
				
		         	</div>
                </div>
                
            <form action="#">
				<input type="hidden" id="pk_userRapport" value="<?php echo $_SESSION['PK_USER'];?>">
			</form>

		

		</section>
		<!-- /.content -->
	  </div>


	<!-- CrmX Admin App -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


      <script>
         function getRandomInt(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
		}
		function NombreJourMois(iMonth, iYear)
		{
			target = new Date(iYear, iMonth, 0);
		nbJour = target.getDate();
		return nbJour;
		}


        function LoadDataChart(fctvalue,arraylabels)
        {
			var companylabel=[];
			var countdata=[];
			var datasetResult=[];
			var PK_USER=document.getElementById('pk_userRapport').value;

            $.ajax({
            url:"https://www.yestravaux.com/webservice/crm/lead.php",
            method:"POST",
            data:{fct:fctvalue,PK_USER:PK_USER},
            dataType:"json",
            success:function(data)
            {


				var div=document.getElementById("fetchChilds");
			   div.innerHTML="";
			   var canvas=document.createElement("canvas");
			   canvas.id="mybar-chart2";
			   canvas.style.height="120";
			   div.appendChild(canvas);
			   $('#barConverted').html(data.outputconverted);
                this.barChart = new Chart(document.getElementById('mybar-chart2').getContext("2d"), {
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
							fontColor:"#878787"
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
					var color=(Math.random()*0xFFFFFF<<0).toString(16);// generate a random color ;

					var object={label:doc.companyName,backgroundColor:"#"+color,borderColor:"#"+color,data:doc.count_converted}
					datasetResult.push(object);
                    this.barChart.data.datasets.push(object);
 
					this.barChart.update();
							});
									
						}
					});


	}
	function LoadChartTaskBy_Month_Year(ArrayJour,val_month,val_year,fctvalue)
	{
		    var companylabel=[];
			var countdata=[];
			var datasetResult=[];
			var PK_USER=document.getElementById('pk_userRapport').value;

            $.ajax({
            url:"https://www.yestravaux.com/webservice/crm/lead.php",
            method:"POST",
            data:{fct:fctvalue,mois:val_month,year:val_year,PK_USER:PK_USER},
            dataType:"json",
            success:function(data)
            {

			   var div=document.getElementById("fetchChildsTask");
			   div.innerHTML="";
			   var canvas=document.createElement("canvas");
			   canvas.id="mybar-chart3";
			   canvas.style.height="120";
			   div.appendChild(canvas);
               this.barChart = new Chart(document.getElementById('mybar-chart3').getContext("2d"), {
			type: 'bar',
			data: {
			labels:ArrayJour,
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
							fontColor:"#878787"
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
			var object={label:doc.companyName,backgroundColor:"#"+color,borderColor:"#"+color,data:doc.count_task}
			datasetResult.push(object);
			this.barChart.data.datasets.push(object);

			this.barChart.update();
					});
							
				}
			});
	}
	function LoadChartTicketBy_Month_Year(ArrayJour,val_month,val_year,fctvalue)
	{
		    var companylabel=[];
			var countdata=[];
			var datasetResult=[];
			var PK_USER=document.getElementById('pk_userRapport').value;

            $.ajax({
            url:"https://www.yestravaux.com/webservice/crm/campaign.php",
            method:"POST",
            data:{fct:fctvalue,mois:val_month,year:val_year,PK_USER:PK_USER},
            dataType:"json",
            success:function(data)
            {

			   var div=document.getElementById("fetchChildsTicket");
			   div.innerHTML="";
			   var canvas=document.createElement("canvas");
			   canvas.id="mybar-chart4";
			   canvas.style.height="120";
			   div.appendChild(canvas);
               this.barChart = new Chart(document.getElementById('mybar-chart4').getContext("2d"), {
			type: 'bar',
			data: {
			labels:ArrayJour,
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
							fontColor:"#878787"
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
				var object={label:doc.ticketRef,backgroundColor:"#"+color,borderColor:"#"+color,data:doc.count_ticket}
				datasetResult.push(object);
				this.barChart.data.datasets.push(object);

				this.barChart.update();
						});
								
					}
				});
	}
	function LoadChartBy_Month_Year(ArrayJour,val_month,val_year,fctvalue)
	{
		    var companylabel=[];
			var countdata=[];
			var datasetResult=[];
			var PK_USER=document.getElementById('pk_userRapport').value;

            $.ajax({
            url:"https://www.yestravaux.com/webservice/crm/lead.php",
            method:"POST",
            data:{fct:fctvalue,mois:val_month,year:val_year,PK_USER:PK_USER},
            dataType:"json",
            success:function(data)
            {
				$('#barConverted').html(data.outputconverted);

			   var div=document.getElementById("fetchChilds");
			   div.innerHTML="";
			   var canvas=document.createElement("canvas");
			   canvas.id="mybar-chart2";
			   canvas.style.height="120";
			   div.appendChild(canvas);
               this.barChart = new Chart(document.getElementById('mybar-chart2').getContext("2d"), {
			type: 'bar',
			data: {
			labels:ArrayJour,
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
							fontColor:"#878787"
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
	}
	function LoadDataTaskChart(fctvalue,arraylabels)
        {
			var companylabel=[];
			var countdata=[];
			var datasetResult=[];
			var PK_USER=document.getElementById('pk_userRapport').value;

            $.ajax({
            url:"https://www.yestravaux.com/webservice/crm/lead.php",
            method:"POST",
            data:{fct:fctvalue,PK_USER:PK_USER},
            dataType:"json",
            success:function(data)
            {


				var div=document.getElementById("fetchChildsTask");
			   div.innerHTML="";
			   var canvas=document.createElement("canvas");
			   canvas.id="mybar-chart3";
			   canvas.style.height="120";
			   div.appendChild(canvas);
                this.barChart = new Chart(document.getElementById('mybar-chart3').getContext("2d"), {
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
							fontColor:"#878787"
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
            

                    //call arow functions for fetching label and count data ..................
				   data.result.forEach(doc=>{
					var color=(Math.random()*0xFFFFFF<<0).toString(16);//geenerate a random color for the selected data ......

					var object={label:doc.companyName,backgroundColor:"#"+color,borderColor:"#"+color,data:doc.count_task}
					datasetResult.push(object);
                    this.barChart.data.datasets.push(object);
 
					this.barChart.update();
							});				
						}
					});


	}
	function LoadDataTicketChart(fctvalue,arraylabels)
        {
			var companylabel=[];
			var countdata=[];
			var datasetResult=[];
			var PK_USER=document.getElementById('pk_userRapport').value;

            $.ajax({
            url:"https://www.yestravaux.com/webservice/crm/campaign.php",
            method:"POST",
            data:{fct:fctvalue,PK_USER:PK_USER},
            dataType:"json",
            success:function(data)
            {


				var div=document.getElementById("fetchChildsTicket");
			   div.innerHTML="";
			   var canvas=document.createElement("canvas");
			   canvas.id="mybar-chart4";
			   canvas.style.height="120";
			   div.appendChild(canvas);
                this.barChart = new Chart(document.getElementById('mybar-chart4').getContext("2d"), {
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
							fontColor:"#878787"
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
            

                    //call arow functions for fetching label and count data ..................
				   data.result.forEach(doc=>{
					var color=(Math.random()*0xFFFFFF<<0).toString(16);//geenerate a random color for the selected data ......

					var object={label:doc.ticketRef,backgroundColor:"#"+color,borderColor:"#"+color,data:doc.count_ticket}
					datasetResult.push(object);
                    this.barChart.data.datasets.push(object);
 
					this.barChart.update();
							});				
						}
					});


	}
	function FetchMessageDataChartTicketByYear(arraymonth,fctvalue,year)
		{
			var companylabel=[];
			var countdata=[];
			var datasetResult=[];
			var PK_USER=document.getElementById('pk_userRapport').value;
		

            $.ajax({
            url:"https://www.yestravaux.com/webservice/crm/lead.php",
            method:"POST",
            data:{fct:fctvalue,PK_USER:PK_USER,year:year},
            dataType:"json",
            success:function(data)
            {
				console.log(data);
				// console.log(typeof(data));
				// data=JSON.parse(data);
				// console.log(data)
				// console.log(typeof(data));

				var div=document.getElementById("fetchChilds_MessageTicketYear");
				div.innerHTML="";
				var canvas=document.createElement("canvas");
				canvas.id="mybar-chart6";
				canvas.style.height="120";
				div.appendChild(canvas);
					this.barChart = new Chart(document.getElementById('mybar-chart6').getContext("2d"), {
				type: 'bar',
				data: {
				labels: arraymonth,
				datasets: [{
				label: 'Messages entrants',
				data: data[0].incoming_message,
				backgroundColor: '#689f38',
				},{
				label: 'Messages sortants',
				data: data[0].outgoing_message,
				backgroundColor: '#462be2',
				},
			]
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
							fontColor:"#878787"
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
            
			this.barChart.update();

                    //call arow functions for fetching label and count data ..................
				   /*data.result.forEach(doc=>{
					var color=(Math.random()*0xFFFFFF<<0).toString(16);//geenerate a random color for the selected data ......

					var object={label:doc.companyName,backgroundColor:"#"+color,borderColor:"#"+color,data:doc.count_message}
					datasetResult.push(object);
                    this.barChart.data.datasets.push(object);
 
					this.barChart.update();
							});	*/			
						}
					});

		}
	function FetchMessageDataChartTicket(arrayjour,fctvalue,mois)
		{
			var companylabel=[];
			var countdata=[];
			var datasetResult=[];
			var PK_USER=document.getElementById('pk_userRapport').value;
		

            $.ajax({
            url:"https://www.yestravaux.com/webservice/crm/lead.php",
            method:"POST",
            data:{fct:fctvalue,PK_USER:PK_USER,mois:mois},
            dataType:"json",
            success:function(data)
            {
				var div=document.getElementById("fetchChilds_MessageTicket");
			   div.innerHTML="";
			   var canvas=document.createElement("canvas");
			   canvas.id="mybar-chart5";
			   canvas.style.height="120";
			   div.appendChild(canvas);
					this.barChart = new Chart(document.getElementById('mybar-chart5').getContext("2d"), {
				type: 'bar',
				data: {
					labels: arrayjour,
				datasets: [{
				label: 'Messages entrants',
				data: data[0].incoming_message,
				backgroundColor: '#FF9149',
				},{
				label: 'Message sortants',
				data: data[0].outgoing_message,
				backgroundColor: '#462be2',
				},
		]
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
								fontColor:"#878787"
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
            
			      this.barChart.update();

                    //call arow functions for fetching label and count data ..................
				   /*data.result.forEach(doc=>{
					var color=(Math.random()*0xFFFFFF<<0).toString(16);//geenerate a random color for the selected data ......

					var object={label:doc.companyName,backgroundColor:"#"+color,borderColor:"#"+color,data:doc.count_message}
					datasetResult.push(object);
                    this.barChart.data.datasets.push(object);
 
					this.barChart.update();
							});	*/			
						}
					});

		}
	    // load data converted leads selected month......................

		function LoadCampanyConvertedLeadByMonth()
		{
			var elementmonth=document.getElementById('monthNameId');
			var elementyear=document.getElementById('yearNameId');
			var idx_month=elementmonth.selectedIndex;
			var val_month=elementmonth.options[idx_month].value;
			var idx_year=elementyear.selectedIndex;
			var val_year=elementyear.options[idx_year].value;
			ArrayJour=[];
			var nbjour=NombreJourMois(Number(val_month),Number(val_year));
			for(let t=1;t<=nbjour;t++){
				ArrayJour.push(''+val_year+'-'+val_month+'-'+t);
			}
		

			$('#titleid').html('Companie Leads convertis en ' + elementmonth.options[idx_month].innerHTML + ' ' + val_year);
			$('#titleconvertedleads').html('Companie Leads convertis en  '+ elementmonth.options[idx_month].innerHTML+ ' '+ val_year );
			LoadChartBy_Month_Year(ArrayJour,val_month,val_year,'FetchDataConvertedLeadByMonth');
		}
		function LoadCampanyTaskByMonth()
		{
			var elementmonth=document.getElementById('monthNameTaskId');
			var elementyear=document.getElementById('yearNameTaskId');
			var idx_month=elementmonth.selectedIndex;
			var val_month=elementmonth.options[idx_month].value;
			var idx_year=elementyear.selectedIndex;
			var val_year=elementyear.options[idx_year].value;
			ArrayJour=[];
			var nbjour=NombreJourMois(Number(val_month),Number(val_year));
			for(let t=1;t<=nbjour;t++){
				ArrayJour.push(''+val_year+'-'+val_month+'-'+t);
			}
			$('#title2id').html('Listes des tâches en ' + elementmonth.options[idx_month].innerHTML + ' ' + val_year);
			LoadChartTaskBy_Month_Year(ArrayJour,val_month,val_year,'FetchDataTaskByMonth');


		}
		function LoadTicketByMonth()
		{
			var elementmonth=document.getElementById('monthNameTicketId');
			var elementyear=document.getElementById('yearNameTicketId');
			var idx_month=elementmonth.selectedIndex;
			var val_month=elementmonth.options[idx_month].value;
			var idx_year=elementyear.selectedIndex;
			var val_year=elementyear.options[idx_year].value;
			ArrayJour=[];
			var nbjour=NombreJourMois(Number(val_month),Number(val_year));
			for(let t=1;t<=nbjour;t++){
				ArrayJour.push(''+val_year+'-'+val_month+'-'+t);
			}
			$('#title3id').html('Listes des tickets résolus en ' + elementmonth.options[idx_month].innerHTML + ' ' + val_year);
			LoadChartTicketBy_Month_Year(ArrayJour,val_month,val_year,'FetchDataTicketByMonth');

		}

        // load data converted leads by selected year......................
		function ChangeLeadConvertedChartYear()
		{
			
			var elementmonth=document.getElementById('monthNameId');
			var elementyear=document.getElementById('yearNameId');
			var idx_month=elementmonth.selectedIndex;
			var val_month=elementmonth.options[idx_month].value;
			var idx_year=elementyear.selectedIndex;
			var val_year=elementyear.options[idx_year].value;
			var ArrayMois=["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "aoû", "Sep", "Oct", "Nov", "Déc"];

			$('#titleid').html('Companie Leads convertis en année '+ elementyear.options[idx_year].innerHTML);
			$('#titleconvertedleads').html('Companie Leads convertis en année '+ elementyear.options[idx_year].innerHTML);

			LoadChartBy_Month_Year(ArrayMois,val_month,val_year,'FetchDataConvertedLeadByYear');

		}
		function ChangeTaskChartYear()
		{
			var elementmonth=document.getElementById('monthNameTaskId');
			var elementyear=document.getElementById('yearNameTaskId');
			var idx_month=elementmonth.selectedIndex;
			var val_month=elementmonth.options[idx_month].value;
			var idx_year=elementyear.selectedIndex;
			var val_year=elementyear.options[idx_year].value;
			var ArrayMois=["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "aoû", "Sep", "Oct", "Nov", "Déc"];

			$('#title2id').html('Listes des tâches en année '+ elementyear.options[idx_year].innerHTML);

			LoadChartTaskBy_Month_Year(ArrayMois,val_month,val_year,'FetchDataTaskByYear');
		}
		function ChangeTicketChartYear()
		{
			var elementmonth=document.getElementById('monthNameTicketId');
			var elementyear=document.getElementById('yearNameTicketId');
			var idx_month=elementmonth.selectedIndex;
			var val_month=elementmonth.options[idx_month].value;
			var idx_year=elementyear.selectedIndex;
			var val_year=elementyear.options[idx_year].value;
			var ArrayMois=["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "aoû", "Sep", "Oct", "Nov", "Déc"];

			$('#title3id').html('Listes des tickets résolus en '+ elementyear.options[idx_year].innerHTML);

			LoadChartTicketBy_Month_Year(ArrayMois,val_month,val_year,'FetchDataTicketByYear');
		}





		function FetchMessageTicket()
		{
			var nbjour1=NombreJourMois(new Date().getMonth()+1,new Date().getFullYear());
			var arraydate1=[];//array that has the days of the current month
			for(let t=1;t<=nbjour1;t++){
			var date1=''+new Date().getFullYear()+'-'+(new Date().getMonth()+1) +'-'+t;
			arraydate1.push(date1);
	        }
			//var arraydate3=["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];//label for year featching
            var elementmonth=document.getElementById("messageTicketMonthId");
			var mois=new Date().getMonth()+1;

			elementmonth.selectedIndex=mois-1;
			if(Number(mois)<10){
				mois="0"+mois;
			}
			else{
				mois=""+mois;
			}

			FetchMessageDataChartTicket(arraydate1,'FetchDataMessageTicket',mois);
        
        
		}
		function FetchMessageTicketThisYear()
		{
			
			var arraydate3=["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "aoû", "Sep", "Oct", "Nov", "Déc"];//label for year featching
            var elementyear=document.getElementById("messageTicketYearId");
			var year=new Date().getFullYear();

		     console.log(new Date().getFullYear());
               year=year +"";
			FetchMessageDataChartTicketByYear(arraydate3,'FetchDataMessageTicketByYear',year);
        
        
		}
		function LoadMessageTicketByMonth()
		{

			var elementmonth=document.getElementById('messageTicketMonthId');
			var idx_month=elementmonth.selectedIndex;
			var val_month=elementmonth.options[idx_month].value;
		
			ArrayJour=[];
			var nbjour=NombreJourMois(Number(val_month),Number(new Date().getFullYear()));
			for(let t=1;t<=nbjour;t++){
				ArrayJour.push(''+new Date().getFullYear()+'-'+val_month+'-'+t);
			}
			FetchMessageDataChartTicket(ArrayJour,'FetchDataMessageTicket',val_month);
            


		}
		function ChangeMessageTicketChartYear()
		{
			var arraydate3=["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "aoû", "Sep", "Oct", "Nov", "Déc"];//label for year featching
            var elementyear=document.getElementById("messageTicketYearId");
			var idx_year=elementyear.selectedIndex;
			var val_year=elementyear.options[idx_year].value;
			FetchMessageDataChartTicketByYear(arraydate3,'FetchDataMessageTicketByYear',val_year);


		}



        // load data chart by index of dropdown menu items.................................
        function LoadData(index)
        {
			var arraylabel=["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi ", "Samedi", "Dimanche"];
			var nbjour1=NombreJourMois(new Date().getMonth()+1,new Date().getFullYear());
			var arraydate1=[];//array that has the days of the current month
			for(let t=1;t<=nbjour1;t++){
			var date1=''+new Date().getFullYear()+'-'+(new Date().getMonth()+1) +'-'+t;
			arraydate1.push(date1);
	        }
			var nbjour2=NombreJourMois(new Date().getMonth(),new Date().getFullYear());
			var arraydate2=[];//array that has the days of the last month
			for(let t=1;t<=nbjour2;t++){
			var date2=''+new Date().getFullYear()+'-'+(new Date().getMonth()) +'-'+t;
			arraydate2.push(date2);
	        }
			var arraydate3=["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "aoû", "Sep", "Oct", "Nov", "Déc"];//label for year featching

           if(index==0)
		   {
			$('#titleid').html('Companie leads convertie cette semaine');
			$('#titleconvertedleads').html('Companie leads convertis cette semaine');
			$('#title2id').html('Listes des tâches de cette semaine');
			$('#title3id').html('Liste des tickets résolus cette samaine');
           

			var mois=new Date().getMonth()+1;
			var annee=new Date().getFullYear();
			var elementmonth=document.getElementById('monthNameId');
		    var elementyear=document.getElementById('yearNameId');
			var elementTicketmonth=document.getElementById('monthNameTicketId');
		    var elementTicketyear=document.getElementById('yearNameTicketId');

			elementmonth.selectedIndex=mois-1;
            for (var i=0;i<elementyear.options.length;i++ ) {
            opt = elementyear.options[i].value;
			if (opt == annee) {
				elementyear.selectedIndex=i;
			} 
          }
		  var elementTaskmonth=document.getElementById('monthNameTaskId');
		    var elementTaskyear=document.getElementById('yearNameTaskId');
			elementTaskmonth.selectedIndex=mois-1;
            for (var i=0;i<elementTaskyear.options.length;i++ ) {
            opt = elementTaskyear.options[i].value;
			if (opt == annee) {
				elementTaskyear.selectedIndex=i;
			} 
          }
		  elementTicketmonth.selectedIndex=mois-1;
            for (var i=0;i<elementTicketyear.options.length;i++ ) {
            opt = elementTicketyear.options[i].value;
			if (opt == annee) {
				elementTicketyear.selectedIndex=i;
			} 
          }
			LoadDataChart('FetchDataThisWeek',arraylabel);
			LoadDataTaskChart('FetchDataTaskThisWeek',arraylabel);
		    LoadDataTicketChart('FetchDataTicketThisWeek',arraylabel); //load data count for the task......



		}
			else if(index ==1)
			{
			$('#titleid').html('Companie leads convertie La semaine dernière');
			$('#title2id').html('Liste des tâches de la semaine dernière');
			$('#title3id').html('Liste des tickets résolus la semaine dernière');


			$('#titleconvertedleads').html('Companie leads convertie la semaine derniére');

			var mois=new Date().getMonth()+1;
			var annee=new Date().getFullYear();
			var elementmonth=document.getElementById('monthNameId');
		    var elementyear=document.getElementById('yearNameId');
			var elementTaskmonth=document.getElementById('monthNameTaskId');
		    var elementTaskyear=document.getElementById('yearNameTaskId');
			var elementTicketmonth=document.getElementById('monthNameTicketId');
		    var elementTicketyear=document.getElementById('yearNameTicketId');
			
			var thisweek=<?php echo json_encode($debut_fin_semaine);?>;
			var lastweek=<?php echo json_encode($last_semaine);?>;
			var thisweekmois=thisweek[0].substr(thisweek[0].indexOf(' ')+1,3);
			var lastweekmois=lastweek[0].substr(lastweek[0].indexOf(' ')+1,3);
			if(thisweekmois === lastweekmois)
			{
			elementmonth.selectedIndex=mois-1;
			elementTaskmonth.selectedIndex=mois-1;
			elementTicketmonth.selectedIndex=mois-1;
			}
			else
			{
			elementmonth.selectedIndex=mois-2;
			elementTaskmonth.selectedIndex=mois-2;
			elementTicketmonth.selectedIndex=mois-2;
			}

            for (var i=0;i<elementyear.options.length;i++ ) {
            opt = elementyear.options[i].value;
			if (opt == annee) {
				elementyear.selectedIndex=i;
			} 
          }
		  for (var i=0;i<elementTaskyear.options.length;i++ ) {
            opt = elementTaskyear.options[i].value;
			if (opt == annee) {
				elementTaskyear.selectedIndex=i;
			} 
          }
		  for (var i=0;i<elementTicketyear.options.length;i++ ) {
            opt = elementTicketyear.options[i].value;
			if (opt == annee) {
				elementTicketyear.selectedIndex=i;
			} 
          }
			LoadDataChart('FetchDataLastWeek',arraylabel);
			LoadDataTaskChart('FetchDataTaskLastWeek',arraylabel);
			LoadDataTicketChart('FetchDataTicketLastWeek',arraylabel);


			
			}
			else if(index ==2)
			{
			$('#titleid').html('Companie leads convertie ce mois-ci');
			$('#title2id').html('Listes des tâches ce mois-ci');
			$('#title3id').html('List des tickets résolus ce mois');


			$('#titleconvertedleads').html('Companie leads convertie ce mois-ci');
			var mois=new Date().getMonth()+1;
			var annee=new Date().getFullYear();
			var elementmonth=document.getElementById('monthNameId');
		    var elementyear=document.getElementById('yearNameId');
			elementmonth.selectedIndex=mois-1;
            for (var i=0;i<elementyear.options.length;i++ ) {
            opt = elementyear.options[i].value;
			if (opt == annee) {
				elementyear.selectedIndex=i;
			} 
          }
		    var elementTaskmonth=document.getElementById('monthNameTaskId');
		    var elementTaskyear=document.getElementById('yearNameTaskId');
			elementTaskmonth.selectedIndex=mois-1;
            for (var i=0;i<elementTaskyear.options.length;i++ ) {
            opt = elementTaskyear.options[i].value;
			if (opt == annee) {
				elementTaskyear.selectedIndex=i;
			} 
          }
		    var elementTicketmonth=document.getElementById('monthNameTicketId');
		    var elementTicketyear=document.getElementById('yearNameTicketId');
			elementTicketmonth.selectedIndex=mois-1;
            for (var i=0;i<elementTicketyear.options.length;i++ ) {
            opt = elementTicketyear.options[i].value;
			if (opt == annee) {
				elementTicketyear.selectedIndex=i;
			} 
          }
			LoadDataChart('FetchDataThisMonth',arraydate1);
			LoadDataTaskChart('FetchDataTaskThisMonth',arraydate1);
			LoadDataTicketChart('FetchDataTicketThisMonth',arraydate1);

			
			}
			else if(index ==3)
			{
			var element=document.getElementById('monthNameId');
			var Taskelement=document.getElementById('monthNameTaskId');
			var Ticketelement=document.getElementById('monthNameTicketId');


			var idx=element.selectedIndex;
			element.selectedIndex=idx-1;
			var idx2=Taskelement.selectedIndex;
			Taskelement.selectedIndex=idx2-1;
			var idx3=Ticketelement.selectedIndex;
			Ticketelement.selectedIndex=idx3-1;
			$('#titleid').html('Companie leads convertis le mois dernier');
			$('#title2id').html('Listes des tâches du mois dernier');
			$('#title3id').html('listes des tickets résolus le mois dernier');


			$('#titleconvertedleads').html('Companie leads convertis le mois dernier');
			LoadDataChart('FetchDataLastMonth',arraydate2);
			LoadDataTaskChart('FetchDataTaskLastMonth',arraydate2);
			LoadDataTicketChart('FetchDataTicketLastMonth',arraydate2);


			}
            else if(index ==4)
			{	
			var TabThreeMonth=<?php echo json_encode($LastThreeMonth);?>;
			var arraymois=[];
			for(let i=0;i<TabThreeMonth.length;i++) {
				arraymois.push(TabThreeMonth[i].substr(TabThreeMonth[i].indexOf(' ')+1,8));
			}

			LoadDataChart('FetchDataByLastThreeMonth',arraymois);
			LoadDataTaskChart('FetchDataTaskByLastThreeMonth',arraymois);
			LoadDataTicketChart('FetchDataTicketByLastThreeMonth',arraymois);


			$('#titleconvertedleads').html('Companie leads convertis au cours des 3 derniers mois');
			$('#titleid').html('Companie leads convertis au cours des 3 derniers mois');
			$('#title2id').html('Listes des tâches des 3 derniers mois');
			$('#title3id').html('Listes des tickets résolus au cours des 3 derniers mois');


			}
			else if(index ==5)
			{
			var TabSixMonth=<?php echo json_encode($LastSixMonth);?>;
			var arraymois=[];
			for(let i=0;i<TabSixMonth.length;i++) {
				arraymois.push(TabSixMonth[i].substr(TabSixMonth[i].indexOf(' ')+1,8));
			}
			console.log(arraymois);
			LoadDataChart('FetchDataByLastSixMonth',arraymois);
			LoadDataTaskChart('FetchDataTaskByLastSixMonth',arraymois);
			LoadDataTicketChart('FetchDataTicketByLastSixMonth',arraymois);


			$('#titleconvertedleads').html('Companie leads convertis au cours des 6 derniers mois');
			$('#titleid').html('Companie leads convertis au cours des 6 derniers mois');
			$('#title2id').html('Listes des tâches des 6 derniers mois');
			$('#title3id').html('Listes des tickets résolus au cours des 6 derniers mois');


			}


			else if(index ==6)
			{
            $('#titleid').html('Companie leads convertie cette année');
			$('#title2id').html('Listes des tâches de cette année');
			$('#title3id').html('Listes des tickets résolus cette année');


			$('#titleconvertedleads').html('Companie leads convertie cette année');

			var elementmonth=document.getElementById('monthNameId');
			var elementyear=document.getElementById('yearNameId');
			var elementTaskmonth=document.getElementById('monthNameTaskId');
			var elementTaskyear=document.getElementById('yearNameTaskId');
			var elementTicketmonth=document.getElementById('monthNameTicketId');
			var elementTicketyear=document.getElementById('yearNameTicketId');

			var mois=new Date().getMonth()+1;//get the current month
			var annee=new Date().getFullYear();


			for (var i=0;i<elementmonth.options.length;i++ ) {
            opt = elementmonth.options[i].value;
			if (opt == mois) {
				elementmonth.selectedIndex=i;
			} 
          }
		  for (var i=0;i<elementyear.options.length;i++ ) {
            opt = elementyear.options[i].value;
			if (opt == annee) {
				elementyear.selectedIndex=i;
			} 
          }
		  //for task
		  for (var i=0;i<elementTaskmonth.options.length;i++ ) {
            opt = elementTaskmonth.options[i].value;
			if (opt == mois) {
				elementTaskmonth.selectedIndex=i;
			} 
          }
		  for (var i=0;i<elementTaskyear.options.length;i++ ) {
            opt = elementTaskyear.options[i].value;
			if (opt == annee) {
				elementTaskyear.selectedIndex=i;
			} 
          }
		  for (var i=0;i<elementTicketmonth.options.length;i++ ) {
            opt = elementTicketmonth.options[i].value;
			if (opt == mois) {
				elementTicketmonth.selectedIndex=i;
			} 
          }
		  for (var i=0;i<elementTicketyear.options.length;i++ ) {
            opt = elementTicketyear.options[i].value;
			if (opt == annee) {
				elementTicketyear.selectedIndex=i;
			} 
          }
			LoadDataChart('FetchDataThisYear',arraydate3);
			LoadDataTaskChart('FetchDataTaskThisYear',arraydate3);
			LoadDataTicketChart('FetchDataTicketThisYear',arraydate3);


			}
			else if(index ==7)
			{
			var element=document.getElementById('yearNameId');
			var Taskelement=document.getElementById('yearNameTaskId');
			var Ticketelement=document.getElementById('yearNameTicketId');
			var idx=element.selectedIndex;
			element.selectedIndex=idx-1;
			var idx2=Taskelement.selectedIndex;
			Taskelement.selectedIndex=idx2-1;
			var idx3=Ticketelement.selectedIndex;
			Ticketelement.selectedIndex=idx3-1;
			$('#titleid').html('Companie Leads convertis l\'année dernière');
			$('#title2id').html('Liste des tâches de l\'année dernière');//title for tasks................
			$('#title3id').html('Liste des tickets résolus l\'année dernière');

			$('#titleconvertedleads').html("Companie leads convertis l'année dernière");

			LoadDataChart('FetchDataLastYear',arraydate3);
			LoadDataTaskChart('FetchDataTaskLastYear',arraydate3);
			LoadDataTicketChart('FetchDataTicketLastYear',arraydate3);


			}

        }


		//load data converted leads by the current day..............................
          function load_converted_leads()
          {
			  var PK_USER=document.getElementById('pk_userRapport').value;
            $.ajax({
            url:"https://www.yestravaux.com/webservice/crm/lead.php",
            method:"POST",
            data:{fct:'FetchConvertedLeads',PK_USER:PK_USER},
            dataType:"json",
            success:function(data)
            {
                $('#barConverted').html(data.converted_leads);
				$('#titleconvertedleads').html("Companie leads convertis cette semaine");
            }

            });

            return false;
          }
		 

		  function LoadTicket_Stats(arrayLabel,mois,fctvalue)
		  {
			var PK_USER=document.getElementById('pk_userRapport').value;

			$.ajax({
			url:"https://www.yestravaux.com/webservice/crm/campaign.php",
			method:"POST",
			data:{
				fct:fctvalue,
				PK_USER:PK_USER,
				mois:mois
			},
			dataType:"json",
			success:function(data)
			{
              
				$("#nb_resolved").html(data.stat.nb_resolved);
				$("#nb_new").html(data.stat.nb_new);
				$("#nb_pending").html(data.stat.nb_pending);
				$("#nb_opened").html(data.stat.nb_opened);
				$("#nb_received").html(data.stat.nb_received);
			
           let nbUnresolved=Number(data.stat.nb_received)-Number(data.stat.nb_resolved);
		   let resolved=(Number(data.stat.nb_resolved)*100/Number(data.stat.nb_received)).toFixed(2);
		   let unresolved=(nbUnresolved *100/Number(data.stat.nb_received)).toFixed(2);
		   
		 
           if(isNaN(resolved))
		   {
			$('#resolved').html(0+" %");

		   }
		  else {
			$('#resolved').html(resolved +"%");

		   }
		  
		 
           if(isNaN(unresolved))
		   {
			$('#unresolved').html(0+" %");

		   }
		  else {
			$('#unresolved').html(unresolved +"%");

		   }

		   

          $('#received').html(Number(data.stat.nb_received));



		  $('#total').html(Number(data.stat.nb_total));



				var options = {
        series: [{
            name: "Resolved",
            data: data.result[0].count_ticket_resolved// array that contain the numbers of tickets resolved by month
        },{
            name: "New",
            data: data.result[0].count_ticket_new
        },
		{
            name: "Pending",
            data: data.result[0].count_ticket_pending
        },
		{
            name: "Opened",
            data: data.result[0].count_ticket_opened
        }
	],
        chart: {
			foreColor:"#bac0c7",
          height: 350,
          type: 'area',
          zoom: {
            enabled: false// enable the zoom  features
          }
        },
		colors:["#00ffff", "#689f38","#c49e36","#FF9149"],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          	show: true,
			curve: 'smooth',
			lineCap: 'butt',
			colors: undefined,
			width: 3,
			dashArray: 0, 
        },		
		markers: {
			size: 2,
			colors: '#FF4961',
			strokeColors: '#ffffff',
			strokeWidth: 2,
			strokeOpacity: 0.9,
			strokeDashArray: 0,
			fillOpacity: 1,
			discrete: [],
			shape: "circle",
			radius: 5,
			offsetX: 0,
			offsetY: 0,
			onClick: undefined,
			onDblClick: undefined,
			hover: {
			  size: undefined,
			  sizeOffset: 3
			}
		},	
        grid: {
			borderColor: '#f7f7f7', 
          row: {
            colors: ['transparent'], // takes an array which will be repeated on columns
            opacity: 0
          },			
		  yaxis: {
			lines: {
			  show: true,
			},
		  },
        },
	
        xaxis: {
          categories: arrayLabel,
		  labels: {
			show: true,
          },
          axisBorder: {
            show: true
          },
          axisTicks: {
            show: true
          },
          tooltip: {
            enabled: true,        
          },
        },
        yaxis: {
          labels: {
            show: true,
           
          }
        
        },
      };
      var chart = new ApexCharts(document.querySelector("#charts_widget_2_chart"), options);
	  
      chart.render(); // pour rendu le contenu de chart ..........................

	  // this method used by apex-chart to render the content of dynamique chart 
	  chart.updateSeries([{
            name: "Resolved",
            data: data.result[0].count_ticket_resolved// array that contain the numbers of tickets resolved by month
        },{
            name: "New",
            data: data.result[0].count_ticket_new
        },
		{
            name: "Pending",
            data: data.result[0].count_ticket_pending
        },
		{
            name: "Opened",
            data: data.result[0].count_ticket_opened
        }
	]);
	
			}
		
		
		});
	
			
			
		  }
		  function LoadTicket_Stats_By_Year(arrayLabel,val_year,fctvalue)
		  {
			var PK_USER=document.getElementById('pk_userRapport').value;

		$.ajax({
		url:"https://www.yestravaux.com/webservice/crm/campaign.php",
		method:"POST",
		data:{
			fct:fctvalue,
			PK_USER:PK_USER,
			year:val_year
		},
		dataType:"json",
		success:function(data)
		{
		
			$("#nb_resolved").html(data.stat.nb_resolved);
			$("#nb_new").html(data.stat.nb_new);
			$("#nb_pending").html(data.stat.nb_pending);
			$("#nb_opened").html(data.stat.nb_opened);
			$("#nb_received").html(data.stat.nb_received);

		let nbUnresolved=Number(data.stat.nb_received)-Number(data.stat.nb_resolved);
		let resolved=(Number(data.stat.nb_resolved)*100/Number(data.stat.nb_received)).toFixed(2);
		let unresolved=(nbUnresolved *100/Number(data.stat.nb_received)).toFixed(2);


		if(isNaN(resolved))
		{
		$('#resolved').html(0+" %");

		}
		else {
		$('#resolved').html(resolved +"%");

		}


		if(isNaN(unresolved))
		{
		$('#unresolved').html(0+" %");

		}
		else {
		$('#unresolved').html(unresolved +"%");

		}



		$('#received').html(Number(data.stat.nb_received));



		$('#total').html(Number(data.stat.nb_total));



			var options = {
		series: [{
		name: "Resolved",
		data: data.result[0].count_ticket_resolved// array that contain the numbers of tickets resolved by month
		},{
		name: "New",
		data: data.result[0].count_ticket_new
		},
		{
		name: "Pending",
		data: data.result[0].count_ticket_pending
		},
		{
		name: "Opened",
		data: data.result[0].count_ticket_opened
		}
		],
		chart: {
		foreColor:"#bac0c7",
		height: 350,
		type: 'area',
		zoom: {
		enabled: false// enable the zoom  features
		}
		},
		colors:["#00ffff", "#689f38","#c49e36","#FF9149"],
		dataLabels: {
		enabled: false,
		},
		stroke: {
		show: true,
		curve: 'smooth',
		lineCap: 'butt',
		colors: undefined,
		width: 3,
		dashArray: 0, 
		},		
		markers: {
		size: 2,
		colors: '#FF4961',
		strokeColors: '#ffffff',
		strokeWidth: 2,
		strokeOpacity: 0.9,
		strokeDashArray: 0,
		fillOpacity: 1,
		discrete: [],
		shape: "circle",
		radius: 5,
		offsetX: 0,
		offsetY: 0,
		onClick: undefined,
		onDblClick: undefined,
		hover: {
		size: undefined,
		sizeOffset: 3
		}
		},	
		grid: {
		borderColor: '#f7f7f7', 
		row: {
		colors: ['transparent'], // takes an array which will be repeated on columns
		opacity: 0
		},			
		yaxis: {
		lines: {
		show: true,
		},
		},
		},

		xaxis: {
		categories: arrayLabel,
		labels: {
		show: true,
		},
		axisBorder: {
		show: true
		},
		axisTicks: {
		show: true
		},
		tooltip: {
		enabled: true,        
		},
		},
		yaxis: {
		labels: {
		show: true,

		}

		},
		};
		var chart = new ApexCharts(document.querySelector("#charts_widget_2_chart"), options);

		chart.render(); // pour rendu le contenu de chart ..........................

		// this method used by apex-chart to render the content of dynamique chart 
		chart.updateSeries([{
		name: "Resolved",
		data: data.result[0].count_ticket_resolved// array that contain the numbers of tickets resolved by month
		},{
		name: "New",
		data: data.result[0].count_ticket_new
		},
		{
		name: "Pending",
		data: data.result[0].count_ticket_pending
		},
		{
		name: "Opened",
		data: data.result[0].count_ticket_opened
		}
		]);

		}


		});




		  }





		function ChangeTicketCountMonth(){

		var elementmonth=document.getElementById('Ticket_ChartMonthId');
		var ind_month=elementmonth.selectedIndex;
		var val_month=elementmonth.options[ind_month].value;
		var arrayLabel=[];
		var val_year=new Date().getFullYear();
		var nbjour=NombreJourMois(Number(val_month),Number(val_year));
		for(let i=1;i<=Number(nbjour);i++){
			arrayLabel.push(''+val_year+'-'+val_month+'-'+i);
		}

		var year_box=document.getElementById('Ticket_ChartYearId');
		for(let i=0;i<year_box.options.length;i++)
		{
			if(year_box.options[i].value==new Date().getFullYear()){
				year_box.selectedIndex=i;
			}
		}

		
		$('#Ticket_id').html("Tickets mensuels de tendance reçus, résolus et non résolus en  <font color='#462be2'>"+ document.getElementById('Ticket_ChartMonthId').options[document.getElementById('Ticket_ChartMonthId').selectedIndex].innerHTML +"</font>"+
			"<font color='#462be2'> "+new Date().getFullYear()+"</font>"
			);

		LoadTicket_Stats(arrayLabel,val_month,'FetchTicketStatByMonth');

		}


		function ChangeTicketCountYear()
		{

		var element_year=document.getElementById('Ticket_ChartYearId');
		var ind_year=element_year.selectedIndex;
		var val_year=element_year.options[ind_year].value;
		var arrayLabel=["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "aoû", "Sep", "Oct", "Nov", "Déc"];
		
		$('#Ticket_id').html("Tickets de tendance annuels reçus, résolus et non résolus en "+
			"<font color='#462be2'>"+element_year.options[ind_year].innerHTML+"</font>"
			);

		LoadTicket_Stats_By_Year(arrayLabel,val_year,'FetchTicketStatByYear');


		}






			$(document).ready(function(){


			var PK_USER=document.getElementById('pk_userRapport').value;
			$.ajax({
			url:"https://www.yestravaux.com/webservice/crm/campaign.php",
			method:"POST",
			data:{
				fct:'LoadTicketClient',
				user_id:PK_USER
			},
			dataType:"json",
			success:function(data)
			{
				var Listclient=document.getElementById('ListClient');
				//data=JSON.parse(data);
				Listclient.innerHTML=data.output;
			},
			error:function(err){
				//console.log(err);
				alert(err);
			}

			});


			//stat morris chart 
		



			$(function () {
				"use strict";
				$('.donut').peity('donut');
				$(".bar").peity("bar");	

			var nbjour1=NombreJourMois(new Date().getMonth()+1,new Date().getFullYear());
			var arraydate1=[];//array that has the days of the current month
			for(let t=1;t<=nbjour1;t++){
			var date1=''+new Date().getFullYear()+'-'+(new Date().getMonth()+1) +'-'+t;
			arraydate1.push(date1);
	        }
			var month_ticket=new Date().getMonth()+1;
             console.log(month_ticket);
			if(Number(month_ticket)<10){
				month_ticket="0"+month_ticket;

			}
			else{
				month_ticket=""+month_ticket;
			}
			console.log("this is the value of this month "+month_ticket);
			$('#Ticket_id').html("Tickets de tendance mensuels reçus, résolus et non résolus en  <font color='#462be2'>"+ document.getElementById('Ticket_ChartMonthId').options[document.getElementById('Ticket_ChartMonthId').selectedIndex].innerHTML +"</font>"+
			"<font color='#462be2'> "+new Date().getFullYear()+"</font>"
			);

              LoadTicket_Stats(arraydate1,month_ticket,'FetchTicketStatByMonth');

				}); 

			console.log("all fine");
			var arraylabel=["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi ", "Samedi", "Dimanche"];

			LoadDataChart('FetchDataThisWeek',arraylabel,'This week'); //load data count for converted leads......
			LoadDataTaskChart('FetchDataTaskThisWeek',arraylabel); //load data count for the task......
			LoadDataTicketChart('FetchDataTicketThisWeek',arraylabel); //load data count for the task......
            FetchMessageTicket();
			FetchMessageTicketThisYear();
			load_converted_leads();

            // for dropdown clic feature........
			$(window).on('show.bs.dropdown', function (e) {

			var menu=document.getElementById('dropmenuID');
			$('#dropmenuID').css('margin', '20px');
			menu.style.position="relative";

			var list=$("#dropmenuID").children();
			for(let i=0;i<list.length;i++)
			{
				
			list[i].onclick=function(){
			var dd=$('#'+list[i].id);
			$('#btnidlink').html(dd.children()[1].innerHTML);
			LoadData(i);
			};

			}
	     });

		});



		$(function () {
	
			});


		function PressOk()
		{
		document.getElementById('press1').className="btn btn-sm bg-white emojstylea1";
		document.getElementById('press2').className="btn btn-sm emojstylea2";

		}
		function PressNO()
		{
		document.getElementById('press1').className="btn btn-sm emojstylea1";
		document.getElementById('press2').className="btn btn-sm bg-white emojstylea2";

		}




      </script>
