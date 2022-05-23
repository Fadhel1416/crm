<?php
header('Access-Control-Allow-Origin: *');





ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Paris');
$b = new MongoClient("localhost:37011");
$db = $b->crm; // select db 
$lead = $db->t_lead;
$tab=json_decode($_POST['searchTermtab']);
$tab=(array) $tab;
$lead_societe =$tab["searchTerm"];
$id_comp =  $tab["idcomp"];
session_start();

if(!isset($_SESSION["PK_USER"])){

  echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";

}
$_SESSION['sessioncamp']=$id_comp;
$output = "";
if(isset($tab["pagenumber"])){
  $currentPage =intval($tab["pagenumber"]);
}else{
  $currentPage = 1;
}

if($lead_societe!=''){
  $cursor = $lead->find(array('campaign_id' => $id_comp,'$or'=>array(
    array('societe' => new MongoRegex('^'.$lead_societe.'/')),
  array('email' => new MongoRegex('^'.$lead_societe.'/')),
  
  array('nom' => new MongoRegex('^'.$lead_societe.'/')),
  array('prenom' => new MongoRegex('^'.$lead_societe.'/'))
  )))->sort(array('_id'=>-1));

$nbleads=$cursor->count();
$parPage = 5;
$pages = ceil($nbleads / $parPage);
$premier = ($currentPage * $parPage) - $parPage;
  $cursor1=$cursor->limit($parPage)->skip($premier);


if($cursor->count() == 0){
    $output .=  '<a class="media media-single" href="#">
    <div class="media-body ps-15 bs-5 rounded border-danger text-bold">
    Aucun leads n \'est disponible </div>
  </a>';
}else{
foreach ($cursor1 as $document) 
                    {
                      $lead_id =  json_decode(json_encode($document["_id"]), true);
                      $leadid= $lead_id['$id'];
                      $class="";
                      $type="";
                      if(!array_key_exists("status",$document)){
                        $document["status"]=0;
                      }
                      if(!array_key_exists("societe",$document)){
                        $document["societe"]=$document["companyName"];
                      }
                      if($document["status"]==2){
                        $class="badge badge-success";
                        $type="Traité";

                      }
                      elseif($document["status"]==1)
                      {
                        $class="badge badge-danger";
                        $type="En Cour";
                      }
                      else{
                        $class="badge badge-warning";
                        $type="Nouveau";
                      }
                      $date="";
                      if(array_key_exists("DATE_ADD_LEAD",$document)){
                        
                        $date=$document["DATE_ADD_LEAD"];
                        $icon='<i class="fa fa-calendar"></i> ';

                      }
                      if(array_key_exists("nom",$document)){
                        $nom=$document["nom"];
                      }
                      
                      else{
                        $nom="";
                      }
                      if(array_key_exists("prenom",$document)){
                        $prenom=$document["prenom"];
                      }
                      else{
                        $prenom="";
                   }
                  
                      $output .=' 
    
          <div class="box bg-lightest no-shadow">
                
        <div class="box-body p-2">
        
          <div class="media-list bb-1 bb-dashed border-light">
            <div class="media align-items-center">
            
              <div class="media-body">

                <ul class="nav d-block nav-stacked">
                  <li class="nav-item"><h5>
                    <a class="hover-primary" href="index.php?page=lead&id='.$leadid.'"><strong>'.$document["societe"].'.</strong></a>
                    </h5></li>
                  <li class="nav-item"><label class="text-info">'.$document["email"].'</label></li>
                  <li class="nav-item"><label class="text-info">'.$nom.' '.$prenom.'</label></li>
                  <li class="nav-item"><small class="text-fade"><i class="fa fa-calendar"></i>'.$icon .''.$date.' </small> </li>
                </ul>
              </div>
              <div class="media-right">
                <span class="'.$class.'">'.$type.'</span>
              </div>
            </div>          
            
          </div>
          
        </div>
    </div>';
    }

}
if($pages>1){
  $output1="";
  $test1="";
  $test2="";
  if($currentPage == 1){
    $tt=$currentPage - 1;
  
    $test1='<li class="paginate_button page-item  previous disabled  " id="productorder_previous">
    <a href="#" onClick="nextPage2('.$tt.');" class="page-link height30" >Previous</a>
  </li>';
  }
  else{
    $tt=$currentPage - 1;
  
    $test1='<li class="paginate_button page-item previous" id="productorder_previous">
    <a href="#" onClick="nextPage2('.$tt.');"  class="page-link  height30" >Previous</a>
  </li>';
  }
  
  for($page=1;$page<=$pages; $page++){
    if($currentPage == $page){
    $output1.='<li class="paginate_button page-item active">
          <a href="#" onClick="nextPage2('.$page.');" class="page-link  height30">'.$page.'</a>
      </li>';}
      else{
        $output1.='<li class="paginate_button page-item">
        <a href="#" onClick="nextPage2('.$page.');" class="page-link height30">'.$page.'</a>
    </li>';
      }
  } 
  if($currentPage == $pages){
    $tt1=$currentPage + 1;
    $test2= '<li class="paginate_button page-item next disabled" id="productorder_next">
    <a href="#" onClick="nextPage2('.$tt1.');"  class="page-link height30">Next</a>
  </li>';
  }
  else{
    $tt1=$currentPage + 1;
    $test2= '<li class="paginate_button page-item next" id="productorder_next">
    <a href="#" onClick="nextPage2('.$tt1.');"  class="page-link height30" >Next</a>
  </li>';
  }
  $output.='<div class="row"><div class="col-lg-2 col-md-2 col-sm-2"></div><div class="col-lg-5 col-md-6 col-sm-6"><div class="dataTables_paginate paging_simple_numbers " id="example1_paginate">
  <ul class="pagination ">
      ';
      $output.=$test1;
      $output.=$output1;
      $output.=$test2;
       
  $output.='</ul></div></div></div>
  ';}
}

$data=array(
'output'=>$output,
'countleads'=>$nbleads
);

  echo json_encode($data);









?>