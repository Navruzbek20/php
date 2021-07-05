<?php
	require 'vendor/autoload.php';
		use \Firebase\JWT\JWT;
$host = '127.0.0.1';
 $username = 'root';
 $pwd = '';
 $db = "yangi";

$con = mysqli_connect($host,$username , $pwd, $db) or die('Ulanishda xatolik bor!');
$request = json_decode(file_get_contents('php://input'),true);

if(isset($request['username'])){
	$username = $request["username"];
	$password = $request["password"];
	$query = mysqli_query($con , "SELECT * FROM login where username ='$username' and password = '$password'");
		
	  if ($query)
  {
  	$flag=null;
    while ($row = mysqli_fetch_array($query)) 
    {
      $flag[]=$row;
      $usernameJWT = $row['username'];
      $passwordJWT = $row['password'];
      $idJWT = $row['id']; 
    }
    if(!is_null($flag)){
    	//$a= json_encode($flag)[0]['login'];
	
		$token_payload = [
		'id'=>$idJWT,
		  'username' => $usernameJWT,
		  'password' => $passwordJWT
		];

		// This is your client secret
		$key = 'ISHONCH';

		// This is your id token
		$jwt = JWT::encode($token_payload, base64_decode(strtr($key, '-_', '+/')), 'HS256');
		$token['token'] = $jwt;	
		echo(json_encode($token));
//         	$decoded = JWT::decode($jwt, base64_decode(strtr($key, '-_', '+/')), ['HS256']);

// print "\n\n";
// print "Decoded:\n";
// print_r($decoded);
    }else{
	$error['message'] = 'sur';
	echo (json_encode($error));
}
  }
}





?>