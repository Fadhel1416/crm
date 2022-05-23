<?php
session_start ();


if(!isset($_SESSION["PK_USER"])){

    echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
  
  }
  
include_once "../../config.inc.php";
global $sqlserver;

$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
$POSTVALUE  = 'fct=Emails_List&PK_USER='.$_SESSION["PK_USER"];
$email_result = curl_do_post($URL, $POSTVALUE);
$email_result =json_decode($email_result);
$email_result=(array)$email_result;




//var_dump($ticketresult);
?>
    
    <!-- Content Wrapper. Contains page content -->
        <div class="container-full" >
            
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Emails Envoyeé</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="fa fa-envelope"></i></a></li>
								<li class="breadcrumb-item active" aria-current="page">Emails</li>
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
                            <h4 class="box-title">Listes Des Emails</h4>
                            <!--a href="https://yestravaux.com/crm2/app/components/pages/ticket_form.php" class="btn bg-gradient-purple pull-right modal-Invit-btn" target="_blank">Ajouter</a-->

                            </div>
                        
                            <div class="box-body">
                            <div class="table-responsive">
							<table id="tickets" class="table table-hover no-wrap" data-page-size="10">
                                <thead>
                                        <tr>
                                        <th>Date</th>
                                        <th>Receiver</th>
                                        <th>Object</th>
                                        <th>contenu</th>
                                        <th>Details</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                      
                                         <tr>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td></td>

                                         </tr>                             
                                       </tbody>
                                    </table>
                            </div>
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
    // function UpdateStatusTicket(idticket){
        
    //     var element=document.getElementById('ticket'+idticket);
	// 	var idx=element.selectedIndex;
	// 	var val=element.options[idx].value;
	// 	var content=element.options[idx].innerHTML;
	// 	val=parseInt(val);
	// 	var selectoption="";
	// 	if(val == 2){
	// 		selectoption="btn-success-light rounded";
	// 	}
	// 	else if(val == 1){
	// 		selectoption="btn-danger-light rounded ";
	// 	}
	// 	else if(val==3){
	// 		selectoption="btn-warning-light rounded";
	// 	}
    //     else{
    //        selectoption= "btn-info-light rounded";
    //     }


    //         $.ajax({
    //         url:'https://www.yestravaux.com/webservice/crm/campaign.php',
    //         type: "POST",
    //         dataType: "html",
    //         data: {fct:'UpdateTicketStatus',ticket_id:idticket,status_ticket:parseInt(val)},
    //         async: true,
    //         success:function(data){	
    //             console.log(data);
    //             data=JSON.parse(data);
    //             if(data.result=="ok"){
    //             element.className=selectoption;
    //             element.options[idx].selected='selected';
    //             $.toast({
    //             heading: 'Félicitations',
    //             text: 'Le statue de ticket est modifié avec succès.',
    //             position: 'top-right',
    //             loaderBg: '#ff6849',
    //             icon: 'success',
    //             hideAfter: 5000
    //             });
    //             }
                

    //         }
    //     });
    //         }




    
    </script> 