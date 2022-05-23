<?php
define('CRYPT_CKEY', '98q524nS1erger151ergge1qYj98P5kL1P6');
define('CRYPT_CIV', 'HBq15lTdS');
define('CRYPT_CBIT_CHECK', 32);

function cc_Masking($number, $maskingCharacter = 'X') {
    return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
}


function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}


function arrayToObject($d) {
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return (object) array_map(__FUNCTION__, $d);
		}
		else {
			// Return object
			return $d;
		}
	}


function TrimArray($Input){
    // see http://www.jonasjohn.de/snippets/php/trim-array.htm
    if (!is_array($Input))
        return trim($Input);

    return array_map('TrimArray', $Input);
}

	


define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');
// Encrypt Function
function mc_encrypt($encrypt, $key){
    $encrypt = serialize($encrypt);
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
    $key = pack('H*', $key);
    $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
    $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
    $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
    return $encoded;
}
// Decrypt Function
function mc_decrypt($decrypt, $key){
    $decrypt = explode('|', $decrypt.'|');
    $decoded = base64_decode($decrypt[0]);
    $iv = base64_decode($decrypt[1]);
    if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
    $key = pack('H*', $key);
    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
    $mac = substr($decrypted, -64);
    $decrypted = substr($decrypted, 0, -64);
    $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
    if($calcmac!==$mac){ return false; }
    $decrypted = unserialize($decrypted);
    return $decrypted;
}
// Old crypt

function encrypt_me($text)
{
    $text_num = str_split($text, CRYPT_CBIT_CHECK);
    $text_num = CRYPT_CBIT_CHECK - strlen($text_num[count($text_num)-1]);

    for ($i=0;$i<$text_num; $i++)
        $text = $text . chr($text_num);

    $cipher = mcrypt_module_open(MCRYPT_TRIPLEDES, '', 'cbc', '');
    mcrypt_generic_init($cipher, CRYPT_CKEY, CRYPT_CIV);
    
    $decrypted = mcrypt_generic($cipher, $text);
    mcrypt_generic_deinit($cipher);

    return base64_encode($decrypted);
}


function decrypt_me($encrypted_text)
{
    $cipher = mcrypt_module_open(MCRYPT_TRIPLEDES, '', 'cbc', '');
    mcrypt_generic_init($cipher, CRYPT_CKEY, CRYPT_CIV);
    
    $decrypted = mdecrypt_generic($cipher, base64_decode($encrypted_text));
    mcrypt_generic_deinit($cipher);
    
    $last_char = substr($decrypted,-1);

    for($i=0; $i<(CRYPT_CBIT_CHECK-1); $i++)
    {
        if(chr($i) == $last_char)
        {
            $decrypted = substr($decrypted, 0, strlen($decrypted)-$i);
            break;
        }
    }

    return $decrypted;
}





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


function generatePassword ($length = 8)
  {

    // start with a blank password
    $password = "";

    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789BCDFGHJKLMNPQRTVWXYZ";

    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
  
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
      $length = $maxlength;
    }
	
    // set up a counter for how many characters are in the password so far
    $i = 0; 
    
    // add random characters to $password until $length is reached
    while ($i < $length) { 

      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        
      // have we already used this character in $password?
      if (!strstr($password, $char)) { 
        // no, so it's OK to add it onto the end of whatever we've already got...
        $password .= $char;
        // ... and increase the counter by one
        $i++;
      }

    }

    // done!
    return $password;

  }

  function kill($data)
  {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die('*');
  }

  function translateISO($code)
  {
    // re-created based on https://www.iso20022.org/standardsrepository/public/wqt/Description/mx/dico/codesets/_YsS_xdp-Ed-ak6NoX_4Aeg_-819075130
    $ISO_20022 = [
        'AC01' => 'IncorrectAccountNumber',
        'AC02' => 'NonNumericAccountNumber',
        'AC03' => 'InvalidAccountNumberForClearingCode',
        'AC04' => 'ClosedAccountNumber',
        'AC05' => 'InvalidAccountNumberWithInstitution',
        'AC06' => 'BlockedAccount',
        'AM01' => 'ZeroAmount',
        'AM02' => 'NotAllowedAmount',
        'AM03' => 'NotAllowedCurrency',
        'AM04' => 'InsufficientFunds',
        'AM05' => 'Duplication',
        'AM06' => 'TooLowAmount',
        'AM07' => 'BlockedAmount',
        'AM08' => 'ChargeDisagreement',
        'BE01' => 'InconsistentWithEndCustomer',
        'BE02' => 'UnknownCreditor',
        'BE03' => 'NoLongerValidCreditor',
        'BE04' => 'MissingCreditorAddress',
        'BE05' => 'UnrecognisedInitiatingParty',
        'AG01' => 'TransactionForbidden',
        'AG02' => 'InvalidBankOperationCode',
        'DT01' => 'InvalidDate',
        'MS01' => 'NotSpecifiedReason',
        'PY01' => 'UnknownAccount',
        'RF01' => 'NotUniqueTransactionReference',
        'RC01' => 'BankIdentifierIncorrect',
        'RC02' => 'NonNumericRoutingCode',
        'RC03' => 'NotValidRoutingCode',
        'RC04' => 'ClosedBranch',
        'TM01' => 'CutOffTime',
        'ED01' => 'CorrespondentBankNotPossible',
        'ED02' => 'TransactionReasonNonReportable',
        'ED03' => 'BalanceInfoRequested',
        'ED04' => 'ChargeDetailsNotCorrect',
        'MS03' => 'NotSpecifiedReasonAgentGenerated',
        'MS02' => 'NotSpecifiedReasonCustomerGenerated',
        'BE06' => 'UnknownEndCustomer',
        'BE07' => 'MissingDebtorAddress',
        'AM09' => 'WrongAmount',
        'AM10' => 'InvalidControlSum',
        'MD01' => 'NoMandate',
        'MD02' => 'MissingMandatoryInformationInMandate',
        'MD03' => 'InvalidFileFormatForOtherReasonThanGroupingIndicator',
        'MD04' => 'InvalidFileFormatForGroupingIndicator',
        'MD06' => 'RefundRequestByEndCustomer',
        'MD07' => 'EndCustomerDeceased',
        'MD05' => 'CollectionNotDue',
        'AC07' => 'InvalidName',
        'ED05' => 'SettlementFailed',
        // more from http://www.ca-toulouse31.fr/Vitrine/ObjCommun/Fic/Toulousain/Pro/SEPA/Liste-interbancaire-Codes-motifs-de-rejets-retours.pdf
        'CUST' => 'CustomerDecision',
        'DUPL' => 'DuplicatePayment',
        'FF01' => 'InvalidFileFormat',
        'FF05' => 'InvalidLocalInstrumentCode',
        'AC13' => 'InvalidDebtorAccountType',
        'FOCR' => 'FollowingCancellationRequest',
        'LEGL' => 'LegalDecision',
        'NOAS' => 'NoAnswerFromCustomer',
        'NOOR' => 'NoOriginalTransactionReceived',
        'RR01' => 'MissingDebtorAccountorIdentification',
        'RR02' => 'MissingDebtorNameorAddress',
        'RR03' => 'MissingCreditorNameorAddress',
        'RR04' => 'RegulatoryReason',
        'SL01' => 'Due to specific service offered by the debtor agent',
        'TM01' => 'CutOffTime - File receive after Cut-off time',
        'FRAD' => 'SEPA(nonISO) Fraudulent originated credit transfer',
        'ARDT' => 'SEPA(nonISO) The transaction has already been returned',
        'TECH' => 'SEPA(nonISO) Technical problems resulting in erroneous SCTs',
    ];

    return isset($ISO_20022[$code]) ? $ISO_20022[$code] : '';
  }
  
  function validateDate($date, $format = 'Ymd') // 'Ymd' => YYYYMMDD (ex:20151201)
  {
     $d = DateTime::createFromFormat($format, $date);
     return $d && $d->format($format) === $date;
  }
 
  function FormatNumber ($S_TELEPHONE,$S_COUNTRY_CODE)
  {
    
     $S_TELEPHONE = str_replace(" ", "",$S_TELEPHONE);
   
     if ($S_COUNTRY_CODE=="FR")
     {
       
       $start_number = substr ($S_TELEPHONE,0,2);
       $end_number = substr ($S_TELEPHONE,3,strlen($S_TELEPHONE)); 
       
       if ($start_number=="07"||$start_number=="06")
       {
         $S_TEL_FORMATED = "33".substr ($S_TELEPHONE,1,strlen($S_TELEPHONE));
         if (strlen ($S_TEL_FORMATED)==11)
         {
         }
       }
       $start_number = substr ($S_TELEPHONE,0,5);
       if ($start_number=="00336"||$start_number=="00337")
       {
         //echo "test";
         $S_TEL_FORMATED = str_replace("00336", "336",$S_TELEPHONE);
         $S_TEL_FORMATED = str_replace("00337", "337",$S_TEL_FORMATED);
       }
 
       $start_number = substr ($S_TELEPHONE,0,3);
       if ($start_number=="336"||$start_number=="337")
       {
         //echo "test";
         $S_TEL_FORMATED = $S_TELEPHONE;
       }
     }
     if ($S_COUNTRY_CODE=="CH")
     {
       
       $start_number = substr ($S_TELEPHONE,0,2);
       $end_number = substr ($S_TELEPHONE,3,strlen($S_TELEPHONE)); 
       
       if ($start_number=="07")
       {
         $S_TEL_FORMATED = "41".substr ($S_TELEPHONE,1,strlen($S_TELEPHONE));
         if (strlen ($S_TEL_FORMATED)==11)
         {
         }
       }
       $start_number = substr ($S_TELEPHONE,0,5);
       if ($start_number=="00417")
       {
         //echo "test";
       
         $S_TEL_FORMATED = str_replace("00417", "417",$S_TEL_FORMATED);
       }
 
       $start_number = substr ($S_TELEPHONE,0,3);
       if ($start_number=="417")
       {
         //echo "test";
         $S_TEL_FORMATED = $S_TELEPHONE;
       }
     }
     if ($S_COUNTRY_CODE=="BE")
     {
       $start_number = substr ($S_TELEPHONE,0,2);
       $end_number = substr ($S_TELEPHONE,3,strlen($S_TELEPHONE)); 
       if ($start_number=="04")
       {
         $S_TEL_FORMATED = "32".substr ($S_TELEPHONE,1,strlen($S_TELEPHONE));      
       } 
       $start_number = substr ($S_TELEPHONE,0,5);
       if ($start_number=="00324")
       {
         //echo "test";
         $S_TEL_FORMATED = str_replace("00324", "324",$S_TELEPHONE);
       }
       $start_number = substr ($S_TELEPHONE,0,3);
       if ($start_number=="324")
       {
         //echo "test";
         $S_TEL_FORMATED = $S_TELEPHONE;
       }   
       
     }
     if ($S_COUNTRY_CODE=="BG")
     {
       $start_number = substr ($S_TELEPHONE,0,2);
       $end_number = substr ($S_TELEPHONE,3,strlen($S_TELEPHONE)); 
       
       if ($start_number=="08")
       {
         $S_TEL_FORMATED = "359".substr ($S_TELEPHONE,1,strlen($S_TELEPHONE));       
       }
       $start_number = substr ($S_TELEPHONE,0,6);
       if ($start_number=="003598")
       {
         //echo "test";
         $S_TEL_FORMATED = str_replace("003598", "359",$S_TELEPHONE);
       }
 
       $start_number = substr ($S_TELEPHONE,0,4);
       if ($start_number=="3598")
       {
         //echo "test";
         $S_TEL_FORMATED = $S_TELEPHONE;
       }
       
     }
     if ($S_COUNTRY_CODE=="LU")
     {
       $start_number = substr ($S_TELEPHONE,0,2);
       $end_number = substr ($S_TELEPHONE,3,strlen($S_TELEPHONE)); 
       
       if ($start_number=="06")
       {
         $S_TEL_FORMATED = "352".substr ($S_TELEPHONE,1,strlen($S_TELEPHONE));       
       }
       $start_number = substr ($S_TELEPHONE,0,6);
       if ($start_number=="003526")
       {
         //echo "test";
         $S_TEL_FORMATED = str_replace("003526", "352",$S_TELEPHONE);
       }
 
       $start_number = substr ($S_TELEPHONE,0,4);
       if ($start_number=="3526")
       {
         //echo "test";
         $S_TEL_FORMATED = $S_TELEPHONE;
       }
       
     }
     
     return $S_TEL_FORMATED;
        
  }



function CallAPIJson($DATA)
{

//--

$url = "https://www.hosteur.com/api-json/index.php"; 

//--

$DATA['IP_USER'] = $_SERVER['REMOTE_ADDR']; 
$DATA['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT']; 
$DATA['REMOTE_HOST'] = $_SERVER['REMOTE_HOST']; 
$DATA['HTTP_REFERER'] = $_SERVER['HTTP_REFERER']; 
$DATA['SCRIPT_FILENAME'] = $_SERVER['SCRIPT_FILENAME']; 
$DATA['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
//--
$content = json_encode($DATA);
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, "data=".urlencode($content));
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$json_response = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//--
if ( $status != 200 ) 
{
die("Error: call to URL $url failed with status $status, response => ".$json_response.", curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}
//--
curl_close($curl);
//--
return json_decode($json_response, false);
}




function CallAPIJson2($DATA)
{
  //--
  $url = "https://www.hosteur.com/api-json/welead.php"; 
  //--
  $DATA['IP_USER'] = $_SERVER['REMOTE_ADDR']; 
  $DATA['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT']; 
  $DATA['REMOTE_HOST'] = $_SERVER['REMOTE_HOST']; 
  $DATA['HTTP_REFERER'] = $_SERVER['HTTP_REFERER']; 
  $DATA['SCRIPT_FILENAME'] = $_SERVER['SCRIPT_FILENAME']; 
  $DATA['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
  //--
  $content = json_encode($DATA);
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, "data=".urlencode($content));
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  $json_response = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  //--
  if ( $status != 200 ) 
  {
    die("Error: call to URL $url failed with status $status, response => ".$json_response.", curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
  }
  //--
  curl_close($curl);
  //--
  return json_decode($json_response, false);
}


function Aff($pk_lang, $lang)
{

  $URLLANG = "https://marketing.hosteur.com/webservice/lang/";
  $POSTVALUE = "fct=Message&PK_LANG=" . $pk_lang;
  $resultat = curl_do_post($URLLANG, $POSTVALUE);
  $result = json_decode($resultat, true);
  return $result[$lang];
}
    
?>