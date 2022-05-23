<?php
ini_set ("display_errors",1);
header('Content-Type: text/html; charset=utf-8');

include_once "../../config.inc.php";
include_once "../../commun.inc.php";
global $sqlserver;

$pass = mc_encrypt("crm", ENCRYPTION_KEY);
//echo "pass :".$pass;
//print_r ($_REQUEST);
//$browser = $_SERVER['HTTP_USER_AGENT'];
if (isset($_REQUEST['init']))
{          
	$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
 	$POSTVALUE= "fct=SendInitPassword&S_EMAIL=".$_REQUEST['email'];

  //echo $URLP."?".$POSTVALUE;die();

  $resultat = curl_do_post($URLP,$POSTVALUE);
  $result= (array) json_decode($resultat);

  //echo 'result';print_r($resultat);
 // var_dump($result);
  if($result["result"]=="ok")
  {
  echo "ok ";
  }
  else
  {
    echo "error";
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

    <title>Desk Hosteur - Réinitialisation Mot de passe</title>
  
	<!-- Vendors Style-->
	<link rel="stylesheet" href="../../css/vendors_css.css">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/skin_color.css">	

</head>

<body class="hold-transition theme-fruit bg-img" style="background-image: url(../../../images/auth-bg/bg-2.jpg)">
	
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">
			<?php if(!isset($_REQUEST['init'])){?>
			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">						
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-2 pb-2 callout callout-success">
								<h3 class="text-white">Réinitialisation Mot de passe</h3>								
							</div>
							<div class="p-40">
								<form onsubmit ="return InitVerif()" action="auth_user_pass.php" method="post">
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-email"></i></span>
											<input type="text" name="email" class="form-control ps-15 bg-transparent" id="email" placeholder="Votre Email">
										</div>
									</div>
									  <div class="row">
										<div class="col-12 text-center">
										<a href="https://yestravaux.com/crm2/app/components/pages/auth_login.php" class="text-info btn btn-sm pull-right">Retour</a>

										  <button type="submit" id="idreset" name="init" class="btn btn-success margin-top-10">Réinitialiser</button>
										</div>
										<!-- /.col -->
									  </div>
								</form>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php }elseif($result["result"]=="ok"){?>
				<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">						
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-2 pb-2 callout callout-info">
								<h3 class="text-white">Confirmation<i class="icon fa fa-check"></i></h3>								
							</div>
							<div class="p-20" style="font-style: italic;">
								un mail a été envoyé à l'adresse <strong><?php echo $_REQUEST['email'];?> </strong>, il contient un lien de réinitialisation de mot de passe , si l'email ne parvient pas veuillez vérifier votre dossier spam<br><br>

							<a href="https://yestravaux.com/crm2/app/components/pages/auth_user_pass.php" style="margin-left:200px" class="btn-info text-white btn btn-sm">Retour</a>

							</div>
						</div>
					</div>
				</div>
			</div>


           <?php }else { ?>
			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">						
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-2 pb-2 callout callout-danger">
							<h3 class="text-white ">Email Inexistante !</h3>								
							</div>
							<div class="p-20 " style="font-style: italic;">
								L'email <b><?php echo $_REQUEST['email'];?></b> n'existe pas , Merci d'entrer un email existante, si vous n'avez pas un compte cliquer sur  <a class="text-danger" href="https://yestravaux.com/crm2/app/components/pages/auth_register.php">s'inscrire</a> pour créer un compte<br><br>
								<a href="https://yestravaux.com/crm2/app/components/pages/auth_user_pass.php" style="margin-left:200px"class="btn-danger text-white btn btn-sm">Retour</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php }?>
		</div>
	</div>	
	<!-- Vendor JS -->
	<script src="../../js/vendors.min.js"></script>
	<script src="../../js/pages/chat-popup.js"></script>
    <script src="../../../assets/icons/feather-icons/feather.min.js"></script>
	<script src="../../../assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js"></script>
	<script src="../../js/pages/toastr.js"></script>
	<script>
  //filter function pour valider un email..................................		
  function validateEmail(email) {
  email = email || "";
  let re = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;
  return re.test(email.toLowerCase().trim());
}
 function InitVerif()
     {
	   var email=document.getElementById('email').value;
        if(email =="")
		{
			$.toast({
			heading: 'Email Vide',
			text: 'Vous douvez choisir votre email.',
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
			heading: 'Invalide Email',
			text: 'Vous douvez entrez un email valide.',
			position: 'bottom-right',
			loaderBg: '#ff6849',
			icon: 'error',
			hideAfter: 5000
			});
			return false;
		}
		return true;

   }

</script>	
</body>
</html>
