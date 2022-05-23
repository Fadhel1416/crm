<?php

$sessioncamp="";
$URL     = 'https://www.yestravaux.com/webservice/crm/lead.php';

$POSTVALUE  = 'fct=ListCampaign&user_id=1';

$datacamp = curl_do_post($URL,$POSTVALUE); 
$datacamp = json_decode($datacamp);
$datacamp = (array) $datacamp;
if(isset($_REQUEST["pagenumber"])){
	$pagenumber=(int)$_REQUEST["pagenumber"];
}
else{
	$pagenumber=1;
}

?>
<div class="container-full" style="height:500px;">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Campagne</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Campagnes</li>
								<li class="breadcrumb-item active" aria-current="page">Ajouter campagne</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>	  

		<!-- Main content -->
		<section class="content" style="height:500px">

		 <div class="row">
		
		 <div class="div-res">
		 <div class="box" id="aaa">
			<div class="box-header with-border">
			  <h4 class="box-title">Toutes vos Campagnes</h4>
			  <a href="index.php?page=add-campagne" data-bs-toggle="modal" data-bs-target="#modal-center5" class="waves-effect waves-light btn btn-success-light mb-5 pull-right"><i class="si-plus si" width="100" height="100"></i></a>

			
			</div>
			<!-- /.box-header -->
			<div class="box-body bg-lightest">
             <?php 
							
			
			
			for($i=0;$i<count($datacamp);$i++) { 
				
				$datacampid = (array) $datacamp[$i]->_id;
                                           $id = $datacampid['$id'];
				?>
							<li class="flexbox mb-5" id="refrechdata<?php echo $id;?>" onmouseover="MouseEventOver('<?php echo $id;?>');" onmouseout="MouseEventOut('<?php echo $id;?>');">
							<div>
							  <span class="badge badge-dot badge-lg me-1 bg-<?php echo $i; ?>" ></span>
							  <span  onClick="LoadDataCamp('<?php echo $id;?>');"><a href="#" class=""><?php echo $datacamp[$i]->companyName;?></a></span>
							</div>
							<div>
							<?php if($datacamp[$i]->status==0) {?>
							<button onClick="verif('<?php echo $id ;?>');" class="btn btn-sm btn-toggle"   aria-pressed="true" autocomplete="off">
												<div class="handle"></div>
							</button>
							<?php } else {?>
								<button onClick="verif('<?php echo $id ;?>');" class="btn btn-sm btn-toggle active"  aria-pressed="true" autocomplete="off">
												<div class="handle"></div>
							</button>

							<?php } ?>

								<a href="#" class="text-success" data-bs-toggle="tooltip" data-bs-original-title="Details"><i class="ti-write" aria-hidden="true"></i></a>
	
								<a class="text-danger" data-bs-toggle="tooltip" data-bs-original-title="Delete"  onClick="SupprimerCamp('<?php echo $id;?>');"><i class="ti-trash" aria-hidden="true"></i></a>
						  </li>

						  <?php } ?>
            </div>
            </div>
         </div>
		  <!-- Validation wizard -->
		  <div class="div-res2" style="height: 1000px">
		  <div class="box" style="height:1000px" id="boxid">
		  <?php
		  
		  session_start();
		  if (empty($_SESSION['sessioncamp'])){
			$datacampid = (array) $datacamp[0]->_id;
			$id = $datacampid['$id'];
			$URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
			$POSTVALUE  = 'fct=InfoCampagne&camp_id='.$id;
			$datacamp = curl_do_post($URL,$POSTVALUE);
			$datacamp = json_decode($datacamp);
			$datacamp = (array) $datacamp;
			$datacampid = (array) $datacamp['_id'];
			$datacamp['_id'] = $datacampid['$id'];
			  ?>
             <input type="hidden" value="<?php echo $pagenumber;?>" id="idpagenumber">

				<div class="row" id="statusread"  style="height: 900px">
				<div class="col-12 col-lg-7 col-xl-9" style="height: 900px">
				
				<div class="nav-tabs-custom" style="height: 1000px" >
				<ul class="nav nav-tabs">
				<li><a href="#leadstab" data-bs-toggle="tab" class="active">leads</a></li>

					<li><a href="#settings" data-bs-toggle="tab" >Info</a></li>
					<li><a href="#usertimeline" data-bs-toggle="tab">settings</a></li>
				
				</ul>

				<div class="tab-content" style="height: 1000px">

					<div class="tab-pane" id="usertimeline">
					<div class="publisher publisher-multi bg-white b-1 mb-30">
					
						</div>
					</div> 
		
				<div class="tab-pane" id="settings">		
			
				<div class="box no-shadow">		
				<form class="form-horizontal form-element col-7">
				<?php foreach($datacamp as $cle => $valeur) {  
					if($cle =='_id' or $cle == 'userId'){ $disabled="disabled " ;} else {$disabled ="";}
					if($cle =='companyName'){ $type='text';} 
					if($cle != 'status') {

						?>
			   
			 <div class="form-group row">
			   <label for="<?php echo $cle ; ?>" class="col-sm-3 form-label"><?php echo $cle ; ?></label>

			   <div class="col-sm-9">
				 <input type="<?php echo $type; ?>" class="form-control" id="<?php echo $cle ; ?>" name="<?php echo $cle ; ?>" placeholder="" value="<?php echo $valeur ; ?>" <?php echo $disabled; ?>>
					   </div>
			 </div>

			<?php } } ?>
			<span id="hiddenconfirmupdate"></span>			

			  <br>
			
			
			
		   </form>
		   <br>
		   <div class="form-group row">
			   <div class="ms-auto col-sm-10">
				 <button onClick="UpdateCampInfo('<?php echo $datacamp['_id'];?>');" class="btn btn-primary">Enregistrer</button>
			   </div>
			 </div>
	   </div>			  
	 </div>
	 <div class="tab-pane active" id="leadstab" style="margin-bottom: 0px" >
		   <div class="search" id="search">
			   <span class="text"></span>
			   <input type="hidden" value=<?php echo $datacamp['_id'];?> id="campidhidden">
			   <input type="text" placeholder="Recherche Lead....." id="input-search" onkeyup="myFunction();" onClick="searchel();">
			   <button class="btn btn-dark-light" id="button-search" onClick="searchel();"><i class="fas fa-search" id="search-icon"></i></button>
		   </div>
		   <div class="" id="user-list" style="height: 800px;padding-bottom:20px">

		   </div>
	   

   </div>
	 <!-- /.tab-pane -->
   </div>
   <!-- /.tab-content -->
 </div>
 <!-- /.nav-tabs-custom -->
</div>
<!-- /.col -->		

 <div class="div-res3">
	<div class="box box-widget widget-user">
	   <!-- Add the bg color to the header using any of the bg-* classes -->
	   <div class="widget-user-header bg-img bbsr-0 bber-0" style="background: url('../images/gallery/full/10.jpg') center center;" data-overlay="5">
		 <h3 class="widget-user-username text-white"><?php echo $datalead['nom_prenom'];?></h3>
		 <!--h6 class="widget-user-desc text-white"><?php echo $datalead['_id'];?></h6-->
		 <h6 class="widget-user-desc text-white"><?php echo $datalead['societe'];?></h6>
	   </div>
	   <div class="widget-user-image">
		 <img class="rounded-circle" src="../images/user3-128x128.jpg" alt="User Avatar">
	   </div>
	   <div class="box-footer">
		 <div class="row">
			 <div class="col-sm-3">

			 </div>
		   <div class="col-sm-5">
			 <div class="description-block">
			   <h5 class="description-header">Campagne</h5>
			   <span class="description-text"><?php echo $datacamp['companyName']; ?></span>
			 </div>
			 <!-- /.description-block -->
		   </div>
	   
	   
		   <!-- /.col -->
		 </div>
		 <!-- /.row -->
	   </div>
	 </div>
	 

 </div>

</div>
		
			<!-- /.box-body -->
			<?php } else {
				 $URL     = 'https://www.yestravaux.com/webservice/crm/campaign.php';
				 $POSTVALUE  = 'fct=InfoCampagne&camp_id='.$_SESSION['sessioncamp'];
				 $datacamp = curl_do_post($URL,$POSTVALUE);
				 $datacamp = json_decode($datacamp);
				 $datacamp = (array) $datacamp;
				 $datacampid = (array) $datacamp['_id'];
				 $datacamp['_id'] = $datacampid['$id'];
			
				
				
				?>
								<input type="hidden" value="<?php echo $pagenumber;?>" id="idpagenumber1">

			 <div class="row" id="statusread"  style="height: 900px">
			<div class="col-12 col-lg-7 col-xl-9" style="height: 900px">
				
			  <div class="nav-tabs-custom" style="height: 1000px" >
				<ul class="nav nav-tabs">
				<li><a href="#leadstab" data-bs-toggle="tab" class="active">leads</a></li>

				  <li><a href="#settings" data-bs-toggle="tab" >Info</a></li>
				  <li><a href="#usertimeline" data-bs-toggle="tab">settings</a></li>
				
				</ul>

				<div class="tab-content" style="height: 1000px">

				 <div class="tab-pane" id="usertimeline">
					<div class="publisher publisher-multi bg-white b-1 mb-30">
					
					  </div>
					</div> 
                     
				  <div class="tab-pane" id="settings">		
				
					<div class="box no-shadow">		
						<form class="form-horizontal form-element col-7">
						<?php foreach($datacamp as $cle => $valeur) {  
							if($cle =='_id' or $cle == 'userId'){ $disabled="disabled " ;} else {$disabled ="";}
							if($cle =='companyName'){ $type='text';} 
							if($cle != 'status') {

								?>
                            
						  <div class="form-group row">
							<label for="<?php echo $cle ; ?>" class="col-sm-3 form-label"><?php echo $cle ; ?></label>

							<div class="col-sm-9">
							  <input type="<?php echo $type; ?>" class="form-control" id="<?php echo $cle ; ?>" name="<?php echo $cle ; ?>" placeholder="" value="<?php echo $valeur ; ?>" <?php echo $disabled; ?>>
									</div>
						  </div>

                         <?php } } ?>
						 <span id="hiddenconfirmupdate"></span>			

                           <br>
						 
						 
						 
						</form>
						<br>
						<div class="form-group row">
							<div class="ms-auto col-sm-10">
							  <button onClick="UpdateCampInfo('<?php echo $datacamp['_id'];?>');" class="btn btn-primary">Enregistrer</button>
							</div>
						  </div>
					</div>			  
				  </div>
				  <div class="tab-pane active" id="leadstab" style="margin-bottom: 0px" >
						<div class="search" id="search1">
							<span class="text"></span>
							<input type="hidden" value=<?php echo $datacamp['_id'];?> id="campidhidden1">
							<input type="text" placeholder="Recherche Lead....." id="input-search1" onkeyup="myFunction();" onClick="searchel();">
							<button class="btn btn-dark-light" id="button-search" onClick="searchel();"><i class="fas fa-search" id="search-icon1"></i></button>
						</div>
						<div class="" id="user-list1" style="height: 800px;padding-bottom:20px">

						</div>
					

				</div>
				  <!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			  </div>
			  <!-- /.nav-tabs-custom -->
			</div>
			<!-- /.col -->		

			  <div class="div-res3">
				 <div class="box box-widget widget-user">
					<!-- Add the bg color to the header using any of the bg-* classes -->
					<div class="widget-user-header bg-img bbsr-0 bber-0" style="background: url('../images/gallery/full/10.jpg') center center;" data-overlay="5">
					  <h3 class="widget-user-username text-white"><?php echo $datalead['nom_prenom'];?></h3>
					  <!--h6 class="widget-user-desc text-white"><?php echo $datalead['_id'];?></h6-->
					  <h6 class="widget-user-desc text-white"><?php echo $datalead['societe'];?></h6>
					</div>
					<div class="widget-user-image">
					  <img class="rounded-circle" src="../images/user3-128x128.jpg" alt="User Avatar">
					</div>
					<div class="box-footer">
					  <div class="row">
						  <div class="col-sm-3">

						  </div>
						<div class="col-sm-5">
						  <div class="description-block">
							<h5 class="description-header">Campagne</h5>
							<span class="description-text"><?php echo $datacamp['companyName']; ?></span>
						  </div>
						  <!-- /.description-block -->
						</div>
					
					
						<!-- /.col -->
					  </div>
					  <!-- /.row -->
					</div>
				  </div>
				  
			
			  </div>

		  </div>
			<!-- /.col -->		

			
			<?php } session_destroy();?>

		  </div>

		  </div>
		  <!-- /.box -->
        
         </div>
         </div>
		 <div class="modal  fade" id="modal-center5" style="width:80%">
	  <div class="modal-dialog" style="width:1000px">
		<div class="modal-content bg-lightest" style="width:1000px;border-radius:1rem;border:2px solid #e9e9f2">
		  <div class="modal-header bg-lightest" style="border-top-left-radius: calc(1rem - 2px); border-top-right-radius: calc(1rem - 2px);">
			<h5 class="modal-title"><b>Ajouter Campagne</b></h5>
			<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
		  </div>
		  <div class="modal-body"  style="width:1000px">
		  <div class="box-body wizard-content" style="width:1000px">
				<form action="#" class="" id="idformcamp">
					<!-- Step 1 -->
					<h6 class="btn btn-success">Compte Administrateur</h6>
					<section>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="wfirstName2" class="form-label"> Nom  </label>
									<input type="text" style="border-radius:1rem;border:2px solid #e9e9f2" class="form-control required" placeholder="tapez le nom de votre campagne" id="wcampagnename" name="firstName"> 
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								<span class="alert text-danger" id="errorval2" name="errorval2" ></span>

								</div>
							</div>
						</div>
					
						
					</section>
			
				
				</form>
			</div>
			
			<div class="modal-footer modal-footer-uniform">
							  
			<a href="#" class="btn bg-gradient-grey" style="border-radius:.75rem;border:1px solid #e9e9f2" data-bs-dismiss="modal" aria-label="Close">Retour</a>

<button class="btn bg-gradient-purple" style="border-radius:.75rem;border:1px solid #e9e9f2" name="Enregister" id="tttt3" onClick="addCampjs();">Enregister</button>
				  
							  
							</div></div></div></div>
		</section>
		<!-- /.content -->
		<div class="modal center-modal fade" id="modal-center4">
	  <div class="modal-dialog">
		<div class="modal-content bg-success">
		  <div class="modal-header">
			<h5 class="modal-title"><b>Confirmation Campagne</b></h5>
			<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
		  </div>
		  <div class="modal-body" style="height:200px">
		
		  Félicitations ! Votre campagne Est modifier



		  </div>
		  
		</div>
	  </div>
	</div>
	  </div>
	  <div class="modal center-modal fade" id="modal-center6">
	  <div class="modal-dialog">
		<div class="modal-content bg-success">
		  <div class="modal-header">
			<h5 class="modal-title"><b>Confirmation Campagne</b></h5>
			<a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
		  </div>
		  <div class="modal-body">
		
		  Félicitations ! Votre campagne Est créer



		  </div>
		  
		</div>
	  </div>
	</div>
	  </div>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	  <script>
// request avec XMLHTTPREQUEST for ajax ............
function myFunction(){
	const searchBar =document.getElementById('input-search1');
	var usersList = document.getElementById('user-list1');
	var idcamp=document.getElementById('campidhidden1').value;
	dataleadfind={};

	let searchTerm = searchBar.value;
  if(searchTerm != ""){
    searchBar.classList.add("active");
  }else{
    searchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "components/pages/findleadSocietetest.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          usersList.innerHTML = data;
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  dataleadfind["searchTerm"]=searchTerm;
  dataleadfind["idcomp"]=idcamp;
  xhr.send("searchTermtab=" + JSON.stringify(dataleadfind));


}
function searchel()
{
	var searchBar =document.getElementById('input-search1');
	var usersList = document.getElementById('user-list1');
	var searchIcon =document.getElementById('search-icon1');

	searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if(searchBar.classList.contains("active")){
    searchBar.value = "";
    searchBar.classList.remove("active");
  }

 
 
}



setInterval(() =>{
	var idcamp=document.getElementById('campidhidden1').value;
	var usersList = document.getElementById('user-list1');
    	var searchBar =document.getElementById('input-search1');
		var idpagenumber =document.getElementById('idpagenumber1').value;

		let xhr = new XMLHttpRequest();
  xhr.open("GET", "components/pages/testpagination.php?campaign_id="+idcamp+"&pagenumber="+ idpagenumber, true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
		  if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data;
          }          
        }
    }
  }
  xhr.send();
}, 500)


/*function ListLeadByCampany(id){
	var usersList = document.getElementById('user-list');

	$.ajax({
                url:'https://www.yestravaux.com/webservice/crm/lead.php',
                type: "POST",
                dataType: "html",
                data: {fct:'ListCampLead',campaign_id:id},
                async: true,
                success:function(data){
					console.log(data);
					console.log("fine");
					usersList.innerHTML=data;

    }
            });
			return true;
}*/

	  </script>

	<script type="text/javascript">
function SupprimerCamp(id){
    swal({
  title: 'Etes-vous sûr ?',
  text: "Voulez vous supprimer cette campagne!",
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
      'Supprimée!',
      'Votre campagne est supprimée.',
      'success'
    ).then(function(){
        $.ajax({
                url:'https://www.yestravaux.com/webservice/crm/campaign.php',
                type: "POST",
                dataType: "html",
                data: {fct:'DeleteCampagne',camp_id:id },
                async: true,
                success:function(data){
					console.log(data);
					console.log("fine");
        $('aaa').html();
		$("#aaa").load(location.href+" #aaa>*","");  

    }
            });
		
			$("#aaa").load(location.href+" #aaa>*","");  


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
    return false;
	}

function verif(id){

	
                       
	$.ajax({
                url:'https://www.yestravaux.com/webservice/crm/campaign.php',
                type: "POST",
				dataType: 'html',
				data:{fct:'verifcamp',camp_id:id},
                success:function(data){
					console.log(data);
					console.log("fine");
    },
	error:function(){
		console.log("error");
	}
            });
			//LoadDataCamp(id);
           $("#aaa").load(location.href+" #aaa>*","");
           
         return true;
		 

}



function LoadDataCamp(id){

	$.ajax({
                url:'components/pages/companySession2.php',
                type: "POST",
                dataType: "html",
                data:{camp_id:id},
                async: true,
				success:function(data){
					console.log(data);
					console.log("fine");
        $('boxid').html(); // rafraichi toute ta DIV "bien sur il lui faut un id "
    }
               
			});

			$("#boxid").load(location.href+" #boxid>*","");  
		   
			return true;

}
function UpdateCampInfo(id){
	var companyname=document.getElementById('companyName').value;
	var hiddenvalue=document.getElementById('hiddenconfirmupdate');
	var datastring={};
          datastring['companyName']=companyname;
		  data_camp=JSON.stringify(datastring);

	$.ajax({
                url:'https://www.yestravaux.com/webservice/crm/campaign.php',
                type: "POST",
                dataType: "html",
 
                data: {fct:'UpdateCamp',data:data_camp,camp_id:id},
                async: true,
                success:function(data){	
                    console.log(data);
					
				},
				error:function(err){
					hiddenvalue.innerHTML="something wrong";
					hiddenvalue.className="style_span btn btn-danger";
				}
			});
			$('aaa').html();

			$("#aaa").load(location.href+" #aaa>*","");  
			$('#modal-center4').modal('show');

			





	return false;
}






function addCampjs()
{
	var nomcompagne=document.getElementById('wcampagnename').value;
	var errorval=document.getElementById('errorval2');
	var form=document.getElementById('idformcamp');

	if(nomcompagne == ""){
    errorval.innerHTML="vous douvez choisir le nom de campagne";
	errorval.focus();
	}
	else{
		var datastring={};
          datastring['userId']="1";
		  datastring['companyName']=nomcompagne;
		  datastring['status']=0;


		  form.reset();
datajson=JSON.stringify(datastring);

$.ajax({
                url:'https://www.yestravaux.com/webservice/crm/campaign.php',
                type: "POST",
                dataType: "html",
 
                data: {fct:'addCamp',data:datajson},
                async: true,
                success:function(data){
					console.log("fine");
				
        $('aaa').html();
		//$('#modal-center2').html();
		$("#aaa").load(location.href+" #aaa>*",""); 

    }
            });  
			$("#aaa").load(location.href+" #aaa>*",""); 
			$('#modal-center5').modal('hide');
 
			$('#modal-center6').modal('show');


	}


}

function MouseEventOver(id)
	{
		document.getElementById('refrechdata'+id).className="flexbox mb-5 bg-light";
	}
	
	function MouseEventOut(id)
	{
		document.getElementById('refrechdata'+id).className="flexbox mb-5";
	}



    function nextPage(numpage,idcampaign){
     
 var idcamp=document.getElementById('campidhidden1').value;
	var usersList = document.getElementById('user-list1');
    	var searchBar =document.getElementById('input-search1');
		var idpagenumber =document.getElementById('idpagenumber1').value;

		let xhr = new XMLHttpRequest();
  xhr.open("GET", "components/pages/testpagination.php?campaign_id="+idcamp+"&pagenumber="+ numpage, true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
		  if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data;
            document.getElementById('idpagenumber1').value=numpage;
          }          
        }
    }
  }
  xhr.send();
console.log(numpage);
console.log(idpagenumber);


  }




    



	</script>
