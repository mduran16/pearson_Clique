<?
/* CODE SAMPLE: PASSWORD GRANT TYPE OAUTH 2 TOKEN REQUEST */ 
 
 
$application_id 	= 'e3d81544-5c14-40c9-b53d-1578a7121b1b'; 
$client_string 		= 'gbtestc'; 
$username 			= 'cliqueteacher'; 
$password 			= 'letmein'; 
 
 
 
$post_request = 'grant_type=password'
				.'&client_id='.$application_id
	   			.'&username='.$client_string.'\\'.$username
	   			.'&password='.$password; 
 
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://m-api.ecollege.com/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_request);
 
// This next opton bypasses some SSL stuff that often trips up 
// local development environments' curl. Shouldn't be needed/used in production
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
 
 
$api_response = curl_exec($ch); 
 
$curlError = curl_error($ch);
 
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 
if($curlError){
 
	 echo "There was a problem making the API Call. cURL problem: $curlError"; 
 
} else if(intval($http_code / 100) >=4){
 
	$decoded = json_decode($api_response); 
	$msg = (is_object($decoded) && isset($decoded->error->message))?$decoded->error->message:"No message reported."; 
	$msg.= " Error ID: "; 
	$msg.= (is_object($decoded) && isset($decoded->error->errorId) && !empty($decoded->error->errorId))?$decoded->error->errorId:'None provided';  
	echo "The API Server responded with ".$http_code.". Message was: $msg"; 
 
} else {
 
	$decoded_response = json_decode($api_response); 
	print_r($decoded_response); 
 
}