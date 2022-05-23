<?php

//ini_set ("display_errors",1);
header('Content-Type: text/html; charset=utf-8');
include_once "../../config.inc.php";
include_once "../../commun.inc.php";
global $sqlserver;

/*$http_origin = $_SERVER['HTTP_ORIGIN'];
header("Access-Control-Allow-Origin: $http_origin");*/
$codepays="+33";
if(isset($_REQUEST['email']))
{
    $Invited_User_EMAIL=$_REQUEST['email'];    
}
else{
    $Invited_User_EMAIL=$_POST['email'];
}

if($_POST)
{
				/* VALUES */
				
				$S_NAME=$_POST['S_NAME'];
				$email =$_POST['hiddenval'];
				$password = $_POST['password'];
				$S_TEL=$_POST['tel'];
				$S_IP=$_SERVER['REMOTE_ADDR'];
				$codepays=$_POST['Code'];
				$S_TEL=$codepays.$S_TEL;
 				$URL1 = "https://www.yestravaux.com/webservice/crm/Auth.php";
    			$POSTVALUE1 = "fct=UpdateInvitedUser&S_NAME=".$S_NAME."&S_TEL=".$S_TEL."&S_IP=".$S_IP."&email=".$email."&password=".$password;
   				$res1=curl_do_post($URL1, $POSTVALUE1);
				var_dump($res1);
				if($res1==1)
				{
					header("Location:auth_login.php");
					echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";

				}
				else{
					$res1="DUPLICATE";
				}
	} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../images/favicon.ico">

    <title>Crm Admin - Inscription </title>
  
	<!-- Vendors Style-->
	<link rel="stylesheet" href="../../css/vendors_css.css">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/skin_color.css">	
	<link
     rel="stylesheet"
     href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
   />
<style>
	
</style>
</head>

<body class="hold-transition theme-fruit bg-img" style="background-image: url(../../../images/auth-bg/bg-2.jpg)">
	
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">
			
			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<h2 class="text-primary">Commencez avec Nous</h2>
								<p class="mb-0">Entrer vos données pour s'enregistrer</p>							
							</div>
							<div class="p-40">
								<form onsubmit="return verifFields()" action="accepte_invitation.php" method="post" id="formreg" >
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
											<input type="text" name="S_NAME" id="S_NAME" value="<?php echo $_POST['S_NAME'];?>" class="form-control ps-15 bg-transparent "  placeholder="Nom Complet">
										</div>
									</div>
									<?php if($res1=="DUPLICATE"){?>
										<div class="form-group" style="padding-top:1px;margin-bottom:1px">
										<div class="input-group mb-1">
										<span class="badge-danger-light" for="inputError" style="color:#EA5455" id="erroremail"><i class="fa fa-times-circle-o" ></i>Cet e-mail est déjà utilisée</span>

										</div>
									</div>
									<?php }?>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-email"></i></span>
                                            <?php if($_REQUEST['email']!=""){?>
											<input type="text" name="email" id="email" value="<?php echo $Invited_User_EMAIL;?>" class="form-control ps-15 bg-transparent " disabled placeholder="Votre Email">
										    <?php } else {?>
                                         <input type="text" name="email" id="email" value="<?php echo $_POST['email'];?>" class="form-control ps-15 bg-transparent "  placeholder="Votre Email">
                                          <?php }?>
                                        </div>
									</div>
									<input type="hidden" name="Code" id="Code" value="<?php echo $codepays;?>">

									<div class="form-group">
										<div class="input-group mb-3">
										<span class="input-group-text bg-transparent"><i class="ti-mobile"></i></span>

											<input type="tel" name="tel" id="tel" style="padding-right:215px" value="<?php echo $_POST['tel'];?>" class="form-control"   >
										</div>
									</div>
									<div class="form-group" style="padding-top:1px;margin-bottom:1px">
										<div class="input-group mb-1">
										<span class="" for="inputError" id="errorpassword"><i class="fa fa-times-circle-o" ></i></span>

										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
											<input type="password" name="password" id="password" class="form-control ps-15" onkeyup="keyVerifPassword('password','errorpassword')"  placeholder="Mot de passe">

										 </div>
									</div>
									<div class="form-group" style="padding-top:1px;margin-bottom:1px">
										<div class="input-group mb-1">
										<span class="" for="inputError" id="confirmpassword"><i class="fa fa-times-circle-o" ></i></span>

										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
											<input type="password" name="password2" id="password2" class="form-control ps-15 bg-transparent " onkeyup="keyVerifPassword('password2','confirmpassword')" placeholder="Réentrer le mot de passe">

										</div>
									</div>
                                    <input type="hidden" value="<?php echo $Invited_User_EMAIL;?>" name="hiddenval">
									  <div class="row">
										<div class="col-12">
										  <div class="checkbox">
											<input type="checkbox" id="basic_checkbox_1">
											<label for="basic_checkbox_1">J'accepte  <a href="#" class="text-warning"><b>les conditions générales</b></a></label>
										  </div>
										</div>
										<!-- /.col -->
										<div class="col-12 text-center">
										  <button type="submit" class="btn btn-info margin-top-10" id="Inscrit">S'ENREGISTRER</button>
										</div>
										<!-- /.col -->
									  </div>
								</form>	
											
								<div class="text-center">
									<p class="mt-15 mb-0">Vous avez déjà un compte?<a href="auth_login.php" class="text-danger ms-5"> SE CONNECTER</a></p>
								</div>
							</div>
						</div>								
					</div>
				</div>
			</div>			
		</div>
	</div>
	<!-- Vendor JS -->
	<script src="../../js/vendors.min.js"></script>
	<script src="../../js/pages/chat-popup.js"></script>
    <script src="../../../assets/icons/feather-icons/feather.min.js"></script>
	<script src="../../../assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js"></script>
	
	<script src="../../js/pages/toastr.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

	<script>

    function validateEmail(email) {
  email = email || "";
  let re = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;
  return re.test(email.toLowerCase().trim());
}

	$(document).ready(function(){
	error1= document.getElementById('errorpassword');
	error1.style.display="none";
	error2= document.getElementById('confirmpassword');
	error2.style.display="none";
	const phoneInputField = document.querySelector("#tel");

   const phoneInput = window.intlTelInput(phoneInputField, {
	 initialCountry:"auto",
	 customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
    return selectedCountryPlaceholder;
  },
   preferredCountries:["fr","ch","be","lu","tn"],
    utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
	geoIpLookup: function(success, failure) {
    $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.country) ? resp.country : "us";
      success(countryCode);
	  
    });
  },
   });
   phoneInputField.addEventListener("countrychange", function(e) {
	var codecountry=phoneInput.getSelectedCountryData().dialCode;
	$('#Code').val("+"+codecountry);
    });
	});
	function verifFields()
	{
		var form=document.getElementById('formreg');
		var name=document.getElementById('S_NAME').value;
		var email=document.getElementById('email').value;
		var tel=document.getElementById('tel').value;
		var password=document.getElementById('password').value;
		var password2=document.getElementById('password2').value;
		var CondG=document.getElementById('basic_checkbox_1');
		console.log(tel);
		if(name=="" || email=="" || tel=="" || password=="" || password2=="")
		{
			$.toast({
			heading: 'Erreur',
			text: 'Merci de remplir tous les champs.',
			position: 'bottom-right',
			loaderBg: '#ff6849',
			icon: 'error',
			hideAfter: 5000
			});
	    return false;
		}
		else if(validateEmail(email)==false){
			$.toast({
			heading: 'Erreur',
			text: 'Votre email est invalide.',
			position: 'bottom-right',
			loaderBg: '#ff6849',
			icon: 'error',
			hideAfter: 5000
			});
	    return false;
		}
		else if(password.length <6)
		{
			$.toast({
			heading: 'Erreur',
			text: 'le mot de passe doit avoir ou mois 6 carctéres.',
			position: 'bottom-right',
			loaderBg: '#ff6849',
			icon: 'error',
			hideAfter: 5000
				});
	
		return false;

		}
		else if(password != password2)
		{
			$.toast({
			heading: 'Erreur',
			text: 'les deux mots de passe doivent être identiques.',
			position: 'bottom-right',
			loaderBg: '#ff6849',
			icon: 'error',
			hideAfter: 5000
			});
	
	    return false;
		}
		else if(CondG.checked==false)
		{
		$.toast({
		heading: 'Erreur',
		text: 'Vous douvez acceptez nos conditions générales.',
		position: 'bottom-right',
		loaderBg: '#ff6849',
		icon: 'error',
		hideAfter: 5000
		});
		
	    return false;

		
		}
		return true;	
	
			}
			
	function keyVerifPassword(idpass,iderror)
	{
		CurrentPassword= document.getElementById(''+idpass).value;
		error= document.getElementById(''+iderror);
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
		else{
			document.getElementById(''+idpass).style.borderColor="#28C76F";
			//error.style.color="#28C76F";
			error.style.display="none";
		}
		
	}
	</script>
	
</body>
</html>
