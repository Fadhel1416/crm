<?php
session_start ();


if(!isset($_SESSION["PK_USER"])){

    echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
  
  }
  
include_once "../../config.inc.php";
global $sqlserver;

$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
$POSTVALUE  = 'fct=Emails_List&PK_USER='.$_SESSION["PK_USER"];
$email_result = curl_do_post($URL, $POSTVALUE);
$email_result =json_decode($email_result);
$email_result=(array)$email_result;




//var_dump($ticketresult);
?>
    
    <!-- Content Wrapper. Contains page content -->
        <div class="container-full" >
            
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Tickets Settings</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="ti ti-settings"></i></a></li>
								<li class="breadcrumb-item active" aria-current="page">Settings</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Main content -->
		<section class="content" id="refresh-users">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
        <div class="row">
			<div class="col-12">
			  <div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					<h4 class="box-title my-0 text-info"><i class="ti ti-settings"></i> Tickets Settings</h4>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
			<!-- /.col -->

			<div class="col-12 col-xl-4">
				<div class="box">
					<div class="box-body">	
						<div class="d-flex flex-wrap align-items-center">							
							<div class="me-25 bg-success-light h-80 w-80 l-h-80 rounded text-center">
                            <img src=" https://fassetsblue.freshdesk.com/production/a/assets/images/new-admin/agents-fdc49c3265a3909be22772b82fb693599700ce020c5166e4bcbd892aee841c52.svg" class="h-50 align-self-center" alt="" >
							</div>
							
							<div class="d-flex flex-column flex-grow-1 my-lg-0 my-10 pe-15">
								<a href="#" class="text-dark fw-600 hover-danger fs-18">
									Clients<br>
								</a>
							
							</div>
							
						
						</div>
					</div>					
				</div>
			</div>
			<div class="col-12 col-xl-4">
				<div class="box">
					<div class="box-body">	
						<div class="d-flex flex-wrap align-items-center">							
							<div class="me-25 bg-info-light h-80 w-80 l-h-80 rounded text-center">
								  <img src="https://fassetsblue.freshdesk.com/production/a/assets/images/new-admin/admin-email-fdc49c3265a3909be22772b82fb693599700ce020c5166e4bcbd892aee841c52.svg" class="h-50 align-self-center" alt="" >
							</div>
							
							<div class="d-flex flex-column flex-grow-1 my-lg-0 my-10 pe-15">
								<a href="#" class="text-dark fw-600 hover-danger fs-18">
									Emails<br>
								</a>
							
							</div>
							
							
						
						</div>
					</div>					
				</div>
			</div>
			<div class="col-12 col-xl-4">
				<div class="box">
					<div class="box-body">	
						<div class="d-flex flex-wrap align-items-center">							
							<div class="me-25 bg-warning-light h-80 w-80 l-h-80 rounded text-center">
								  <img src="../images/svg-icon/color-svg/003-settings.svg" class="h-50 align-self-center" alt="" >
							</div>
							
							<div class="d-flex flex-column flex-grow-1 my-lg-0 my-10 pe-15">
								<a href="#" class="text-dark fw-600 hover-warning fs-18">
									Ticket Fields<br>
									 
								</a>
							
							</div>

					
						</div>
					</div>					
				</div>
			</div>
			<div class="col-12 col-xl-4">
				<div class="box">
					<div class="box-body">	
						<div class="d-flex flex-wrap align-items-center">							
							<div class="me-25 bg-info-light h-80 w-80 l-h-80 rounded text-center">
								  <img src="../images/svg-icon/color-svg/005-paint-palette.svg" class="h-50 align-self-center" alt="" >
							</div>
							
							<div class="d-flex flex-column flex-grow-1 my-lg-0 my-10 pe-15">
								<a href="#" class="text-dark fw-600 hover-info fs-18">
									Notifications<br>
									
								</a>
							
							</div>
						
						
						</div>
					</div>					
				</div>
			</div>		
            <div class="col-12 col-xl-4">
				<div class="box">
					<div class="box-body">	
						<div class="d-flex flex-wrap align-items-center">							
							<div class="me-25 bg-danger-light h-80 w-80 l-h-80 rounded text-center">
								  <img src="https://fassetsblue.freshdesk.com/production/a/assets/images/new-admin/apps-fdc49c3265a3909be22772b82fb693599700ce020c5166e4bcbd892aee841c52.svg"  class="h-50 align-self-center"alt="Apps">
							</div>
							
							<div class="d-flex flex-column flex-grow-1 my-lg-0 my-10 pe-15">
								<a href="#" class="text-dark fw-600 hover-danger fs-18">
									Apps<br>
								</a>
							
							</div>
							
							
						
						</div>
					</div>					
				</div>
			</div>
            <div class="col-12 col-xl-4">
				<div class="box">
					<div class="box-body">	
						<div class="d-flex flex-wrap align-items-center">							
							<div class="me-25 bg-danger-light h-80 w-80 l-h-80 rounded text-center">
								  <img src="https://fassetsblue.freshdesk.com/production/a/assets/images/new-admin/helpdesk-fdc49c3265a3909be22772b82fb693599700ce020c5166e4bcbd892aee841c52.svg" class="h-50 align-self-center" alt="" >
							</div>
							
							<div class="d-flex flex-column flex-grow-1 my-lg-0 my-10 pe-15">
								<a href="#" class="text-dark fw-600 hover-danger fs-18">
									HelpDesk Settings<br>
								</a>
							
							</div>
							
							
						
						</div>
					</div>					
				</div>
			</div>	  
			
			<div class="col-12 col-xl-4">
				<div class="box">
					<div class="box-body">	
						<div class="flex-grow-1 pb-15">	
							<div class="d-flex align-items-center pe-2 mb-30">							
								<span class="text-fade fw-600 fs-16 flex-grow-1">
									7 Hours Ago
								</span>
								<div class="bg-info-light h-50 w-50 l-h-50 rounded text-center">
									  <img src="../images/svg-icon/color-svg/001-glass.svg" class="h-30 align-self-center" alt="" >
								</div>							
							</div>
							
							<a href="#" class="text-dark fw-600 hover-primary fs-18">
								Lorem Ipsum is simply dummy<br>
								Printing
							</a>
							<p class="fs-16 mt-15">
								There are many variations of passages.<br>
								Lorem Ipsum available<br>
								but the majority.
							</p>
						</div>							
						<div class="d-flex flex-column mt-10">
							<div class="d-flex">
								<a href="#" class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
									<img src="../images/avatar/avatar-1.png" class="h-50 align-self-end" alt="" >
								</a>
								<a href="#" class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
									<img src="../images/avatar/avatar-3.png" class="h-50 align-self-end" alt="" >
								</a>
								<a href="#" class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
									<img src="../images/avatar/avatar-4.png" class="h-50 align-self-end" alt="" >
								</a>
							</div>
						</div>
					</div>					
				</div>
			</div>
			<div class="col-12 col-xl-4">
				<div class="box">
					<div class="box-body">	
						<div class="flex-grow-1 pb-15">	
							<div class="d-flex align-items-center pe-2 mb-30">							
								<span class="text-fade fw-600 fs-16 flex-grow-1">
									7 Hours Ago
								</span>
								<div class="bg-danger-light h-50 w-50 l-h-50 rounded text-center">
									  <img src="../images/svg-icon/color-svg/008-python.svg" class="h-30 align-self-center" alt="" >
								</div>							
							</div>
							
							<a href="#" class="text-dark fw-600 hover-primary fs-18">
								Lorem Ipsum is simply dummy<br>
								Printing
							</a>
							<p class="fs-16 mt-15">
								There are many variations of passages.<br>
								Lorem Ipsum available<br>
								but the majority.
							</p>
						</div>							
						<div class="d-flex flex-column mt-10">
							<div class="d-flex">
								<a href="#" class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
									<img src="../images/avatar/avatar-1.png" class="h-50 align-self-end" alt="" >
								</a>
								<a href="#" class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
									<img src="../images/avatar/avatar-3.png" class="h-50 align-self-end" alt="" >
								</a>
								<a href="#" class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
									<img src="../images/avatar/avatar-4.png" class="h-50 align-self-end" alt="" >
								</a>
								<a href="#" class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
									<img src="../images/avatar/avatar-5.png" class="h-50 align-self-end" alt="" >
								</a>
							</div>
						</div>
					</div>					
				</div>
			</div>
			<div class="col-12 col-xl-4">
				<div class="box">
					<div class="box-body">	
						<div class="flex-grow-1 pb-15">	
							<div class="d-flex align-items-center pe-2 mb-30">							
								<span class="text-fade fw-600 fs-16 flex-grow-1">
									5 Hours Ago
								</span>
								<div class="bg-primary-light h-50 w-50 l-h-50 rounded text-center">
									  <img src="../images/svg-icon/color-svg/007-color-palette.svg" class="h-30 align-self-center" alt="" >
								</div>							
							</div>
							
							<a href="#" class="text-dark fw-600 hover-primary fs-18">
								Lorem Ipsum is simply dummy<br>
								Printing
							</a>
							<p class="fs-16 mt-15">
								There are many variations of passages.<br>
								Lorem Ipsum available<br>
								but the majority.
							</p>
						</div>							
						<div class="d-flex flex-column mt-10">
							<div class="d-flex">
								<a href="#" class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
									<img src="../images/avatar/avatar-1.png" class="h-50 align-self-end" alt="" >
								</a>
								<a href="#" class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
									<img src="../images/avatar/avatar-3.png" class="h-50 align-self-end" alt="" >
								</a>
								<a href="#" class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center overflow-hidden">
									<img src="../images/avatar/avatar-4.png" class="h-50 align-self-end" alt="" >
								</a>
							</div>
						</div>
					</div>					
				</div>
			</div>
			  
			<div class="col-12 col-xl-4">
				<div class="box">		
					<div class="box-header no-border">
						<h4 class="box-title">Revenue Overview</h4>
						<ul class="box-controls pull-right">
						  <li class="dropdown">
							<a data-bs-toggle="dropdown" href="#" class="btn btn-success-light px-10 base-font">Export</a>
							<div class="dropdown-menu dropdown-menu-end">
							  <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
							  <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
							  <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
							  <div class="dropdown-divider"></div>
							  <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
							</div>
						  </li>
						</ul>
					</div>
					<div class="box-body py-0">	
						<div class="row">
							<div class="col-6">
								<div class="py-10">
									<div class="text-fade fw-600">Average Profit</div>
                    				<div class="fs-18 fw-600">$150K</div>
								</div>
							</div>
							<div class="col-6">
								<div class="py-10">
									<div class="text-fade fw-600">Revenue</div>
                    				<div class="fs-18 fw-600">$15,250k</div>
								</div>
							</div>
							<div class="col-6">
								<div class="py-10">
									<div class="text-fade fw-600">Taxes</div>
                    				<div class="fs-18 fw-600">$50k</div>
								</div>
							</div>
							<div class="col-6">
								<div class="py-10">
									<div class="text-fade fw-600">Yearly Income</div>
                    				<div class="fs-18 fw-600">$44,850k</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body p-0">	
						<div id="revenue4" class="text-dark"></div>
					</div>
										
				</div>
			</div>  
			<div class="col-12 col-xl-4">
				<div class="box">		
					<div class="box-header no-border">
						<h4 class="box-title">Revenue Overview</h4>
						<ul class="box-controls pull-right">
						  <li class="dropdown">
							<a data-bs-toggle="dropdown" href="#" class="btn btn-success-light px-10 base-font">Export</a>
							<div class="dropdown-menu dropdown-menu-end">
							  <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
							  <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
							  <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
							  <div class="dropdown-divider"></div>
							  <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
							</div>
						  </li>
						</ul>
					</div>
					<div class="box-body">
						
						<div id="revenue5" class="text-dark"></div>
						
						<p class="text-center fs-16 pb-20">
							Notes: There are many variations of passages <br>
							of Lorem Ipsum available.
						</p>
						<a href="#" class="btn btn-info w-p100">Generate Report</a>
					</div>										
				</div>
			</div>  
			<div class="col-12 col-xl-4">
				<div class="box">		
					<div class="box-header no-border">
						<h4 class="box-title">Revenue Overview</h4>
						<ul class="box-controls pull-right">
						  <li class="dropdown">
							<a data-bs-toggle="dropdown" href="#" class="btn btn-success-light px-10 base-font">Export</a>
							<div class="dropdown-menu dropdown-menu-end">
							  <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
							  <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
							  <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
							  <div class="dropdown-divider"></div>
							  <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
							</div>
						  </li>
						</ul>
					</div>
					<div class="box-body pt-0">
						
						<div id="revenue6" class="text-dark"></div>
						
						<div class="d-flex align-items-center mb-20">
							<div class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center">
								  <img src="../images/svg-icon/color-svg/001-glass.svg" class="h-30" alt="">
							</div>
							<div class="d-flex flex-column flex-grow-1 me-2 fw-500">
								<a href="#" class="text-dark hover-primary mb-1 fs-16">Duis faucibus lorem</a>
								<span class="text-fade">Pharetra, Nulla , Nec, Aliquet</span>
							</div>
							<span class="badge badge-xl badge-light"><span class="fw-600">+125$</span></span>
						</div>
						<div class="d-flex align-items-center mb-20">
							<div class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center">
								  <img src="../images/svg-icon/color-svg/002-google.svg" class="h-30" alt="">
							</div>
							<div class="d-flex flex-column flex-grow-1 me-2 fw-500">
								<a href="#" class="text-dark hover-danger mb-1 fs-16">Mauris varius augue</a>
								<span class="text-fade">Pharetra, Nulla , Nec, Aliquet</span>
							</div>
							<span class="badge badge-xl badge-light"><span class="fw-600">+125$</span></span>
						</div>
						<div class="d-flex align-items-center">
							<div class="me-15 bg-lightest h-50 w-50 l-h-50 rounded text-center">
								  <img src="../images/svg-icon/color-svg/003-settings.svg" class="h-30" alt="">
							</div>
							<div class="d-flex flex-column flex-grow-1 me-2 fw-500">
								<a href="#" class="text-dark hover-success mb-1 fs-16">Aliquam in magna</a>
								<span class="text-fade">Pharetra, Nulla , Nec, Aliquet</span>
							</div>
							<span class="badge badge-xl badge-light"><span class="fw-600">+125$</span></span>
						</div>
					</div>										
				</div>
			</div>
			
			<div class="col-12 col-xl-4">
				<div class="box">		
					<div class="box-header no-border">
						<h4 class="box-title">Overview</h4>
						<ul class="box-controls pull-right">
						  <li class="dropdown">
							<a data-bs-toggle="dropdown" href="#" class="btn btn-success-light px-10 base-font">Export</a>
							<div class="dropdown-menu dropdown-menu-end">
							  <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
							  <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
							  <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
							  <div class="dropdown-divider"></div>
							  <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
							</div>
						  </li>
						</ul>
					</div>
					<div class="box-body">	
						<div id="revenue7" class="text-dark"></div>
					</div>
					<div class="box-body py-0">	
						<div class="row pt-50">
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-primary-light h-50 w-50 l-h-60 rounded text-center">
										  <span class="icon-Library fs-24"><span class="path1"></span><span class="path2"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-primary mb-1 fs-16">Project Briefing</a>
										<span class="text-fade">Project Manager</span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-danger-light h-50 w-50 l-h-60 rounded text-center">
										<span class="icon-Write fs-24"><span class="path1"></span><span class="path2"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-danger mb-1 fs-16">Concept Design</a>
										<span class="text-fade">Art Director</span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-success-light h-50 w-50 l-h-60 rounded text-center">
										<span class="icon-Group-chat fs-24"><span class="path1"></span><span class="path2"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-success mb-1 fs-16">Functional Logics</a>
										<span class="text-fade">Lead Developer</span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-info-light h-50 w-50 l-h-60 rounded text-center">
										<span class="icon-Attachment1 fs-24"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-info mb-1 fs-16">Development</a>
										<span class="text-fade">DevOps</span>
									</div>
								</div>
							</div>
						</div>
					</div>										
				</div>
			</div>
			<div class="col-12 col-xl-4">
				<div class="box">		
					<div class="box-header no-border">
						<h4 class="box-title">Overview</h4>
						<ul class="box-controls pull-right">
						  <li class="dropdown">
							<a data-bs-toggle="dropdown" href="#" class="btn btn-success-light px-10 base-font">Export</a>
							<div class="dropdown-menu dropdown-menu-end">
							  <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
							  <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
							  <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
							  <div class="dropdown-divider"></div>
							  <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
							</div>
						  </li>
						</ul>
					</div>
					<div class="box-body">	
						<div class="row pt-50">
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-primary-light h-50 w-50 l-h-60 rounded text-center">
										  <span class="icon-Library fs-24"><span class="path1"></span><span class="path2"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-primary mb-1 fs-16">Project Briefing</a>
										<span class="text-fade">Project Manager</span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-danger-light h-50 w-50 l-h-60 rounded text-center">
										<span class="icon-Write fs-24"><span class="path1"></span><span class="path2"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-danger mb-1 fs-16">Concept Design</a>
										<span class="text-fade">Art Director</span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-success-light h-50 w-50 l-h-60 rounded text-center">
										<span class="icon-Group-chat fs-24"><span class="path1"></span><span class="path2"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-success mb-1 fs-16">Functional Logics</a>
										<span class="text-fade">Lead Developer</span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-info-light h-50 w-50 l-h-60 rounded text-center">
										<span class="icon-Attachment1 fs-24"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-info mb-1 fs-16">Development</a>
										<span class="text-fade">DevOps</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body p-0">	
						<div id="revenue8" class="text-dark"></div>
					</div>
										
				</div>
			</div>
            <div class="col-12 col-xl-4">
				<div class="box">		
					<div class="box-header no-border">
						<h4 class="box-title">Overview</h4>
						<ul class="box-controls pull-right">
						  <li class="dropdown">
							<a data-bs-toggle="dropdown" href="#" class="btn btn-success-light px-10 base-font">Export</a>
							<div class="dropdown-menu dropdown-menu-end">
							  <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
							  <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
							  <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
							  <div class="dropdown-divider"></div>
							  <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
							</div>
						  </li>
						</ul>
					</div>
					<div class="box-body">	
						<div class="row pt-50">
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-primary-light h-50 w-50 l-h-60 rounded text-center">
										  <span class="icon-Library fs-24"><span class="path1"></span><span class="path2"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-primary mb-1 fs-16">Project Briefing</a>
										<span class="text-fade">Project Manager</span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-danger-light h-50 w-50 l-h-60 rounded text-center">
										<span class="icon-Write fs-24"><span class="path1"></span><span class="path2"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-danger mb-1 fs-16">Concept Design</a>
										<span class="text-fade">Art Director</span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-success-light h-50 w-50 l-h-60 rounded text-center">
										<span class="icon-Group-chat fs-24"><span class="path1"></span><span class="path2"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-success mb-1 fs-16">Functional Logics</a>
										<span class="text-fade">Lead Developer</span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="d-flex align-items-center mb-30">
									<div class="me-15 bg-info-light h-50 w-50 l-h-60 rounded text-center">
										<span class="icon-Attachment1 fs-24"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
									</div>
									<div class="d-flex flex-column fw-500">
										<a href="#" class="text-dark hover-info mb-1 fs-16">Development</a>
										<span class="text-fade">DevOps</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body p-0">	
						<div id="revenue8" class="text-dark"></div>
					</div>
										
				</div>
			</div>
		
			<!-- /.col -->

		  </div>
            <!-- /.row -->
		</section>
            <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
     <script>
    // function UpdateStatusTicket(idticket){
        
    //     var element=document.getElementById('ticket'+idticket);
	// 	var idx=element.selectedIndex;
	// 	var val=element.options[idx].value;
	// 	var content=element.options[idx].innerHTML;
	// 	val=parseInt(val);
	// 	var selectoption="";
	// 	if(val == 2){
	// 		selectoption="btn-success-light rounded";
	// 	}
	// 	else if(val == 1){
	// 		selectoption="btn-danger-light rounded ";
	// 	}
	// 	else if(val==3){
	// 		selectoption="btn-warning-light rounded";
	// 	}
    //     else{
    //        selectoption= "btn-info-light rounded";
    //     }


    //         $.ajax({
    //         url:'https://www.yestravaux.com/webservice/crm/campaign.php',
    //         type: "POST",
    //         dataType: "html",
    //         data: {fct:'UpdateTicketStatus',ticket_id:idticket,status_ticket:parseInt(val)},
    //         async: true,
    //         success:function(data){	
    //             console.log(data);
    //             data=JSON.parse(data);
    //             if(data.result=="ok"){
    //             element.className=selectoption;
    //             element.options[idx].selected='selected';
    //             $.toast({
    //             heading: 'Félicitations',
    //             text: 'Le statue de ticket est modifié avec succès.',
    //             position: 'top-right',
    //             loaderBg: '#ff6849',
    //             icon: 'success',
    //             hideAfter: 5000
    //             });
    //             }
                

    //         }
    //     });
    //         }




    
    </script> 