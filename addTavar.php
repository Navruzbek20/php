<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
header("Content-Type: application/json; charset=UTF-8");


$request_headers 	= 	getallheaders();
$autorized 			=	checkAuth($request_headers['Authorization']);
  
  if($autorized){
 		$request_body = json_decode(file_get_contents('php://input'),true);
		if (isset($request_body['name'])) {
	 		$name 	= $request_body['name'];
	 		$price 	= $request_body['price'];
	 		$count 	= $request_body['count'];
			
 			$mysqli = connectToDB();
		 	$mysqli->query("INSERT INTO TAVAR(name,price,count) VALUES('$name','$price','$count')") or
	 		die($mysqli->error);
	 		echo 	json_encode(
	 					array( 	
	 						"success"=>true, 
					   		"message"=>"Malumotlar kiritildi"
						)
					);
	 	}
  }

  function checkAuth($header_token){
  	$key = 'ISHONCH';
  	try{
		$token = explode(" ", $header_token)[1];  
		$decoded = JWT::decode($token, base64_decode(strtr($key, '-_', '+/')), ['HS256']);
		return true;
	}catch(Exception $e){
	 	return false;
	};
  }

  function connectToDB(){
  	$host = '127.0.0.1';
	$username = 'root';
	$pwd = '';
	$db = "yangi";
	return new mysqli($host, $username , $pwd, $db);
  }

?>