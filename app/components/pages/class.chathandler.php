<?php
class ChatHandler {
	function send($message) {
		global $clientSocketArray;
		$messageLength = strlen($message);
		foreach($clientSocketArray as $clientSocket)
		{
			@socket_write($clientSocket,$message,$messageLength);
		}
		return true;
	}

	function unseal($socketData) {
		$length = ord($socketData[1]) & 127;
		if($length == 126) {
			$masks = substr($socketData, 4, 4);
			$data = substr($socketData, 8);
		}
		elseif($length == 127) {
			$masks = substr($socketData, 10, 4);
			$data = substr($socketData, 14);
		}
		else {
			$masks = substr($socketData, 2, 4);
			$data = substr($socketData, 6);
		}
		$socketData = "";
		for ($i = 0; $i < strlen($data); ++$i) {
			$socketData .= $data[$i] ^ $masks[$i%4];
		}
		return $socketData;
	}

	function seal($socketData) {
		$b1 = 0x80 | (0x1 & 0x0f);
		$length = strlen($socketData);
		
		if($length <= 125)
			$header = pack('CC', $b1, $length);
		elseif($length > 125 && $length < 65536)
			$header = pack('CCn', $b1, 126, $length);
		elseif($length >= 65536)
			$header = pack('CCNN', $b1, 127, $length);
		return $header.$socketData;
	}

	function doHandshake($received_header,$client_socket_resource, $host_name, $port) {
		$headers = array();
		$lines = preg_split("/\r\n/", $received_header);
		foreach($lines as $line)
		{
			$line = rtrim($line);
			if(preg_match('/\A(\S+): (.*)\z/', $line, $matches)){
				$headers[$matches[1]] = $matches[2];
			}
		}
		print_r($headers);
		$secKey = $headers['Sec-WebSocket-Key'];
		$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
		//hand shaking header
		$upgrade  = "HTTP/1.1 101 Web Switching Protocols \r\n" .
		"Upgrade: websocket\r\n" .
		"Connection: Upgrade\r\n" .
		"Origin: wss://185.148.76.33:8090/\r\n" .
		"WebSocket-Location: ws://$host_name:$port\r\n".
		"Sec-WebSocket-Version: 13\r\n" .
		"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
		socket_write($client_socket_resource,$upgrade,strlen($upgrade));
	}
	// function doHandshake($buffer,$client_socket_resource, $host_name, $port)
	// {
	// 	$magicGUID = "258EAFA5-E914-47DA-95CA-C5AB0DC85B11";
	// 	$headers = array();
	// 	$lines = explode("\n",$buffer);
	// 	foreach ($lines as $line) {
	// 	  if (strpos($line,":") !== false) {
	// 		$header = explode(":",$line,2);
	// 		$headers[strtolower(trim($header[0]))] = trim($header[1]);
	// 	  }
	// 	  elseif (stripos($line,"get ") !== false) {
	// 		preg_match("/GET (.*) HTTP/i", $buffer, $reqResource);
	// 		$headers['get'] = trim($reqResource[1]);
	// 	  }
	// 	}
	// 	print_r($headers);
	// 	if (isset($headers['get'])) {
	// 	 // $user->requestedResource = $headers['get'];
	// 	} 
	// 	else {
	// 	  // todo: fail the connection
	// 	  $handshakeResponse = "HTTP/1.1 405 Method Not Allowed\r\n\r\n";     
	// 	}
	// 	if (!isset($headers['host']) || !isset($headers['host'])) {
	// 	  $handshakeResponse = "HTTP/1.1 400 Bad Request";
	// 	}
	// 	if (!isset($headers['upgrade']) || strtolower($headers['upgrade']) != 'websocket') {
	// 	  $handshakeResponse = "HTTP/1.1 400 Bad Request";
	// 	} 
	// 	if (!isset($headers['connection']) || strpos(strtolower($headers['connection']), 'upgrade') === FALSE) {
	// 	  $handshakeResponse = "HTTP/1.1 400 Bad Request";
	// 	}
	// 	if (!isset($headers['sec-websocket-key'])) {
	// 	  $handshakeResponse = "HTTP/1.1 400 Bad Request";
	// 	} 
	// }
	
	function newConnectionACK($client_ip_address) {
		// $message = 'New client ' . $client_ip_address.' joined this room';
		// $messageArray = array('message'=>$message,'message_type'=>'chat-connection-ack','room_id'=>"",'pk_user'=>"",'k_key'=>"");
		// $ACK = $this->seal(json_encode($messageArray));
		// return $ACK;
	}
	
	function connectionDisconnectACK($client_ip_address) {
		// $message = $client_ip_address.' disconnected';
		// $messageArray = array('message'=>$message,'message_type'=>'chat-connection-ack','room_id'=>"",'pk_user'=>"",'k_key'=>"");
		// $ACK = $this->seal(json_encode($messageArray));
		// return $ACK;
	}
	
	function createChatBoxMessage($chat_user,$chat_box_message,$room_id,$pk_user,$k_key) {
		$message = $chat_user . ": <div class='chat-box-message'>" . $chat_box_message . "</div>";
		$messageArray = array('message'=>$chat_box_message,'message_type'=>'chat-box-html','room_id'=>$room_id,'pk_user'=>$pk_user,'k_key'=>$k_key);
		$chatMessage = $this->seal(json_encode($messageArray));
		return $chatMessage;
	}
}
?>