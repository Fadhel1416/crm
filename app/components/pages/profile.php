<?php
session_start ();


if(!isset($_SESSION["PK_USER"])){

	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
  
  }
  
include_once "../../config.inc.php";
global $sqlserver;
$clientBrowser = $_SERVER['HTTP_USER_AGENT'];
if(isset($_REQUEST['updateInfo']))
{

    $URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
    $POSTVALUE= "fct=UpdateUserInfo&pk_user=".$_SESSION['PK_USER']."&k_key=".$_SESSION['K_KEY']."&user_name=".$_REQUEST["user_name"]."&user_email=".$_REQUEST["user_email"]."&user_tel=".$_REQUEST["user_tel"]."&browser=".$clientBrowser."";
    //echo $URLP."?".$POSTVALUE;die();
    $resultat= curl_do_post($URLP,$POSTVALUE);
    $result= (array)json_decode($resultat, true);
	var_dump($result);
}

if(isset($_SESSION['K_KEY']) && isset($_SESSION['PK_USER'])){
    $URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
    $POSTVALUE= "fct=UserInfo&pk_user=".$_SESSION['PK_USER']."&k_key=".$_SESSION['K_KEY'];
    //echo $URLP."?".$POSTVALUE;die();
    $resultat = curl_do_post($URLP,$POSTVALUE);
    $result= (array)json_decode($resultat, true);
}

else{
    echo "<script>window.location.href='https://yestravaux.com/crm2/app/components/pages/auth_login.php'</script>";
}

?>
   
  <!-- Content Wrapper. Contains page content -->
	  <div class="container-full" >
		
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Profile</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="fa fa-user"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Utilisateur</li>
								<li class="breadcrumb-item active" aria-current="page">Profile</li>
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
					$POSTVALUE= "fct=UserInfo&pk_user=".$_SESSION['PK_USER']."&k_key=".$_SESSION['K_KEY'];
					//echo $URLP."?".$POSTVALUE;die();
					$resultat = curl_do_post($URLP,$POSTVALUE);
					$result= (array)json_decode($resultat, true);
				}

				else{
					echo "<script>window.location.href='https://yestravaux.com/crm2/app/components/pages/auth_login.php'</script>";
				}
?>
			<div class="row">
				<div class="col-12 col-lg-7 col-xl-8">
					
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
					<li><a href="#userInfo" class="active" data-bs-toggle="tab">Info</a></li>
					<li><a  href="#changepassword" data-bs-toggle="tab">Mot de passe</a></li>
					<li><a href="#apikey" data-bs-toggle="tab">Clé API</a></li>
					</ul>

					<div class="tab-content">

					<div class="tab-pane active" id="userInfo">
					
					<div class="box no-shadow">		
							<form class="" action="" method="post">
							<div class="form-group row">
								<label for="inputName" class="col-sm-2 form-label">Nom</label>

								<div class="col-sm-10">
								<input type="text" class="form-control" id="name" name="user_name" value="<?php echo $result['S_NAME'];?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail" class="col-sm-2 form-label">Email</label>

								<div class="col-sm-10">
								<input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo $result['S_EMAIL'];?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputPhone" class="col-sm-2 form-label">Téléphone</label>

								<div class="col-sm-10">
								<input type="tel" class="form-control" id="tel" name="user_tel" value="<?php echo $result['S_TEL'];?>">
								</div>
							</div>
							
							
							<!--div class="form-group row">
								<div class="ms-auto col-sm-10">
								<div class="checkbox">
									<input type="checkbox" id="basic_checkbox_1" checked="">
									<label for="basic_checkbox_1"> I agree to the</label>
									&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">Terms and Conditions</a>
								</div>
								</div>
							</div-->
							<div class="form-group row">
								<div class="ms-auto col-sm-10">
								<button type="submit" class="btn btn-success" name="updateInfo">Enregister</button>
								</div>
							</div>
							</form>
						</div>


					</div>    
					<!-- /.tab-pane -->

					<div class="tab-pane" id="changepassword">			

						<div class="box no-shadow">		
							<form id="formforpassword">
							
							<div class="form-group row">
								<label for="inputpassword" class="col-sm-2 form-label">Mot de passe actuel</label>

								<div class="col-sm-10">
						<label class="form-label" for="inputError" id="errorpassword">
							</label>
								<input type="password" name="password_actuelle" class="form-control" id="password_actuelle"  placeholder="Votre mot de passe">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputpassword" class="col-sm-2 form-label">Nouveau mot de passe</label>

								<div class="col-sm-10">
								<label class="form-label" for="inputError" id="errornewpassword">
							</label>
								<input type="password" name="password" class="form-control bg-transparent" id="password" onKeyup="keyVerifPassword('password','errornewpassword','checkpassword')" placeholder="Entrez le nouveau mot de passe">
								<div class="text-success" style="margin-left:820px;margin-top:-30px" id="checkpassword"><i class="fa fa-check"></i></div>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputrepeated_password" class="col-sm-2 form-label">Confirmez mot de passe </label>

								<div class="col-sm-10">
								<label class="form-label" for="inputError" id="errorconfirmpassword">
							</label>
								<input type="password" name="confirm_password" class="form-control" id="confirm_password" onKeyup="keyVerifPassword('confirm_password','errorconfirmpassword','checkconfpassword')" placeholder="confirmez mot de passe">
								<div class="text-success" style="margin-left:820px;margin-top:-30px" id="checkconfpassword"><i class="fa fa-check"></i></div>

								</div>
							</div>
							<input type="hidden" name="user_pk" class="form-control" id="user_pk" value="<?php echo $_SESSION['PK_USER'];?>">
							<input type="hidden" name="user_key" class="form-control" id="user_key" value="<?php echo $_SESSION['K_KEY'];?>">
							<input type="hidden" name="user_browser" class="form-control" id="user_browser" value="<?php echo $clientBrowser;?>">



							
							
							<!--div class="form-group row">
								<div class="ms-auto col-sm-10">
								<div class="checkbox">
									<input type="checkbox" id="basic_checkbox_1" checked="">
									<label for="basic_checkbox_1"> I agree to the</label>
									&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">Terms and Conditions</a>
								</div>
								</div>
							</div-->
							</form>
							<div class="form-group row">
								<div class="ms-auto col-sm-10">
								<button  class="btn btn-success" name="updatePassword" id="updatePassword">Enregister</button>
								</div>
							</div>
							
					</div>

					</div>
					<!-- /.tab-pane -->

					<div class="tab-pane" id="apikey">		
					<div class="col-md-12 col-12">
					<div class="box box-solid bg-dark">
					<div class="box-header">
						Votre Clé API est:<br>
						<h6 class="box-title" id="box_key"> <?php echo substr($result['S_API_KEY'],0,100);?> . . . . </h6> <a href="#" title="Copy" class="text-white" onClick="CopyKey('<?php echo $result['S_API_KEY'];?>')"><i class="fa fa-clone" aria-hidden="true"></i></a>
					<div class="pull-right text-" id="confirmCopy"></div>
					</div>

					
					</div>
				</div>
								
					</div>
					<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.nav-tabs-custom -->
				</div>
				<!-- /.col -->		

				<div class="col-12 col-lg-5 col-xl-4">
					<div class="box box-widget widget-user">
						<!-- Add the bg color to the header using any of the bg-* classes -->
						<div class="widget-user-header bg-img bbsr-0 bber-0" style="background: url('../../../images/guesst.png') center center;" data-overlay="5">
						<h3 class="widget-user-username text-white"><?php  echo $result['S_NAME']; ?></h3>
						<h6 class="widget-user-desc text-white"><?php  echo $result['S_EMAIL']; ?></h6>
						</div>
					<div class="widget-user-image" >
						<?php 
						if($result['S_IMAGE']!=null){
							$urlimage="https://www.yestravaux.com/pro/manager/photos/{$result['S_IMAGE']}";}
							else{
								$urlimage="../images/guesst.png";
							
							}?>
					<img class="rounded-circle" src="<?php echo $urlimage;?>" alt="User Avatar" style="height:100px;width:100px;border:3px solid #ffffff" id="image_user" onclick="document.getElementById('UserImage').click()">
					<span style="padding-top:-50px" class="text-white"><i class="si-camera si" ></i></span>
	
					<form enctype="multipart/form-data" method="post" name="fileinfo" id="fileinfo">

							<input type="file" name="UserImage" id="UserImage" value="Choisir Image" style="display:none;">
							</form>
						</div>
						<div class="box-footer">
						<div class="row">
							
							<!-- /.col -->
							
							<!-- /.col -->
							
							<!-- /.col -->
						</div>
						<!-- /.row -->
						</div>
					</div>
					<div class="box">
						<div class="box-body box-profile">            
						<div class="row">
							<div class="col-12">
								<div>
									<p><strong>Email</strong> :<span class="text-gray ps-10"><?php  echo $result['S_EMAIL']; ?></span> </p>
									<p><strong>Téléphone</strong> :<span class="text-gray ps-10"><?php  echo $result['S_TEL']; ?></span></p>
									<p><strong>Date De Création</strong> :<span style="font-size:15px;font-style:italic"class="text-info"><?php  echo $result['D_DATE_ADD']; ?></span></p>
								</div>
							</div>
							<div class="col-12">
								<div class="pb-15">						
							
								
								</div>
							</div>
							
						</div>
						</div>
						<!-- /.box-body -->
					</div>
				
					
				

				
					</div>

				</div>

			</div>
			<!-- /.row -->

			</section>
			<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	
				
				
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	
	
<script>
	function CopyKey(copyText)
	{
	navigator.clipboard.writeText(copyText);
	$("#confirmCopy").html('<i class="mdi mdi-check btn-primary btn-xs mb-6"></i>copied');
	setTimeout(() => {
		$("#confirmCopy").html('');
	}, 1000);

	}
	//update password.......................
	$('#updatePassword').click(function(){
		USERKEY=$('#user_key').val();
		PK_USER=$('#user_pk').val();
		BROWSER=$('#user_browser').val();
		password=$('#password').val();
		passwordConfirm= $('#confirm_password').val();
		CurrentPassword= $('#password_actuelle').val();
		user_email=$('#user_email').val();
		if(CurrentPassword =="" || password=="" || passwordConfirm=="")
		{
			$.toast({
					heading: 'Erreur',
					text: 'Vous douvez choisir tout les champs.',
					position: 'top-right',
					loaderBg: '#ff6849',
					icon: 'error',
					hideAfter: 5000
			});
		}
		else if(password !=passwordConfirm)
		{
			$.toast({
					heading: 'Erreur',
					text: 'Merci de choisir deux mot de passe identiques.',
					position: 'top-right',
					loaderBg: '#ff6849',
					icon: 'error',
					hideAfter: 5000
			});
		}
		else{
		$.ajax({
					url:'https://www.yestravaux.com/webservice/crm/Auth.php',
					type: "POST",
					dataType: "html",
					data: {fct:'VerificationPassword',email:user_email,passwordvalue:CurrentPassword},
					async: true,
					success:function(data){	
						console.log(data);
						data=JSON.parse(data);
						if(data.verif =="ok")
						{
							$.ajax({
								url:'https://www.yestravaux.com/webservice/crm/Auth.php',
								type: "POST",
								dataType: "html",
								data: {fct:'UpdateUserPassword',pk_user:Number(PK_USER),k_key:USERKEY,passwordvalue:password,browser:BROWSER},
								async: true,
								success:function(data){	
								$.toast({
									heading: 'Félicitations',
									text: 'Votre mot de passe est modifié avec succés.',
									position: 'top-right',
									loaderBg: '#ff6849',
									icon: 'success',
									hideAfter: 5000
								});
								$('#refresh-profil').html();
								form=document.getElementById('formforpassword');
								form.reset();  

					}
				});
						}
						else{

                            $.toast({
									heading: 'Erreur',
									text: 'Votre mot de passe actuel est incorrect.',
									position: 'top-right',
									loaderBg: '#ff6849',
									icon: 'error',
									hideAfter: 5000
								});
							}
							

						}
					});

		}


				
		});

	$(document).ready(function(){
	error1= document.getElementById('errorpassword');
	error1.style.display="none";
	error2= document.getElementById('errornewpassword');
	error2.style.display="none";
	error3= document.getElementById('errorconfirmpassword');
	error3.style.display="none";
	check1=document.getElementById('checkpassword');
	check2=document.getElementById('checkconfpassword');
    check1.style.display="none";
	check2.style.display="none";
});


	function keyVerifPassword(idpass,iderror,idcheck)
	{
		CurrentPassword= document.getElementById(''+idpass).value;
		error= document.getElementById(''+iderror);
           //<i class="fa fa-times-circle-o"></i>mot de passe doit contient des caratéres et digit
        var regx1=/^(?=.*\d)/;
		var regx2=/(?=.*[!@#$%^&*])/;
		var regx3=/(?=.*[a-z])(?=.*[A-Z])/;
		var regx4=/(?=.*[0-9])/;
		if(!regx1.test(CurrentPassword)){
			document.getElementById(''+idpass).style.borderColor="#EA5455";
			error.style.color="#EA5455";
			error.innerHTML='<i class="fa fa-times-circle-o"></i>mot de passe doit contient ou mois un caratére';

			error.style.display="inline-block";

		}
		if(!regx3.test(CurrentPassword))
		{
			CurrentPassword= document.getElementById(''+idpass).value;

			document.getElementById(''+idpass).style.borderColor="#EA5455";
			error.style.color="#EA5455";
			error.innerHTML='<i class="fa fa-times-circle-o"></i>mot de passe doit contient des caratéres majuscule et miniscule';

			error.style.display="inline-block";
		}
		else if(!regx4.test(CurrentPassword)){
			document.getElementById(''+idpass).style.borderColor="#EA5455";
			error.style.color="#EA5455";
			error.innerHTML='<i class="fa fa-times-circle-o"></i>mot de passe doit contient des digits';

			error.style.display="inline-block";
		}
		else if(!regx2.test(CurrentPassword)){
			document.getElementById(''+idpass).style.borderColor="#EA5455";
			error.style.color="#EA5455";
			error.innerHTML='<i class="fa fa-times-circle-o"></i>mot de passe doit contient ou mois un caratére symbole';

			error.style.display="inline-block";
		}
		
		else if(CurrentPassword.length < 6)
		{
			document.getElementById(''+idpass).style.borderColor="#EA5455";
			error.style.color="#EA5455";
			error.innerHTML='<i class="fa fa-times-circle-o"></i>mot de passe doit avoir ou mois 6 carctéres';

			error.style.display="inline-block";
		} 
		else if(CurrentPassword=="")
		{
			document.getElementById(''+idcheck).style.display="none";

		}
		else{
			document.getElementById(''+idpass).style.borderColor="#28C76F";
			//error.style.color="#28C76F";
			error.style.display="none";
			document.getElementById(''+idcheck).style.display="";

		}

		
	}

function uploadFile() {

var files = document.getElementById("UserImage").files;
var K_KEY=$('#user_key').val();
var PK_USER=$('#user_pk').val();
var BROWSER=$('#user_browser').val();


if(files.length > 0 ){

	var formData = new FormData();
	formData.append("UserImage", files[0]);

	var xhttp = new XMLHttpRequest();

	// Set POST method and ajax file path
	xhttp.open("POST", "https://www.yestravaux.com/webservice/crm/Auth.php?fct=UploadFile&k_key="+K_KEY+"&pk_user="+PK_USER+"&browser="+BROWSER, true);
	
	// call on request changes state
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var response = this.responseText;
		console.log(response);
		response=JSON.parse(response);
		if(response.ETAT=="success_transfert")
		{
		$.toast({
		heading: 'Félicitations',
		text: 'Votre image est enregistré avec succéss.',
		position: 'top-right',
		loaderBg: '#ff6849',
		icon: 'success',
		hideAfter: 5000
		});
		}
		else if(response.ETAT=="error_size")
		{
		$.toast({
		heading: 'Erreur',
		text: 'La taille de l\'image ne doit pas passe 1MO.',
		position: 'top-right',
		loaderBg: '#ff6849',
		icon: 'error',
		hideAfter: 5000
		});
			
		}
		else{
		$.toast({
		heading: 'Erreur',
		text: 'vérifiez votre image, veuillez choisir un format valide (jpg,jpeg,png).',
		position: 'top-right',
		loaderBg: '#ff6849',
		icon: 'error',
		hideAfter: 5000
		});
		}

		}
	};

	// Send request with data
	xhttp.send(formData);

	}else{
	console.log("Please select a file");
	}

}

//move the image into the target source image..................
$(window).load(function(){
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
			
		reader.onload = function (e) {
			$('#image_user').attr('src', e.target.result);
		}		
		reader.readAsDataURL(input.files[0]);
	}
}
	
$('#UserImage').change(function(){
	readURL(this);
	uploadFile();
});

});//]]> 

</script>