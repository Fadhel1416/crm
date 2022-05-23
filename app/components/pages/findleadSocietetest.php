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
$_SESSION['sessioncamp']=$id_comp;
$output = "";
if(isset($_REQUEST["pagenumber"])){
  $currentPage =intval($_REQUEST["pagenumber"]);
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
$parPage = 4;
$pages = ceil($nbleads / $parPage);
$premier = ($currentPage * $parPage) - $parPage;
  $cursor1=$cursor->limit($parPage)->skip($premier);


if($cursor->count() == 0){
    $output .= '<div class="box" style="height:50px">
    <div class="box-body">
                   
    <div class="bg-light text-center rounded p-50 b-1 mb-30"><h4>Aucun lead n’est disponible</h4></div></div></div>';



}else{
foreach ($cursor1 as $document) 
                    {
                      $lead_id =  json_decode(json_encode($document["_id"]), true);
                      $leadid= $lead_id['$id'];
                      $class="";
                      $type="";
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
                      $output .=' <div class="box bg-primary-light">
    
      <div class="box-body p-0">
       
        <div class="media-list bb-1 bb-dashed border-light">
        <div class="media align-items-center">
         
          <div class="media-body">
          <p class="fs-16">
            <a class="hover-primary" href="index.php?page=lead&id="'. $leadid.'><strong>'.$document["societe"].'</strong>
          </p>
            '.$document["email"].' <br>
            '.$nom.' '.$prenom.'<br>
            '.$date.'
            </a>
          </div>
          <div class="media-right">
          <span style="width:70px" class="'.$class.'">'.$type.'</span>
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
    
      $test1='<li class="page-item disabled">
      <a href="#" onClick="nextPage('.$tt.');" class="page-link border-warning" style="width:100px;height:50px;display:inline-block;border-radius: 5px;border: 4px double #cccccc;
      text-color:white;
      text-align: center">Précédente</a>
    </li>';
    }
    else{
      $tt=$currentPage - 1;
    
      $test1='<li class="page-item">
      <a href="#" onClick="nextPage('.$tt.');" class="page-link border-warning" style="width:100px;height:50px;display: inline-block;border-radius: 5px;border: 4px double #cccccc;
      text-color:white;
      text-align: center;marign-bottom:10px;">Précédente</a>
    </li>';
    }
    
    for($page=1;$page<=$pages; $page++){
      if($currentPage == $page){
      $output1.='<li class="page-item active">
            <a href="#" onClick="nextPage('.$page.');" class="button-pagination page-link border-white" style="width:40px;height:50px;display: inline-block;border-radius: 5px;border: 4px double #cccccc;
            text-color:white;
            text-align: center;marign-bottom:30px">'.$page.'</a>
        </li>';}
        else{
          $output1.='<li class="page-item">
          <a href="#" onClick="nextPage('.$page.');" class="button-pagination page-link" style="width:40px;height:50px;display: inline-block;border-radius: 5px;border: 4px double ;
          text-color:white;
          text-align: center;marign-bottom:30px">'.$page.'</a>
      </li>';
        }
    } 
    if($currentPage == $pages){
      $tt1=$currentPage + 1;
      $test2= '<li class="page-item disabled">
      <a href="#" onClick="nextPage('.$tt1.');" class="page-link border-warning" style="width:100px;height:50px;display: inline-block;border-radius: 5px;border: 4px double #cccccc;
      text-color:white;
      text-align: center;marign-bottom:30px">Suivante</a>
    </li>';
    }
    else{
      $tt1=$currentPage + 1;
      $test2= '<li class="page-item ">
      <a href="#" onClick="nextPage('.$tt1.');" class="page-link border-warning" style="width:100px;height:50px;display: inline-block;border-radius: 5px;border: 4px double #cccccc;
      text-color:white;
      text-align: center;marign-bottom:30px">Suivante</a>
    </li>';
    }
    $output.='<div class="row"><div class="col-lg-2"><input type="hidden"></div>
    <div class="col-lg-4"><ul class="pagination pull-center">
        ';
        $output.=$test1;
        $output.=$output1;
        $output.=$test2;
         
    $output.='</ul></div>
    ';
}}

  echo $output;









?>