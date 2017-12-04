<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Tux\ {
	WeddingParty
};
/**
 * API for Wedding Party
 *
 * @author Zach Spangler <zaspangler@gmail.com>
 * @version 1.0
 */
// verify the session; if not active, start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	// grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/crowdvibe.ini");

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
	$weddingPartyProfileId = filter_input(INPUT_GET, "weddingPartyProfileId", FILTER_SANITIZE_STRING);
	$weddingPartyWeddingId = filter_input(INPUT_GET, "weddingPartyWeddingId", FILTER_SANITIZE_STRING);
	$weddingPartyAdmin = filter_input(INPUT_GET, "weddingPartyAdminId", FILTER_VALIDATE_INT, FILTER_FLAG_NO_ENCODE_QUOTES);

// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();
		// gets a profile by cid
		if(empty($id) === false) {
			$weddingParty = WeddingParty::getWeddingPartyByWeddingPartyId($pdo, $id);
			// gets profile by profile id
			if($weddingParty !== null) {
				$reply->data = $weddingParty;
			}
		} else if(empty($weddingPartyProfileId) === false) {
			$weddingParty = WeddingParty::getWeddingPartyByWeddingPartyProfileId($pdo, $weddingPartyProfileId);
			if($$weddingParty !== null) {
				$reply->data = $weddingParty;
			}
		} else if(empty($weddingPartyWeddingId) === false) {
			$weddingParty = WeddingParty::getWeddingPartyByWeddingPartyWeddingId($pdo, $weddingPartyWeddingId);
			if($$weddingParty !== null) {
				$reply->data = $weddingParty;
			}
		}
	} else if ($method === "PUT") {
		//enforce that the XSRF token is in the header
		verifyXsrf();
		//enforce the user is signed in and only trying and only trying to edit their profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this wedding party", 403));
		}
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//retrieve the profile to be updated
		$weddingParty = WeddingParty::getWeddingPartyByWeddingPartyId($pdo, $id);
		if($weddingParty === null) {
			throw(new \RuntimeException("Wedding Party does not exist", 404));
		}
		//profile Admin
		if(empty($requestObject->profileAdmin) === true) {
			throw(new \InvalidArgumentException("No profile admin present", 405));
		}
		$weddingParty->update($pdo);

		// update reply
		$reply->message = "Wedding Party information updated";
	} else if ($method === "DELETE") {
		//Verify XRSF token
		verifyXsrf();
		//validateJwtHeader();
		$weddingParty = WeddingParty::getWeddingPartyByWeddingPartyId($pdo, $id);
		if($weddingParty === null) {
			throw(new \RuntimeException("Wedding Party does not exist", 404));
		}
		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $profile->getProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 400));
		}
		//delete the profile from the database
		$weddingParty->delete($pdo);
		$reply->message = "Wedding Party Deleted";
	} else {
		throw (new \InvalidArgumentException(("Invalid HTTP request"), 400));
	}
} catch (\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);