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
		
		return $S_TEL_FORMATED;
			 
 }
  
    
?>