<?php
	 require 'vendor/autoload.php';
    use \Firebase\JWT\JWT;
 $host = '127.0.0.1';
 $username = 'root';
 $pwd = '';
 $db = "yangi";
  header("Content-Type: application/json; charset=UTF-8");
$key = 'ISHONCH';
$h = getallheaders();
$idJWT=null;
try{
$token = explode(" ", $h['Authorization'])[1];  
$decoded = JWT::decode($token, base64_decode(strtr($key, '-_', '+/')), ['HS256']);
$idJWT=$decoded->id;

}catch(Exception $e){
 $message['error'] = 'Kechirasiz!';
  echo json_encode($message);
}

  


if(!is_null($idJWT)){
   $con = mysqli_connect($host,$username , $pwd, $db) or die('Ulanishda xatolik bor!');

  if (mysqli_connect_error($con))
  {
    echo "Bazaga ulanmadi!".mysqli_connect_error();
  }
  $query = mysqli_query($con , "SELECT *FROM TAVAR" );

  if ($query)
  {
    while ($row = mysqli_fetch_object($query)) 
    {
      $flag[]=$row;
    }

    echo(json_encode($flag));
  }
  mysqli_close($con);
}
 
?>