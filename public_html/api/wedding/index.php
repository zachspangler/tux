<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Tux\ {
	Profile,
	Company,
	Wedding
};
/**
 * API for Wedding
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
	$weddingCompanyId = filter_input(INPUT_GET, "weddingCompanyId", FILTER_SANITIZE_STRING);
	$weddingDate = filter_input(INPUT_GET, "weddingDate", FILTER_VALIDATE_INT);
	$weddingName = filter_input(INPUT_GET, "weddingName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$weddingReturnByDate = filter_input(INPUT_GET, "weddingReturnByDate", FILTER_VALIDATE_INT);

	if(empty($weddingDate) === false && empty($weddingReturnByDate) === false) {
		$weddingDate = date("Y-m-d H:i:s", $weddingDate/1000);
		$weddingReturnByDate = date("Y-m-d H:i:s", $weddingReturnByDate/1000);
	}

// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();
		// gets a profile by cid
		if(empty($id) === false) {
			$wedding = Wedding::getWeddingByWeddingId($pdo, $id);
			// gets wedding by wedding id
			if($wedding !== null) {
				$reply->data = $wedding;
			}
		} else if(empty($weddingCompanyId) === false) {
			$wedding = Wedding::getWeddingByCompanyId($pdo, $weddingCompanyId);
			if($wedding !== null) {
				$reply->data = $wedding;
			}
		}
		else if(empty($weddingDate) === false) {
			$wedding = Wedding::getWeddingByWeddingDate($pdo, $weddingSunriseStartDateTime, $weddingSunsetStartDateTime);
			if($wedding !== null) {
				$reply->data = $wedding;
			}
		} else if(empty($weddingName) === false) {
			$wedding = Wedding::getWeddingByWeddingName($pdo, $weddingName);
			if($wedding !== null) {
				$reply->data = $wedding;
			}
		} else if(empty($weddingReturnByDate) === false) {
			$wedding = Wedding::getWeddingByWeddingReturnByDate($pdo, $weddingSunriseReturnDateTime, $weddingSunsetReturnDateTime);
			if($wedding !== null) {
				$reply->data = $wedding;
			}
		}
	} else if ($method === "PUT") {
		//enforce that the XSRF token is in the header
		verifyXsrf();
		//enforce the user is signed in and only trying and only trying to edit their profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this wedding", 403));
		}
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new \RuntimeException("Profile does not exist", 404));
		}
		//profile Email
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("No profile email present", 405));
		}
		//profile First Name
		if(empty($requestObject->profileFirstName) === true) {
			throw(new \InvalidArgumentException("No first name present", 405));
		}
		//profile Last Name
		if(empty($requestObject->profileLastName) === true) {
			throw(new \InvalidArgumentException("No last name present", 405));
		}

		//set First Name and Last Name to profileName
		$profileName = ($profileFirstName . " " . $profileLastName);

		//set updated fields
		$profile->setProfileEmail($requestObject->profileEmail);
		$profile->setProfileName($requestObject->profileName);
		$profile->setProfilePhone($requestObject->profilePhone);
		$profile->update($pdo);

		// update reply
		$reply->message = "Profile information updated";
	} else if ($method === "DELETE") {
		//Verify XRSF token
		verifyXsrf();
		//validateJwtHeader();
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw (new \RuntimeException("Profile does not exist"));
		}
		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $profile->getProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 400));
		}
		//delete the profile from the database
		$profile->delete($pdo);
		$reply->message = "Profile Deleted";
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