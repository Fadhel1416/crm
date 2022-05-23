<?php
$browser= $_SERVER['HTTP_USER_AGENT'];
if(isset($_REQUEST['key']))
{
 $key=$_REQUEST['key'];
}
else{
 $key="";
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

    <title>Desk Hosteur - Réinitialisation mot de passe</title>
  
	<!-- Vendors Style-->
	<link rel="stylesheet" href="../../css/vendors_css.css">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/skin_color.css">	

</head>

<body class="hold-transition theme-fruit bg-img" style="background-image: url(../../../images/auth-bg/bg-2.jpg)">
	
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">
			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">						
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-2 pb-2 callout callout-info">
								<h3 class="text-white">Réinitialisation Mot de passe</h3>								
							</div>
							<div class="p-40">
								<form action="#" method="post" id="formInitID">
                                <div class="form-group" style="padding-top:1px;margin-bottom:1px">
										<div class="input-group mb-1">
										<span class="" for="inputError" id="errorpassword1"><i class="fa fa-times-circle-o" ></i></span>

										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
											<input type="password" onkeyup="keyVerifPassword('password','errorpassword1')" name="password" class="form-control ps-15 bg-transparent" id="password" placeholder="Nouveau mot de passe">
										</div>
									</div>
                                    <div class="form-group" style="padding-top:1px;margin-bottom:1px">
										<div class="input-group mb-1">
										<span class="" for="inputError" id="errorpassword2"><i class="fa fa-times-circle-o" ></i></span>

										</div>
									</div>
                                    <div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
											<input type="password"  onkeyup="keyVerifPassword('passwordconfirm','errorpassword2')" name="passwordconfirm" class="form-control ps-15 bg-transparent" id="passwordconfirm" placeholder="confirmez mot de passe">
										</div>
									</div>
                                    <div class="form-group">
										<div class="input-group mb-3">
											<input type="hidden" name="emailval" class="form-control ps-15 bg-transparent" id="emailval" value="">
                                            <input type="hidden" name="keyval" class="form-control ps-15 bg-transparent" id="keyval" value="<?php echo $key;?>">
                                            <input type="hidden" name="BROWSER" class="form-control ps-15 bg-transparent" id="BROWSER" value="<?php echo $browser;?>">


										</div>
									</div>
									 
								</form>
                                <div class="row">
										<div class="col-12 text-center">
										  <button type="button" id="idresetPASS" name="init" class="btn btn-info margin-top-10">Réinitialiser</button>
										</div>
										<!-- /.col -->
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
	<script>
    $(document).ready(function(){
	error1= document.getElementById('errorpassword1');
	error1.style.display="none";
	error2= document.getElementById('errorpassword2');
	error2.style.display="none";
	});
  $('#idresetPASS').click(function(){
      var pass=$('#password').val();
      var passconf=$('#passwordconfirm').val();
      if(pass=="" || passconf=="")
      {
        $.toast({
			heading: 'Erreur',
			text: 'Merci de remplir tous les champs.',
			position: 'bottom-right',
			loaderBg: '#ff6849',
			icon: 'error',
			hideAfter: 5000
			});
      }
      else if(pass!=passconf){
        $.toast({
			heading: 'Erreur',
			text: 'les deux mot de passe ne sont pas identiques.',
			position: 'bottom-right',
			loaderBg: '#ff6849',
			icon: 'error',
			hideAfter: 5000
			});
      }
      else{
          var email=$('#emailval').val();
          var key=$('#keyval').val();
          var browser=$('#BROWSER').val();
          $.ajax({
                url:'https://www.yestravaux.com/webservice/crm/Auth.php',
                type: "POST",
                dataType: "html",
                data: {fct:'InitPassword',K_KEY:key,S_PASSWORD:pass,browser:browser},
                async: true,
                success:function(data){	
                    data=JSON.parse(data);
                    if(data.result=="ok"){
                    $.toast({
                        heading: 'Félicitations',
                        text: 'Votre mot de passe est modifié avec succés.',
                        position: 'bottom-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 2000
                    });
                    form=document.getElementById('formInitID');
                    form.reset(); 
                    setTimeout(() => {
                        window.location.href="https://yestravaux.com/crm2/app/components/pages/auth_login.php"
                    }, 2000);
                        }
					else{
					$.toast({
					heading: 'Erreur',
					text: 'Merci de saisir des informations valide.',
					position: 'bottom-right',
					loaderBg: '#ff6849',
					icon: 'error',
					hideAfter: 2000
				});

                    }
				}
				});
      }

  });

//function pour renforcer la securité de mot de passe................................
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
