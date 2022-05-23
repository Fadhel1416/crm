
<?php
// session_start ();
// include_once "../../config.inc.php";
// global $sqlserver;
$clientBrowser = $_SERVER['HTTP_USER_AGENT'];

/*$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
$POSTVALUE= "fct=GetRolesLists";
//echo $URLP."?".$POSTVALUE;die();
$resultat = curl_do_post($URLP,$POSTVALUE);
$result= (array)json_decode($resultat, true);
$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
$POSTVALUE= "fct=GetInvitedUsers&PK_USER=".$_SESSION['PK_USER'];
//echo $URLP."?".$POSTVALUE;die();
$resultat2 = curl_do_post($URLP,$POSTVALUE);
$invited_users= (array)json_decode($resultat2, true);
$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
$POSTVALUE= "fct=UserInfo&pk_user=".$_SESSION['PK_USER']."&k_key=".$_SESSION['K_KEY'];
//echo $URLP."?".$POSTVALUE;die();
$resultat3 = curl_do_post($URLP,$POSTVALUE);
$ConnectedUser= (array)json_decode($resultat3, true);
if($ConnectedUser['FK_ROLE']==3 ||$ConnectedUser['FK_ROLE']==2)
{
	// echo "<script>window.location.href='https://yestravaux.com/crm2/app/components/pages/error-permission.php'</script>";
	echo "<script>window.location.href='https://yestravaux.com/crm2/app/components/pages/error-permission.php'</script>";

	}
	*/
	// if(!isset($_SESSION["PK_USER"])){

	// 	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
	
	// }

	
	$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
	$POSTVALUE= "fct=UserInfo&pk_user=".$_SESSION['PK_USER']."&k_key=".$_SESSION['K_KEY'];
	//echo $URLP."?".$POSTVALUE;die();
	$resultat3 = curl_do_post($URLP,$POSTVALUE);
	$ConnectedUser= (array)json_decode($resultat3, true);

	?>
	
	<!-- Content Wrapper. Contains page content -->
		<div class="container-full" >
			<form action="#">
			<input type="hidden" id="k_key" value="<?php echo $_SESSION['K_KEY'];?>">
			<input type="hidden" id="pk_user" value="<?php echo $_SESSION['PK_USER'];?>">
			</form>
			<!-- Content Header (Page header) -->	  
			<div class="content-header">
				<div class="d-flex align-items-center">
					<div class="me-auto">
						<h4 class="page-title">API</h4>
						<div class="d-inline-block align-items-center">
							<nav>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="fa fa-user"></i></a></li>
									<li class="breadcrumb-item" aria-current="page">Clé API</li>
								</ol>
							</nav>
						</div>
					</div>
					
				</div>
			</div>
		
			<section class="content" id="refresh-users">
			<?php
	$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
	$POSTVALUE= "fct=UserInfo&pk_user=".$_SESSION['PK_USER']."&k_key=".$_SESSION['K_KEY'];
	//echo $URLP."?".$POSTVALUE;die();
	$resultat3 = curl_do_post($URLP,$POSTVALUE);
	$ConnectedUser= (array)json_decode($resultat3, true);
		?>
				<div class="row">

			<div class="col-md-12 col-xl-10 col-sm-12">
					<div class="box box-solid bg-dark">
					<div class="box-header">
						Your API KEY<br>
						<h6 class="box-title" id="box_key"> <?php echo substr($ConnectedUser["S_API_KEY"],0,50);?> . . . .  <a href="#" title="Copy" class="text-white" onClick="CopyKey('<?php echo $ConnectedUser["S_API_KEY"];?>')"><span id="iconcopy"><i class="fa fa-clone" aria-hidden="true"></i></span></a>
						<button class="btn btn-sm btn-default" style="margin-left:0px" onclick="generateKey()">Regenerate</button>	 </h6>

					<div class="pull-right text-" id="confirmCopy"></div>
					</div></div></div></div>

			<!--div class="row">
			<div class="col-sm-10 col-xl-8 col-md-10">	
				<div class="box">
	<div class="box-body bg-dark">
	<h4><span class="text-fade" style="padding-left:10px"><b>Your API KEY </b></span></h4> 
	<span style="padding-left:10px;width:auto"><?php echo substr($ConnectedUser["S_API_KEY"],0,2);?> . . . .</span> 
	<a href="#" title="Copy" class="text-white" onClick="CopyKey('<?php echo $ConnectedUser["S_API_KEY"];?>')"><i class="fa fa-clone" aria-hidden="true"></i></a>
				<button class="btn btn-sm btn-success" style="margin-left:50px" onclick="generateKey()">Regenerate</button>	 
				<div class="pull-right text-" id="confirmCopy"></div>

		

            </div>  </div>

            
        </div>  </div-->
			</section>
			<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/highlight.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>
		function CopyKey(copyText)
		{
		navigator.clipboard.writeText(copyText);
		$("#iconcopy").html('<i class="mdi mdi-check btn-primary btn-xs mb-6"></i>copied');
		setTimeout(() => {
			$("#iconcopy").html('<i class="fa fa-clone" aria-hidden="true"></i>');
		}, 1000);

		}
		jQuery(document).ready(function() {
	hljs.highlightAll();
	});



	function generateKey()
	{
		var USER_KEY=document.getElementById('k_key').value;
		var PK_USER=document.getElementById('pk_user').value;
			$.ajax({
				url:'https://www.yestravaux.com/webservice/crm/Auth.php',
				type: "POST",
				dataType: "html",
				data: {fct:'generateKey',pk_user:Number(PK_USER),k_key:USER_KEY},
				async: true,
				success:function(data){	
					data=JSON.parse(data);
					if(data.result=="ok")
					{
						$.toast({
					heading: 'Félicitations',
					text: 'Votre Api Key est régénèrer avec succés.',
					position: 'top-right',
					loaderBg: '#ff6849',
					icon: 'success',
					hideAfter: 3000
				});

					}
				
				$('refresh-users').html();

			}
		});
		$("#refresh-users").load(location.href+" #refresh-users>*","");  // referch the content of user key....................
	}
	</script>