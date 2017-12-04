<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Tux\ {
	Company
};
/**
 * API for Company
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
	$companyAddress = filter_input(INPUT_GET, "profileAddress", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$companyCity = filter_input(INPUT_GET, "companyCity", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$companyEmail = filter_input(INPUT_GET, "companyEmail", FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
	$companyName = filter_input(INPUT_GET, "companyName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$companyPhone = filter_input(INPUT_GET, "companyPhone", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$companyPostalCode = filter_input(INPUT_GET, "companyPostalCode", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$companyState = filter_input(INPUT_GET, "companyState", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();
		// gets a profile by cid
		if(empty($id) === false) {
			$company = Company::getCompanyByCompanyId($pdo, $id);
			// gets profile by profile id
			if($company !== null) {
				$reply->data = $company;
			}
		} else if(empty($companyCity) === false) {
			$company = Company::getCompanyByCompanyCity($pdo, $companyCity)->toArray();
			if($company !== null) {
				$reply->data = $company;
			}
		} else if(empty($companyEmail) === false) {
			$company = Company::getCompanyByCompanyEmail($pdo, $companyEmail);
			if($company !== null) {
				$reply->data = $company;
			}
		} else if(empty($companyName) === false) {
			$company = Company::getCompanyByCompanyName($pdo, $companyName)->toArray();
			if($company !== null) {
				$reply->data = $company;
			}
		} else if(empty($companyPhone) === false) {
			$company = Company::getCompanyByCompanyPhone($pdo, $companyPhone);
			if($company !== null) {
				$reply->data = $company;
			}
		} else if(empty($companyPostalCode) === false) {
			$company = Company::getCompanyByCompanyPostalCode($pdo, $companyPostalCode)->toArray();
			if($company !== null) {
				$reply->data = $company;
			}
		} else if(empty($companyState) === false) {
			$company = Company::getCompanyByCompanyState($pdo, $companyState)->toArray();
			if($company !== null) {
				$reply->data = $company;
			}
		}
	} else if($method === "POST" || $method === "PUT") {
		//enforce that the XSRF token is in the header
		verifyXsrf();

		//enforce the user is signed in and only trying and only trying to edit their company
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getCompanyId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this company", 403));
		}
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//retrieve the company to be updated
		$company = Company::getCompanyByCompanyId($pdo, $id);
		if($company === null) {
			throw(new \RuntimeException("Company does not exist", 404));
		}
		//company Address
		if(empty($requestObject->companyAddress) === true) {
			throw(new \InvalidArgumentException("No company address present", 405));
		}
		//company City
		if(empty($requestObject->companyCity) === true) {
			throw(new \InvalidArgumentException("No company city present", 405));
		}
		//company Email
		if(empty($requestObject->companyEmail) === true) {
			throw(new \InvalidArgumentException("No company email present", 405));
		}
		//company Name
		if(empty($requestObject->companyName) === true) {
			throw(new \InvalidArgumentException("No company name present", 405));
		}
		//company Phone
		if(empty($requestObject->companyPhone) === true) {
			throw(new \InvalidArgumentException("No company phone present", 405));
		}
		//company Postal Code
		if(empty($requestObject->companyPostalCode) === true) {
			throw(new \InvalidArgumentException("No company postal code present", 405));
		}
		//company State
		if(empty($requestObject->companyState) === true) {
			throw(new \InvalidArgumentException("No company state present", 405));
		}
		//perform the actual put or post
		if($method === "PUT") {

			//retrieve the method to update
			$company = Company::getCompanyByCompanyId($pdo, $id);
			if($company === null) {
				throw (new RuntimeException("Company does not exist.", 404));
			}
			//enforce the user is signed in and only trying to edit their own event
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $company->getCompanyProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this event", 403));
			}
			//set updated fields
			$company->setCompanyAddress($requestObject->companyAddress);
			$company->setCompanyCity($requestObject->companyCity);
			$company->setCompanyEmail($requestObject->companyEmail);
			$company->setCompanyName($requestObject->companyName);
			$company->setCompanyPhone($requestObject->companyPhone);
			$company->setCompanyPostalCode($requestObject->companyPostalCode);
			$company->setCompanyState($requestObject->companyState);
			$company->update($pdo);

			// update reply
			$reply->message = "Profile information updated";
		} else if ($method === "POST") {
			// enforce that the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to create a company", 403));
			}
			//enforce the end user has a JWT token
			validateJwtHeader();

			// create a new Company an insert it into the database
			$company = new Company(generateUuidV4(), $requestObject->companyAddress, $requestObject->companyCity, $requestObject->companyEmail, $requestObject->companyHash,  $requestObject->companyName, $requestObject->companyPhone, $requestObject->companyPostalCode, $requestObject->companySalt, $requestObject->companyState);
			$company->insert($pdo);

			// update reply
			$reply->message="Company created OK";
		}
	} else if ($method === "DELETE") {
		//Verify XRSF token
		verifyXsrf();

		//retrieve the company to be deleted
		$profile = Company::getCompanyByCompanyId($pdo, $id);
		if($profile === null) {
			throw (new \RuntimeException("Company does not exist"));
		}

		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["company"]) === true || $_SESSION["company"]->getCompanyId()->toString() !== $profile->getCompanyId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to access this company", 400));
		}

		//delete the profile from the database
		$profile->delete($pdo);
		$reply->message = "Company Deleted";
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