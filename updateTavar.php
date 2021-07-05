<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
header("Content-Type: application/json; charset=UTF-8");


$request_headers 	= 	getallheaders();
$autorized 			=	checkAuth($request_headers['Authorization']);
  
  if($autorized){
 		$request_body = json_decode(file_get_contents('php://input'),true);
 		$id = (int)$_GET['id'];
 		echo $id;
		if (isset($request_body['name'])) {
	 		$name 	= $request_body['name'];
	 		$price 	= $request_body['price'];
	 		$count 	= $request_body['count'];
			
 			$mysqli = connectToDB();
		 	$mysqli->query("UPDATE TAVAR SET name = '$name',price = '$price',count = '$count' 
		 		WHERE id = $id") or
	 		die($mysqli->error);
	 		echo 	json_encode(
	 					array( 	
	 						"success"=>true, 
					   		"message"=>"Malumotlar o`zgartirildi"
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