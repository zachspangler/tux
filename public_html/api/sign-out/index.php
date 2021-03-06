<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Zachspangler\Tux\Profile;
/**
 * api for signing out of our application
 *
 * @author Zach Spangler <zaspangler@gmail.com>
 * @version 1.0
 */
//verify the xsrf challenge
if (session_status()!==PHP_SESSION_ACTIVE){
	session_start();
}
//prepare default error message
$reply =new stdClass();
$reply->status =200;
$reply->data=null;
try{
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/crowdvibe.ini");
	$method= array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER)? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if ($method === "GET"){
		$_SESSION =[];
		$reply->message= "You are now signed out";
	}
	else {
		throw(new\InvalidArgumentException("Invalid HTTP method request"));
	}
} catch (Exception $exception){
	$reply->status=$exception->getCode();
	$reply->message=$exception->getMessage();
}catch(TypeError $typeError){
	$reply->status =$exception->getCode();
	$reply->message=$exception->getMessage();
}
header("Content-type: application /json");
if($reply->data ===null){
	unset($reply->data);
}
echo json_encode($reply);