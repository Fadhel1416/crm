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
$ticket = $db->t_ticket;
//$camp=$db->t_campaign;
$tab=json_decode($_POST['searchTermtab']);
$tab=(array) $tab;
$ticket_search =$tab["searchTerm"];
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

if($ticket_search!=''){

//$campanies=$camp->find(array('userId'=>$pk_user));
$indice=0;


  $cursor = $ticket->find(array('$and'=>array(array('$or'=>array(
    array('nom' => new MongoRegex('^'.$ticket_search.'/')),
  array('prenom' => new MongoRegex('^'.$ticket_search.'/')),
  
  array('email' => new MongoRegex('^'.$ticket_search.'/')),
  array('tel' => new MongoRegex('^'.$ticket_search.'/')),
  array('object' => new MongoRegex('^'.$ticket_search.'/')),
  array('DATE_ADD_TICKET' => new MongoRegex('^'.$ticket_search.'/'))
  )),array('idUser'=>intval($pk_user)))))->sort(array('_id'=>-1));

if($cursor->count() >0){
  $indice=$indice+1;

}

            foreach ($cursor as $document) 
                    { 
                      $ticket_id =  json_decode(json_encode($document["_id"]), true);
                      $ticketid= $ticket_id['$id'];
                      $class="";
                      $type="";
        
                      $date="";
                      if(array_key_exists("DATE_ADD_TICKET",$document)){
                        
                        $date=$document["DATE_ADD_TICKET"];
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
                    


        $output.=' <a href="https://desk.hosteur.pro/tickets/ticket_reply.php?id_ticket='.$ticketid.'" target="_blank"><div class="box-body " style="padding-top:0px">
        <div class="media-list bb-1 bb-dashed border-light">
          <div class="media ">     
            <div class="media-body">
           
              <ul class="nav d-block nav-stacked" style="margin-left:-40px">
            <li class="nav-item">
           
               <span class="text-success" style="margin-left:0px;padding-left:0px">'.$document["email"].'</span>
               <span class="text-info" style="padding-left:10px">'.$nom .' '.$prenom.'</sp>
               <span class="text-info" style="padding-left:10px">'.$document["tel"].'</span>

               <span class="text-warning" style="padding-left:10px">'.$document["object"].'</span>
               
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
  $output .= '<div class="box" style="margin-bottom:0px"><div class="box-body p-0" ><div class="bg-white text-center rounded  b-1"><h5>Aucun ticket n’est disponible</h5></div></div></div>';
}
  echo $output;
?>