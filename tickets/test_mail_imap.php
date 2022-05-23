<?php
//ini_set('display_errors', 1);

include_once "../app/config.inc.php";
include_once "../app/commun.inc.php";

?>

<!DOCTYPE html>
<html>
  
<head>
    <link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <script>
        function getEmails() {
            document.getElementById('dataDivID').style.display = "block";
        }
    </script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">  

    <style>
        body {
   font-family: Arial;
 }
  table {
     font-family: arial, sans-serif;
     border-collapse: collapse;
     width: 100%;
 }
  tr:nth-child(even) {
     background-color: #dddddd;
 }
 td, th {
     padding: 8px;
     width:100px;
     border: 1px solid #dddddd;
     text-align: left;                
 }
 .form-container {
     padding: 20px;
     background: #F0F0F0;
     border: #e0dfdf 1px solid;                
     border-radius: 2px;
 }
 * {
     box-sizing: border-box;
 }
 
 .columnClass {
     float: left;
     padding: 10px;
 }
 
 .row:after {
     content: "";
     display: table;
     clear: both;
 }
 
 .btn {
     background: #333;
     border: #1d1d1d 1px solid;
     color: #f0f0f0;
     font-size: 0.9em;
     width: 200px;
     border-radius: 2px;
     background-color: #f1f1f1;
     cursor: pointer;
 }
 
 .btn:hover {
     background-color: #ddd;
 }
 
 .btn.active {
     background-color: #666;
     color: white;
 }
    </style>
</head>
  
<body>
    <h2>Boite Emails</h2>



  
    <div id="btnContainer">
        <button class="btn active" onclick="getEmails()">
            <i class="fa fa-bars"></i>Click to get Emails
        </button>
    </div>
    <br>
      
    <div id="dataDivID" class="form-container" style="display:none;">
        <?php

        

            // /* gmail connection,with port number 993 */
            // $host = '{imap.gmail.com:993/imap/ssl}INBOX';
            // /* Your gmail credentials */
            // $user = 'alifadhel619@gmail.com';
            // $password = 'fadhel1416$';

            function AddTicket($email,$subject,$body,$nom_prenom,$date)
            {

                $URL     = 'https://api.hosteur.pro/webservice/crm/campaign.php';
                $POSTVALUE  = 'fct=CreateTicketFromEmail&user_id=73&email='.$email.'&subject='.htmlspecialchars($subject).'&body='.htmlspecialchars($body).
                '&nomPrenom='.$nom_prenom.'&date='.$date;
                $Result=curl_do_post($URL,$POSTVALUE);
                $Result=json_decode($Result);
            }
            $host = '{mail.exchange-swiss.ch:993/imap/ssl}INBOX';//input stream  with imap protocale............
            /* Your gmail credentials */
            $user = 'manageo-rgpd@hosteur.pro';
            $password = '@fZ}#QKGm3hV';
  
            /* Establish a IMAP connection */
            $conn = imap_open($host, $user, $password,NULL,1) 
            or die(' hi unable to connect Gmail: ' . imap_last_error());
            $info = imap_check($conn);
            echo '<span class="text-dark">La boite aux lettres contient </span><span class="text-success">'.$info->Nmsgs.'</span><span class="text-dark"> message(s) dont </span><span class="text-warning">'.
            $info->Recent.'</span> recent(s)';
            /* Search emails from gmail inbox*/
            $mails = imap_search($conn, 'ALL');//recuperer tout les emails 
            /* loop through each email id mails are available.  */
         
            if ($mails) {
  
                /* Mail output variable starts*/
            $mailOutput = '';
            $mailOutput.= '<div class="table-responsive"><table id="tickets_email" class="table table-hover no-wrap" data-page-size="10"><thead><tr><th>Subject</th><th>Sender Name</th><th>Sender Email</th> 
                        <th> Date Time </th><th>Status</th> <th> Content </th></tr></thead>';

            /* rsort is used to display the latest emails on top */
            rsort($mails);
            /* For each email */
            foreach ($mails as $email_number) {

                /* Retrieve specific email information*/
                $headers = imap_fetch_overview($conn, $email_number, 0);

                /*  Returns a particular section of the body*/
                $message = imap_fetchbody($conn, $email_number, 1);
                if(strlen($message)>1000){
                    $subMessage = substr($message, 0, 1000);
                }
                else{
                    $subMessage=$message;
                }
               
                $structure = imap_fetchstructure($conn, $email_number);
                // utiliser ce code lorseque vous tient de recuperer des emails contient des html ...................
                // if(isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])) {
                // $part = $structure->parts[1];
                // $finalMessage = imap_fetchbody($conn,$email_number,2);
                // if($part->encoding == 3) {
                // $finalMessage = imap_base64($finalMessage);
                // } else if($part->encoding == 1) {
                // $finalMessage = imap_8bit($finalMessage);
                // } else {
                // $finalMessage = imap_qprint($finalMessage);
                // }
                // }
                $finalMessage =utf8_decode(imap_qprint($subMessage));
                            
                $header = imap_headerinfo($conn, $email_number);
                $fromaddr = $header->from[0]->mailbox . "@" . $header->from[0]->host;
                $finalMessage=nl2br($finalMessage);
                $mailOutput.= '<tbody><div class="row well">';
                /* Gmail MAILS header information */
                $subject=utf8_decode(imap_qprint($headers[0]->subject));

                $subject=str_replace('_',' ',$subject);
                $subject=str_replace('=?UTF-8?Q?',' ',$subject);
                $subject=str_replace('?',' ',$subject);
                $mailOutput.= '<td><span class="columnClass"><input type="checkbox" class="form-check-input"/></form> ' .
                $subject. '</span></td> ';
                $mailOutput.= '<td><span class="text-info">' . 
                $headers[0]->from. '</span></td>';
                $mailOutput.= '<td><span class="text-info">' . 
                $fromaddr. '</span></td>';
                $mailOutput.= '<td><span class="text-primary">' .
                $headers[0]->date . '</span></td>';
                if($headers[0]->seen){
                    $mailOutput.= '<td><span class="badge badge-success">Seen</span></td>';
                }
                else{
                    $mailOutput.= '<td><span class="badge badge-danger">Unseen</span></td>';

                }
                


                $mailOutput.= '</div>';

                /* Mail body is returned */
                $mailOutput.= '<td><span class="text-fade">' . 
                $finalMessage . '</span></td></tr></div></div></tbody>';
                $date=substr($headers[0]->date,0,strpos($headers[0]->date,'+'));//pour enlever le timezone code.....
                $date=date('y-m-d h:i:s',strtotime($date));
                if ($fromaddr!="@")
                {
                    AddTicket($fromaddr, $subject."",quoted_printable_decode($subMessage)."",$headers[0]->from,$date);

                }
                //ce deux ligne permet de supprimer les emails traiter des flux imap donc l'admin ne peut pas consulter ces emails a partir des son adresse car ona supprimer .....
                //imap_delete ($conn, $email_number); 
                // imap_expunge ($conn);


                }// End foreach
                $mailOutput.= '</table>';
                echo $mailOutput;
            }//endif
            else{
                echo '<div class="">Boite emails doest not contain messages</div>';
            } 
  
            /* imap connection is closed */
            imap_close($conn);
            ?>
    </div>


    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
    // call jquey
	$('#tickets_email').DataTable({
		paging:true,
		order: [[ 0, "desc" ]]
		});
</script>

</body>
  
</html>