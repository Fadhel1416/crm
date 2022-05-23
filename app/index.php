<?php 
// Include router class
include('commun.inc.php');
include('config.inc.php');
include('components/uncludes/header.php');
session_start();
if(!isset($_SESSION['PK_USER'])&& !isset($_SESSION['K_KEY'])){

	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
}
else{
	$URL='https://www.yestravaux.com/webservice/crm/Auth.php';
	$POSTVALUE  = 'fct=UserProfil&pk_user='.$_SESSION['PK_USER'].'&kkey='.$_SESSION[ 'K_KEY'];
	$connectedUser = curl_do_post($URL, $POSTVALUE);
	$connectedUser = json_decode($connectedUser);
	$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
	$POSTVALUE= "fct=GetInvitedUsers&PK_USER=".$_SESSION['PK_USER'];
	//echo $URLP."?".$POSTVALUE;die();
	$resultat2 = curl_do_post($URLP,$POSTVALUE);
	$invited_users= (array)json_decode($resultat2, true);
	if($connectedUser->S_IMAGE !=null){
		$urlimage="https://www.yestravaux.com/pro/manager/photos/".$connectedUser->S_IMAGE;}
		else{
			$urlimage="../images/Guest2.png";
		
		}
}
?>

	<body class="hold-transition light-skin sidebar-mini theme-fruit fixed">
	<div class="wrapper">
	<div id="loader"></div>
	<div class="art-bg">
		<img src="../images/art1.svg" alt="" class="art-img light-img">
		<img src="../images/art2.svg" alt="" class="art-img dark-img">
	</div>
	<header class="main-header" id="headerid">
		<div class="d-flex align-items-center logo-box justify-content-center" >	
			<!-- Logo -->
			<a href="index.html" class="logo">
			<!-- logo-->
			<div class="logo-mini w-30">
				<span class="light-logo"><img src="../images/logo-letter.png" alt="logo"></span>
				<span class="dark-logo"><img src="../images/logo-letter.png" alt="logo"></span>
			</div>
			<div class="logo-lg">
				<span class="light-logo"><img src="../images/logo-dark-text3.png" alt="logo"></span>
				<span class="dark-logo"><img src="../images/logo-light-text2.png" alt="logo"></span>
			</div>
			</a>	
		</div>  
		<!-- Header Navbar -->
		<nav class="navbar navbar-static-top" id="navid">
		<!-- Sidebar toggle button-->
		<div class="app-menu">
			<ul class="header-megamenu nav" style="position:fixed;top:3px;">
				<li class="btn-group nav-item">
					<a href="#" class="waves-effect waves-light nav-link push-btn btn-outline no-border btn-primary-light text-white" data-toggle="push-menu" role="button">
						<i data-feather="align-left"></i>
					</a>
				</li>
				<li>
				
				</li>
								
				<li class="btn-group d-lg-inline-flex d-none">
				
					<div class="app-menu">
						<div class="search-bx mx-5">
							<form>
								<div class="input-group">

								<input type="search" class="form-ontrol" placeholder="Chercher Lead" id="input-search2" onClick="FunctionVerif()" onkeyup="FindLead();" aria-label="Search" aria-describedby="button-addon2">
								
								<div class="input-group-append">
									<button class="btn" type="submit" id="button-addon3"><i data-feather="search"></i></button>
									
								</div>
			
								
								
								</div>
								
							
								</div>
								<span class="myuser-list2" id="user-list2">
							
							</span>
								
							</form>
							
						
			
					</div>

					
					
				</li>
				
			
				<li class="btn-group nav-item d-none d-xl-inline-block" id="id-btn1">
					<a href="contact_app_chat.html" class="waves-effect waves-light nav-link btn-outline no-border svg-bt-icon btn-info-light text-white" title="Chat">
						<i data-feather="message-circle"></i>
					</a>
				</li>
				<li class="btn-group nav-item d-none d-xl-inline-block" id="id-btn2">
					<a href="mailbox.html" class="waves-effect waves-light nav-link btn-outline no-border svg-bt-icon btn-danger-light text-white" title="Mailbox">
						<i data-feather="at-sign"></i>
					</a>
				</li>
				<li class="btn-group nav-item d-none d-xl-inline-block" id="id-btn3"> 
					<a href="extra_taskboard.html" class="waves-effect waves-light btn-outline no-border nav-link svg-bt-icon btn-success-light text-white" title="Taskboard">
						<i data-feather="clipboard"></i>
					</a>
				</li>
			</ul> 
		</div>
			
<div class="navbar-custom-menu r-side">
	<ul class="nav navbar-nav ">		 
		<li class="btn-group nav-item d-none d-xl-inline-block">
			<a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link btn-outline no-border full-screen btn-warning-light text-white" title="Full Screen">
				<i data-feather="maximize"></i>
			</a>
		</li>
	<!-- Notifications -->
	

	<li class="dropdown notifications-menu" id="notifications">
		<a href="#" id="functionnoti"  class="dropdown-toggle btn-outline no-border btn-info-light text-white"  data-bs-toggle="dropdown">
	<span id="idcountnoti" class="btn-sm label-pill  count"></span><i data-feather="bell"></i> 
		</a>
		<ul class="dropdown-menu animated bounceIn">

		

		<li class="header">
				<div class="p-20">
					<div class="flexbox">
						<div>
							<h4 class="mb-0 mt-0">Notifications</h4>
							

						</div>
						<div>
							<a href="index.php?page=SeeAllNotification" class="text-danger" id="nbnotification">Voir Tout</a>
						</div>
					</div>
					<div class="flexbox">
							<a class="flexbox-a" href="#">Vous avez <span id="totalNotifications"></span> notifications</a>
					</div>
					</div>
				</li>

				<li>
					<!-- inner menu: contains the actual data -->
					<ul class="menu sm-scrol" id="dropdownoti">
					
					</ul>
				</li>
				<li class="footer">
					<a href="#" onClick="Mark_Notification_As_Seen()">Marquer tout comme vu</a>
				</li>
				</ul>
			</li>	
			
			<!-- User Account-->
			<li class="dropdown user user-menu">
            <a href="#" class="waves-effect waves-light dropdown-toggle no-border p-5 text-white" data-bs-toggle="dropdown" title="User">
				<img class="avatar avatar-pill" src="../images/logo-letter.png" alt="">
            </a>
            <ul class="dropdown-menu animated flipInX">
				<li class="user-body">
					<a class="dropdown-item" href="?page=profile"><i class="ti-user text-muted me-2"></i> Profile</a>
					<!--a class="dropdown-item" href="#"><i class="ti-wallet text-muted me-2"></i> My Wallet</a-->
					<!--a class="dropdown-item" href="#"><i class="ti-settings text-muted me-2"></i> Settings</a-->
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="?page=logout"><i class="ti-lock text-muted me-2"></i>Se Déconnecter</a>
				</li>
				</ul>
			</li>			  
			<!-- Control Sidebar Toggle Button -->
			<li>
				<a href="#" data-toggle="control-sidebar" title="Setting" class="waves-effect waves-light btn-outline no-border btn-danger-light text-white">
					<i data-feather="settings"></i>
				</a>
			</li>
				
			</ul>
		</div>
    </nav>
	<!--nav class="navbar navbar-static-top" style="margin-left:50px;">
	<div class="app-menu">
		<ul class="header-megamenu nav">
		
			<li class="btn-group d-lg-inline-flex d-none">
			
				<div class="app-menu">
					

			
				
			</li>
</ul>
</div>
</nav-->
	</header>
	
	<aside class="main-sidebar"  id="sidebarid">
	
		<div class="user-profile">
			<div class="profile-pic">
				<img src="<?php echo $urlimage ?>" alt="user">	
				<div class="profile-info"><h4><?php echo $connectedUser->S_NAME;?></h4>
					<div class="list-icons-item dropdown">
						<a href="?page=LogDetail" class="list-icons-item  btn-rounded btn-sm btn-info">Log Detail</a>
						<!--div class="dropdown-menu">
							<a href="?page=LogDetail" class="dropdown-item">Detailed log</a>
						</div-->
					</div>
				</div>
			</div>
		</div>
    <!-- sidebar-->
    <section class="sidebar position-relative">	
			<div class="multinav">
			<div class="multinav-scroll" style="height: 100%;">	
				<!-- sidebar menu-->
				<ul class="sidebar-menu" data-widget="tree">	
					<li class="" id="Dashboard">
					<a href="?page=dashboard">
						<i data-feather="monitor"></i>
						<span>Dashboard</span>
					
					</a>
				
				</li>				  
				<li class="header">Campagnies & Configuration </li>

				<li class="treeview" id="task"> 
					<a href="#">
						<i data-feather="grid"></i>
						<span>Tâches</span>
						<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li ><a href="?page=task"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Tâches</a></li>
						
					</ul>
				</li>

				<li class="">
					<a href="?page=add-campagne">
						<i data-feather="cast"></i>
						<span>Companie</span>
						
					</a>
					
					</li>
					<li class="">
					<a href="?page=leads">
						<i data-feather="life-buoy"></i>
						<span>Leads</span>
					
					</a>
					</li>
					<li class="treeview"  id="rapport">
					<a href="#">
						<i data-feather="pie-chart"></i>
						<span>Rapport</span>
						<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="?page=rapport"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Rapport</a></li>
						
					</ul>
				</li>
				

			<li class="treeview"  id="user">
			
				<a href="#">
				<i data-feather="users"></i>
				<span>Utilisateurs</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-right pull-right"></i>
				</span>
				</a>
				<ul class="treeview-menu" id="UserUpdateRole">
				<?php if($connectedUser->FK_ROLE!=2 && $connectedUser->FK_ROLE!=3){?>	
					<li><a href="?page=User_Invits"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Listes Utilisateurs</a>	
					<?php }?>
				
			
				</li>
				<?php  

				$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
					$POSTVALUE= "fct=GetInvitedUsers&PK_USER=".$_SESSION['PK_USER'];
					//echo $URLP."?".$POSTVALUE;die();
					$resultat2 = curl_do_post($URLP,$POSTVALUE);
					$invited_users= (array)json_decode($resultat2, true);

				?>
					<?php for($i=0;$i<count($invited_users);$i++){
						if($invited_users[$i]['S_IMAGE']!=null){
							$urlimage="https://www.yestravaux.com/pro/manager/photos/".$invited_users[$i]['S_IMAGE'];}
							else{
								$urlimage="../images/Guest2.png";
							
							}
							if($invited_users[$i]['FK_ROLE']==2)
							{
								$role="Admin";
								$class="bg-gradient-grey rounded";
							}
							else{
								$role="User";
								$class="bg-gradient-ubuntu rounded";
							}
							
							?>		
						
							<li style="margin-left:20px"><img src="<?php echo $urlimage;?>" class="rounded" width="20" height="20">
							<span style="padding-left:2px;height:50px" class="text-info"><?php echo $invited_users[$i]['S_NAME'];?></span>
							<span style="margin-top:50px;font-size:11px" class="text-white <?php echo $class;?>"><?php echo $role;?></span>

						</li>
							
							<?php }?>
							
					
					</ul>
					</li>
				
					<?php if($connectedUser->FK_USER_PRINCIPAL==null || $connectedUser->FK_ROLE==2){?>
					<!--li class="">
					<a href="?page=User_Invits">
						<i data-feather="users"></i>
						<span>Utilisateurs</span>
					
					</a>
                </li-->
				<?php }?>
				<li class="header">Support </li>

				<li class="treeview">
					<a href="#">
						<i data-feather="inbox"></i>
						<span>Tickets et Chat</span>
						<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="contact_app_chat.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Chat App</a></li>
						<li><a href="?page=tickets"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Tickets</a></li>
					</ul>
					</li>
					
					<li class="header">Documentation et API </li>

					<li class="treeview">
					<a href="#">
						<i data-feather="edit"></i>
						<span>API</span>
						<span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="?page=CleApi"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Clé API</a></li>
						<li><a href="?page=documentation" target="_blank"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Doc</a></li>
						<li><a href="#" target="_blank"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Code Exemples</a></li>
					</ul>
					</li>

					
							
				</ul>
				
				<div class="sidebar-widgets">				
				<div class="copyright text-start m-25">
					<p style="bottom: 0;"><strong class="d-block">Crm Admin Dashboard</strong> © 2021Tous les droits sont réservés</p>
					</div>
				</div>
			</div>
			</div>
		</section>
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<?php
	session_start();
	?>

		<?php include('route.php'); ?>
	</div>
	<!-- /.content-wrapper -->
	<footer class="main-footer">
		<!--div class="pull-right d-none d-sm-inline-block">
			<ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
			<li class="nav-item">
				<a class="nav-link" href="javascript:void(0)">FAQ</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Purchase Now</a>
			</li>
			</ul>
		</div-->
		
	</footer>

	<!-- Control Sidebar -->
	<aside class="control-sidebar">
		
	<div class="rpanel-title"><span class="pull-right btn btn-circle btn-danger"><i class="ion ion-close text-white" data-toggle="control-sidebar"></i></span> </div>  <!-- Create the tabs -->
    <ul class="nav nav-tabs control-sidebar-tabs">
		<li class="nav-item"><a href="#control-sidebar-home-tab" data-bs-toggle="tab" class=""><i class="mdi mdi-message-text"></i></a></li>
		<li class="nav-item"><a href="#control-sidebar-settings-tab" data-bs-toggle="tab"><i class="mdi mdi-playlist-check"></i></a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
		<!-- Home tab content -->
		<div class="tab-pane" id="control-sidebar-home-tab">
			<div class="flexbox">
				<a href="#" class="text-grey">
					<i class="ti-more"></i>
				</a>	
				<p>Users</p>
				<a href="#" class="text-end text-grey"><i class="ti-plus"></i></a>
			</div>
			<div class="lookup lookup-sm lookup-right d-none d-lg-block">
				<input type="text" name="s" placeholder="Chercher lead par id" class="w-p100">
			</div>
			<div class="media-list media-list-hover mt-20">
				<div class="media py-10 px-0">
				<a class="avatar avatar-lg status-success" href="#">
					<img src="../images/avatar/1.jpg" alt="...">
				</a>
				<div class="media-body">
					<p class="fs-16">
					<a class="hover-primary" href="#"><strong>Tyler</strong></a>
					</p>
					<p>Praesent tristique diam...</p>
					<span>Just now</span>
				</div>
				</div>

				<div class="media py-10 px-0">
				<a class="avatar avatar-lg status-danger" href="#">
					<img src="../images/avatar/2.jpg" alt="...">
				</a>
				<div class="media-body">
					<p class="fs-16">
					<a class="hover-primary" href="#"><strong>Luke</strong></a>
					</p>
					<p>Cras tempor diam ...</p>
					<span>33 min ago</span>
				</div>
				</div>

				<div class="media py-10 px-0">
				<a class="avatar avatar-lg status-warning" href="#">
					<img src="../images/avatar/3.jpg" alt="...">
				</a>
				<div class="media-body">
					<p class="fs-16">
					<a class="hover-primary" href="#"><strong>Evan</strong></a>
					</p>
					<p>In posuere tortor vel...</p>
					<span>42 min ago</span>
				</div>
				</div>

			<div class="media py-10 px-0">
				<a class="avatar avatar-lg status-primary" href="#">
					<img src="../images/avatar/4.jpg" alt="...">
				</a>
				<div class="media-body">
					<p class="fs-16">
					<a class="hover-primary" href="#"><strong>Evan</strong></a>
					</p>
					<p>In posuere tortor vel...</p>
					<span>42 min ago</span>
				</div>
				</div>			
				
				<div class="media py-10 px-0">
				<a class="avatar avatar-lg status-success" href="#">
					<img src="../images/avatar/1.jpg" alt="...">
				</a>
				<div class="media-body">
					<p class="fs-16">
					<a class="hover-primary" href="#"><strong>Tyler</strong></a>
					</p>
					<p>Praesent tristique diam...</p>
					<span>Just now</span>
				</div>
				</div>

				<div class="media py-10 px-0">
				<a class="avatar avatar-lg status-danger" href="#">
					<img src="../images/avatar/2.jpg" alt="...">
				</a>
				<div class="media-body">
					<p class="fs-16">
					<a class="hover-primary" href="#"><strong>Luke</strong></a>
					</p>
					<p>Cras tempor diam ...</p>
					<span>33 min ago</span>
				</div>
				</div>

				<div class="media py-10 px-0">
				<a class="avatar avatar-lg status-warning" href="#">
					<img src="../images/avatar/3.jpg" alt="...">
				</a>
				<div class="media-body">
					<p class="fs-16">
					<a class="hover-primary" href="#"><strong>Evan</strong></a>
					</p>
					<p>In posuere tortor vel...</p>
					<span>42 min ago</span>
				</div>
				</div>

				<div class="media py-10 px-0">
				<a class="avatar avatar-lg status-primary" href="#">
					<img src="../images/avatar/4.jpg" alt="...">
				</a>
				<div class="media-body">
					<p class="fs-16">
					<a class="hover-primary" href="#"><strong>Evan</strong></a>
					</p>
					<p>In posuere tortor vel...</p>
					<span>42 min ago</span>
				</div>
				</div>
				
			</div>

		</div>
		<!-- /.tab-pane -->
		<!-- Settings tab content -->
		<div class="tab-pane" id="control-sidebar-settings-tab">
			<div class="flexbox">
			<a href="#" class="text-grey">
				<i class="ti-more"></i>
			</a>	
			<p>Todo List</p>
			<a href="#" class="text-end text-grey"><i class="ti-plus"></i></a>
			</div>
			<ul class="todo-list mt-20">
				<li class="py-15 px-5 by-1">
				<!-- checkbox -->
				<input type="checkbox" id="basic_checkbox_1" class="filled-in">
				<label for="basic_checkbox_1" class="mb-0 h-15"></label>
				<!-- todo text -->
				<span class="text-line">Nulla vitae purus</span>
				<!-- Emphasis label -->
				<small class="badge bg-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
				<!-- General tools such as edit or delete-->
				<div class="tools">
					<i class="fa fa-edit"></i>
					<i class="fa fa-trash-o"></i>
				</div>
				</li>
				<li class="py-15 px-5">
				<!-- checkbox -->
				<input type="checkbox" id="basic_checkbox_2" class="filled-in">
				<label for="basic_checkbox_2" class="mb-0 h-15"></label>
				<span class="text-line">Phasellus interdum</span>
				<small class="badge bg-info"><i class="fa fa-clock-o"></i> 4 hours</small>
				<div class="tools">
					<i class="fa fa-edit"></i>
					<i class="fa fa-trash-o"></i>
				</div>
				</li>
				<li class="py-15 px-5 by-1">
				<!-- checkbox -->
				<input type="checkbox" id="basic_checkbox_3" class="filled-in">
				<label for="basic_checkbox_3" class="mb-0 h-15"></label>
				<span class="text-line">Quisque sodales</span>
				<small class="badge bg-warning"><i class="fa fa-clock-o"></i> 1 day</small>
				<div class="tools">
					<i class="fa fa-edit"></i>
					<i class="fa fa-trash-o"></i>
				</div>
				</li>
				<li class="py-15 px-5">
				<!-- checkbox -->
				<input type="checkbox" id="basic_checkbox_4" class="filled-in">
				<label for="basic_checkbox_4" class="mb-0 h-15"></label>
				<span class="text-line">Proin nec mi porta</span>
				<small class="badge bg-success"><i class="fa fa-clock-o"></i> 3 days</small>
				<div class="tools">
					<i class="fa fa-edit"></i>
					<i class="fa fa-trash-o"></i>
				</div>
				</li>
				<li class="py-15 px-5 by-1">
				<!-- checkbox -->
				<input type="checkbox" id="basic_checkbox_5" class="filled-in">
				<label for="basic_checkbox_5" class="mb-0 h-15"></label>
				<span class="text-line">Maecenas scelerisque</span>
				<small class="badge bg-primary"><i class="fa fa-clock-o"></i> 1 week</small>
				<div class="tools">
					<i class="fa fa-edit"></i>
					<i class="fa fa-trash-o"></i>
				</div>
				</li>
				<li class="py-15 px-5">
				<!-- checkbox -->
				<input type="checkbox" id="basic_checkbox_6" class="filled-in">
				<label for="basic_checkbox_6" class="mb-0 h-15"></label>
				<span class="text-line">Vivamus nec orci</span>
				<small class="badge bg-info"><i class="fa fa-clock-o"></i> 1 month</small>
				<div class="tools">
					<i class="fa fa-edit"></i>
					<i class="fa fa-trash-o"></i>
				</div>
				</li>
				<li class="py-15 px-5 by-1">
				<!-- checkbox -->
				<input type="checkbox" id="basic_checkbox_7" class="filled-in">
				<label for="basic_checkbox_7" class="mb-0 h-15"></label>
				<!-- todo text -->
				<span class="text-line">Nulla vitae purus</span>
				<!-- Emphasis label -->
				<small class="badge bg-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
				<!-- General tools such as edit or delete-->
				<div class="tools">
					<i class="fa fa-edit"></i>
					<i class="fa fa-trash-o"></i>
				</div>
				</li>
				<li class="py-15 px-5">
				<!-- checkbox -->
				<input type="checkbox" id="basic_checkbox_8" class="filled-in">
				<label for="basic_checkbox_8" class="mb-0 h-15"></label>
				<span class="text-line">Phasellus interdum</span>
				<small class="badge bg-info"><i class="fa fa-clock-o"></i> 4 hours</small>
				<div class="tools">
					<i class="fa fa-edit"></i>
					<i class="fa fa-trash-o"></i>
				</div>
				</li>
				<li class="py-15 px-5 by-1">
				<!-- checkbox -->
				<input type="checkbox" id="basic_checkbox_9" class="filled-in">
				<label for="basic_checkbox_9" class="mb-0 h-15"></label>
				<span class="text-line">Quisque sodales</span>
				<small class="badge bg-warning"><i class="fa fa-clock-o"></i> 1 day</small>
				<div class="tools">
					<i class="fa fa-edit"></i>
					<i class="fa fa-trash-o"></i>
				</div>
				</li>
				<li class="py-15 px-5">
				<!-- checkbox -->
				<input type="checkbox" id="basic_checkbox_10" class="filled-in">
				<label for="basic_checkbox_10" class="mb-0 h-15"></label>
				<span class="text-line">Proin nec mi porta</span>
				<small class="badge bg-success"><i class="fa fa-clock-o"></i> 3 days</small>
				<div class="tools">
					<i class="fa fa-edit"></i>
					<i class="fa fa-trash-o"></i>
				</div>
				</li>
			</ul>
		</div>
		<!-- /.tab-pane -->
		</div>
	</aside>
	<!-- /.control-sidebar -->
	
	<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
	
	</div>
	<!-- ./wrapper -->
		
		<!-- ./side demo panel -->
		<div class="sticky-toolbar">	    
		
	    <a href="" data-bs-toggle="tooltip" data-bs-placement="left" title="Tickets" class="waves-effect waves-light btn btn-danger btn-flat mb-5 btn-sm" target="_blank">
			<span class="icon-Image"></span>
		</a>
	    <a id="chat-popup" href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="Live Chat" class="waves-effect waves-light btn btn-warning btn-flat btn-sm">
			<span class="icon-Group-chat"><span class="path1"></span><span class="path2"></span></span>
		</a>
	</div>
	<!-- Sidebar -->
		
	<div id="chat-box-body">
		<div id="chat-circle" class="waves-effect waves-circle btn btn-circle btn-lg btn-warning l-h-70">
            <div id="chat-overlay"></div>
            <span class="icon-Group-chat fs-30"><span class="path1"></span><span class="path2"></span></span>
		</div>

		<div class="chat-box">
            <div class="chat-box-header p-15 d-flex justify-content-between align-items-center">
                <div class="btn-group">
					<button class="waves-effect waves-circle btn btn-circle btn-primary-light h-40 w-40 rounded-circle l-h-45" type="button" data-bs-toggle="dropdown">
						<span class="icon-Add-user fs-22"><span class="path1"></span><span class="path2"></span></span>
					</button>
					<div class="dropdown-menu min-w-200">
                    <a class="dropdown-item fs-16" href="#">
                        <span class="icon-Color me-15"></span>
                        New Group</a>
                    <a class="dropdown-item fs-16" href="#">
                        <span class="icon-Clipboard me-15"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                        Contacts</a>
                    <a class="dropdown-item fs-16" href="#">
                        <span class="icon-Group me-15"><span class="path1"></span><span class="path2"></span></span>
                        Groups</a>
                    <a class="dropdown-item fs-16" href="#">
                        <span class="icon-Active-call me-15"><span class="path1"></span><span class="path2"></span></span>
                        Calls</a>
                    <a class="dropdown-item fs-16" href="#">
                        <span class="icon-Settings1 me-15"><span class="path1"></span><span class="path2"></span></span>
                        Settings</a>
                    <div class="dropdown-divider"></div>
					<a class="dropdown-item fs-16" href="#">
                        <span class="icon-Question-circle me-15"><span class="path1"></span><span class="path2"></span></span>
                        Help</a>
					<a class="dropdown-item fs-16" href="#">
                        <span class="icon-Notifications me-15"><span class="path1"></span><span class="path2"></span></span> 
                        Privacy</a>
					</div>
					</div>
					<div class="text-center flex-grow-1">
						<div class="text-dark fs-18">Mayra Sibley</div>
						<div>
							<span class="badge badge-sm badge-dot badge-primary"></span>
							<span class="text-muted fs-12">Active</span>
						</div>
					</div>
					<div class="chat-box-toggle">
						<button id="chat-box-toggle" class="waves-effect waves-circle btn btn-circle btn-danger-light h-40 w-40 rounded-circle l-h-45" type="button">
						<span class="icon-Close fs-22"><span class="path1"></span><span class="path2"></span></span>
                    </button>                    
                </div>
            </div>
            <div class="chat-box-body">
                <div class="chat-box-overlay">   
                </div>
                <div class="chat-logs">
                    <div class="chat-msg user">
                        <div class="d-flex align-items-center">
                            <span class="msg-avatar">
                                <img src="../images/avatar/2.jpg" class="avatar avatar-lg">
                            </span>
                            <div class="mx-10">
                                <a href="#" class="text-dark hover-primary fw-bold">Mayra Sibley</a>
                                <p class="text-muted fs-12 mb-0">2 Hours</p>
                            </div>
                        </div>
                        <div class="cm-msg-text">
                            Hi there, I'm Jesse and you?
                        </div>
                    </div>
                    <div class="chat-msg self">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="mx-10">
                                <a href="#" class="text-dark hover-primary fw-bold">You</a>
                                <p class="text-muted fs-12 mb-0">3 minutes</p>
                            </div>
                            <span class="msg-avatar">
                                <img src="../images/avatar/3.jpg" class="avatar avatar-lg">
                            </span>
                        </div>
                        <div class="cm-msg-text">
						My name is Anne Clarc.         
                        </div>        
                    </div>
                    <div class="chat-msg user">
                        <div class="d-flex align-items-center">
                            <span class="msg-avatar">
                                <img src="../images/avatar/2.jpg" class="avatar avatar-lg">
                            </span>
                            <div class="mx-10">
                                <a href="#" class="text-dark hover-primary fw-bold">Mayra Sibley</a>
                                <p class="text-muted fs-12 mb-0">40 seconds</p>
                            </div>
                        </div>
                        <div class="cm-msg-text">
                            Nice to meet you Anne.<br>How can i help you?
                        </div>
                    </div>
                </div><!--chat-log -->
            </div>
            <div class="chat-input">      
                <form>
					<input type="hidden" id="pk_user" value="<?php echo $_SESSION['PK_USER']; ?>">
					<input type="hidden" id="k_key" value="<?php echo $_SESSION['K_KEY'];?>">
                    <input type="text" id="chat-input" placeholder="Send a message..."/>
                    <button type="submit" class="chat-submit" id="chat-submit">
                        <span class="icon-Send fs-22"></span>
                    </button>
                </form>      
            </div>
		</div>
	</div>
	
<?php

include('components/uncludes/footer.php');

?>
	<script src="../assets/vendor_components/datatable/datatables.min.js"></script>
	<script>
		function load_unseen_notification(view = '')
		{
			let dropdownmenu=document.getElementById('dropdownoti');
			let countnotifications=document.getElementById('idcountnoti');
			var PK_USER=document.getElementById('pk_user').value;
			
		$.ajax({
		url:"https://www.yestravaux.com/webservice/crm/lead.php",
		method:"POST",
		data:{fct:'FetchNotifications',view:view,PK_USER:PK_USER},
		dataType:"json",
		success:function(data)
		{
			dropdownmenu.style.width="270px";
			dropdownmenu.innerHTML=data.notification;
		if(data.unseen_notification > 0)
		{
			countnotifications.className='btn-sm label-pill label-danger count';
			countnotifications.innerHTML=data.unseen_notification;
		}
		$('#totalNotifications').html(data.allnotifications);
		}
		});

		}


		$(document).ready(function(){
			$(window).on('show.bs.dropdown', function (e) {
			
			if(e.target.id =="functionnoti"){
            //update notifications status as seen 

			/*
			let countnotifications2=document.getElementById('idcountnoti');
			countnotifications2.className='btn-sm label-pill  count';
			load_unseen_notification('yes');
			countnotifications2.innerHTML='';
			*/
			}
			});
		load_unseen_notification();

		setInterval(function(){
		load_unseen_notification();
		}, 500);
	
		$(function($) {
		let url = window.location.href;
		$('.sidebar-menu li a').each(function() {
			if (this.href === url) {
			$(this).closest('li').addClass('active');
			}
		});

		$('.sidebar-menu li ul li a').each(function() {
			if (this.href === url) {
				(($(this).parent()).parent()).closest('li').addClass('treeview active menu-open');
			    $(this).closest('li').addClass('active');	
			}	
		});
});


$('#user-list2').mouseleave(function(event)
{
	var appmenu =document.querySelector('.app-menu');
	//appmenu.style.position="initial";
	var usersList = document.getElementById('user-list2');
    usersList.innerHTML='';
	

});
$('#input-search2').focus(function(event){
	var usersList = document.getElementById('user-list2');
	var nav = document.getElementById('navid');
	var menu = document.getElementById('idmenu');
	var sidebar = document.getElementById('sidebarid');
	const searchBar =document.getElementById('input-search2');
	var appmenu =document.querySelector('.header-megamenu');
	
	//appmenu.style.display="flex";

    dataleadfind={};

	let searchTerm = searchBar.value;
	if(searchTerm == ""){
		usersList.innerHTML = '';
		//menu.style.marginTop="0px";
		//sidebar.style.marginTop="auto";

	}
	let xhr3 = new XMLHttpRequest();
	xhr3.open("POST", "components/pages/IndexFindLead.php", true);
	xhr3.onload = ()=>{
	if(xhr3.readyState === XMLHttpRequest.DONE){
		if(xhr3.status === 200){
		let data = xhr3.response;
		var ss='<div class="box" style="margin-bottom:0px"><div class="box-body p-0" ><div class="bg-white text-center rounded  b-1"><h5>Aucun lead n’est disponible</h5></div></div></div>';
		if(data != ss){
		usersList.innerHTML = data;

		nav.style.marginBottom="-1040px";
		
		}			
		else{
			usersList.innerHTML = data;
			nav.style.marginBottom="-1040px";
		}

		}
	}
	}
	xhr3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	dataleadfind["searchTerm"]=searchTerm;
	//dataleadfind["idcomp"]=idcamp;
	xhr3.send("searchTermtab=" + JSON.stringify(dataleadfind));
});


});

	function Mark_Notification_As_Seen(){
		let countnotifications2=document.getElementById('idcountnoti');
		countnotifications2.className='btn-sm label-pill  count';
		load_unseen_notification('yes');
		countnotifications2.innerHTML='';
	}


		function FunctionVerif()
		{
		const searchBar =document.getElementById('input-search2');
		if(searchBar=="")
		{
			var usersList = document.getElementById('user-list2');
			userslist.innerHTML="";
		}
		}
		function FindLead(){
		const searchBar =document.getElementById('input-search2');
		var usersList = document.getElementById('user-list2');
		//var idcamp=document.getElementById('campidhidden').value;
		var menu = document.getElementById('idmenu');
		var sidebar = document.getElementById('sidebarid');
		var header = document.getElementById('headerid');
		var nav = document.getElementById('navid');
		/*var appmenu =document.querySelector('.header-megamenu');
			appmenu.style.marginTop="5px";
			appmenu.style.display="flex";*/
		dataleadfind={};

		let searchTerm = searchBar.value;
		if(searchTerm == ""){
			usersList.innerHTML = '';
			menu.style.marginTop="0px";
			sidebar.style.marginTop="auto";

		}
		else{
		let xhr3 = new XMLHttpRequest();
		xhr3.open("POST", "components/pages/IndexFindLead.php", true);
		xhr3.onload = ()=>{
		if(xhr3.readyState === XMLHttpRequest.DONE){
			if(xhr3.status === 200){
			let data = xhr3.response;
			var ss='<div class="box" style="margin-bottom:0px"><div class="box-body p-0" ><div class="bg-white text-center rounded  b-1"><h5>Aucun lead n’est disponible</h5></div></div></div>';
			if(data != ss){
			usersList.innerHTML = data;

			nav.style.marginBottom="-1050px";
			
			}			
			else{
				usersList.innerHTML = data;
				nav.style.marginBottom="-1050px";
			}

			}
		}
	}
		xhr3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		dataleadfind["searchTerm"]=searchTerm;
		//dataleadfind["idcomp"]=idcamp;
		xhr3.send("searchTermtab=" + JSON.stringify(dataleadfind));
		}

}

		$.fn.dataTable.ext.errMode = 'none';
		$('#tickets').DataTable({
		paging:true,
		order: [[ 0, "desc" ]]
		});
		$('#tickets1').DataTable({
		paging:true,
		order: [[ 0, "desc" ]]
		});
		$('#ticketsnew').DataTable({
		paging:true,
		order: [[ 0, "desc" ]]
		});
		$('#ticketsprogress').DataTable({
		paging:true,
		order: [[ 0, "desc" ]]
		});
		$('#ticketstreated').DataTable({
		paging:true,
		order: [[ 0, "desc" ]]
		});
		$('#ticketsconverted').DataTable({
		paging:true,
		order: [[ 0, "desc" ]]
		});
</script>


</body>
</html>