<?php

namespace Edu\Cnm\Tux;
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
