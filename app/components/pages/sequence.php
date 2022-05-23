
<?php

session_start();
if(!isset($_SESSION["PK_USER"])){

	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
  
  }
  
$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
$POSTVALUE  = 'fct=AddCampaign&user_id=1';
$dataSequence = curl_do_post($URL,$POSTVALUE); 
$dataSequence = json_decode($dataSequence);
$dataSequence = (array) $dataSequence;
?>
	 <div class="container-full">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Campagne</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Sequence</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>	  

		<!-- Main content -->
		<section class="content">

         	<div class="row">

         		<div class="col-10 mx-auto">
         			<div class="row">
         				<div class="col-3 connectedSortable" id="container-1">

							<ul class="todo-list" id="tablist">
								<li class="p-15">
								  <div class="box p-15 mb-0 d-block bb-2 border-danger">
									  <span class="handle">
										<i class="fa fa-ellipsis-v"></i>
										<i class="fa fa-ellipsis-v"></i>
									  </span>
									  <span class="fs-18 text-line"><a id="Test-1" class="showSingle" href="#Style1">Nulla vitae purus</a> </span>
								  </div>
								  <div class="mt-5 box">
									  	<div class="box-body mb-0 pt-10 pb-10 pe-5 ps-5 d-block text-center" style="display: inline-block;">
										  <h6 class="text-line" style="display: inline-block;">Wait for  
										  	<input class="form-control" type="number" name="number" placeholder="" style="width: 25%;display: inline-block;">  days, then
										  </h6>
									  </div>
								  </div>
								</li>
								<li class="p-15">
								  <div class="box p-15 mb-0 d-block bb-2 border-warning">
									  <span class="handle">
										<i class="fa fa-ellipsis-v"></i>
										<i class="fa fa-ellipsis-v"></i>
									  </span>
									  <span class="fs-18 text-line"><a id="Test-2" class="showSingle" href="#Style2">Maecenas scelerisque</a> </span>
								  </div>
								  <div class="mt-5 box">
									  	<div class="box-body mb-0 pt-10 pb-10 pe-5 ps-5 d-block text-center" style="display: inline-block;">
										  <h6 class="text-line" style="display: inline-block;">Wait for 
										  	<input class="form-control" type="number" name="number" placeholder="" style="width: 25%;display: inline-block;"> days, then
										  </h6>
									  </div>
								  </div>
								</li>
								<li class="p-15">
								  <div class="box p-15 mb-0 d-block bb-2 border-secondary">
									  <span class="handle">
										<i class="fa fa-ellipsis-v"></i>
										<i class="fa fa-ellipsis-v"></i>
									  </span>
									  <span class="fs-18 text-line"><a id="Test-3" class="showSingle" href="#Style3">Vivamus nec orci</a> </span>
								  </div>
								  <div class="mt-5 box">
									  	<div class="box-body mb-0 pt-10 pb-10 pe-5 ps-5 d-block text-center" style="display: inline-block;">
										  <h6 class="text-line" style="display: inline-block;">Wait for 
										  	<input class="form-control" type="number" name="number" placeholder="" style="width: 25%;display: inline-block;"> days, then
										  </h6>
									  </div>
								  </div>
								</li>
							</ul>
							<ul  class="todo-list">
								<li  class="p-15"><button type="button" class="waves-effect waves-light btn btn-outline btn-secondary mb-5" id="Add_Step">Add a new step</button></li>
							</ul>
		         		</div>
		         		
		         		<div class="col-9" id="tab-content">

		         			<div id="Style1" class="box targetDiv" >
		         				<div  class="box-body">

		         					<div  class="row col-8 mx-auto" >
		         						<div id="SelectChoice">
										<div class="col-6">
											<a id="But-1" class="info-box pull-up" href="">
												<span class="info-box-icon bg-info rounded"><i class="ti-email"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">MAIL</span>
												  
												</div>
											</a>
										</div>
										<div class="col-6">
											<a id="But-2" class="info-box pull-up" href="">
												<span class="info-box-icon bg-warning rounded"><i class="ti-comment-alt"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">SMS</span>
												  
												</div>
											</a>
										</div>
										<div class="col-6">
											<a  id="But-3" class="info-box pull-up" href="">
												<span class="info-box-icon bg-danger rounded"><i class="mdi mdi-phone-in-talk"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">CALL</span>
												  
												</div>
											</a>
										</div>
										<div class="col-6">
											<a  id="But-4" class="info-box pull-up" href="">
												<span class="info-box-icon bg-dark  rounded"><i class="ti-list"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">TASK</span>
												  
												</div>
											</a>
										</div>
										</div>

										<div id="Form-1" class="row" style="display: none;">
											<div class="p-15">
												<div class="form-group">
													<input class="form-control" placeholder="Sender:">
											  	</div>
											  	<div class="form-group">
													<input class="form-control" placeholder="Subject:">
											  	</div>
											  	<div class="form-group">
													<textarea id="editor1" name="editor1" rows="10" cols="80">
															This is my textarea to be replaced with CKEditor.
													</textarea>
											  	</div>
											  	<div class="form-group">
													<select class="form-select">
														<option>Langue</option>
														<option>Français</option>
														<option>Anglais</option>
														<option>Bulgare</option>
													</select>
												</div>
												<div class="form-group box-footer text-end">
													<button type="button" class="waves-effect waves-light btn btn-info mb-5">Enregistrer</button>
												</div>
											</div>
										</div>

										<div id="Form-2" class="row" style="display: none;">
											<div class="p-15">
												<div class="form-group">
													<input class="form-control" placeholder="Sender:">
											  	</div>
											  	<div class="form-group">
													<textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
											  	</div>
											  	<div class="form-group">
													<select class="form-select">
														<option>Langue</option>
														<option>Français</option>
														<option>Anglais</option>
														<option>Bulgare</option>
													</select>
												</div>
												<div class="form-group box-footer text-end">
													<button type="button" class="waves-effect waves-light btn btn-info mb-5">Enregistrer</button>
												</div>
											</div>
										</div>
										<div id="Form-3" class="row" style="display: none;"></div>
										<div id="Form-4" class="row" style="display: none;"></div>
									</div>

		         				</div>
		         			</div>

		         			<div id="Style2" class="box targetDiv" >
		         				<div  class="box-body">

		         					<div  class="row col-8 mx-auto" >
		         						<div id="SelectChoice">
										<div class="col-6">
											<a id="But-5" class="info-box pull-up" href="">
												<span class="info-box-icon bg-info rounded"><i class="ti-email"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">MAIL</span>
												  
												</div>
											</a>
										</div>
										<div class="col-6">
											<a id="But-6" class="info-box pull-up" href="">
												<span class="info-box-icon bg-warning rounded"><i class="ti-comment-alt"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">SMS</span>
												  
												</div>
											</a>
										</div>
										<div class="col-6">
											<a  id="But-7" class="info-box pull-up" href="">
												<span class="info-box-icon bg-danger rounded"><i class="mdi mdi-phone-in-talk"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">CALL</span>
												  
												</div>
											</a>
										</div>
										<div class="col-6">
											<a  id="But-8" class="info-box pull-up" href="">
												<span class="info-box-icon bg-dark  rounded"><i class="ti-list"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">TASK</span>
												  
												</div>
											</a>
										</div>
										</div>

										<div id="Form-5" class="row" style="display: none;">
											<div class="p-15">
												<div class="form-group">
													<input class="form-control" placeholder="Sender:">
											  	</div>
											  	<div class="form-group">
													<input class="form-control" placeholder="Subject:">
											  	</div>
											  	<div class="form-group">
													<textarea id="editor1" name="editor1" rows="10" cols="80">
															This is my textarea to be replaced with CKEditor.
													</textarea>
											  	</div>
											  	<div class="form-group">
													<select class="form-select">
														<option>Langue</option>
														<option>Français</option>
														<option>Anglais</option>
														<option>Bulgare</option>
													</select>
												</div>
												<div class="form-group box-footer text-end">
													<button type="button" class="waves-effect waves-light btn btn-info mb-5">Enregistrer</button>
												</div>
											</div>
										</div>

										<div id="Form-6" class="row" style="display: none;">
											<div class="p-15">
												<div class="form-group">
													<input class="form-control" placeholder="Sender:">
											  	</div>
											  	<div class="form-group">
													<textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
											  	</div>
											  	<div class="form-group">
													<select class="form-select">
														<option>Langue</option>
														<option>Français</option>
														<option>Anglais</option>
														<option>Bulgare</option>
													</select>
												</div>
												<div class="form-group box-footer text-end">
													<button type="button" class="waves-effect waves-light btn btn-info mb-5">Enregistrer</button>
												</div>
											</div>
										</div>
										<div id="Form-7" class="row" style="display: none;"></div>
										<div id="Form-8" class="row" style="display: none;"></div>
									</div>

		         				</div>
		         			</div>

		         			<div id="Style3" class="box targetDiv" >
		         				<div  class="box-body">

		         					<div  class="row col-8 mx-auto" >
		         						<div id="SelectChoice">
										<div class="col-6">
											<a id="But-1" class="info-box pull-up" href="">
												<span class="info-box-icon bg-info rounded"><i class="ti-email"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">MAIL</span>
												  
												</div>
											</a>
										</div>
										<div class="col-6">
											<a id="But-2" class="info-box pull-up" href="">
												<span class="info-box-icon bg-warning rounded"><i class="ti-comment-alt"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">SMS</span>
												  
												</div>
											</a>
										</div>
										<div class="col-6">
											<a  id="But-3" class="info-box pull-up" href="">
												<span class="info-box-icon bg-danger rounded"><i class="mdi mdi-phone-in-talk"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">CALL</span>
												  
												</div>
											</a>
										</div>
										<div class="col-6">
											<a  id="But-4" class="info-box pull-up" href="">
												<span class="info-box-icon bg-dark  rounded"><i class="ti-list"></i></span>
												<div class="info-box-content">
												  <span class="info-box-number">TASK</span>
												  
												</div>
											</a>
										</div>
										</div>

										<div id="Form-1" class="row" style="display: none;">
											<div class="p-15">
												<div class="form-group">
													<input class="form-control" placeholder="Sender:">
											  	</div>
											  	<div class="form-group">
													<input class="form-control" placeholder="Subject:">
											  	</div>
											  	<div class="form-group">
													<textarea id="editor1" name="editor1" rows="10" cols="80">
															This is my textarea to be replaced with CKEditor.
													</textarea>
											  	</div>
											  	<div class="form-group">
													<select class="form-select">
														<option>Langue</option>
														<option>Français</option>
														<option>Anglais</option>
														<option>Bulgare</option>
													</select>
												</div>
												<div class="form-group box-footer text-end">
													<button type="button" class="waves-effect waves-light btn btn-info mb-5">Enregistrer</button>
												</div>
											</div>
										</div>

										<div id="Form-2" class="row" style="display: none;">
											<div class="p-15">
												<div class="form-group">
													<input class="form-control" placeholder="Sender:">
											  	</div>
											  	<div class="form-group">
													<textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
											  	</div>
											  	<div class="form-group">
													<select class="form-select">
														<option>Langue</option>
														<option>Français</option>
														<option>Anglais</option>
														<option>Bulgare</option>
													</select>
												</div>
												<div class="form-group box-footer text-end">
													<button type="button" class="waves-effect waves-light btn btn-info mb-5">Enregistrer</button>
												</div>
											</div>
										</div>
										<div id="Form-3" class="row" style="display: none;"></div>
										<div id="Form-4" class="row" style="display: none;"></div>
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
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	  <script type="text/javascript">

	  	$("#tab-content > div").hide();

		$("#container-1 a[href]").click(function(){

			$("#tab-content " + $(this).attr("href")).show().siblings().hide();

		});

		$(function() {

	       $('#But-1').click(function() {
	       	
	       		$('#Form-1').show();
	       		$('#Form-2').hide();
	       		$('#Form-3').hide();
	            $('#Form-4').hide();
	            return false;
	       });    

	       $('#But-2').click(function() {
	         	
	       		$('#Form-1').hide();
	            $('#Form-2').show();
	       		$('#Form-3').hide();
	            $('#Form-4').hide();
	           return false;
	       }); 

	       $('#But-3').click(function() {
	         
	       		$('#Form-1').hide();
	       		$('#Form-2').hide();
	            $('#Form-3').show();
	            $('#Form-4').hide();
	           return false;
	       }); 

	       $('#But-4').click(function() {
	         
	       		$('#Form-1').hide();
	       		$('#Form-2').hide();
	       		$('#Form-3').hide();
	            $('#Form-4').show();	            
	           return false;
	       });  

	       $('#But-5').click(function() {
	       	
	       		$('#Form-5').show();
	       		$('#Form-6').hide();
	       		$('#Form-7').hide();
	            $('#Form-8').hide();
	            return false;
	       });    

	       $('#But-6').click(function() {
	         	
	       		$('#Form-5').hide();
	            $('#Form-6').show();
	       		$('#Form-7').hide();
	            $('#Form-8').hide();
	           return false;
	       }); 

	       $('#But-7').click(function() {
	         
	       		$('#Form-5').hide();
	       		$('#Form-6').hide();
	            $('#Form-7').show();
	            $('#Form-8').hide();
	           return false;
	       }); 

	       $('#But-8').click(function() {
	         
	       		$('#Form-5').hide();
	       		$('#Form-6').hide();
	       		$('#Form-7').hide();
	            $('#Form-8').show();	            
	           return false;
	       });    
	    });

		
	  	$(function () {
	  		$('#Add_Step').click( function(){

		    	var tabs = $("#container-1").tab();
		    	var tabCounter = tabs.find('ul').first().children().length;
		    	var Contents = $("#tab-content").tab();
		        var ul = tabs.find( "ul#tablist" );
		       
		        $('<li class="p-15"><div class="box p-15 mb-0 d-block bb-2 border-danger"><span class="handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span><span class="fs-18 text-line"><a id="Test-' + ++tabCounter + '" class="showSingle" href="#Style' + tabCounter + '">Nulla vitae purus</a> </span></div><div class="mt-5 box"><div class="box-body mb-0 pt-10 pb-10 pe-5 ps-5 d-block text-center" style="display: inline-block;"><h6 class="text-line" style="display: inline-block;">Wait for <input class="form-control" type="number" name="number" placeholder="" style="width: 25%;display: inline-block;"> days, then </h6></div></div></li>').appendTo( ul );

		        $( '<div class="box targetDiv" id="Style' + tabCounter + '" ><div  class="box-body">'+ tabCounter +' <span>New</span></div></div>' ).appendTo( Contents );


		        $("#tab-content > div").hide();

		        $("#container-1 a[href]").click(function(){

					$("#tab-content " + $(this).attr("href")).show().siblings().hide();

				});
		    });

		  


		});
	  </script>
