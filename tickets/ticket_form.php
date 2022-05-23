<?php 
header('Content-Type: text/html; charset=utf-8');
include_once "../../config.inc.php";
include_once "../../commun.inc.php";

$val=0;
if($_POST){

    $data = array('nom'=>htmlspecialchars($_POST["nom"]),'prenom'=>htmlspecialchars($_POST["prenom"]),'email' =>htmlspecialchars($_POST["email"]),
    'tel'=>htmlspecialchars($_POST["tel"]),
    'object'=>htmlspecialchars($_POST["sujet"]),
    'body'  =>htmlspecialchars($_POST["body"]),
    );
    $data=json_encode($data);
    $URL     = 'https://api.hosteur.pro/webservice/crm/campaign.php';
    $POSTVALUE  = 'fct=TicketAdd&data='.$data.'&id_user=73';
    $data_ticket =curl_do_post($URL,$POSTVALUE); 

        if($data_ticket!=null){
			$k=1;
		}

}





?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<style>
	input[type="text"],input[type="email"] {
		height:50px;
	}
	input[type="submit"]{
		height:70px;
		width:180px;
	}
</style>
<script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
<div class="row">	
    
				<div class="col-lg-6 col-12">
					  <div class="box">
						<div class="box-header with-border">
						</div>
                        <br>
						
						<!-- /.box-header -->
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-8">
                            <form method="post" action="">
							<div class="box-body">
								<h4 class="box-title text-info  text-center"><i class="ti-user me-15"></i>Ajouter Des Tickets</h4>
                                <br>
								<?php if($k==1){?>
								<div class="row">
								<div class="col-md-12 alert-success rounded" style="padding:20px">
								Votre réponse est bien envoyée
								</div>
								</div>
								<?php }?>
								<br>
								<div class="row">
								  <div class="col-md-6">
									<div class="form-group">
									  <label class="form-label">Nom</label>
									  <input type="text" class="form-control rounded-pill"  name="nom" placeholder="Nom" required>
									</div>
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <label class="form-label">Prenom</label>
									  <input type="text" class="form-control rounded-pill" name="prenom" placeholder="Prenom" required>
									</div>
								  </div>
								</div>
								<div class="row">
								  <div class="col-md-6">
									<div class="form-group">
									  <label class="form-label">E-mail</label>
									  <input type="email" class="form-control rounded-pill" name="email" placeholder="E-mail" required>
									</div>
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <label class="form-label">Contact TEL</label>
									  <input type="text" class="form-control rounded-pill" name="tel" placeholder="TEL" required>
									</div>
								  </div>
                                  <div class="col-md-12">
									<div class="form-group">
									  <label class="form-label">Sujet</label>
									  <input type="text" class="form-control rounded-pill" name="sujet" placeholder="Sujet de ticket" required>
									</div>
								  </div>
                                <div class="col-md-12">
                              
                                   
								<div class="form-group">
								<label class="form-label">Contenu</label>

								  <textarea rows="5" class="form-control" placeholder="Entrez la  description de votre ticket ....." name="body"></textarea>
								</div>
                                </div>
                                </div>

							</div>
							<!-- /.box-body -->
							
							<div class="g-recaptcha"  data-sitekey="6LcwD7AfAAAAAL88VwYSWxO656Ff719NfyZzYq0J"></div>
                            <br>

							<div class="box-footer" style="text-align: center;">
								<input type="submit" class="btn  btn-lg btn-danger rounded-pill p-20" value="Envoyer" name="envoyer">
								
							</div>  


						</form>
                            </div>

						
					  </div>
					  <!-- /.box -->			
				</div>  



</body>
</html>
