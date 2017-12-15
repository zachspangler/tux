<?php

namespace Zachspangler\Tux;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");


use Ramsey\Uuid\Uuid;
/**
 * Handoff Action List
 *
 * This is the lead source information stored for each company
 *
 * @author Zach Spangler <zaspangler@gmail.com> and Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 1.0.0
 **/
class Company implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for the company; this is the primary key
	 * @var Uuid|string $companyId
	 **/
	private $companyId;
	/**
	 * address of the company
	 * @var string $companyAddress
	 **/
	private $companyAddress;
	/**
	 * city of the company
	 * @var string $companyCity
	 **/
	private $companyCity;
	/**
	 * email of the company
	 * @var string $companyEmail
	 **/
	private $companyEmail;
	/**
	 * email of the company
	 * @var string $companyEmail
	 **/
	private $companyHash;
	/**
	 * name of the company
	 * @var string $companyName
	 **/
	private $companyName;
	/**
	 * phone of the company
	 * @var string $companyPhone
	 **/
	private $companyPhone;
	/**
	 * postal code of the company
	 * @var string $companyPostalCode
	 **/
	private $companyPostalCode;
	/**
	 * salt of the company
	 * @var string $companyState
	 **/
	private $companySalt;
	/**
	 * state of the company
	 * @var string $companyState
	 **/
	private $companyState;

	/**
	 * constructor for this Company
	 *
	 * @param Uuid|string $newCompanyId
	 * @param string $newCompanyAddress
	 * @param string $newCompanyCity
	 * @param string $newCompanyEmail
	 * @param string $newCompanyHash
	 * @param string $newCompanyName
	 * @param string $newCompanyPhone
	 * @param string $newCompanyPostalCode
	 * @param string $newCompanySalt
	 * @param string $newCompanyState
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newCompanyId, string $newCompanyAddress, string $newCompanyCity, string $newCompanyEmail, string $newCompanyHash, string $newCompanyName, string $newCompanyPhone, string $newCompanyPostalCode, string $newCompanySalt, string $newCompanyState) {
		try {
			$this->setCompanyId($newCompanyId);
			$this->setCompanyAddress($newCompanyAddress);
			$this->setCompanyCity($newCompanyCity);
			$this->setCompanyEmail($newCompanyEmail);
			$this->setCompanyHash($newCompanyHash);
			$this->setCompanyName($newCompanyName);
			$this->setCompanyPhone($newCompanyPhone);
			$this->setCompanyPostalCode($newCompanyPostalCode);
			$this->setCompanySalt($newCompanySalt);
			$this->setCompanyState($newCompanyState);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for company id
	 *
	 * @return Uuid value of profile id (or null if new Profile)
	 **/
	public function getCompanyId(): Uuid {
		return ($this->companyId);
	}

	/**
	 * mutator method for company id
	 *
	 * @param  Uuid| string $newCompanyId value of new profile id
	 * @throws \RangeException if $newCompanyId is not positive
	 * @throws \TypeError if the company Id is not
	 **/
	public function setCompanyId($newCompanyId): void {
		try {
			$uuid = self::validateUuid($newCompanyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->companyId = $uuid;
	}

	/**
	 * accessor method for company address
	 *
	 * @return string for company address
	 **/
	public function getCompanyAddress(): string {
		return ($this->companyAddress);
	}

	/**
	 * mutator method for company id
	 *
	 * @param string $newCompanyAddress value of new profile id
	 * @throws \RangeException if $newCompanyAddress is not positive
	 * @throws \TypeError if the companyAddress is not
	 **/
	public function setCompanyAddress($newCompanyAddress): void {
		if($newCompanyAddress === null) {
			$this->CompanyAddress = null;
			return;
		}
		// verify the company address is secure
		$newCompanyAddress = trim($newCompanyAddress);
		$newCompanyAddress = filter_var($newCompanyAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company address will fit in the database
		if(strlen($newCompanyAddress) > 255) {
			throw(new \RangeException("Address id is too large"));
		}
		// store the id
		$this->companyAddress = $newCompanyAddress;
	}

	/**
	 * accessor method for company city
	 *
	 * @return string for company city
	 **/
	public function getCompanyCity(): string {
		return ($this->companyCity);
	}

	/**
	 * mutator method for company city
	 *
	 * @param string $newCompanyCity value of new profile id
	 * @throws \RangeException if $newCompanyCity is not positive
	 * @throws \TypeError if the companyCity is not
	 **/
	public function setCompanyCity($newCompanyCity): void {
		if($newCompanyCity === null) {
			$this->CompanyCity = null;
			return;
		}
		// verify the company city is secure
		$newCompanyCity = trim($newCompanyCity);
		$newCompanyCity = filter_var($newCompanyCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCompanyCity) > 255) {
			throw(new \RangeException("Address id is too large"));
		}
		// store the id
		$this->companyCity = $newCompanyCity;
	}

	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getCompanyEmail(): string {
		return $this->companyEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newCompanyEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setCompanyEmail(string $newCompanyEmail): void {
		// verify the email is secure
		$newCompanyEmail = trim($newCompanyEmail);
		$newCompanyEmail = filter_var($newCompanyEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newCompanyEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newCompanyEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}
		// store the email
		$this->companyEmail = $newCompanyEmail;
	}

	/**
	 * accessor method for companyHash
	 *
	 * @return string value of hash
	 */
	public function getCompanyHash(): string {
		return $this->companyHash;
	}

	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newCompanyHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setCompanyHash(string $newCompanyHash): void {
		//enforce that the hash is properly formatted
		$newCompanyHash = trim($newCompanyHash);
		$newCompanyHash = strtolower($newCompanyHash);
		if(empty($newCompanyHash) === true) {
			throw(new \InvalidArgumentException("profile password hash empty or insecure"));
		}
		//enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newCompanyHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		//enforce that the hash is exactly 128 characters.
		if(strlen($newCompanyHash) !== 128) {
			throw(new \RangeException("profile hash must be 128 characters"));
		}
		//store the hash
		$this->companyHash = $newCompanyHash;
	}

	/**
	 * accessor method for companyName
	 *
	 * @return string for companyName
	 **/
	public function getCompanyName(): string {
		return ($this->companyName);
	}

	/**
	 * mutator method for companyName
	 *
	 * @param string $newCompanyName value of new profile id
	 * @throws \RangeException if $newCompanyName is not positive
	 * @throws \TypeError if the companyName is not
	 **/
	public function setCompanyName($newCompanyName): void {
		if($newCompanyName === null) {
			$this->CompanyName = null;
			return;
		}
		// verify the company city is secure
		$newCompanyName = trim($newCompanyName);
		$newCompanyName = filter_var($newCompanyName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCompanyName) > 255) {
			throw(new \RangeException("Address id is too large"));
		}
		// store the id
		$this->companyName = $newCompanyName;
	}

	/**
	 * accessor method for companyPhone
	 *
	 * @return string for companyPhone
	 **/
	public function getCompanyPhone(): string {
		return ($this->companyPhone);
	}

	/**
	 * mutator method for companyPhone
	 *
	 * @param string $newCompanyPhone value of new profile id
	 * @throws \RangeException if $newCompanyPhone is not positive
	 * @throws \TypeError if the companyPhone is not
	 **/
	public function setCompanyPhone($newCompanyPhone): void {
		if($newCompanyPhone === null) {
			$this->CompanyPhone = null;
			return;
		}
		// verify the company phone is secure
		$newCompanyPhone = trim($newCompanyPhone);
		$newCompanyPhone = filter_var($newCompanyPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCompanyPhone) > 255) {
			throw(new \RangeException("Address id is too large"));
		}
		// store the id
		$this->companyPhone = $newCompanyPhone;
	}

	/**
	 * accessor method for companyPostalCode
	 *
	 * @return string for companyPostalCode
	 **/
	public function getCompanyPostalCode(): string {
		return ($this->companyPostalCode);
	}

	/**
	 * mutator method for companyPostalCode
	 *
	 * @param string $newCompanyPostalCode value of new profile id
	 * @throws \RangeException if $newCompanyPostalCode is not positive
	 * @throws \TypeError if the companyPostalCode is not
	 **/
	public function setCompanyPostalCode($newCompanyPostalCode): void {
		if($newCompanyPostalCode === null) {
			$this->CompanyPostalCode = null;
			return;
		}
		// verify the company phone is secure
		$newCompanyPostalCode = trim($newCompanyPostalCode);
		$newCompanyPostalCode = filter_var($newCompanyPostalCode, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCompanyPostalCode) > 255) {
			throw(new \RangeException("Address id is too large"));
		}
		// store the id
		$this->companyPostalCode = $newCompanyPostalCode;
	}

	/**
	 *accessor method for company salt
	 *
	 * @return string representation of the salt hexadecimal
	 */
	public function getCompanySalt(): string {
		return $this->companySalt;
	}

	/**
	 * mutator method for company salt
	 *
	 * @param string $newCompanySalt
	 * @throws \InvalidArgumentException if the salt is not secure
	 * @throws \RangeException if the salt is not 64 characters
	 * @throws \TypeError if the profile salt is not a string
	 */
	public function setCompanySalt(string $newCompanySalt): void {
		//enforce that the salt is properly formatted
		$newCompanySalt = trim($newCompanySalt);
		$newCompanySalt = strtolower($newCompanySalt);
		//enforce that the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newCompanySalt)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		//enforce that the salt is exactly 64 characters.
		if(strlen($newCompanySalt) !== 64) {
			throw(new \RangeException("profile salt must be 128 characters"));
		}
		//store the hash
		$this->companySalt = $newCompanySalt;
	}

	/**
	 *accessor method for company state
	 *
	 * @return string company state
	 */
	public function getCompanyState(): string {
		return $this->companyState;
	}

	/**
	 * mutator method for company state
	 *
	 * @param string $newCompanyState
	 * @throws \InvalidArgumentException if the salt is not secure
	 * @throws \RangeException if the salt is not 64 characters
	 * @throws \TypeError if the profile salt is not a string
	 */
	public function setCompanyState(string $newCompanyState): void {
		//enforce that the salt is properly formatted
		$newCompanyState = trim($newCompanyState);
		$newCompanyState = strtolower($newCompanyState);
		//enforce that the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newCompanyState)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		//enforce that the salt is exactly 64 characters.
		if(strlen($newCompanyState) !== 64) {
			throw(new \RangeException("profile salt must be 128 characters"));
		}
		//store the hash
		$this->companyState = $newCompanyState;
	}

	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO company(companyId, companyAddress, companyCity, companyEmail, companyHash, companyName, companyPhone, companyPostalCode, CompanySalt, CompanyState) VALUES (:companyId, :companyAddress, :companyCity, :companyEmail, :companyHash, :companyName, :companyPhone, :companyPostalCode, :companySalt, :companyState)";
		$statement = $pdo->prepare($query);
		$parameters = ["companyId" => $this->companyId->getBytes(), "companyAddress" => $this->companyAddress, "companyCity" => $this->companyCity, "companyEmail" => $this->companyEmail, "companyHash" => $this->companyHash, "companyName" => $this->companyName, "companyPhone" => $this->companyPhone, "companyPostalCode" => $this->companyPostalCode, "companySalt" => $this->companyState];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Company from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM company WHERE companyId = :companyId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->companyId->getBytes()];
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
		$query = "UPDATE company SET companyId = :companyId, companyAddress = :companyAddress, companyCity = :companyCity, companyEmail = :companyEmail, companyHash = :companyHash, companyName = :companyName, companyPhone = :companyPhone, companyPostalCode = :companyPostalCode, CompanySalt = :companySalt, CompanyState = :companyState WHERE companyId = :companyId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["companyId" => $this->companyId->getBytes(), "companyAddress" => $this->companyAddress, "companyCity" => $this->companyCity, "companyEmail" => $this->companyEmail, "companyHash" => $this->companyHash, "companyName" => $this->companyName, "companyPhone" => $this->companyPhone, "companyPostalCode" => $this->companyPostalCode, "companySalt" => $this->companyState];
		$statement->execute($parameters);
	}


	/**
	 * gets the Company by company id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param string $companyId profile Id to search for
	 * @return Company|null Company or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getCompanyByCompanyId(\PDO $pdo, string $companyId):?Company {
		// sanitize the id before searching
		try {
			$companyId = self::validateUuid($companyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT companyId, companyAddress, companyCity, companyEmail, companyHash, companyName, companyPhone, companyPostalCode, CompanySalt, CompanyState FROM company WHERE companyId = :companyId";
		$statement = $pdo->prepare($query);
		// bind the company id to the place holder in the template
		$parameters = ["companyId" => $companyId->getBytes()];
		$statement->execute($parameters);
		// grab the company from mySQL
		try {
			$company = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$company = new Company($row["companyId"], $row["companyAddress"], $row["companyCity"], $row["companyEmail"], $row["companyHash"],  $row["companyName"], $row["companyPhone"], $row["companyPostalCode"], $row["companySalt"], $row["companyState"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($company);
	}

	/**
	 * gets the Company by City
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $companyCity is the search term that includes profile first namd and last name
	 * @return \SplFixedArray SplFixedArray of Companies found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCompanyByCompanyCity(\PDO $pdo, string $companyCity): \SPLFixedArray {
		// sanitize the city before searching
		$companyCity = trim($companyCity);
		$companyCity = filter_var($companyCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($companyCity) === true) {
			throw(new \PDOException("not a valid city"));
		}

		// create query template
		$query = "SELECT companyId, companyAddress, companyCity, companyEmail, companyHash, companyName, companyPhone, companyPostalCode, CompanySalt, CompanyState FROM company WHERE :companyCity LIKE CONCAT('%', REPLACE(:companyCity, ' ', '%'),'%')";
		$statement = $pdo->prepare($query);

		// bind the city to the place holder in the template
		$companyCity = "companyCity";
		$parameters = ["companyCity" => $companyCity];
		$statement->execute($parameters);

		// build an array of cities
		$companyCities = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$companyCity = new Company($row["companyId"], $row["companyAddress"], $row["companyCity"], $row["companyEmail"], $row["companyHash"],  $row["companyName"], $row["companyPhone"], $row["companyPostalCode"], $row["companySalt"], $row["companyState"]);
				$companyCities[$companyCities->key()] = $companyCity;
				$companyCities->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($companyCities);
	}

	/**
	 * gets the Company by email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $companyEmail email to search for
	 * @return Company|null Company or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCompanyByCompanyEmail(\PDO $pdo, string $companyEmail): ?Company {
		// sanitize the email before searching
		$companyEmail = trim($companyEmail);
		$companyEmail = filter_var($companyEmail, FILTER_VALIDATE_EMAIL);
		if(empty($companyEmail) === true) {
			throw(new \PDOException("not a valid email"));
		}
		// create query template
		$query = "SELECT companyId, companyAddress, companyCity, companyEmail, companyHash, companyName, companyPhone, companyPostalCode, CompanySalt, CompanyState FROM company WHERE companyEmail = :companyEmail";
		$statement = $pdo->prepare($query);
		// bind the Company email to the place holder in the template
		$parameters = ["companyEmail" => $companyEmail];
		$statement->execute($parameters);
		// grab the Company from mySQL
		try {
			$company = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$company = new Company($row["companyId"], $row["companyAddress"], $row["companyCity"], $row["companyEmail"], $row["companyHash"],  $row["companyName"], $row["companyPhone"], $row["companyPostalCode"], $row["companySalt"], $row["companyState"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($company);
	}

	/**
	 * gets the Company by Name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $companyName is the search term that includes profile first namd and last name
	 * @return \SplFixedArray SplFixedArray of Companies found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCompanyByCompanyName(\PDO $pdo, string $companyName): \SPLFixedArray {
		// sanitize the name before searching
		$companyName = trim($companyName);
		$companyName = filter_var($companyName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($companyName) === true) {
			throw(new \PDOException("not a valid name"));
		}

		// create query template
		$query = "SELECT companyId, companyAddress, companyCity, companyEmail, companyHash, companyName, companyPhone, companyPostalCode, CompanySalt, CompanyState FROM company WHERE :companyName LIKE CONCAT('%', REPLACE(:companyName, ' ', '%'),'%')";
		$statement = $pdo->prepare($query);

		// bind the profile to the place holder in the template
		$companyName = "companyName";
		$parameters = ["companyName" => $companyName];
		$statement->execute($parameters);

		// build an array of profiles
		$companyNames = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$companyName = new Company($row["companyId"], $row["companyAddress"], $row["companyCity"], $row["companyEmail"], $row["companyHash"],  $row["companyName"], $row["companyPhone"], $row["companyPostalCode"], $row["companySalt"], $row["companyState"]);
				$companyNames[$companyNames->key()] = $companyName;
				$companyNames->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($companyNames);
	}

	/**
	 * gets the Company by phone
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $companyPhone to search for
	 * @return Company|null Company or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCompanyByCompanyPhone(\PDO $pdo, string $companyPhone): ?Company {
		// sanitize the phone before searching
		$companyPhone = trim($companyPhone);
		$companyPhone = filter_var($companyPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($companyPhone) === true) {
			throw(new \PDOException("not a valid phone number"));
		}
		// create query template
		$query = "SELECT companyId, companyAddress, companyCity, companyEmail, companyHash, companyName, companyPhone, companyPostalCode, CompanySalt, CompanyState FROM company WHERE companyPhone = :companyPhone";
		$statement = $pdo->prepare($query);
		// bind the profile email to the place holder in the template
		$parameters = ["companyPhone" => $companyPhone];
		$statement->execute($parameters);
		// grab the Profile from mySQL
		try {
			$company = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$$company = new Company($row["companyId"], $row["companyAddress"], $row["companyCity"], $row["companyEmail"], $row["companyHash"],  $row["companyName"], $row["companyPhone"], $row["companyPostalCode"], $row["companySalt"], $row["companyState"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($company);
	}

	/**
	 * gets the Company by Postal Code
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $companyPostalCode is the search term that includes profile first namd and last name
	 * @return \SplFixedArray SplFixedArray of Companies found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCompanyByCompanyPostalCode(\PDO $pdo, string $companyPostalCode): \SPLFixedArray {
		// sanitize the city before searching
		$companyPostalCode = trim($companyPostalCode);
		$companyPostalCode = filter_var($companyPostalCode, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($companyPostalCode) === true) {
			throw(new \PDOException("not a valid city"));
		}

		// create query template
		$query = "SELECT companyId, companyAddress, companyCity, companyEmail, companyHash, companyName, companyPhone, companyPostalCode, CompanySalt, CompanyState FROM company WHERE :companyPostalCode LIKE CONCAT('%', REPLACE(:companyPostalCode, ' ', '%'),'%')";
		$statement = $pdo->prepare($query);

		// bind the postal code to the place holder in the template
		$companyPostalCode = "companyPostalCode";
		$parameters = ["companyPostalCode" => $companyPostalCode];
		$statement->execute($parameters);

		// build an array of companies with the same postal codes
		$companyPostalCodes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$companyPostalCode = new Company($row["companyId"], $row["companyAddress"], $row["companyCity"], $row["companyEmail"], $row["companyHash"],  $row["companyName"], $row["companyPhone"], $row["companyPostalCode"], $row["companySalt"], $row["companyState"]);
				$companyPostalCodes[$companyPostalCodes->key()] = $companyPostalCode;
				$companyPostalCodes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($companyPostalCodes);
	}

	/**
	 * gets the Company by State
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $companyState
	 * @return \SplFixedArray SplFixedArray of Companies found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCompanyByCompanyState(\PDO $pdo, string $companyState): \SPLFixedArray {
		// sanitize the state before searching
		$companyState = trim($companyState);
		$companyState = filter_var($companyState, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($companyState) === true) {
			throw(new \PDOException("not a valid state"));
		}

		// create query template
		$query = "SELECT companyId, companyAddress, companyCity, companyEmail, companyHash, companyName, companyPhone, companyPostalCode, CompanySalt, CompanyState FROM company WHERE :companyState LIKE CONCAT('%', REPLACE(:companyState, ' ', '%'),'%')";
		$statement = $pdo->prepare($query);

		// bind the postal code to the place holder in the template
		$companyState = "companyState";
		$parameters = ["companyState" => $companyState];
		$statement->execute($parameters);

		// build an array of companies with the same postal codes
		$companyStates = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$companyState = new Company($row["companyId"], $row["companyAddress"], $row["companyCity"], $row["companyEmail"], $row["companyHash"],  $row["companyName"], $row["companyPhone"], $row["companyPostalCode"], $row["companySalt"], $row["companyState"]);
				$companyStates[$companyStates->key()] = $companyState;
				$companyStates->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($companyStates);
	}

	/**
	 * gets all Companies
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of weddings found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllCompanies(\PDO $pdo) : \SPLFixedArray {

		// create query template
		$query = "SELECT companyId, companyAddress, companyCity, companyEmail, companyHash, companyName, companyPhone, companyPostalCode, CompanySalt, CompanyState FROM company";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of tweets
		$companies = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$company = new Company($row["companyId"], $row["companyAddress"], $row["companyCity"], $row["companyEmail"], $row["companyHash"],  $row["companyName"], $row["companyPhone"], $row["companyPostalCode"], $row["companySalt"], $row["companyState"]);
				$companies[$companies->key()] = $company;
				$companies->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($companies);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public
	function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["companyId"] = $this->companyId->toString();
		unset($fields["companyHash"]);
		unset($fields["companySalt"]);
		return ($fields);
	}
}
