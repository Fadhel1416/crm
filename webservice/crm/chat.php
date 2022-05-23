<?php
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once "config.inc.php";
include_once "commun.inc.php";  
//ini_set ("display_errors",1);
$b = new MongoClient("localhost:37011");
$db = $b->crm; // select db 
$room=$db->t_room;
$message=$db->t_message_room;

global $sqlserver;


if($_REQUEST['fct']=='AddChannel'){


}


if($_REQUEST['fct']=="GetListRooms"){
$result=[];
$pk_user=$_REQUEST['pk_user'];



$list_room=$room->find(array('idUser'=>$pk_user));

foreach($list_room as $doc)
{
    $res["name"]=$doc["name"];
    $res["created_on"]=$doc["created_on"];
    $room_id =  json_decode(json_encode($doc["_id"]), true);
    $id= $room_id['$id'];  
    $res["room_id"]=$id;
    $res["k_key_user"]=$doc["k_key_user"];

    array_push($result,$res);  
}

echo json_encode($result);

}
   if($_REQUEST['fct']=='InsertMessage')
   {
        $msg=$_REQUEST['message'];
        $room_id=$_REQUEST['room_id'];
        $pk_user=$_REQUEST['pk_user'];
        $k_key=$_REQUEST['k_key'];

        $sqlprofil = $sqlserver->prepare("select top 1 PK_USER, S_EMAIL,S_NAME from t_user where K_KEY = ?");
        $sqlprofil->execute(array($_REQUEST['k_key'])) or die (print_r($sqlprofil->errorInfo()));
        $UserAccount = $sqlprofil->fetchObject();
        $message_room["pk_user"]=$pk_user;
        $message_room["k_key"]=$k_key;
        $message_room["room_id"]=$room_id;
        $message_room["message"]=$msg;

        $message->insert($message_room);

        //  $output='';
        // if($message_room["_id"]!=null)
        // {
        //    $ListMessage=$message->find(array("pk_user"=>$pk_user,"room_id"=>$room_id));

        //    foreach($ListMessage as $msg)
        //    {
        //     $sqlprofil = $sqlserver->prepare("select top 1 PK_USER, S_EMAIL,S_NAME from t_user where K_KEY = ?");
        //     $sqlprofil->execute(array($msg['k_key'])) or die (print_r($sqlprofil->errorInfo()));
        //     $UserAccount = $sqlprofil->fetchObject();
        //        if($msg["k_key"]==$k_key){
               

        //            $output.=' <div class="mb-3 float-end me-2 max-w-p80">
        //            <div class="position-absolute pt-1 pe-2 r-0">
        //                <span class="text-extra-small"></span>
        //            </div>
        //            <div class="card-body">
                      
        //                <div class="chat-text-start ps-55">
        //                    <p class="mb-0 text-semi-muted bg-light rounded text-info">'.$msg["message"].'.</p>
        //                </div>
        //            </div>
        //          </div>
        //          <div class="clearfix"></div>';
        //        }
        //        else{
        //           $output.=' <div class="  mb-3 float-start me-2 no-shadow  max-w-p80">
        //           <div class="position-absolute pt-1 pe-2 r-0">
        //               <span class="text-extra-small text-muted">09:25</span>
        //           </div>
        //           <div class="card-body">
        //               <div class="d-flex flex-row pb-2">
        //                   <a class="d-flex" href="#">
        //                       <img alt="Profile" src="../images/avatar/1.jpg" class="avatar me-10">
        //                   </a>
        //                   <div class="d-flex flex-grow-1 min-width-zero">
        //                       <div class="m-2 ps-0 align-self-center d-flex flex-column flex-lg-row justify-content-between">
        //                           <div class="min-width-zero">
        //                               <p class="mb-0 fs-16 text-dark">'.$UserAccount->S_NAME.'</p>

        //                           </div>
        //                       </div>
        //                   </div>
        //               </div>
        //               <div class="chat-text-start ps-55">
        //                   <p class="mb-0 text-semi-muted text-fade">'.$msg["message"].'</p>
        //               </div>
        //           </div>
        //         </div>
        //         <div class="clearfix"></div>';





        //        }

        //    }



        // }
        // else{

        //    $output="error";



        // }

     


//echo $output;


   }


   if($_REQUEST['fct']=='GetMessages')
   {
        $room_id=$_REQUEST['room_id'];
        $pk_user=$_REQUEST['pk_user'];
        $k_key=$_REQUEST['k_key'];

      
           $ListMessage=$message->find(array("pk_user"=>$pk_user,"room_id"=>$room_id));
           $output='';
           foreach($ListMessage as $msg)
           {
            $sqlprofil = $sqlserver->prepare("select top 1 PK_USER, S_EMAIL,S_NAME,S_IMAGE from t_user where K_KEY = ?");
            $sqlprofil->execute(array($msg['k_key'])) or die (print_r($sqlprofil->errorInfo()));
            $UserAccount = $sqlprofil->fetchObject();
            if($UserAccount->S_IMAGE !=null){
                $urlimage="https://www.yestravaux.com/pro/manager/photos/".$UserAccount->S_IMAGE;}
                else{
                    $urlimage="images/Guest2.png";
                
                }
               if($msg["k_key"]==$k_key){
               

                   $output.=' <div class="mb-3 float-end me-2 max-w-p80">
                   <div class="position-absolute pt-1 pe-2 r-0">
                       <span class="text-extra-small"></span>
                   </div>
                   <div class="card-body">
                       
                       <div class="chat-text-start ps-55">
                           <p class="mb-0 text-semi-muted bg-light rounded  text-info">'.$msg["message"].'</p>
                       </div>
                   </div>
                 </div>
                 <div class="clearfix"></div>';
               }
               else{
                  $output.=' <div class="  mb-3 float-start me-2 no-shadow  max-w-p80">
                  <div class="position-absolute pt-1 pe-2 r-0">
                  </div>
                  <div class="card-body">
                      <div class="d-flex flex-row pb-2">
                          <a class="d-flex" href="#">
                              <img alt="Profile" src="'.$urlimage.'" class="avatar me-10">
                          </a>
                          <div class="d-flex flex-grow-1 min-width-zero">
                              <div class="m-2 ps-0 align-self-center d-flex flex-column flex-lg-row justify-content-between">
                                  <div class="min-width-zero">
                                      <p class="mb-0 fs-16 text-dark">'.$UserAccount->S_NAME.'</p>

                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="chat-text-start ps-55">
                          <p class="mb-0 text-semi-muted  text-fade">'.$msg["message"].'</p>
                      </div>
                  </div>
                </div>
                <div class="clearfix"></div>';





               }

           }


echo $output;


   }











$b->close();


?>