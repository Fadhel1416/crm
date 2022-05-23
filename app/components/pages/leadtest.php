
<?php 
$session='';
if(isset($_REQUEST["Enregister"]) ){

	$data = array('campaign_id'=>htmlspecialchars($_POST["selectedname"]),'nom'=>htmlspecialchars($_POST["nom"]),'prenom'=>htmlspecialchars($_POST["prenom"]),'email' =>htmlspecialchars($_POST["email"]),
	  'phone'=>htmlspecialchars($_POST["phone"]),
	  'societe'=>htmlspecialchars($_POST["societe"]),
	  'ip'  =>$_SERVER['REMOTE_ADDR'],
	);
	$lengthchamp=(int) $_POST['hiddenval'];
	for($i=0;$i<$lengthchamp;$i++) {
	$data[$_POST["champ".$i]]=$_POST["value".$i];
			  
  }
	$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
      $data=json_encode($data);
	  $POSTVALUE  = 'fct=addlead&data='.$data.'&cmpid='.$_POST["selectedname"]; 
	  $datacamp =curl_do_post($URL,$POSTVALUE); 
}
$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
$POSTVALUE  = 'fct=ListCampaign&user_id=1';
$datacamp = curl_do_post($URL,$POSTVALUE);
$datacamp = json_decode($datacamp);
$datacamp = (array) $datacamp;

?>

  
  <!-- Content Wrapper. Contains page content -->
 
	  <div class="container-full">
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Campagnes</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Leads</li>
								<li class="breadcrumb-item active" aria-current="page">Liste et stats</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Main content -->
		<section class="content" id="reloadcontent">

		  <div class="row">
			  <div class="col-lg-3 col-12">
			 
                 <div class="col-lg-12 col-12">
				  <div class="box">
					  <div class="box-header with-border">
						<h5 class="box-title">Leads par campagne</h5>
						<div class="box-tools pull-right">
							<ul class="card-controls">
							  <li class="dropdown">
								<a data-bs-toggle="dropdown" href="#"><i class="ion-android-more-vertical"></i></a>
								<div class="dropdown-menu dropdown-menu-end">
								  <a class="dropdown-item active" href="#">Aujourd'hui</a>
								  <a class="dropdown-item" href="#">Hier</a>
								  <a class="dropdown-item" href="#">Semaine dernière</a>
								  <a class="dropdown-item" href="#">Mois dernier</a>
								</div>
							  </li>
							  <li><a href="" class="link card-btn-reload" data-bs-toggle="tooltip" title="" data-bs-original-title="Refresh"><i class="fa fa-circle-thin"></i></a></li>
							</ul>
						</div>
					  </div>

					  <div class="box-body">
						<div class="text-center pb-25">                  
						  <div class="donut" data-peity='{ "fill": ["#fc4b6c", "#ffb22b", "#398bf7"], "radius": 86, "innerRadius": 50  }' > 
							  <?php for($i=0;$i<count($datacamp);$i++) { 
							
						     echo $datacamp[$i]->companyLeads;
							 echo ",";

						      } ?></div>
						</div>

						<ul class="list-inline">

						  <?php for($i=0;$i<count($datacamp);$i++) { ?>
							<li class="flexbox mb-5">
							<div>
							  <span class="badge badge-dot badge-lg me-1 bg-<?php echo $i; ?>" ></span>
							  <span><?php echo $datacamp[$i]->companyName;?></span>
							</div>
							<div><?php echo $datacamp[$i]->companyLeads;?></div>
						  </li>

						  <?php } ?>
						  <!--li class="flexbox mb-5">
							<div>
							  <span class="badge badge-dot badge-lg me-1" style="background-color: #fc4b6c"></span>
							  <span>Technical</span>
							</div>
							<div>8952</div>
						  </li>

						  <li class="flexbox mb-5">
							<div>
							  <span class="badge badge-dot badge-lg me-1" style="background-color: #ffb22b"></span>
							  <span>Accounts</span>
							</div>
							<div>7458</div>
						  </li>

						  <li class="flexbox">
							<div>
							  <span class="badge badge-dot badge-lg me-1" style="background-color: #398bf7"></span>
							  <span>Other</span>
							</div>
							<div>3254</div>
						  </li-->
						</ul>
					  </div>
					</div>
			  </div>
			  <div class="col-lg-12 col-12">
				  <div class="box">
					  <div class="box-header with-border">
						<h5 class="box-title">Leads traités par campagne</h5>

						<div class="box-tools pull-right">
							<ul class="card-controls">
							  <li class="dropdown">
								<a data-bs-toggle="dropdown" href="#"><i class="ion-android-more-vertical"></i></a>
								<div class="dropdown-menu dropdown-menu-end">
								  <a class="dropdown-item active" href="#">Aujourd'hui</a>
								  <a class="dropdown-item" href="#">Hier</a>
								  <a class="dropdown-item" href="#">Semaine dernière</a>
								  <a class="dropdown-item" href="#">Mois dernier</a>
								</div>
							  </li>
							  <li><a href="" class="link card-btn-reload" data-bs-toggle="tooltip" title="" data-bs-original-title="Refresh"><i class="fa fa-circle-thin"></i></a></li>
							</ul>
						</div>
					  </div>
                          <input type="hidden" id="hiddensession">
					  <div class="box-body">
						<div class="flexbox mt-10">
							<div class="bar" data-peity='{ "fill": ["#689f38", "#FF4961", "#FF9149"], "height": 268, "width": 120, "padding":0.2 }'>1,0,0</div>
						  <ul class="list-inline align-self-end text-muted text-end mb-0">
							<li>hosteur dev <span class="badge badge-primary ms-2">1</span></li>
							<li>hosteur callcenter <span class="badge badge-danger ms-2">0</span></li>
							<li>hosteur domaine <span class="badge badge-warning ms-2">0</span></li>
							<!--li>Chloe <span class="badge badge-danger ms-2">854</span></li>
							<li>Daniel <span class="badge badge-warning ms-2">215</span></li-->
						  </ul>
						</div>

					  </div>
				  </div>
			  </div>
              </div>
               <div class="col-9">
				<div class="col-12">
					<div class="box">
						<div class="box-header with-border">						
							<h4 class="box-title">Liste des leads</h4>
							<div class="row">
								<div class="col-sm-10">
								<div class="form-group form-group-float">
							<select class="custom-select btn-lg" id="listleadcmp" onChange="FindLeadByCompany();">
							<?php for($i=0;$i<count($datacamp);$i++) { 
								 $campid = (array) $datacamp[$i]->_id;
								 $idcamp = $campid['$id'];
								
								?>

								<option value="<?php echo $idcamp;?>"><?php echo $datacamp[$i]->companyName;?></option>

                           <?php }?>
								
							</select>
						</div>
								</div>
								<div class="col-sm-2">
								<a href="#" class="btn btn-success pull-right" data-bs-toggle="modal" data-bs-target="#modal-center2">Ajouter </a>

								</div>
							</div>
							
						</div>
						<div class="box-body p-15">						
							<div class="table-responsive" id="verifid">
								
							<?php 
							session_start();
                                    if (empty($_SESSION['compony'])){
                                        $URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
                                        $POSTVALUE  = 'fct=ListLead&campaign_id=61b0cdb8ff89110450000029';
                                        $dataleadresult = curl_do_post($URL, $POSTVALUE);
                                        $dataleadresult = json_decode($dataleadresult);
                                        $dataleadresult = (array) $dataleadresult;
                                    }
									else{
                                        $URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';
                                        $POSTVALUE  = 'fct=ListLead&campaign_id='.$_SESSION['compony'];
                                        $dataleadresult = curl_do_post($URL, $POSTVALUE);
                                        $dataleadresult = json_decode($dataleadresult);
                                        $dataleadresult = (array) $dataleadresult;
									}  ?>
								<table id="tickets" class="table mt-0 table-hover no-wrap"  >
									<thead>
										<tr>
											<th>ID</th>
											<th>Campagne</th>
											<th>Nom/prenom</th>
											<th>Email</th>
											<th>Société</th>
											
											<th>Status</th>
											<!--th>Ass. to</th-->
											<th>Tél</th>
											<th>IP</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									
									<?php
									for($i=0; $i < count($dataleadresult); $i++) { 
										
                                           $dataleadid = (array) $dataleadresult[$i]->_id;
                                           $id = $dataleadid['$id'];

										?>

										<tr>
											<td><?php echo $id;?></td>
											<td class="text-info"><?php echo $dataleadresult[$i]->companyName;?></td>
											<td>
												<a href="#"><?php echo $dataleadresult[$i]->nom;?></a>
											</td>
											<td><?php echo $dataleadresult[$i]->email;?></td>
											<td><?php echo $dataleadresult[$i]->societe;?></td>
											
											<td>
											<?php if($dataleadresult[$i]->status == 2){
											$class="btn-success";}
											elseif($dataleadresult[$i]->status == 1){
												$class="btn-danger";
											}
											else{
												$class="btn-warning";
											}
											?>
		 									<select class="custom-select <?php echo $class ;?>" id="<?php echo 'statelead'.$id;?>" onChange="UpdateStatusLead('<?php echo $id;?>');">
                                           <option value="2" <?php if($dataleadresult[$i]->status == 2){ echo "selected" ;}?>>Traité</option>
                                           <option value="1" <?php if($dataleadresult[$i]->status == 1){ echo "selected" ;}?>>En cour</option>
                                           <option value="0" <?php if($dataleadresult[$i]->status == 0){ echo "selected" ;}?>>Nouveau</option>
                                           </select> 
										 
												</td>
											<!--td>Elijah</td-->
											<td><?php echo $dataleadresult[$i]->phone;?></td>
											<td><?php echo $dataleadresult[$i]->ip;?></td>
											
											<td>
												<a href="index.php?page=lead&id=<?php echo $id;?>" class="text-success" data-bs-toggle="tooltip" data-bs-original-title="Details"><i class="ti-write" aria-hidden="true"></i></a>
	
												<a  class="text-danger" data-bs-toggle="tooltip" data-bs-original-title="Delete"  onClick="verif('<?php echo $id;?>');"><i class="ti-trash" aria-hidden="true"></i></a>
											</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
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
 
  <!-- Modal -->
  <div class="modal center-modal fade" id="modal-center2">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header btn btn-dark">
			<h5 class="modal-title"><b>Ajouter Lead</b></h5>
			<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
		  </div>
		  <div class="modal-body">
			<form action="index.php?page=leads" id="formid" method="POST"  class="">
			<div class="form-group row" id="div1">
							<label for="Nom" class="col-sm-3 form-label">Nom</label>

							<div class="col-sm-9">
							  <input type="text" class="form-control required" id="nomlead" name="nom" placeholder="Entrer Votre Nom" required>
							</div>
						  </div>
						  <div class="form-group row" id="div2">
							<label for="email" class="col-sm-3 form-label">Prenom</label>

							<div class="col-sm-9">
							  <input type="text" class="form-control required" id="prenomlead" name="prenom" placeholder="Entrer Votre Prenom" required>
							</div>
						  </div>
			              <div class="form-group row" id="div3">
							<label for="email" class="col-sm-3 form-label">Email</label>

							<div class="col-sm-9">
							  <input type="email" class="form-control required" id="emaillead" name="email" placeholder="Entrer Votre Email" required>
							</div>
						  </div>
						  <div class="form-group row" id="div4">
							<label for="phone" class="col-sm-3 form-label">Tel</label>

							<div class="col-sm-9">
							  <input type="text" class="form-control required" id="phonelead" name="phone" placeholder="Entrer Votre Tel" required>
							</div>
						  </div>
						 
						  <div class="form-group row" id="div5">
							<label for="societe" class="col-sm-3 form-label">Sociéte</label>

							<div class="col-sm-9">
							  <input type="text" class="form-control required" id="societelead" name="societe" placeholder="Entrer Votre Nom Sociéte" required>
							</div>
						  </div>
						  <div class="form-group row" id="div6">
							<label for="campanyname" class="col-sm-3 form-label">Nom Company</label>

							<div class="col-sm-9">
							<select class="form-select required" id="cmpnamelead" name="selectedname" required="required">
										<option value="" selected>Selectionnez Nom Company</option>
									
							 <?php for($i=0;$i<count($datacamp);$i++) { 
								 $datacampid = (array) $datacamp[$i]->_id;
								 $id = $datacampid['$id'];
							?>
								<option value=<?php echo $id;?>><?php echo $datacamp[$i]->companyName;?></option>
										<?php }?>
										</select>
							</div>
						  </div>  
						  </div>
						  <div class="form-group row" id="div7">
						  <div class="col-sm-5">
						  <input type="hidden" class="form-control" value="">

						  </div>
						  <div class="col-sm-3">
						  <a for="addchamp" id="ggg" class="waves-effect waves-light btn btn-success-light mb-5" onClick="addField();"><i class="si-plus si" width="30" height="50"></i></a>
						  </div></div>
						  <div class="form-group row" id="div8">
						  <div class="col-sm-3">
						  <input type="hidden" class="form-control" id="hiddenval" name="hiddenval" value="">

						  </div>
						  <div class="col-sm-8">
						  <span class="alert text-danger" id="errorval" name="errorval" ></span>
						  </div></div>
						  
						  <div class="form-group row" id="champs">

							
						  </div>
						 

	
		  <div class="form-group row" id="div8">
						  <div class="col-sm-3">
						  <input type="hidden" class="form-control" id="hiddenval2" name="hiddenval" value="">

						  </div>
						  <div class="col-sm-8">
						  <b><span class="box box-inverse box-primary" id="successval" name="successval"></span></b>
						  </div></div>
			</form>
			
			<div class="modal-footer modal-footer-uniform">
							  
			<a href="index.php?page=leads" id="tttt1" class="waves-effect waves-light btn btn-info-light mb-3">Retour</a>

<button class=" waves-light btn btn-primary-light mb-3" name="Enregister" id="tttt2" onClick="addleadjs();">Enregister</button>
				  
							  
							</div>
			

		  </div>
		  
		</div>
	  </div>
	</div>
	<div class="modal center-modal fade" id="modal-center3">
	  <div class="modal-dialog">
		<div class="modal-content bg-success">
		  <div class="modal-header">
			<h5 class="modal-title"><b>Confirmation Lead</b></h5>
			<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
		  </div>
		  <div class="modal-body">
		
		  Félicitations ! Votre Lead Est Créé Avec Succès



		  </div>
		  
		</div>
	  </div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="../../../assets/vendor_components/datatable/datatables.min.js"></script>

  <!-- /.modal -->
  <script>
      var k="";
						  var i=0;
	    var form=document.getElementById('formid');
        var div = document.getElementById('champs');
        function addInput(name1,name2){
			//var label=document.createElement("label");
			//label.className="col-sm-3 form-label";
			var div1=document.createElement("div");
			div1.className="col-sm-3";

            var input1 = document.createElement("input");
            input1.name = name1;
			input1.className="form-control required";
			input1.placeholder="Nom Champ";
			input1.id="Idc"+i;
			input1.required="required";
			//var label2=document.createElement("label");
			//label2.className="col-sm-2 form-label";
			var div2=document.createElement("div");
			div2.className="col-sm-9";
			var input2 = document.createElement("input");
            input2.name = name2;
			input2.className="form-control required";
			input2.placeholder="Valeur Champ";
			input2.id="Idv"+i;
			input2.required="required";

			div1.appendChild(input1);
			div2.appendChild(input2);
			//div.appendChild(label);
			div.appendChild(div1);

			div.appendChild(div2);
			form.appendChild(div);
          i=i+1;
		  document.getElementById('hiddenval').value=i;

        }

        function addField(){
       addInput("champ"+i,"value"+i);
        div.appendChild(document.createElement("br"));
		div.appendChild(document.createElement("br"));
        }
		
function addleadjs()
{
	var form=document.getElementById('formid');

	var namelead=document.getElementById('nomlead').value;
	var prenomlead=document.getElementById('prenomlead').value;
	var emaillead=document.getElementById('emaillead').value;
	var phonelead=document.getElementById('phonelead').value;
	var societelead=document.getElementById('societelead').value;
	var cmpnamelead=document.getElementById('cmpnamelead').value;
	var nbchamps=Number(document.getElementById('hiddenval').value);
	var errorval=document.getElementById('errorval');

	if(namelead =="" || prenomlead =="" || emaillead =="" || phonelead =="" || societelead =="" || cmpnamelead ==""){
		//$("#errorval").text("Veuillez entrez tout les champs");
	errorval.innerHTML="Veuillez entrez tout les champs";
	errorval.focus(); 
	}
	
	else {
		$.ajax({
                url:'https://www.yestravaux.com/webservice/crm/campaign.php',
                type: "POST",
                dataType: "html",
 
                data: {fct:'InfoCampagne',camp_id:cmpnamelead },
                async: true,
                success:function(data){
					console.log(data);
					console.log("fine");
					var datastring={};
          datastring['campaign_id']=cmpnamelead;
          datastring['companyName']=(JSON.parse(data))["companyName"];
          datastring['nom']=namelead;
          datastring['prenom']=prenomlead;
          datastring['email']=emaillead;
          datastring['phone']=phonelead;
          datastring['societe']=societelead;

      for(i=0;i<nbchamps;i++){

	champi=document.getElementById('Idc'+i).value;
	valuei=document.getElementById('Idv'+i).value;
	if( champi=="" || valuei ==""){
		errorval.innerHTML="Veuillez entrez tout les champs";
		errorval.focus(); 

	}
	datastring[champi]=valuei;


}

div.innerHTML='';
div.parentNode.removeChild(div);

form.reset();
document.getElementById('hiddenval').value=0;

i=0;

datajson=JSON.stringify(datastring);

$.ajax({
                url:'https://www.yestravaux.com/webservice/crm/lead.php',
                type: "POST",
                dataType: "html",
 
                data: {fct:'addlead',data:datajson,cmpid:cmpnamelead },
                async: true,
                success:function(data){
					console.log(data);
					console.log("fine");
				
        $('verifid').html();
		//$('#modal-center2').html();
    }
            });

			$.fn.dataTable.ext.errMode = 'none';
        $('#tickets').DataTable({
			"searching":true,
			"paging":true,
           "order": [[ 0, "desc" ]]
        });

			$("#tickets").load(location.href+" #tickets>*","");  
		   
		    $('#modal-center2').modal('hide');
			$('#modal-center3').modal('show');
				
    }
            });

           




	}
	return false;
}

	</script>
	<script type="text/javascript">
	function verif(id){
    swal({
  title: ' vous éte sur?',
  text: "Voulez vous supprimer ce lead!",
  type: "warning",
  imageWidth: '400',
  imageHeight: '150',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'oui, je confirme',
  cancelButtonText: 'Non',
  confirmButtonClass: ' btn-primary ',
  cancelButtonClass: 'btn-danger',
  buttonsStyling: true
}).then(function(){
    swal(
      'Supprimée!',
      'Votre lead est supprimée.',
      'success'
    ).then(function(){
        $.ajax({
                url:'https://www.yestravaux.com/webservice/crm/lead.php',
                type: "POST",
                dataType: "html",
 
                data: {fct:'DeleteLead',lead_id:id },
                async: true,
                success:function(data){
					console.log(data);
					console.log("fine");
        $('verifid').html();
    }
            });
			
			$.fn.dataTable.ext.errMode = 'none';
        $('#tickets').DataTable({
			"searching":true,
			"paging":true,
           "order": [[ 0, "desc" ]]
        });

			$("#tickets").load(location.href+" #tickets>*","");  


    })
   
},function (dismiss) {
  // dismiss can be 'cancel', 'overlay',
  // 'close', and 'timer'
  if (dismiss === 'cancel') {
    swal(
      'Annulée',
      'la suppression a été annulée :)',
      'error'
    )
  }
})
    return false;
	}
	//document.body.setAttribute('dir', 'rtl')	

	function UpdateStatusLead(id) {
	var element=document.getElementById('statelead'+id);
	var idx=element.selectedIndex;
    var val=element.options[idx].value;
    var content=element.options[idx].innerHTML;
	val=parseInt(val);
	var selectoption="";
	if(val == 2){
		selectoption="custom-select btn-success";
	}
	else if(val == 1){
		selectoption="custom-select btn-danger";

	}
	else{
		selectoption="custom-select btn-warning";

	}
	console.log(parseInt(val));
	$.ajax({
                url:'https://www.yestravaux.com/webservice/crm/lead.php',
                type: "POST",
                dataType: "html",
 
                data: {fct:'UpdateLeadStatus',lead_id:id,statuslead:parseInt(val)},
                async: true,
                success:function(data){	
                    console.log(data);
					element.className=selectoption;
					element.options[idx].selected='selected';
					$('verifid').html();

				}
			});
			$.fn.dataTable.ext.errMode = 'none';
        $('#tickets').DataTable({
			"searching":true,
			"paging":true,
           "order": [[ 0, "desc" ]]
        });

			$("#tickets").load(location.href+" #tickets>*","");  
			return true;
          
}


function FindLeadByCompany() {
	var element=document.getElementById('listleadcmp');

	var idx=element.selectedIndex;
    var val=element.options[idx].value;
	element.options[idx].selected='selected';
	$.ajax({
                url:'components/pages/componySession.php',
                type: "POST",
                dataType: "html",
 
                data: {campaign_id:val},
                async: true
               
			});

			$('verifid').html();

            //window.location.href="index.php?page=leadtest";
           // $("#verifid").load(location.href+" #verifid>*","");  
		

		   $.fn.dataTable.ext.errMode = 'none';
        $('#tickets').DataTable({
			"searching":true,
			"paging":true,
           "order": [[ 0, "desc" ]]
        });

			$("#tickets").load(location.href+" #tickets>*","");  

		   
			return true;
          
}



	</script>


<script>
  

    </script>
