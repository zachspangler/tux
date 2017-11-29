<?php

namespace Edu\Cnm\DataDesign;
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