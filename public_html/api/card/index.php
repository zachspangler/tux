<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Tux\ {
	Card
};

/**
 * API for Profile
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
	$cardProfileId = filter_input(INPUT_GET, "cardProfileId", FILTER_SANITIZE_NUMBER_INT);
	$cardWeddingId = filter_input(INPUT_GET, "cardWeddingId", FILTER_SANITIZE_NUMBER_INT);
	$cardChest = filter_input(INPUT_GET, "cardChest", FILTER_SANITIZE_NUMBER_INT);
	$cardComplete = filter_input(INPUT_GET, "cardComplete", FILTER_SANITIZE_NUMBER_INT);
	$cardHeight = filter_input(INPUT_GET, "cardHeight", FILTER_SANITIZE_NUMBER_INT);
	$cardNeck = filter_input(INPUT_GET, "cardNeck", FILTER_SANITIZE_NUMBER_INT);
	$cardOutseam = filter_input(INPUT_GET, "cardOutseam", FILTER_SANITIZE_NUMBER_INT);
	$cardPant = filter_input(INPUT_GET, "cardPant", FILTER_SANITIZE_NUMBER_INT);
	$cardShirt = filter_input(INPUT_GET, "cardShirt", FILTER_SANITIZE_NUMBER_INT);
	$cardShoeSize = filter_input(INPUT_GET, "cardShoeSize", FILTER_SANITIZE_NUMBER_INT);
	$cardSleeve = filter_input(INPUT_GET, "cardSleeve", FILTER_SANITIZE_NUMBER_INT);
	$cardUnderarm = filter_input(INPUT_GET, "cardUnderarm", FILTER_SANITIZE_NUMBER_INT);
	$cardWeight = filter_input(INPUT_GET, "cardWeight", FILTER_SANITIZE_NUMBER_INT);

// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();
		// gets a profile by id
		if(empty($id) === false) {
			$card = Card::getCardByCardId($pdo, $id);
			// gets profile by profile id
			if($card !== null) {
				$reply->data = $card;
			}
		} else if(empty($cardProfileId) === false) {
			$card = Card::getCardByProfileId($pdo, $cardProfileId)->toArray();
			if($card !== null) {
				$reply->data = $card;
			}
		} else if(empty($cardWeddingId) === false) {
			$card = Card::getCardByProfileId($pdo, $cardWeddingId)->toArray();
			if($card !== null) {
				$reply->data = $card;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		//enforce that the XSRF token is in the header
		verifyXsrf();

		//enforce the user is signed in and only trying and only trying to edit their profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this card", 403));
		}
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//retrieve the card to be updated
		$card = Card::getCardByCardId($pdo, $id);
		if($card === null) {
			throw(new \RuntimeException("Card does not exist", 404));
		}
		//Profile Id associated with card
		if(empty($requestObject->cardProfileId) === true) {
			throw(new \InvalidArgumentException("No Profile linked to the Card", 405));
		}
		//Wedding Id associated with card
		if(empty($requestObject->cardWeddingId) === true) {
			throw(new \InvalidArgumentException("No Wedding linked to the Card", 405));
		}
		//Chest Size
		if(empty($requestObject->cardChest) === true) {
			throw(new \InvalidArgumentException("Chest Size not present", 405));
		}
		//Coat Size
		if(empty($requestObject->cardCoat) === true) {
			throw(new \InvalidArgumentException("Coat Size not present", 405));
		}
		//Card Complete
		if(empty($requestObject->cardComplete) === true) {
			throw(new \InvalidArgumentException("Card Complete not present", 405));
		}
		//Height
		if(empty($requestObject->cardHeight) === true) {
			throw(new \InvalidArgumentException("Height not present", 405));
		}
		//Neck Size
		if(empty($requestObject->cardNeck) === true) {
			throw(new \InvalidArgumentException("Neck Size not present", 405));
		}
		//Outseam Size
		if(empty($requestObject->cardOutseam) === true) {
			throw(new \InvalidArgumentException("Outseam Size not present", 405));
		}
		//Pant Size
		if(empty($requestObject->cardPant) === true) {
			throw(new \InvalidArgumentException("Pant Size not present", 405));
		}
		//Shirt Size
		if(empty($requestObject->cardShirt) === true) {
			throw(new \InvalidArgumentException("Shirt Size not present", 405));
		}
		//Sleeve Size
		if(empty($requestObject->cardSleeve) === true) {
			throw(new \InvalidArgumentException("Sleeve Size not present", 405));
		}
		//Underarm Size
		if(empty($requestObject->cardUnderarm) === true) {
			throw(new \InvalidArgumentException("Underarm Size not present", 405));
		}
		//Weight
		if(empty($requestObject->cardWeight) === true) {
			throw(new \InvalidArgumentException("Weight not present", 405));
		}

		if($method === "PUT") {
			//retrieve the method to update
			$card = Card::getCardByCardId($pdo, $id);
			if($card === null) {
				throw (new RuntimeException("Card does not exist.", 404));
			}
			//set updated fields
			$card->setcardChest($requestObject->cardChest);
			$card->setcardCoat($requestObject->cardCoat);
			$card->setcardComplete($requestObject->cardComplete);
			$card->setcardHeight($requestObject->cardHeight);
			$card->setcardNeck($requestObject->cardNeck);
			$card->setcardOutseam($requestObject->cardOutseam);
			$card->setcardPant($requestObject->cardPant);
			$card->setcardShirt($requestObject->cardShirt);
			$card->setcardShoeSize($requestObject->cardShoeSize);
			$card->setcardSleeve($requestObject->cardSleeve);
			$card->setcardUnderarm($requestObject->cardUnderarm);
			$card->setcardWeight($requestObject->cardWeight);
			$card->update($pdo);

			// update reply
			$reply->message = "Card information updated";

		} else if($method === "POST") {

			// enforce that the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post events", 403));
			}
			//enforce the end user has a JWT token
			validateJwtHeader();

			// create a new Event an insert it into the database
			$card = new Card(generateUuidV4(), $_SESSION["profile"]->getProfileId(), $requestObject->cardWeddingId, $requestObject->cardChest, $requestObject->cardCoat, $requestObject->cardComplete, $requestObject->cardComplete, $requestObject->cardNeck, $requestObject->cardOutseam, $requestObject->cardPant, $requestObject->cardShirt, $requestObject->cardShoeSize, $requestObject->cardSleeve, $requestObject->cardUnderarm);
			$card->insert($pdo);

			// update reply
			$reply->message = "Card created OK";
		}

	} else if($method === "DELETE") {
		//Verify XRSF token
		verifyXsrf();

		//retrieve the card to be deleted
		$card = Card::getCardByCardId($pdo, $id);
		if($card === null) {
			throw (new \RuntimeException("Card does not exist"));
		}
		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $card->getCardProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to access this card", 400));
		}
		//delete the profile from the database
		$card->delete($pdo);
		$reply->message = "Card Deleted";
	} else {
		throw (new \InvalidArgumentException(("Invalid HTTP request"), 400));
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);