

  <!-- Content Wrapper. Contains page content -->

  <div class="container-full">
		<!-- Main content -->
		<section class="content">			
			<div class="row">
				<div class="col-lg-4 col-12">
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
					  <div class="box-body p-0">
						<div id="spark1"></div>
					  </div>
					</div>
				</div>
				<div class="col-lg-4 col-12">
					<div class="box bg-warning bg-food-dark pull-up">
					  <div class="box-body">
						  <h5 class="mb-0">
							<span class="text-uppercase">TAX</span>
							<span class="float-end"><a class="btn btn-rounded btn-white btn-outline" href="#">View</a></span>
						  </h5>
						  <br>		
						  <small>Monthly Deduction</small>
							<div class="d-flex justify-content-between">
								<p class="fs-26">$55k</p>
								<div><i class="ion-arrow-graph-up-right text-white me-1"></i> 324 more than last year</div>
							</div>
					  </div>
					  <div class="box-body p-0">
						<div id="spark2"></div>
					  </div>	  
					</div>
				</div>
				<div class="col-lg-4 col-12">
					<div class="box bg-danger bg-food-dark pull-up">
					  <div class="box-body">
						  <h5 class="mb-0">
							<span class="text-uppercase">REVENUE</span>
							<span class="float-end"><a class="btn btn-rounded btn-white btn-outline" href="#">View</a></span>
						  </h5>
						  <br>			
						  <small>Weekly Revenue</small>
							<div class="d-flex justify-content-between">
								<p class="fs-26">$16k</p>
								<div><i class="ion-arrow-graph-down-right text-white me-1"></i> %41 down last year</div>					
							</div>
					  </div>
					  <div class="box-body p-0">
						<div id="spark3"></div>
					  </div>	  
					</div>
				</div>
               
				<div class="col-12 col-xxxl-8 col-xl-6">
					<div class="box">
						<div class="box-header with-border">
						  <h4 class="box-title">Revenue Statistics</h4>

						  <ul class="box-controls pull-right">
							<li><a class="box-btn-close" href="#"></a></li>
							<li><a class="box-btn-slide" href="#"></a></li>	
							<li><a class="box-btn-fullscreen" href="#"></a></li>
						  </ul>
						</div>
						<div class="box-body">
							<div id="bar"></div>	
						</div>
					</div>
				</div>
				<div class="col-12 col-xxxl-4 col-xl-6">
					<div class="box">
						<div class="box-header with-border">
						  <h4 class="box-title">Department Sales</h4>
							<ul class="box-controls pull-right">
							  <li><a class="box-btn-close" href="#"></a></li>
							  <li><a class="box-btn-slide" href="#"></a></li>	
							  <li><a class="box-btn-fullscreen" href="#"></a></li>
							</ul>
						</div>
						<div class="box-body">
							<div id="donut"> </div>
						</div>
					</div>	
				</div>	
				<div class="col-12">
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
				</div>
				<div class="col-xl-4 col-12">
				  <div class="info-box bg-gradient-purple text-white">
					<span class="info-box-icon rounded"><i class="ion ion-cash"></i></span>
					<div class="info-box-content">
					  <span class="info-box-number">51,642</span>
					  <span class="info-box-text">ORDER RECEIVED</span>
					</div>
				  </div>
				</div>
				<div class="col-xl-4 col-12">
				  <div class="info-box bg-gradient-metalred text-white">
					<span class="info-box-icon rounded"><i class="ion ion-stats-bars"></i></span>
					<div class="info-box-content">
					  <span class="info-box-number">$5,354</span>
					  <span class="info-box-text">TAX DEDUCATION</span>
					</div>
				  </div>
				</div>
				<div class="col-xl-4 col-12">
				  <div class="info-box bg-gradient-deepocean text-white">
					<span class="info-box-icon rounded"><i class="ion ion-thumbsup"></i></span>
					<div class="info-box-content">
					  <span class="info-box-number">$1,642</span>
					  <span class="info-box-text">REVENUE STATUS</span>
					</div>
				  </div>
				</div>
				<div class="col-12 col-xl-8">	
					<div class="box">
						<div class="box-header with-border">
						  <h4 class="box-title">Invoice List</h4>
						</div>
						<div class="box-body">
						  <div class="table-responsive">
							<table id="invoice-list" class="table table-hover no-wrap" data-page-size="10">
								<thead>
									<tr>
										<th>#Invoice</th>
										<th>Description</th>
										<th>Amount</th>
										<th>Status</th>
										<th>Issue</th>
										<th>View</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>#5010</td>
										<td>Lorem Ipsum</td>
										<td>$548</td>
										<td><span class="label label-danger">Unpaid</span> </td>
										<td>15-Jan</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<tr>
										<td>#5011</td>
										<td>Lorem Ipsum</td>
										<td>$548</td>
										<td><span class="label label-success">Paid</span> </td>
										<td>15-Sep</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<tr>
										<td>#5012</td>
										<td>Lorem Ipsum</td>
										<td>$9658</td>
										<td><span class="label label-danger">Unpaid</span> </td>
										<td>15-Jun</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<tr>
										<td>#5013</td>
										<td>Lorem Ipsum</td>
										<td>$4587</td>
										<td><span class="label label-success">Paid</span> </td>
										<td>15-May</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<tr>
										<td>#5014</td>
										<td>Lorem Ipsum</td>
										<td>$856</td>
										<td><span class="label label-danger">Unpaid</span> </td>
										<td>15-Mar</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<tr>
										<td>#5015</td>
										<td>Lorem Ipsum</td>
										<td>$956</td>
										<td><span class="label label-danger">Unpaid</span> </td>
										<td>15-Aug</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<tr>
										<td>#5016</td>
										<td>Lorem Ipsum</td>
										<td>$745</td>
										<td><span class="label label-success">Paid</span> </td>
										<td>15-Aug</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<tr>
										<td>#5010</td>
										<td>Lorem Ipsum</td>
										<td>$548</td>
										<td><span class="label label-danger">Unpaid</span> </td>
										<td>15-Jan</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<tr>
										<td>#5011</td>
										<td>Lorem Ipsum</td>
										<td>$548</td>
										<td><span class="label label-success">Paid</span> </td>
										<td>15-Sep</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<tr>
										<td>#5012</td>
										<td>Lorem Ipsum</td>
										<td>$9658</td>
										<td><span class="label label-danger">Unpaid</span> </td>
										<td>15-Jun</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
									<tr>
										<td>#5013</td>
										<td>Lorem Ipsum</td>
										<td>$4587</td>
										<td><span class="label label-success">Paid</span> </td>
										<td>15-May</td>
										<td>
											<a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						</div>
					</div>	
				</div>
				<div class="col-12 col-xl-4">
					<div class="box">	
						<div class="box-header no-border">
							<h4>Total Income</h4>
							<ul class="box-controls pull-right">
							  <li class="dropdown">
								<a data-bs-toggle="dropdown" href="#" class="btn btn-rounded btn-primary px-10">Stats</a>
								<div class="dropdown-menu dropdown-menu-right">
								  <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
								  <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
								  <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
								  <div class="dropdown-divider"></div>
								  <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
								</div>
							  </li>
							</ul>
						</div>
						<div class="box-body pb-40">
							<h1 class="text-center fs-50"><small>$</small>84,125,859</h1>
						</div>
						<div class="box-body p-0 overflow-h">					  	
							<div id="spark4"></div>
						</div>
					</div>	
					<div class="box">
						<div class="box-header with-border">
							<h4 class="box-title">Item Sales <span class="fs-12 text-fade">Total Sales By item</span></h4>
							<ul class="box-controls pull-right">
							  <li class="dropdown">
								<a data-bs-toggle="dropdown" href="#"><i class="ti-more-alt"></i></a>
								<div class="dropdown-menu dropdown-menu-right">
								  <a class="dropdown-item" href="#"><i class="iconsmind-Flash-2"></i> Activity</a>
								  <a class="dropdown-item" href="#"><i class="iconsmind-Email"></i> Messages</a>
								  <a class="dropdown-item" href="#"><i class="iconsmind-File-Edit"></i> FAQ</a>
								  <div class="dropdown-divider"></div>
								  <a class="dropdown-item" href="#"><i class="consmind-Gear-2"></i> Support</a>
								</div>
							  </li>
							</ul>
						</div>
						<div class="box-body bb-1 bbe-0">
							<span class="fs-50 text-primary">$154,875</span>
							<span class="text-fade">Total Revenue This Month</span>
						</div>
						<div class="box-body">
							<div class="row justify-content-between pb-25">
								<div class="col-4">
									<h2 class="mb-0">60%</h2>				         
									<div class="progress progress-xs mb-0 mb-10">
									  <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>					  
									</div>						 
									<span class="fs-16 text-fade">
										Sales
									</span>
								</div>
								<div class="col-4">
									<h2 class="mb-0">40%</h2>				         
									<div class="progress progress-xs mb-0 mb-10">
									  <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>					  
									</div>						 
									<span class="fs-16 text-fade">
										Product
									</span>
								</div>
								<div class="col-4">
									<h2 class="mb-0">50%</h2>				         
									<div class="progress progress-xs mb-0 mb-10">
									  <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>					  
									</div>						 
									<span class="fs-16 text-fade">
										Community
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
		    </div>     
            <div class="row">
						<div class ="col-md-3">

<canvas id="myChartjs" width="10" height="10"></canvas>



</div> 
<div class="col-md-3">
<canvas id="myChartjs2" width="10" height="10"></canvas>

</div>
</div> 
		    <!-- /.row -->
		</section>
		<!-- /.content -->
	  </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
var ctx = document.getElementById('myChartjs');


var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(['hosteur','bansko','yestravaux','asana']);?>,
        datasets: [{
            label: '#campany rate',
            data:<?php echo json_encode([9,8,7,10]);?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
     options: {
		plugins: {
      title: {
        display: true,
        text: 'Nombre of leads of campany'
      }
    },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
		
    }
});

var ctx2 = document.getElementById('myChartjs2');


var myChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode(['hosteur','bansko','yestravaux','asana']);?>,
        datasets: [{
            label: '#campany rate',
            data:<?php echo json_encode([9,8,7,10]);?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1
        }]
    },
     options: {
		plugins: {
      title: {
        display: true,
        text: 'Nombres of leads per campany'
      }
    },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
		
    }
});




</script>
  
	
	<!-- Page Content overlay -->
	
	
	
	
