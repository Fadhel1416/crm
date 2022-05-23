<?php
session_start ();
include_once "../../config.inc.php";
global $sqlserver;
session_start();




if(!isset($_SESSION["PK_USER"])){

   echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";

}

$clientBrowser = $_SERVER['HTTP_USER_AGENT'];

/*if(isset($_SESSION['K_KEY']) && isset($_SESSION['PK_USER'])){
    $URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
    $POSTVALUE= "fct=UserInfo&pk_user=".$_SESSION['PK_USER']."&k_key=".$_SESSION['K_KEY'];
    //echo $URLP."?".$POSTVALUE;die();
    $resultat = curl_do_post($URLP,$POSTVALUE);
    $result= (array)json_decode($resultat, true);
}

else{
    echo "<script>window.location.href='https://yestravaux.com/crm2/app/components/pages/auth_login.php'</script>";
}*/

?>
   
  <!-- Content Wrapper. Contains page content -->
	  <div class="container-full" >
		
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Detail</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="fa fa-user"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">User</li>
								<li class="breadcrumb-item active" aria-current="page">Log</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Main content -->
		<section class="content" id="refresh-profil">

		        <?php  
				
				if(isset($_SESSION['K_KEY']) && isset($_SESSION['PK_USER'])){
					$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
					$POSTVALUE= "fct=UserInfoLog&pk_user=".$_SESSION['PK_USER']."&k_key=".$_SESSION['K_KEY'];
					//echo $URLP."?".$POSTVALUE;die();
					$resultat = curl_do_post($URLP,$POSTVALUE);
					$result= (array)json_decode($resultat, true);
                    //var_dump($result);                
				}
				else{
					echo "<script>window.location.href='https://yestravaux.com/crm2/app/components/pages/auth_login.php'</script>";
				}
                if(isset($_SESSION['K_KEY']) && isset($_SESSION['PK_USER'])){
					$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
					$POSTVALUE= "fct=UserUpdateLog&pk_user=".$_SESSION['PK_USER']."&k_key=".$_SESSION['K_KEY'];
					//echo $URLP."?".$POSTVALUE;die();
					$resultat2 = curl_do_post($URLP,$POSTVALUE);
					$result2= (array)json_decode($resultat2, true);
                   // var_dump($result2);
                    
				}
                 ?>
                 <!--form id="formforpassword">
						  
						 


						 
						 
						  <div class="form-group row">
							<div class="ms-auto col-sm-10">
							  <div class="checkbox">
								<input type="checkbox" id="basic_checkbox_1" checked="">
								<label for="basic_checkbox_1"> I agree to the</label>
								  &nbsp;&nbsp;&nbsp;&nbsp;<a href="#">Terms and Conditions</a>
							  </div>
							</div>
						  </div>
						  </form-->
		  <div class="row">
			<div class="col-12 col-lg-10 col-xl-9">
				
			  <div class="nav-tabs-custom" >
				<ul class="nav nav-tabs">
				  <li><a href="#LogConnexion" class="active" data-bs-toggle="tab">Log Connexion</a></li>
				  <li><a  href="#LogUpdate" data-bs-toggle="tab">Log Update</a></li>
				</ul>

				<div class="tab-content bg-dark  " id="dddd" style="height:550px;">

				 <div class="tab-pane active bg-dark"  id="LogConnexion" >
                <!--span class="text-white">Log connection for connected user. . . . . . . . . . . . . . . .</span-->
							  
                 <div class="box no-shadow  bg-dark ">		
                 <div class="row ">
                      <div class="col-lg-2">
                         <span class="text-primary">CONNECTION DATE</span> 
                      </div>
                      <div class="col-lg-2">
                         <span class="text-primary">IP</span> 
                      </div>
                      <div class="col-lg-8">
                         <span class="text-primary">BROWSER</span> 
                      </div>
            </div>

                    <?php
                    foreach($result as $log)
                    {
                      ?>
                      <div class="row">
                      <div class="col-lg-2">
                         <span class="text-fade"><?php echo substr($log["D_DATE_LOG_CONNEXION"],0,19) ;?></span> 
                      </div>
                      <div class="col-lg-2">
                         <span class="text-success"><?php echo $log["S_IP"] ;?></span> 
                      </div>
                      <div class="col-lg-8">
                         <span class="text-fade"><?php echo substr($log["S_USER_AGENT"],0,300) ;?></span> 
                      </div>

                      </div>
                      <?php }?>
                     

					</div>


				  </div>    
				  <!-- /.tab-pane -->

					
						
						 

				  <div class="tab-pane bg-dark" id="LogUpdate">		
				  
              <div class="box no-shadow bg-dark">		
					
              <div class="row ">
                      <div class="col-lg-2">
                         <span class="text-primary">ACTION DATE</span> 
                      </div>
                      <div class="col-lg-2">
                         <span class="text-primary">IP</span> 
                      </div>
                      <div class="col-lg-4">
                         <span class="text-primary">ACTION</span> 
                      </div>
                      <div class="col-lg-1">
                         <span class="text-primary">CAMPAIGN</span> 
                      </div>
                      <div class="col-lg-3">
                         <span class="text-primary">BROWSER</span> 
                      </div>
            </div>

                    <?php
                    foreach($result2 as $log)
                    {
                      ?>
                      <div class="row">
                      <div class="col-lg-2">
                         <span class="text-fade"><?php echo substr($log["D_DATE_LOG_CONNEXION"],0,19) ;?></span> 
                      </div>
                      <div class="col-lg-2">
                         <span class="text-success"><?php echo $log["S_IP"] ;?></span> 
                      </div>
                      <div class="col-lg-4">
                         <span class="text-fade"><?php echo $log["ACTION"] ;?></span> 
                      </div>
                      <?php if($log["ID_CAMP"] =="Not Defined"){  ?>
                      <div class="col-lg-1">
                         <span class="text-warning"><?php echo $log["ID_CAMP"] ;?></span> 
                      </div>
                      <?php }else if($log["ID_CAMP"] ==""){ ?>
                        <div class="col-lg-1">
                         <span class="text-danger">Supprimed</span> 
                      </div>
                      <?php  } else { ?>
                        <div class="col-lg-1">
                         <span class="text-warning"><?php echo $log["ID_CAMP"] ;?></span> 
                      </div>
                      <?php  }?>
                      <div class="col-lg-3">
                         <span class="text-fade"><?php echo substr($log["S_USER_AGENT"],0,100) ;?>.</span> 
                      </div>

                      </div>
                      <?php }?>                       </div>		  
				  </div>
				  <!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			  </div>
			  <!-- /.nav-tabs-custom -->
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
	
	$(document).ready(function(){
        new PerfectScrollbar('#dddd', {
            handlers: ['click-rail', 'drag-thumb', 'keyboard', 'wheel', 'touch'],
scrollingThreshold: 3000,
wheelSpeed: 3,
wheelPropagation: false,
inScrollbarLength: null,
maxScrollbarLength: null,
useBothWheelAxes: false,
suppressScrollX: true,
suppressScrollY: false,
swipeEasing: true,

scrollXMarginOffset: 0,
scrollYMarginOffset: 0

});
    });
    

</script>