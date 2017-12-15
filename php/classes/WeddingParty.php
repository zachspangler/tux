<?php

namespace Zachspangler\Tux;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * Cross Section of a Twitter Profile
 *
 * This is a cross section of what is probably stored about a Twitter user. This entity is a top level entity that
 * holds the keys to the other entities in this example (i.e., Favorite and Profile).
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 4.0.0
 **/
class WeddingParty implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this Profile; this is the primary key
	 * @var Uuid $profileId
	 **/
	private $weddingPartyId;
	/**
	 * token handed out to verify that the profile is valid and not malicious.
	 *v@var $profileActivationToken
	 **/
	private $weddingPartyProfileId;
	/**
	 * token handed out to verify that the profile is valid and not malicious.
	 *v@var $profileActivationToken
	 **/
	private $weddingPartyWeddingId;
	/**
	 * token handed out to verify that the profile is valid and not malicious.
	 *v@var $profileActivationToken
	 **/
	private $weddingPartyAdmin;

	/**
	 * constructor for this Wedding Party class
	 *
	 * @param Uuid|string $newWeddingPartyId
	 * @param Uuid|string $newWeddingPartyProfileId
	 * @param Uuid|string $newWeddingPartyWeddingId
	 * @param boolean $newWeddingPartyAdmin
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newWeddingPartyId, $newWeddingPartyProfileId, $newWeddingPartyWeddingId, boolean $newWeddingPartyAdmin) {
		try {
			$this->setWeddingPartyId($newWeddingPartyId);
			$this->setWeddingPartyProfileId($newWeddingPartyProfileId);
			$this->setWeddingPartyWeddingId($newWeddingPartyWeddingId);
			$this->setWeddingPartyAdmin($newWeddingPartyAdmin);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

/**
* accessor method for weddingPartyId
*
* @return Uuid value of company id (or null if new Profile)
**/
	public function getWeddingPartyId(): Uuid {
		return ($this->weddingPartyId);
	}

	/**
	 * mutator method for weddingPartyId
	 *
	 * @param  Uuid| string $newWeddingPartyId
	 * @throws \RangeException if $newWeddingPartyId is not positive
	 * @throws \TypeError if the $newWeddingPartyId is not the correct type
	 **/
	public function setWeddingPartyId($newWeddingPartyId): void {
		try {
			$uuid = self::validateUuid($newWeddingPartyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->weddingPartyId = $uuid;
	}

	/**
	 * accessor method for weddingPartyProfileId
	 *
	 * @return Uuid value of $newWeddingPartyProfileId id
	 **/
	public function getWeddingPartyProfileId(): Uuid {
		return ($this->weddingPartyProfileId);
	}

	/**
	 * mutator method for weddingPartyProfileId
	 *
	 * @param  Uuid| string $newWeddingPartyProfileId
	 * @throws \RangeException if $newWeddingPartyProfileId is not positive
	 * @throws \TypeError if the $newWeddingPartyProfileIdId is not the correct type
	 **/
	public function setWeddingPartyProfileId($newWeddingPartyProfileId): void {
		try {
			$uuid = self::validateUuid($newWeddingPartyProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->weddingPartyProfileId = $uuid;
	}

	/**
	 * accessor method for weddingPartyWeddingId
	 *
	 * @return Uuid value of $newWeddingPartyWeddingId id
	 **/
	public function getWeddingPartyWeddingId(): Uuid {
		return ($this->weddingPartyWeddingId);
	}

	/**
	 * mutator method for weddingPartyWeddingId
	 *
	 * @param  Uuid| string $newWeddingPartyWeddingId
	 * @throws \RangeException if $newWeddingPartyWeddingId is not positive
	 * @throws \TypeError if the $newWeddingPartyWeddingId is not the correct type
	 **/
	public function setWeddingPartyWeddingId($newWeddingPartyWeddingId): void {
		try {
			$uuid = self::validateUuid($newWeddingPartyWeddingId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->weddingPartyWeddingId = $uuid;
	}

	/**
	 * accessor method for Wedding Party Admin
	 *
	 * @return boolean value of Wedding Party Admin
	 **/
	public function getWeddingPartyAdmin(): boolean {
		return ($this->weddingPartyAdmin);
	}
	/**
	 * mutator method for weddingPartyAdmin
	 *
	 * @param bool $newWeddingPartyAdmin
	 **/
	public function setWeddingPartyAdmin(boolean $newWeddingPartyAdmin): void {
		$this->weddingPartyAdmin = $newWeddingPartyAdmin;
	}

	/**
	 * inserts this Wedding Party into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO weddingParty(weddingPartyId, weddingPartyProfileId, weddingPartyWeddingId, weddingPartyAdmin) VALUES (:weddingPartyId, :weddingPartyProfileId, :weddingPartyWeddingId, :weddingPartyAdmin)";
		$statement = $pdo->prepare($query);
		$parameters = ["weddingPartyId" => $this->weddingPartyId->getBytes(), "weddingPartyProfileId" => $this->weddingPartyProfileId->getBytes(), "weddingPartyWeddingId" => $this->weddingPartyWeddingId->getBytes(), "weddingPartyAdmin" => $this->weddingPartyAdmin];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM weddingParty WHERE weddingPartyId = :weddingPartyId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["weddingPartyId" => $this->weddingPartyId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE weddingParty SET weddingPartyId = :weddingPartyId, weddingPartyProfileId = :weddingPartyProfileId, weddingPartyWeddingId = :weddingPartyWeddingId, weddingPartyAdmin = :weddingPartyAdmin WHERE weddingPartyId = :weddingPartyId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["weddingPartyId" => $this->weddingPartyId->getBytes(), "weddingPartyProfileId" => $this->weddingPartyProfileId->getBytes(), "weddingPartyWeddingId" => $this->weddingPartyWeddingId->getBytes(), "weddingPartyAdmin" => $this->weddingPartyAdmin];
		$statement->execute($parameters);
	}

	/**
	 * gets the Wedding Party by Wedding Party Id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param UUid|string $weddingPartyId to search for
	 * @return WeddingParty |null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getWeddingPartyByWeddingPartyId(\PDO $pdo, string $weddingPartyId):?WeddingParty {
		// sanitize the wedding party id before searching
		try {
			$weddingPartyId = self::validateUuid($weddingPartyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT weddingPartyId, weddingPartyProfileId, weddingPartyWeddingId, weddingPartyAdmin FROM weddingParty WHERE weddingPartyId = :weddingPartyId";
		$statement = $pdo->prepare($query);
		// bind the wedding party id to the place holder in the template
		$parameters = ["weddingPartyId" => $weddingPartyId->getBytes()];
		$statement->execute($parameters);
		// grab the wedding party from mySQL
		try {
			$weddingParty = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$weddingParty = new WeddingParty($row["weddingPartyId"], $row["weddingPartyProfileId"], $row["weddingPartyWeddingId"], $row["weddingPartyAdmin"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($weddingParty);
	}

	/**
	 * gets the Wedding Party by Wedding Id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param UUid|string $weddingPartyId to search for
	 * @return \SplFixedArray SplFixedArray of Profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getWeddingPartyByWeddingPartyWeddingId(\PDO $pdo, string $weddingPartyWeddingId):?WeddingParty {
		// sanitize the wedding party wedding id before searching
		try {
			$weddingPartyWeddingId = self::validateUuid($weddingPartyWeddingId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT weddingPartyId, weddingPartyProfileId, weddingPartyWeddingId, weddingPartyAdmin FROM weddingParty WHERE weddingPartyWeddingId = :weddingPartyWeddingId";
		$statement = $pdo->prepare($query);

		// bind the wedding party id to the place holder in the template
		$parameters = ["weddingPartyWeddingId" => $weddingPartyWeddingId->getBytes()];
		$statement->execute($parameters);

		// build an array of profiles
		$weddingPartyWeddingIds = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$weddingPartyWeddingId = new WeddingParty($row["weddingPartyId"], $row["weddingPartyProfileId"], $row["weddingPartyWeddingId"], $row["weddingPartyAdmin"]);
				$weddingPartyWeddingIds[$weddingPartyWeddingIds->key()] = $weddingPartyWeddingId;
				$weddingPartyWeddingIds->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($weddingPartyWeddingIds);
	}

	/**
	 * gets the Wedding Party by Profile Id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param UUid|string $weddingPartyId to search for
	 * @return \SplFixedArray SplFixedArray of Profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getWeddingPartyByWeddingPartyProfileId(\PDO $pdo, string $weddingPartyProfileId):?WeddingParty {
		// sanitize the wedding party wedding id before searching
		try {
			$weddingPartyProfileId = self::validateUuid($weddingPartyProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT weddingPartyId, weddingPartyProfileId, weddingPartyWeddingId, weddingPartyAdmin FROM weddingParty WHERE weddingPartyProfileId = :weddingPartyProfileId";
		$statement = $pdo->prepare($query);

		// bind the wedding party id to the place holder in the template
		$parameters = ["$weddingPartyProfileId" => $$weddingPartyProfileId->getBytes()];
		$statement->execute($parameters);

		// build an array of profiles
		$weddingPartyProfileIds = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$weddingPartyProfileId = new WeddingParty($row["weddingPartyId"], $row["weddingPartyProfileId"], $row["weddingPartyWeddingId"], $row["weddingPartyAdmin"]);
				$weddingPartyProfileIds[$weddingPartyProfileIds->key()] = $weddingPartyProfileId;
				$weddingPartyProfileIds->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($weddingPartyProfileIds);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public
	function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["weddingPartyId"] = $this->weddingPartyId->toString();
		$fields["weddingPartyProfileId"] = $this->weddingPartyProfileId->toString();
		$fields["weddingPartyWeddingId"] = $this->weddingPartyWeddingId->toString();
		return ($fields);
	}
}