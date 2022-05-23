<?php
//session_start ();
// include_once "config.inc.php";
// include_once "commun.inc.php";
// date_default_timezone_set('Europe/Paris');
// if(!isset($_SESSION["PK_USER"])){

// 	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";

// }
// global $sqlserver;
$clientBrowser = $_SERVER['HTTP_USER_AGENT'];

$URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
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
    if($ConnectedUser['FK_ROLE']==3 || $ConnectedUser['FK_ROLE']==2)
    {
    // echo "<script>window.location.href='https://yestravaux.com/crm2/app/components/pages/error-permission.php'</script>";
    echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/error-permission.php'</script>";

    }

?>
   
 <!-- Content Wrapper. Contains page content -->
	  <div class="container-full" >
		
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Utilisateurs</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="fa fa-user"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Utilisateurs</li>
								<li class="breadcrumb-item active" aria-current="page">Invités</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Main content -->
		<section class="content" id="refresh-users">
          <?php

        $URLP= "https://www.yestravaux.com/webservice/crm/Auth.php";
        $POSTVALUE= "fct=GetInvitedUsers&PK_USER=".$_SESSION['PK_USER'];
        //echo $URLP."?".$POSTVALUE;die();
        $resultat2 = curl_do_post($URLP,$POSTVALUE);
        $invited_users= (array)json_decode($resultat2, true);

           ?>
		  <div class="row">
          <div class="col-sm-10 col-xl-8">	
					<div class="box">
						<div class="box-header with-border">
						  <h4 class="box-title">Utilisateurs Invités</h4>
                          <a href="#" class=" btn bg-gradient-purple pull-right modal-Invit-btn" data-bs-toggle="modal" data-bs-target="#modal-Invit">Inviter</a>

						</div>
                      
						<div class="box-body">
						  <div class="table-responsive">
							<table id="ticketsinvit" class="table table-hover no-wrap" data-page-size="10">
								<thead>
									<tr>
										<th>Date de Création</th>
										<th>Email</th>
                                        <th>Image</th>		
										<th>Rôle</th>
										<th>Nom</th>
                                        <th>Etat</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php  
                                    if($invited_users !=null){
                                    for($i=0;$i<count($invited_users);$i++){
                                        if($invited_users[$i]['S_IMAGE']!=null){
                                            $urlimage="https://www.yestravaux.com/pro/manager/photos/".$invited_users[$i]['S_IMAGE'];}
                                            else{
                                                $urlimage="../images/Guest2.png";
                                            
                                            }
                                        
                                        if($invited_users[$i]["FK_ROLE"]==2){
                                            $role="Admin";
                                            $class="badge badge-primary-light";
                                            $class3="btn-primary-light";
                                        }
                                        else if($invited_users[$i]["FK_ROLE"]==3){
                                            $role="Utilisateur";
                                            $class="badge badge-danger";
                                            $class3="btn-danger-light";

                                        }
                                        if($invited_users[$i]["S_ETAT_ROLE"]=="sended"){
                                            $etat="sended";
                                            $class2="badge badge-warning";
                                        }
                                        else if($invited_users[$i]["S_ETAT_ROLE"]=="accepted"){
                                            $etat="accepted";
                                            $class2="badge badge-success-light";

                                        }                
                                        ?>
                                    <tr>
                                    <td><?php echo $invited_users[$i]["D_DATE_ADD"]; ?></td>
                                    <td><?php echo $invited_users[$i]["S_EMAIL"]; ?></td>
                                    <td><img src="<?php echo $urlimage; ?>" width="70" height="70" class="rounded"></td>

                                    <td><!--span class="<?php echo $class; ?>"><?php echo $role; ?></span-->
                                    <select class="custom-select <?php echo $class3 ;?>" id="<?php echo 'staterole'.$invited_users[$i]["K_KEY"];?>" onChange="UpdateStatusUser('<?php echo $invited_users[$i]["K_KEY"];?>');">
                                    <option value="2" <?php if($invited_users[$i]["FK_ROLE"] == 2){ echo "selected" ;}?>>Admin</option>
                                    <option value="3" <?php if($invited_users[$i]["FK_ROLE"]== 3){ echo "selected" ;}?>>Utilisateur</option>
                                    </select> 
                                    </td>
                                    <td><?php echo $invited_users[$i]["S_NAME"]; ?></td>
                                    <td><span class="<?php echo $class2; ?>"><?php echo $etat; ?></span>
                                    
                                    </td>
                                    <td><a class="text-danger" data-bs-toggle="tooltip" data-bs-original-title="Delete"  onClick="DeleteInvited('<?php echo $invited_users[$i]["K_KEY"];?>','<?php echo $urlimage;?>');"><i class="ti-trash" aria-hidden="true"></i></a></td>

                                    </tr>	
                                    <?php }}?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>	
                    </div>

            </div>
            <!-- /.row -->
            <div class="modal center-modal fade" id="modal-Invit">
                <div class="modal-dialog">
                    <div class="modal-content bg-lightest  modal-content2">
                        <div class="modal-header bg-lightest modal-header2">
                            <h5 class="modal-title text-info"><b><span style="padding-left:100px">Inviter vos utilisateurs</span></b></h5>
                            <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                        </div>
                        <div class="modal-body">
                        
							<form action="#" class="" id="formusers">
                            <div class="form-group row">
                            <label for="Nom" class="col-sm-12 form-label"><b>Email:</b></label><br>

                            <div class="col-sm-12">
                                <input type="email"class="form-control modal-input2 required" id="emailuser_invit" name="emailuser_invit" placeholder="ali.f@externalisation.pro" required>
                            </div>
                            </div>
                            <div class="form-group row" >
                            <label for="Nom" class="col-sm-12 form-label"><b>Inviter en tant que:</b></label><br>

                            <div class="col-sm-12">
                            <select class="form-select modal-input2 required" id="userinvitrole" name="user-roles" required="required">
                            <option value="<?php echo $result[0]["PK_ROLE"];?>"><?php echo $result[0]["S_ROLE"];?></option>

                                    <?php for($i=1;$i<count($result);$i++) { 
                                    
                                ?>
                                <option value="<?php echo $result[$i]["PK_ROLE"];?>"><?php echo $result[$i]["S_ROLE"];?></option>
                                <?php }?>
                                </select>
                            
                            </div>
                            </div>
                            <input type="hidden" id="kkey" value="<?php echo $_SESSION['K_KEY'];?>">
                            <input type="hidden" id="pk_user" value="<?php echo $_SESSION['PK_USER'];?>">
                            <input type="hidden" id="user_browser" value="<?php echo $clientBrowser;?>">

                            <?php $link="https://desk.hosteur.pro/app/components/pages/accepte_invitation.php?email=";?>
							</form>
						
		
						<div class="modal-footer modal-footer-uniform">
							<a href="#" class="btn btn-sm text-dark" onClick="CopyLink('<?php echo $link;?>')" ><span class="glyphicon glyphicon-link"></span>Copier le lien </a>
                            <!--div style="margin-left:170px" class="pull-right" id="confirmCopy"></div-->

							<button style="" class="btn btn-sm bg-gradient-grey" name="Send" id="" onClick="SendEmailInvit()">Envoyer</button>

						</div>
					</div>
				</div>
			</div>
		</div>
        <div class="modal center-modal fade" id="modal-UpdateInvit">
                <div class="modal-dialog">
                    <div class="modal-content bg-lightest  modal-content2">
                        <div class="modal-header bg-lightest modal-header2">
                        <h5 class="modal-title text-info"><b><span style="padding-left:100px"> Merci de confirmer votre mot de passe<span></b></h5>
                            <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                        </div>
                        <div class="modal-body">
                            
                                <form action="#" class="" id="formRoleUpdate">
                                <div class="form-group">
                                <label for="Nom" class="col-sm-12 form-label"><b>Mot de Passe</b></label><br>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
                                                <input type="password" name="password" id="passworduser" class="form-control ps-15" name="passworduser" placeholder="Mot de passe">

                                            </div> </div>
                            
                            </form>
                                    </div>
		
						<div class="modal-footer modal-footer-uniform">
                            <!--div style="margin-left:170px" class="pull-right" id="confirmCopy"></div-->

							<button style="" class="btn btn-sm bg-warning" name="Update" id="ConfirmeMDP">Confirmer</button>

						</div>
					</div>
				</div>
			</div>
		</div>
		</section>
            <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
		$(document).ready(function(){
			$('#ticketsinvit').DataTable({
		paging:true,
		order: [[0, "desc" ]],
		"language": {
		"sProcessing": "Traitement en cours ...",
		"sLengthMenu": "Afficher _MENU_ Utilisateurs",
		"sZeroRecords": "Aucun lead trouvé",
		"sEmptyTable": "Aucune donnée disponible",
		"sInfo": "_START_ à _END_ sur _TOTAL_ Utilisateurs",
		"sInfoEmpty": "Aucune ligne affichée",
		"sInfoFiltered": "(Filtrer un maximum de _MAX_)",
		"sInfoPostFix": "",
		"sSearch": "Chercher:",
		"sUrl": "",
		"sInfoThousands": ",",
		"sLoadingRecords": "Chargement...",
		"oPaginate": {
		"sFirst": "Premier", "sLast": "Dernier", "sNext": "Suivant", "sPrevious": "Précédent"
		},
		"oAria": {
		"sSortAscending": ": Trier par ordre croissant", "sSortDescending": ": Trier par ordre décroissant"
				}
			}
		});
		});
	</script>
<script>
   

    function CopyLink(link)
    {
        navigator.clipboard.writeText(link+document.getElementById('emailuser_invit').value);
    }
    function SendEmailInvit()
    {
        var userEmail=document.getElementById('emailuser_invit').value;
        var element=document.getElementById('userinvitrole');
            var idx=element.selectedIndex;
            var val=element.options[idx].value;
            var form=document.getElementById('formusers');
            var K_KEY=$('#kkey').val();
            var PK_USER=$('#pk_user').val();
            var BROWSER=$('#user_browser').val();
            $.ajax({
                url:'https://www.yestravaux.com/webservice/crm/Auth.php',
                type: "POST",
                dataType: "html",
                data: {fct:'SendInvitations',kkey:K_KEY,FK_ROLE:Number(val),email:userEmail,pk_user:PK_USER,browser:BROWSER},
                async: true,
                success:function(data){	   
                console.log(data);     
                var res=JSON.parse(data);
                if(res.result=="ok"){
                    $.toast({
                    heading: 'Félicitations',
                    text: 'Votre invitation a été envoyé avec succès.',
                    position: 'bottom-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 2000
                });
                
                form.reset(); 
                setTimeout(() => {
                    location.reload();
                }, 2000);
                //$('#refresh-users').html();
                //$("#refresh-users").load(location.href+" #refresh-users>*","");			
                }
                else if(res.result=="MyAccount")
                {
                    $.toast({
                    heading: 'Erreur',
                    text: 'Vous ne pouvez pas inviter vous-même.',
                    position: 'bottom-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 5000
                });
                }
                else{
                    $.toast({
                    heading: 'Erreur',
                    text: 'Invitation déjà envoyée.',
                    position: 'bottom-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 5000
                });

                }
            

                }
            });
        }
function DeleteInvited(key,urlimage)
{

    USER_KEY=$('#kkey').val();
    PK_USER=$('#pk_user').val();
    BROWSER=$('#user_browser').val();
	swal({
		title: 'Etes-vous sûr ?',
        imageUrl:""+urlimage,
		text: "Voulez-vous supprimer cet utilisateur invité!",
		imageWidth: '400',
		imageHeight: '200',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Oui, je confirme',
		cancelButtonText: 'Non',
		confirmButtonClass: ' btn-primary ',
		cancelButtonClass: 'btn-danger',
		buttonsStyling: true
		}).then(function(){
			swal(
			'Supprimée!',
			'Votre utilisateur invité est supprimée.',
			'success'
			).then(function(){
					$.ajax({
                        url:'https://www.yestravaux.com/webservice/crm/lead.php',
                        type: "POST",
                        dataType: "html",
                        data: {fct:'DeleteInvitedUser',pk_user:PK_USER,k_key:USER_KEY,key_invited:key,browser:BROWSER},
                        async: true,
                        success:function(data){
                        data=JSON.parse(data);
                        if(data.result=="ok")
                        {
                        setTimeout(() => {
                            location.reload();
                        }, 2000);	
                        }
                        else{
                        $.toast({
                            heading: 'Erreur',
                            text: 'Utilisateur n\'exist pas.',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                                hideAfter: 3000
                            });
                        }
                }});
            
				//location.reload();

		})
	},function (dismiss) {
	if (dismiss === 'cancel') {
		swal(
		'Annulée',
		'la suppression a été annulée :)',
		'error'
		)
	}})
		return false;
}
function UpdateStatusUser(key_userinvited)
{

    $('#modal-UpdateInvit').modal('show');
    var K_KEY=$('#kkey').val();
    var PK_USER=$('#pk_user').val();
    var BROWSER=$('#user_browser').val();
    var confirmeBtn=$('#ConfirmeMDP');
    confirmeBtn.click(function(e){
    var PASSWORD=$('#passworduser').val();

        if(PASSWORD=="")
        {
            $.toast({
                    heading: 'Erreur',
                    text: 'Merci d\'entrer votre mot de passe.',
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3000
                });
                }
            else {
            $.ajax({
            url:'https://www.yestravaux.com/webservice/crm/lead.php',
            type: "POST",
            dataType: "html",
            data: {fct:'VerifyMDP',k_key:K_KEY,password:PASSWORD},
            async: true,
            success:function(data){	
                data=JSON.parse(data);
                if(data.result=="ok")
                {
                e.preventDefault();
                var element=document.getElementById('staterole'+key_userinvited);
                var form=document.getElementById('formRoleUpdate');            
                var idx=element.selectedIndex;
                var val=element.options[idx].value;
                var content=element.options[idx].innerHTML;
                val=parseInt(val);
                var selectoption="";
                if(val == 2)
                {
                    selectoption="custom-select btn-primary-light";
                }
                else
                {
                    selectoption="custom-select btn-danger-light";
                }
                
            console.log(parseInt(val));
            $.ajax({
                    url:'https://www.yestravaux.com/webservice/crm/lead.php',
                    type: "POST",
                    dataType: "html",

                    data: {fct:'UpdateRoleUser',fk_role:parseInt(val),pk_user:PK_USER,k_key:key_userinvited,browser:BROWSER},
                    async: true,
                    success:function(data){	
                    data=JSON.parse(data);
                    if(data.result=="ok")
                    {
                        console.log(data);
                        element.className=selectoption;
                        element.options[idx].selected='selected';
                        $.toast({
                        heading: 'Félicitations',
                        text: 'Vous avez modifié le rôle  de l\'utilisateur.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 4000
                        });
                    }
                    else {
                        $.toast({
                        heading: 'Erreur',
                        text: 'Vérifié si cet utilisateur est existant.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 2000
                    });
                }
                        
                }
                        });
                        form.reset();
                        $('#modal-UpdateInvit').modal('hide');

                        $.fn.dataTable.ext.errMode = 'none';
                        /*$('staterole'+key_userinvited).html();		 
                        $('UserUpdateRole').html();		 
                        $("#UserUpdateRole").load(location.href+" #UserUpdateRole>*","");*/
                        setTimeout(() => {
                            location.reload();
                        }, 2000);			                               
                        }
                        else{
                            $.toast({
                            heading: 'Erreur',
                            text: 'Votre mot de passe est incorrect.',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3000
                        });
                        }                        
                    }
                });
        }
        });
    
            $("#formRoleUpdate").keypress(function(e) {
                //Enter key
                if (e.which == 13) {
                    UpdateStatusUser(key_userinvited);
                    e.preventDefault();             
                }
                }); 
}
</script>