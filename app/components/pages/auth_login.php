<?php
session_start ();
ini_set ("display_errors",1);
header('Content-Type: text/html; charset=utf-8');

include_once "../../config.inc.php";
include_once "../../commun.inc.php";
global $sqlserver;

$pass = mc_encrypt("crm", ENCRYPTION_KEY);
//echo "pass :".$pass;
//print_r ($_REQUEST);

$browser = $_SERVER['HTTP_USER_AGENT'];
$error=0;

if (isset($_REQUEST['connexion']))
{          
	$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
 	$POSTVALUE= "fct=UserLogin&S_EMAIL=".$_REQUEST['email']."&S_PASSWORD=".$_REQUEST['password']."&browser=".$browser."";

  //echo $URLP."?".$POSTVALUE;die();

  $resultat = curl_do_post($URLP,$POSTVALUE);
  $result= (array) json_decode($resultat);

  //echo 'result';print_r($resultat);
  //var_dump($result);
	
	if (isset($result['PK_USER']) && !empty($result['PK_USER']) )
	{
		$_SESSION['PK_USER']=$result['PK_USER'];
		$_SESSION['K_KEY']=$result['K_KEY'];
		var_dump($_SESSION);
		
		$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
		$POSTVALUE= "fct=UserStatusUpdate&K_KEY=".$result['K_KEY']."&status=1";

	//echo $URLP."?".$POSTVALUE;die();

		$resultat = curl_do_post($URLP,$POSTVALUE);
		//$result= (array) json_decode($resultat);

        header("Location: ../../../index.php?page=dashboard");

		

		
	}
	else
	{
		$error = 1;
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

    <title>Desk Hosteur - Se Connecter</title>
  
	<!-- Vendors Style-->
	<link rel="stylesheet" href="../../css/vendors_css.css">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/skin_color.css">	

</head>
	
<body class="hold-transition theme-fruit bg-img" style="background-image: url(../../../images/auth-bg/bg-1.jpg)">
	
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">	
		
			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<h2 class="text-primary">SE CONNECTER </h2>
								<p class="mb-0">Entrer vos accèes pour continuer sur admin</p>							
							</div>
							<div class="p-40">
							<?php if($error==1){?>
								<div class="form-group" style="padding-top:1px;margin-bottom:1px">
										<div class="input-group mb-1 badge-danger-light rounded">
										<span class="" for="inputError" id="InfoError"><i class="fa fa-times-circle-o" ></i> Vous informations semblent incorrect</span>
										</div>
									</div>
									<?php }?>

								<form action="auth_login.php" method="post" id="formauth">
								
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
											<input type="text" id="email" class="form-control ps-15 bg-transparent"  placeholder="Email" name="email">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
											<input type="password" id="password" name="password" class="form-control ps-15 bg-transparent "  placeholder="Mot de passe">
											<input type="hidden" id="testconn" name="testconn" class="form-control ps-15 bg-transparent">

										</div>
									</div>
									  <div class="row">
										<div class="col-6">
										  <div class="checkbox">
											<input type="checkbox" id="basic_checkbox_1" >
											<label for="basic_checkbox_1">Se souvenir de moi</label>
										  </div>
										</div>
										<!-- /.col -->
										<div class="col-6">
										 <div class="fog-pwd text-end">
											<a href="auth_user_pass.php" class="hover-warning"><i class="ion ion-locked"></i> Mot de passe oublié?</a><br>
										  </div>
										</div>
										<!-- /.col -->
										<div class="col-12 text-center">
										  <button type="submit" onclick="JavaScript:return VerifConn(event)" name="connexion" id="connexion" class="btn btn-danger mt-10">SE CONNECTER</button>
										</div>
										<!-- /.col -->
									  </div>
								</form>	
								<div class="text-center">
									<p class="mt-15 mb-0">Vous n'avez pas un compte? <a href="auth_register.php" class="text-warning ms-5">S'enregistrer</a></p>
								</div>	
							</div>						
						</div>
						<!--div class="text-center">
						  <p class="mt-20 text-white">- Sign With -</p>
						  <p class="gap-items-2 mb-20">
							  <a class="btn btn-social-icon btn-round btn-facebook" href="#"><i class="fa fa-facebook"></i></a>
							  <a class="btn btn-social-icon btn-round btn-twitter" href="#"><i class="fa fa-twitter"></i></a>
							  <a class="btn btn-social-icon btn-round btn-instagram" href="#"><i class="fa fa-instagram"></i></a>
							</p>	
						</div-->
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
	<script>
		var test=false;
        function validateEmail(email) 
	    {
			email = email || "";
			let re = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;
			return re.test(email.toLowerCase().trim());
		}

   function VerifConn(e)
	{
			var email=document.getElementById('email').value;
			var password=document.getElementById('password').value;
			var form=document.getElementById('formauth');
			var datastring={};
			var test=true;
			var hiddenval=document.getElementById('testconn');
			
			 if(email=="" || password== "")
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
			else if(validateEmail(email)==false)
			{
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
		
		   else {	

			return true;
			}
	}
	</script>	

</body>
</html>
