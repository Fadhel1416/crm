<?php
header('Access-Control-Allow-Origin: *');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if(!isset($_SESSION["PK_USER"])){

  echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";

}
date_default_timezone_set('Europe/Paris');
$b = new MongoClient("localhost:37011");
$db = $b->crm; // select db 
$lead = $db->t_lead;
$camp=$db->t_campaign;
$tab=json_decode($_POST['searchTermtab']);
$tab=(array) $tab;
$lead_search =$tab["searchTerm"];
$pk_user=$tab["pk_user"];
//$id_comp =  $tab["idcomp"];
//session_start();
//$_SESSION['sessioncamp']=$id_comp;
$output = "";
/*if(isset($_REQUEST["pagenumber"])){
  $currentPage =intval($_REQUEST["pagenumber"]);
}else{
  $currentPage = 1;
}*/

if($lead_search!=''){

$campanies=$camp->find(array('userId'=>$pk_user));
$indice=0;
foreach($campanies as $doc){

  $id_comp=json_decode(json_encode($doc["_id"]),true);
  $idcamp=$id_comp['$id'];

  $cursor = $lead->find(array('$and'=>array(array('$or'=>array(
    array('societe' => new MongoRegex('^'.$lead_search.'/')),
  array('email' => new MongoRegex('^'.$lead_search.'/')),
  array('phone' => new MongoRegex('^'.$lead_search.'/')),

  array('nom' => new MongoRegex('^'.$lead_search.'/')),
  array('prenom' => new MongoRegex('^'.$lead_search.'/')),
  array('DATE_ADD_LEAD' => new MongoRegex('^'.$lead_search.'/'))
  )),array('campaign_id'=>$idcamp))))->sort(array('_id'=>-1));

if($cursor->count() >0){
  $indice=$indice+1;

}

            foreach ($cursor as $document) 
                    { 
                      $lead_id =  json_decode(json_encode($document["_id"]), true);
                      $leadid= $lead_id['$id'];
                      $class="";
                      $type="";
        
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
                    


        $output.=' <a href="index.php?page=lead&id='.$leadid.'" target="_blank"><div class="box-body " style="padding-top:0px">
        <div class="media-list bb-1 bb-dashed border-light" >
          <div class="media ">     
            <div class="media-body">
           
              <ul class="nav d-block nav-stacked" style="margin-left:-40px">
            <li class="nav-item">
           
               <span class="text-success" style="margin-left:0px;padding-left:0px">'.$document["email"].'</span>
               <span class="text-info" style="padding-left:10px">'.$nom .' '.$prenom.'</span>
               <span class="text-info" style="padding-left:10px">'.$document["phone"] .'</span>

               <span class="text-fade" style="padding-left:10px">'.$document["societe"].'</span>
               
               </li>
              </ul>
            </div>
            <div class="media-right">
              <span class="badge badge-dark rounded">'.$date.'</span>
            </div>
          </div>          
          
        </div>
        
        
      </div></a>';





                            }

}
/*
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
*/
}


if($indice==0)
{
  $output .= '<div class="box" style="margin-bottom:0px"><div class="box-body p-0" ><div class="bg-white text-center rounded  b-1"><h5>Aucun lead n’est disponible</h5></div></div></div>';
}
  echo $output;
?>