<?php
session_start ();


if(!isset($_SESSION["PK_USER"])){

    echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
  
  }
  
include_once "../../config.inc.php";
global $sqlserver;

$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
$POSTVALUE  = 'fct=TicketList&PK_USER='.$_SESSION["PK_USER"];
$ticketresult = curl_do_post($URL, $POSTVALUE);
$ticketresult =json_decode($ticketresult);
$ticketresult=(array)$ticketresult;

$clientBrowser=$_SERVER['HTTP_USER_AGENT'];

//var_dump($ticketresult);
?>
    
    <!-- Content Wrapper. Contains page content -->
        <div class="container-full" >
            
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Tickets</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="fa fa-ticket"></i></a></li>
								<li class="breadcrumb-item active" aria-current="page">Tickets</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Main content -->
		<section class="content" id="refresh-users">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
            <div class="row">
            <div class="col-sm-12 col-xl-10">	
                        <div class="box">
                            <div class="box-header with-border">
                            <h4 class="box-title">Listes des tickets</h4>
                            <!--a class="btn btn-sm btn-secondary" onClick="Supprimer();" style="margin-left:200px;margin-bottom:-50px"><i class="fa fa-trash" aria-hidden="true"></i> Supprimer</!--a-->

                            <a href="index.php?page=ticketSettings" class="btn bg-dark pull-right modal-Invit-btn" target="_blank"><i class="ti-settings"></i> Paramètre </a>

                            </div>
                        
                            <div class="box-body">
                             
                            <div class="table-responsive">
                              <div><a class="btn btn-sm btn-secondary" onClick="Supprimer();" style="display:none;" id="DisplayButton"><i class="fa fa-trash" aria-hidden="true" ></i> Supprimer</a></div>
                              <br>
							<table id="tickets10" class="table table-hover no-wrap" data-page-size="10">
                                <thead>
                                        <tr>
                                        <th>Création</th>
                                        <th>Email</th>
                                        <th>Object</th>
                                        <th>Statut</th>
                                        <th>Source</th>
                                        <th>Répondre</th>
                                        <th>Informations</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                    
                                    for($i=0;$i<count($ticketresult);$i++){
                                        if($ticketresult[$i]->status==1){
                                            $status="New";
                                            $class="btn-danger-light";
                                        }
                                        else if($ticketresult[$i]->status==2)
                                        {
                                            $status="Resolved";
                                            $class="btn-success-light";

                                        }
                                        else if($ticketresult[$i]->status==3){
                                            $status="Pending";
                                            $class="btn-warning-light";

                                        }
                                        else{
                                            $status="Opened";
                                            $class="btn-info-light";
                                        }
                                        $id=$ticketresult[$i]->_id;

                                        if(!array_key_exists('source',$ticketresult[$i])){
                                            $source='Website';
                                            $classSource="badge badge-danger";
                                        }
                                        else if($ticketresult[$i]->source=="Website"){
                                            $source='Website';
                                            $classSource="badge badge-danger";

                                        }  
                                        else if($ticketresult[$i]->source=="Email"){
                                            $source='Email';
                                            $classSource="badge badge-primary";

                                        }
                                    ?>
                                        <tr>
    
                                            <td>
                                            <input type="checkbox" value="<?php echo $id;?>" id="<?php echo $id;?>" name="check" onclick="DisplayButton();">
                                        <label for="<?php echo $id;?>"></label>

                                            <?php echo $ticketresult[$i]->DATE_ADD_TICKET;?> <?php echo $ticketresult[$i]->time;?>
            
                                        
                                        </td>
                                            <td><?php echo $ticketresult[$i]->email;?></td>
                                            <td><?php echo $ticketresult[$i]->object;?></td>
                                            <td>
                                            <select class="<?php echo $class ;?> rounded" id="<?php echo 'ticket'.$id;?>" onChange="UpdateStatusTicket('<?php echo $id;?>');">
                                            <option value="1" <?php if($ticketresult[$i]->status==1){ echo "selected" ;}?> >Nouveau</option>

										<option value="2" <?php if($ticketresult[$i]->status==2){ echo "selected" ;}?>>Résolu</option>
										<option value="3" <?php if($ticketresult[$i]->status==3){ echo "selected" ;}?>>En attente</option>
                                        <option value="4" <?php if($ticketresult[$i]->status==4){ echo "selected" ;}?>>Ouverte</option>


										</select> 


                                            </td>
                                            <td><span class="<?php echo $classSource;?>" style="width:55px"><?php echo $source;?></span></td>
                                            <td><a href="https://desk.hosteur.pro/tickets/ticket_reply.php?id_ticket=<?php echo  $id;?>" target="_blank" class="btn btn-sm btn-warning">Connect</a></td>
                                            <td><a href="index.php?page=details_ticket&id_ticket=<?php  echo $id;  ?>" target="_blank" class="btn-sm btn-info"><i class="si si-eye"></i></a></td>
                                        </tr>
                                        <?php } ?>	
                                        </tbody>
                                    </table>
                            </div>
                            </div>
                        </div>	
                    </div>

            </div>
            <!-- /.row -->

            <form action="" style="display:none">
		<input type="hidden" id="k_keyAdd" value="<?php echo $_SESSION['K_KEY'];?>">
		<input type="hidden" id="pk_userAdd" value="<?php echo $_SESSION['PK_USER'];?>">
		<input type="hidden" id="user_browser" value="<?php echo $clientBrowser;?>">
		</form>
		</section>
            <!-- /.content -->



    </div>
    <!-- /.content-wrapper -->
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="https://smtpjs.com/v3/smtp.js"></script>

    <script>
    function UpdateStatusTicket(idticket){
        
        var element=document.getElementById('ticket'+idticket);
		var idx=element.selectedIndex;
		var val=element.options[idx].value;
		var content=element.options[idx].innerHTML;
		val=parseInt(val);
		var selectoption="";
		if(val == 2){
			selectoption="btn-success-light rounded";
		}
		else if(val == 1){
			selectoption="btn-danger-light rounded ";
		}
		else if(val==3){
			selectoption="btn-warning-light rounded";
		}
        else{
           selectoption= "btn-info-light rounded";
        }


            $.ajax({
            url:'https://www.yestravaux.com/webservice/crm/campaign.php',
            type: "POST",
            dataType: "html",
            data: {fct:'UpdateTicketStatus',ticket_id:idticket,status_ticket:parseInt(val)},
            async: true,
            success:function(data){	
                console.log(data);
                data=JSON.parse(data);
                if(data.result=="ok"){
                element.className=selectoption;
                element.options[idx].selected='selected';
                $.toast({
                heading: 'Félicitations',
                text: 'Le statue de ticket est modifié avec succès.',
                position: 'top-right',
                loaderBg: '#ff6849',
                icon: 'success',
                hideAfter: 5000
                });
                }
                

            }
        });
            }
            $(document).ready(function(){
                var Next_Prevous=54;
                //Configuring language paramètre for datatable...........
                $('#tickets10').DataTable({
                paging:true,
                order: [[0, "desc" ]],
                "language": {
                    "sProcessing": "Traitement en cours ...",
                    "sLengthMenu": "Afficher _MENU_ Tickets",
                    "sZeroRecords": "Aucun résultat trouvé",
                    "sEmptyTable": "Aucune donnée disponible",
                    "sInfo": "_START_ à _END_ sur _TOTAL_ Tickets",
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
                        
                        /*Email.send({
                Host : "smtp.elasticemail.com",
                Username : "alifadhel619@gmail.com",
                Password : "C8BEA22FA3CF3999D50FDF0285684765E85A",
                To : 'ali.f@externalisation.pro',
                From : "alifadhel619@gmail.com",
                Subject : "This is the subject",
                Body : "And this is the body"
                }).then(
                message => alert(message)
                );*/
                    });

            function Supprimer()
            {
            USER_KEY=$('#k_keyAdd').val();
			PK_USER=$('#pk_userAdd').val();
			BROWSER=$('#user_browser').val();
                var check=document.getElementsByName('check');
            var tab=[];
            $count=0;
            for(var i=0;i<check.length;i++)
            {
                if(check[i].checked){
                    $count=$count+1;
                // console.log(check[i].value);
                    tab.push(check[i].value);
                }
            }
            if($count==1){
            var message="Voulez vous supprimer cette ticket !";
            var confirmation='Votre ticket est supprimé';
            }
            else if ($count>1){
                var message="Voulez vous supprimer ces tickets !";
                var confirmation='Vous tickets est supprimés';
            }
            else
            {
                $.toast({
                heading: 'Erreur',
                text: 'Merci de selectionner des tickets pour supprimer.',
                position: 'bottom-right',
                loaderBg: '#ff6849',
                icon: 'error',
                hideAfter: 5000
                });
                }

                if($count!=0){
                console.log(tab);

                        swal({
                    title: 'Etes-vous sûr ?',
                    text: message,
                    type: "warning",
                    imageWidth: '400',
                    imageHeight: '150',
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
                        'Supprimé!',
                        confirmation,
                        'success'
                        ).then(function(){
                            $.ajax({
                                    url:'https://www.yestravaux.com/webservice/crm/campaign.php',
                                    type: "POST",
                                    dataType: "html",

                                    data: {fct:'DeleteTicket',ticket_id_tab:tab,pk_user:PK_USER,kkey:USER_KEY,browser:BROWSER},
                                    async: true,
                                    success:function(data){
                                        console.log(data);
                                        location.reload();
                                }
                                });
                                
                            // 	$.fn.dataTable.ext.errMode = 'none';
                            // 	$('#tickets1').DataTable({
                            // 		paging:true,
                            // 	order: [[ 0, "desc" ]]
                            // 	});
                            // 	$('#tickets2').DataTable({
                            // 		paging:true,
                            // 	order: [[ 0, "desc" ]]
                            // 	});



                            // 	//$("#tickets1").load(location.href+" #tickets1>*","");  
                            // $('ggg_change').html();		 
                            // $("#ggg_change").load(location.href+" #ggg_change>*","");


                        })

                        },function (dismiss) {
                        if (dismiss === 'cancel') {
                            swal(
                            'Annulée',
                            'la suppression a été annulée :)',
                            'error'
                            )
                        }
                        })
                    }
                    return false;

                    }



                function DisplayButton()
                {
                    var but=document.getElementById('DisplayButton');
                    var check=document.getElementsByName('check');
                    var $vv=0;
                    for(var i=0;i<check.length;i++)
                    {
                        if(check[i].checked){
                        $vv=1;
                        }                
                    }
                    if($vv==1)
                    {
                        //but.style.visibility="visible";
                        but.style.display="inline-block";
                        but.style.className="btn btn-sm btn-secondary";

                    }
                    else{
                        //but.style.visibility="hidden";
                        but.style.display="none";

                    }

                    }
                    
                    </script>