<?php

namespace Zachspangler\Tux;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");


use Ramsey\Uuid\Uuid;

/**
 * Wedding Information
 *
 * This stores the wedding information for each rental
 *
 * @author Zach Spangler <zaspangler@gmail.com> and Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 1.0.0
 **/
class Wedding implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/**
	 * id for the wedding; this is the primary key
	 * @var Uuid|string $weddingId
	 **/
	private $weddingId;
	/**
	 * Id of the company who is providing tuxes for the wedding; this is the foreign key
	 * @var Uuid|string $weddingCompanyId
	 **/
	private $weddingCompanyId;
	/**
	 * date of the wedding
	 * @var \DateTime $weddingDate
	 **/
	private $weddingDate;
	/**
	 * name of the Wedding
	 * @var string $weddingName
	 **/
	private $weddingName;
	/**
	 * date that all cards must be returned to the company
	 * @var \DateTime $weddingReturnByDate
	 **/
	private $weddingReturnByDate;

	/**
	 * constructor for this Wedding class
	 *
	 * @param Uuid|string $newWeddingId
	 * @param Uuid|string $newWeddingCompanyId
	 * @param \DateTime|string $newWeddingDate
	 * @param string $newWeddingName
	 * @param \DateTime|string $newWeddingReturnByDate
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newWeddingId, $newWeddingCompanyId, \DateTime $newWeddingDate, string $newWeddingName, \DateTime $newWeddingReturnByDate) {
		try {
			$this->setWeddingId($newWeddingId);
			$this->setWeddingCompanyId($newWeddingCompanyId);
			$this->setWeddingDate($newWeddingDate);
			$this->setWeddingName($newWeddingName);
			$this->setWeddingReturnByDate($newWeddingReturnByDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for wedding id
	 *
	 * @return Uuid value of company id (or null if new Profile)
	 **/
	public function getWeddingId(): Uuid {
		return ($this->weddingId);
	}

	/**
	 * mutator method for wedding id
	 *
	 * @param  Uuid| string $newWeddingId value of new profile id
	 * @throws \RangeException if $newWeddingId is not positive
	 * @throws \TypeError if the wedding Id is not
	 **/
	public function setWeddingId($newWeddingId): void {
		try {
			$uuid = self::validateUuid($newWeddingId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->weddingId = $uuid;
	}

	/**
	 * accessor method for wedding company id
	 *
	 * @return Uuid value of wedding company id (or null if new Profile)
	 **/
	public function getWeddingCompanyId(): Uuid {
		return ($this->weddingCompanyId);
	}

	/**
	 * mutator method for wedding company id
	 *
	 * @param  Uuid| string $newWeddingId value of new profile id
	 * @throws \RangeException if $newWeddingId is not positive
	 * @throws \TypeError if the wedding company Id is not
	 **/
	public function setWeddingCompanyId($newWeddingCompanyId): void {
		try {
			$uuid = self::validateUuid($newWeddingCompanyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->weddingCompanyId = $uuid;
	}

	/**
	 * accessor method for weddingDate
	 *
	 * @return \DateTime
	 */
	public function getWeddingDate(): \DateTime {
		return ($this->weddingDate);
	}
	/**
	 * mutator method for weddingDate
	 *
	 * @param \DateTime $newWeddingDate
	 * @throws \InvalidArgumentException if $newEventStartDateTime is not valid
	 * @throws \RangeException if $newWeddingDate is a date that doesn't exist
	 */
	public function setWeddingDate($newWeddingDate): void {
		// store the date/time using the Validate Trait
		try {
			$newWeddingDate = self::validateDateTime($newWeddingDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->weddingDate = $newWeddingDate;
	}

	/**
	 * accessor method for weddingName
	 *
	 * @return string for weddingName
	 **/
	public function getWeddingName(): string {
		return ($this->weddingName);
	}

	/**
	 * mutator method for weddingName
	 *
	 * @param string $newWeddingName value of new profile id
	 * @throws \RangeException if $newWeddingName is not positive
	 * @throws \TypeError if the $newWeddingName is not
	 **/
	public function setWeddingName($newWeddingName): void {
		if($newWeddingName === null) {
			$this->WeddingName = null;
			return;
		}
		// verify the company address is secure
		$newWeddingName = trim($newWeddingName);
		$newWeddingName = filter_var($newWeddingName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company address will fit in the database
		if(strlen($newWeddingName) > 255) {
			throw(new \RangeException("Address id is too large"));
		}
		// store the id
		$this->weddingName = $newWeddingName;
	}

	/**
	 * accessor method for weddingReturnByDate
	 *
	 * @return \DateTime
	 */
	public function getWeddingReturnByDate(): \DateTime {
		return ($this->weddingReturnByDate);
	}
	/**
	 * mutator method for weddingReturnByDate
	 *
	 * @param \DateTime $newWeddingReturnByDate
	 * @throws \InvalidArgumentException if $newWeddingReturnByDate is not valid
	 * @throws \RangeException if $newWeddingReturnByDate is a date that doesn't exist
	 */
	public function setWeddingReturnByDate($newWeddingReturnByDate): void {
		// store the date/time using the Validate Trait
		try {
			$newWeddingReturnByDate = self::validateDateTime($newWeddingReturnByDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->weddingReturnByDate = $newWeddingReturnByDate;
	}

	/**
	 * gets the wedding by wedding id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param string $weddingId to search for
	 * @return Wedding|null wedding or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getWeddingByWeddingId(\PDO $pdo, string $weddingId):?Wedding {
		// sanitize the wedding id before searching
		try {
			$weddingId = self::validateUuid($weddingId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT weddingId, weddingCompanyId, weddingDate, weddingName, weddingReturnByDate FROM wedding WHERE weddingId = :weddingId";
		$statement = $pdo->prepare($query);

		// bind the wedding id to the place holder in the template
		$parameters = ["weddingId" => $weddingId->getBytes()];
		$statement->execute($parameters);

		// grab the wedding from mySQL
		try {
			$wedding = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$wedding = new Wedding($row["weddingId"], $row["weddingCompanyId"], $row["weddingDate"], $row["weddingName"], $row["weddingReturnByDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($wedding);
	}

	/**
	 * gets the wedding by company id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param string $weddingCompanyId to search for
	 * @return \SplFixedArray SplFixedArray of weddings found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getWeddingByCompanyId(\PDO $pdo, string $weddingCompanyId):?Wedding {
		// sanitize the wedding id before searching
		try {
			$weddingCompanyId = self::validateUuid($weddingCompanyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT weddingId, weddingCompanyId, weddingDate, weddingName, weddingReturnByDate FROM wedding WHERE weddingCompanyId = :weddingCompanyId";
		$statement = $pdo->prepare($query);

		// bind the wedding id to the place holder in the template
		$parameters = ["weddingCompanyId" => $weddingCompanyId->getBytes()];
		$statement->execute($parameters);

		// build an array of profiles
		$weddings = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$wedding = new Wedding($row["weddingId"], $row["weddingCompanyId"], $row["weddingDate"], $row["weddingName"], $row["weddingReturnByDate"]);
				$weddings[$weddings->key()] = $wedding;
				$weddings->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($weddings);
	}

	/**
	 * gets an array of weddings based on wedding date
	 *
	 * @param \PDO $pdo connection object
	 * @param string $sunriseWeddingStartDate beginning date to search for
	 * @param string $sunsetWeddingStartDate ending date to search for
	 * @return \SplFixedArray of events found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * @throws \InvalidArgumentException if either sun dates are in the wrong format
	 */
	public static function getWeddingByWeddingDate(\PDO $pdo, string $weddingSunriseStartDateTime, string $weddingSunsetStartDateTime): \SplFixedArray {

		//enforce both dates are present
		if((empty ($weddingSunriseStartDateTime) === true) || (empty($weddingSunsetStartDateTime) === true)) {
			throw (new \InvalidArgumentException("dates are empty of insecure"));
		}
		//ensure both dates are in the correct format and are secure
		try {
			$weddingSunriseStartDateTime = self::validateDateTime($weddingSunriseStartDateTime);
			$weddingSunsetStartDateTime = self::validateDateTime($weddingSunsetStartDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT weddingId, weddingCompanyId, weddingDate, weddingName, weddingReturnByDate FROM wedding WHERE weddingStartDateTime >= :sunriseWeddingDate AND weddingStartDateTime <= :sunsetWeddingDate";
		$statement = $pdo->prepare($query);

		//format the dates so that mySQL can use them
		$formattedWeddingSunriseStartDateTime = $weddingSunriseStartDateTime->format("Y-m-d H:i:s.u");
		$formattedWeddingSunsetStartDateTime = $weddingSunsetStartDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["sunriseWeddingDate" => $formattedWeddingSunriseStartDateTime, "sunsetWeddingDate" => $formattedWeddingSunsetStartDateTime];
		$statement->execute($parameters);

		//build an array of events
		$weddings = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$wedding = new Wedding($row["weddingId"], $row["weddingCompanyId"], $row["weddingDate"], $row["weddingName"], $row["weddingReturnByDate"]);
				$weddings[$weddings->key()] = $wedding;
				$weddings->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($weddings);
	}

	/**
	 * gets the Wedding by Wedding Name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileName is the search term that includes profile first namd and last name
	 * @return \SplFixedArray SplFixedArray of Profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getWeddingByWeddingName(\PDO $pdo, string $weddingName): \SPLFixedArray {
		// sanitize the name before searching
		$weddingName = trim($weddingName);
		$weddingName = filter_var($weddingName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($weddingName) === true) {
			throw(new \PDOException("not a valid name"));
		}

		// create query template
		$query = "SELECT weddingId, weddingCompanyId, weddingDate, weddingName, weddingReturnByDate FROM wedding WHERE :weddingName LIKE CONCAT('%', REPLACE(:weddingName, ' ', '%'),'%')";
		$statement = $pdo->prepare($query);

		// bind the profile to the place holder in the template
		$weddingName = "weddingName";
		$parameters = ["weddingName" => $weddingName];
		$statement->execute($parameters);

		// build an array of profiles
		$weddingNames = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$weddingName = new Wedding($row["weddingId"], $row["weddingCompanyId"], $row["weddingDate"], $row["weddingName"], $row["weddingReturnByDate"]);
				$weddingNames[$weddingNames->key()] = $weddingName;
				$weddingNames->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($weddingNames);
	}

	/**
	 * gets an array of weddings based on the car return by date date
	 *
	 * @param \PDO $pdo connection object
	 * @param string $sunriseReturnByReturnDate beginning date to search for
	 * @param string $sunsetReturnByReturnDate ending date to search for
	 * @return \SplFixedArray of events found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * @throws \InvalidArgumentException if either sun dates are in the wrong format
	 */
	public static function getWeddingByWeddingReturnByDate(\PDO $pdo, string $weddingSunriseReturnDateTime, string $weddingSunsetReturnDateTime): \SplFixedArray {

		//enforce both dates are present
		if((empty ($weddingSunriseReturnDateTime) === true) || (empty($weddingSunsetReturnDateTime) === true)) {
			throw (new \InvalidArgumentException("dates are empty of insecure"));
		}
		//ensure both dates are in the correct format and are secure
		try {
			$weddingSunriseReturnDateTime = self::validateDateTime($weddingSunriseReturnDateTime);
			$weddingSunsetReturnDateTime = self::validateDateTime($weddingSunsetReturnDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT weddingId, weddingCompanyId, weddingDate, weddingName, weddingReturnByDate FROM wedding WHERE weddingReturnDateTime >= :sunriseWeddingDate AND weddingReturnDateTime <= :sunsetWeddingDate";
		$statement = $pdo->prepare($query);

		//format the dates so that mySQL can use them
		$formattedWeddingSunriseReturnDateTime = $weddingSunriseReturnDateTime->format("Y-m-d H:i:s.u");
		$formattedWeddingSunsetReturnDateTime = $weddingSunsetReturnDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["sunriseWeddingDate" => $formattedWeddingSunriseReturnDateTime, "sunsetWeddingDate" => $formattedWeddingSunsetReturnDateTime];
		$statement->execute($parameters);

		//build an array of events
		$weddings = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$wedding = new Wedding($row["weddingId"], $row["weddingCompanyId"], $row["weddingDate"], $row["weddingName"], $row["weddingReturnByDate"]);
				$weddings[$weddings->key()] = $wedding;
				$weddings->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($weddings);
	}

	/**
	 * gets all Weddings
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of weddings found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllWeddings(\PDO $pdo) : \SPLFixedArray {

		// create query template
		$query = "SELECT weddingId, weddingCompanyId, weddingDate, weddingName, weddingReturnByDate FROM wedding";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of tweets
		$weddings = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$wedding = new Wedding($row["weddingId"], $row["weddingCompanyId"], $row["weddingDate"], $row["weddingName"], $row["weddingReturnByDate"]);
				$weddings[$weddings->key()] = $wedding;
				$weddings->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($weddings);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public
	function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["weddingId"] = $this->weddingId->toString();
		$fields["weddingCompanyId"] = $this->weddingCompanyId->toString();
		return ($fields);
	}
}
