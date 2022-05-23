
<?php
// session_start();
// include_once "../../config.inc.php";
// global $sqlserver;



// if(!isset($_SESSION["PK_USER"])){

//   echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";

// }



$clientBrowser = $_SERVER['HTTP_USER_AGENT'];

/*$data=array('campaign_id'=>"6229f709ff8911c89d000090",'nom'=>"jfdggh",'prenom'=>"fidgjdf",'email'=>"ali.f@externalisation.pro",
	'phone'=>"42165140",
	'societe'=>"hosteur",
	'companyName'=>"hosteur",
	'api_key'=>"LEO3Y5O1Fnd0OxKZsK0dfdfdfsdf7d0nshARtsiX3hAsvJ0zxfrHrj4nGtK3sKokHLGrt7vq3odWhbq3FP6RhanDM"
  );
  $data=json_encode($data);
  $URL='https://www.yestravaux.com/webservice/crm/lead.php';
  $POSTVALUE='fct=AddLeadApi&data='.$data; 
  $dataAddLead=curl_do_post($URL,$POSTVALUE);
  $newdata=json_decode($dataAddLead,true);
  $newdata=(array) $newdata;

var_dump($newdata);
$URL='https://www.yestravaux.com/webservice/crm/lead.php';
 $POSTVALUE='fct=LeadList&campaign_id=6229f709ff8911c89d000029&api_key=iRednVJMa8a00Y1WBa7UkUihGHRD9HMZlx7MGxY3f15ViXzqbANUJY3levWd0eVOtHon0Ap0jGlECsY7tF0Juyq2BL'; 
 $dataLeadLists=curl_do_post($URL,$POSTVALUE);
 $result=json_decode($dataLeadLists,true);
var_dump($result);*/
?>
   
 <!-- Content Wrapper. Contains page content -->
	  <div class="container-full" >
		
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Documentations</h4>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="fa fa-user"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Doc</li>
							</ol>
						</nav>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Main content -->
		<section class="content" id="refresh-users">
        
		  <div class="row">
          <div class="col-sm-8 col-xl-8">	
					<div class="box">
                        <h3><span class="text-dark" style="padding-left:10px"><b>Developper Introducations</b></span></h3>
						<p class="" style="text-size:12px;padding-left:10px">Get started with CRM Admin,the world’s most popular CRM for managing your activities. You can find here some of free API examples that can be used for testing our services.</p>
<div class="box-body" style="width:auto;height:auto">
<h4><span class="text-dark" style="padding-left:5px"><b>Global Function</b></span></h4> 
<p style="padding-left:1px">this is a global function that we used in all functions to send http request to our API services.</p>

<div class="bg-gradient-grey-dark">           
              <?php     
        $code =' 
        <?php
        //global function
        function curl_do_post($URL_ENVOI,$CHAINE)	
        {	  
          if (strpos($URL_ENVOI,"?")<>false) 
          {		
          $PARAMS = substr($URL_ENVOI,strpos($URL_ENVOI,"?")+1,strlen($URL_ENVOI)-(strpos($URL_ENVOI,"?")+1));
          $URL_ENVOI = substr($URL_ENVOI,0,strpos($URL_ENVOI,"?"));
          $CHAINE = $CHAINE."&".$PARAMS;
          }
          $host = "$URL_ENVOI";
          $XPost = $CHAINE;
          $url = $host;
          $ch = curl_init();// initialize curl handle
          curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
          curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); // return into a variable
          curl_setopt($ch, CURLOPT_FAILONERROR,true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_TIMEOUT, 40); // times out after 4s
          curl_setopt($ch, CURLOPT_POSTFIELDS, $XPost); // add POST fields
          $result = curl_exec($ch);
          return $result;
        }
        ?>
        '
    ?>
    <pre>
    <code class="highlight" style="font-size:10px">
        <?php echo htmlspecialchars( $code ); ?>
    </code>
    </pre>

</div>
<h4><span class="text-dark" style="padding-left:3px"><b>Add Lead API</b></span></h4> 
<p style="padding-left:1px">In this example we call a API for adding lead.</p>
   <div class="bg-gradient-grey-dark">
             
     <?php     

$code =' 
<?php
//function to add lead by API
function LeadAdd($companyID,$apikey,$name,$prenom,$email,$societe,$phone,$companyName){
  $data=array(\'campaign_id\'=>$companyID,\'nom\'=>$name,\'prenom\'=>$prenom,\'email\' =>$email,
	\'phone\'=>$phone,
	\'societe\'=>$societe,
	\'companyName\'=>$companyName,
	\'api_key\'=>$apikey
  );
  //convert data to json code
  $data=json_encode($data);
  //call API endpoint
  $URL=\'https://www.yestravaux.com/webservice/crm/lead.php\';
  $POSTVALUE=\'fct=LeadAdd&data=\'.$data; 
  $dataAddLead=curl_do_post($URL,$POSTVALUE);
  $result=json_decode($dataAddLead,true);
  $result=(array) $result;
  var_dump($result);
}
?>
//Example with CURL:
curl https://www.yestravaux.com/webservice/crm/lead.php -d fct=LeadAdd 
-d camp_id=6229f709ff8911c89d000029 -d email=info@externalisation.com -d  nom=Fabien -d prenom=Potencier -d phone=21642165140 
-d api_key=LEO3Y5O1Fnd0OxKZsK07d0nshkjsdfjsdfkjskdfksdfjkdfixKZsK07fsdZdd08z
'
?>
<pre>
    <code class="highlight" style="font-size:10px">
        <?php echo htmlspecialchars( $code ); ?>
    </code>
</pre>

</div>

<h4><span class="text-dark" style="padding-left:3px"><b>Lists Lead API</b></span></h4> 
<p style="padding-left:1px">In this example we call a API for fetching all leads by campaign_id.<p>
<div class="row bg-gradient-grey-dark">
           <div class="col-8">  
             <?php     

$code2 =' 
<?php

//function to find leads by API
function LeadList($campanyID,$apikey){

 //call API endpoint                                                                             
 $URL=\'https://www.yestravaux.com/webservice/crm/lead.php\';
 $POSTVALUE=\'fct=LeadList&campaign_id=\'.$campanyID.\'&api_key=\'.$apikey; 
 $dataLeadLists=curl_do_post($URL,$POSTVALUE);
 $result=json_decode($dataLeadLists,true);
 $result=(array) $result;

   var_dump($result);
}
?>

//Example with CURL:
curl https://www.yestravaux.com/webservice/crm/lead.php -d fct=LeadList
-d campaign_id=6229f709ff8911c89d000029 
-d api_key=LEO3Y5O1Fnd0OxKZsK07d0nshkjsdfjsdfkjskdfksdfjkdfixKZsK07fsdZdd08z

'
?>
<pre>
   <code class="highlight" style="font-size:10px">
       <?php echo htmlspecialchars( $code2 ); ?>
   </code>
</pre>

</div>
<div class="col-4">
<?php     

$code2 =' 
Result example with json format 
[
  {
      "_id": {
          "$id": "622a0dccff89118c76000029"
      },
      "campaign_id": "6229f709ff8911c89d000029",
      "companyName": "Hosteur",
      "nom": "Fabien",
      "prenom": "Potencier",
      "email": "fabien.f@externalisation.pro",
      "phone": "21642165140",
      "societe": "Hosteur Dev",
      "status": 2,
      "DATE_ADD_LEAD": "22-03-21",
      "time_ADD_LEAD": "08:05:54",
      "ip": "41.224.10.154",
      "converted": "0",
      "DATE_MODIF_LEAD": "22-03-23"
      "time_MODIF_LEAD": "08:05:54"

 }
]

'
?>
<pre>
   <code class="highlight" style="font-size:10px">
       <?php echo htmlspecialchars( $code2 ); ?>
   </code>
</pre>

</div>


</div>

<br>
<h4><span class="text-dark" style="padding-left:3px"><b>Delete Lead API</b></span></h4> 
<p style="padding-left:1px">In this example we call a API for deleting lead.</p>
<div class="bg-gradient-grey-dark">
             
             <?php     

$code2 =' 
<?php

//function to delete lead by API
function LeadDelete($LeadID,$apikey){

 //call API endpoint
 $URL=\'https://www.yestravaux.com/webservice/crm/lead.php\';
 $POSTVALUE=\'fct=LeadDelete&lead_id=\'.$LeadID.\'&api_key=\'.$apikey; 
 $dataLead_delete=curl_do_post($URL,$POSTVALUE);
 $result=json_decode($dataLead_delete,true);
 echo $result;
}
?>
//Example with CURL:
curl https://www.yestravaux.com/webservice/crm/lead.php -d fct=LeadDelete -d lead_id=6229f709ff8911c89d000029 
-d api_key=LEO3Y5O1Fnd0OxKZsK07d0nshkjsdfjsdfkjskdfksdfjkdfixKZsK07fsdZdd08z


'
?>
<pre>
   <code class="highlight" style="font-size:10px">
       <?php echo htmlspecialchars( $code2 ); ?>
   </code>
</pre>

</div>
					
						</div>
					</div>	
				</div>

		  </div>

		</section>
		<!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/highlight.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    jQuery(document).ready(function() {
hljs.highlightAll();
});

</script>