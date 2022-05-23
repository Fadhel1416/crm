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
	
	
	
// new crypt	
define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');
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


  function do_tracking()
  {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $pk_site = 1;
    $email = isset($_REQUEST['EMAIL']) ? $_REQUEST['EMAIL'] : null;
    $name = isset($_REQUEST['NAME']) ? $_REQUEST['NAME'] : null;

    $tracking = [
      'utm_aff' => isset($_REQUEST['utm_aff']) ? $_REQUEST['utm_aff'] : null, 
      'utm_source' => isset($_REQUEST['utm_source']) ? $_REQUEST['utm_source'] : null,  
      'utm_campaign' => isset($_REQUEST['utm_campaign']) ? $_REQUEST['utm_campaign'] : null,  
      'utm_medium' => isset($_REQUEST['utm_medium']) ? $_REQUEST['utm_medium'] : null, 
    ];

    foreach ($tracking as $utm => $value) {
      if ($value) {
         $_SESSION[$utm] = $value;
         setcookie($utm, $value, time()+2592000); // 30 jours 
      }
    }

    if ($tracking['utm_campaign']) {
      AddClicCampaign (
          $tracking['utm_campaign'], 
          $_SERVER['REMOTE_ADDR'],
          $email, 
          $pk_site, 
          $tracking['utm_source'],
          $tracking['utm_medium'], 
          $tracking['utm_aff'],
          $name
      );
    }
      
  }


  function AddClicCampaign ($S_CAMPAIGN, $S_IP,$EMAIL,$FK_SITE, $S_SOURCE, $S_MEDIUM,$FK_AFFILIE, $S_CLIC_NAME="")
  {
    
    $URLP                   = "https://www.yestravaux.com/webservice/stats/index.php";
    $POSTVALUE              = "fct=AddClicCampaign&S_CAMPAIGN=".$S_CAMPAIGN."&S_IP=".$S_IP."&EMAIL=".$EMAIL."&FK_SITE=".$FK_SITE."&S_SOURCE=".$S_SOURCE."&S_MEDIUM=".$S_MEDIUM."&FK_AFFILIE=".$FK_AFFILIE."&S_CLIC_NAME=".$S_CLIC_NAME."";
    $resultat               = curl_do_post($URLP,$POSTVALUE);
  }

  function isJson($string) {
    json_decode($string);
    return (json_last_error() === JSON_ERROR_NONE);
  }

  function isMobile()
  {
    return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$_SERVER['HTTP_USER_AGENT'])||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($_SERVER['HTTP_USER_AGENT'],0,4));

  }

  function kill($data)
  {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die('*');
  }

  //get exrept of an text
  function ttruncat($text,$numb) {
  if (strlen($text) > $numb) { 
    $text = substr($text, 0, $numb); 
    $text = substr($text,0,strrpos($text," ")); 
    $etc = " ...";  
    $text = $text.$etc; 
    }
  return $text; 
  }


  //get URL rewrite for an article
  function sluggable($str) {

      $before = array(
          'àáâãäåòóôõöøèéêëðçìíîïùúûüñšž',
          '/[^a-z0-9\s]/',
          array('/\s/', '/--+/', '/---+/')
      );
   
      $after = array(
          'aaaaaaooooooeeeeeciiiiuuuunsz',
          '',
          '-'
      );

      $str = strtolower($str);
      $str = strtr($str, $before[0], $after[0]);
      $str = preg_replace($before[1], $after[1], $str);
      $str = trim($str);
      $str = preg_replace($before[2], $after[2], $str);
   
      return $str;
  }
  
  function GText ($S_LANG, $S_FR)
{
	$URLP                   = "https://www.yestravaux.com/webservice/lang/";
    $POSTVALUE              = "fct=Txt&S_LANG=$S_LANG&S_FR=$S_FR";
    $resultat               = curl_do_post($URLP,$POSTVALUE);
	
	echo $resultat;
}

   
 
  
    
?>