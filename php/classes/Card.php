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
class Card implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for the card size; this is the primary key
	 * @var Uuid|string $cardId
	 **/
	private $cardId;
	/**
	 * address of the company
	 * @var Uuid|string $cardProfileId
	 **/
	private $cardProfileId;
	/**
	 * address of the company
	 * @var Uuid|string $cardWeddingId
	 **/
	private $cardWeddingId;
	/**
	 * city of the company
	 * @var int $cardChest
	 **/
	private $cardChest;
	/**
	 * email of the company
	 * @var int $cardPant
	 **/
	private $cardCoat;
	/**
	 * email of the company
	 * @var boolean $cardComplete
	 **/
	private $cardComplete;
	/**
	 * name of the company
	 * @var int $cardHeight
	 **/
	private $cardHeight;
	/**
	 * name of the company
	 * @var int $cardNeck
	 **/
	private $cardNeck;
	/**
	 * name of the company
	 * @var int $cardOutseam
	 **/
	private $cardOutseam;
	/**
	 * name of the company
	 * @var int $cardPant
	 **/
	private $cardPant;
	/**
	 * name of the company
	 * @var string $cardReviewed
	 **/
	private $cardReviewed;
	/**
	 * name of the company
	 * @var int $cardShirt
	 **/
	private $cardShirt;
	/**
	 * name of the company
	 * @var int $cardShoeSize
	 **/
	private $cardShoeSize;
	/**
	 * name of the company
	 * @var int $cardSleeve
	 **/
	private $cardSleeve;
	/**
	 * name of the company
	 * @var int $cardUnderarm
	 **/
	private $cardUnderarm;
	/**
	 * name of the company
	 * @var int $cardWeight
	 **/
	private $cardWeight;
	/**
	 * constructor for this Company
	 *
	 * @param Uuid|string $newCardId
	 * @param Uuid|string $newCardProfileId
	 * @param Uuid|string $newCardWeddingId
	 * @param int $newCardChest
	 * @param int $newCardCoat
	 * @param boolean $newCardComplete
	 * @param int $newCardHeight
	 * @param int $newCardNeck
	 * @param int $newCardOutseam
	 * @param int $newCardPant
	 * @param boolean $newCardReviewed
	 * @param int $newCardShirt
	 * @param int $newCardShoeSize
	 * @param int $newCardSleeve
	 * @param int $newCardUnderarm
	 * @param int $newCardWeight
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct($newCardId, $newCardProfileId, $newCardWeddingId, int $newCardChest, int $newCardCoat, boolean $newCardComplete, int $newCardHeight, int $newCardNeck, int $newCardOutseam, int $newCardPant, boolean $newCardReviewed, int $newCardShirt, int $newCardShoeSize, int $newCardSleeve, int $newCardUndearm, int $newCardWeight) {
		try {
			$this->setCardId($newCardId);
			$this->setCardProfileId($newCardProfileId);
			$this->setCardWeddingId($newCardWeddingId);
			$this->setCardChest($newCardChest);
			$this->setCardCoat($newCardCoat);
			$this->setCardComplete($newCardComplete);
			$this->setCardHeight($newCardHeight);
			$this->setCardNeck($newCardNeck);
			$this->setCardOutseam($newCardOutseam);
			$this->setCardPant($newCardPant);
			$this->setCardReviewed($newCardReviewed);
			$this->setCardShirt($newCardShirt);
			$this->setCardShoeSize($newCardShoeSize);
			$this->setCardSleeve ($newCardSleeve);
			$this->setCardUnderarm($newCardUndearm);
			$this->setCardWeight($newCardWeight);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for card id
	 *
	 * @return Uuid value of card id
	 **/
	public function getCardId(): Uuid {
		return ($this->cardId);
	}

	/**
	 * mutator method for wedding id
	 *
	 * @param  Uuid| string $newCardId value of new profile id
	 * @throws \RangeException if $newCardId is not positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardId($newCardId): void {
		try {
			$uuid = self::validateUuid($newCardId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->cardId = $uuid;
	}

	/**
	 * accessor method for cardProfileId
	 *
	 * @return Uuid value of cardProfileId
	 **/
	public function getCardProfileId(): Uuid {
		return ($this->cardProfileId);
	}

	/**
	 * mutator method for cardProfileId
	 *
	 * @param  Uuid| string $newCardProfileId value of new profile id
	 * @throws \RangeException if $newCardProfileId is not positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardProfileId($newCardProfileId): void {
		try {
			$uuid = self::validateUuid($newCardProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->cardProflieId = $uuid;
	}

	/**
	 * accessor method for cardWeddingId
	 *
	 * @return Uuid value of cardWeddingId
	 **/
	public function getCardWeddingId(): Uuid {
		return ($this->cardWeddingId);
	}

	/**
	 * mutator method for cardWeddingId
	 *
	 * @param  Uuid| string $newCardProfileId value of new profile id
	 * @throws \RangeException if $newCardProfileId is not positive
	 *  @throws \TypeError if the input is not correct type
	 **/
	public function setCardWeddingId($newCardWeddingId): void {
		try {
			$uuid = self::validateUuid($newCardWeddingId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->cardWeddingId = $uuid;
	}

	/**
	 * accessor method for cardChest
	 *
	 * @return int for cardChest
	 **/
	public function getCardChest(): int {
		return ($this->cardChest);
	}

	/**
	 * mutator method for cardChest
	 *
	 * @param int $newCardChest value of cardChest
	 * @throws \RangeException if $newCardChest is positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardChest($newCardChest): void {
		if($newCardChest === null) {
			$this->cardChest = null;
			return;
		}
		// verify the company city is secure
		$newCardChest = trim($newCardChest);
		$newCardChest = filter_var($newCardChest, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardChest) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardChest = $newCardChest;
	}

	/**
	 * accessor method for cardCoat
	 *
	 * @return int for cardCoat
	 **/
	public function getCardCoat(): int {
		return ($this->cardCoat);
	}

	/**
	 * mutator method for cardCoat
	 *
	 * @param int $newCardCoat value of cardCoat
	 * @throws \RangeException if $newCardCoat is positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardCoat($newCardCoat): void {
		if($newCardCoat === null) {
			$this->cardCoat = null;
			return;
		}
		// verify the company city is secure
		$newCardCoat = trim($newCardCoat);
		$newCardCoat = filter_var($newCardCoat, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardCoat) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardCoat = $newCardCoat;
	}

	/**
	 * accessor method for cardComplete
	 *
	 * @return boolean for cardComplete
	 **/
	public function getCardComplete(): boolean {
		return ($this->cardComplete);
	}

	/**
	 * mutator method for cardComplete
	 *
	 * @param int $newCardComplete value of cardComplete
	 * @throws \RangeException if $newCardComplete is positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardComplete($newCardComplete): void {
		if($newCardComplete === null) {
			$this->cardComplete = null;
			return;
		}
		// verify the company city is secure
		$newCardComplete = trim($newCardComplete);
		$newCardComplete = filter_var($newCardComplete, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardComplete) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardComplete = $newCardComplete;
	}

	/**
	 * accessor method for cardHeight
	 *
	 * @return int for cardHeight
	 **/
	public function getCardHeight(): int {
		return ($this->cardHeight);
	}

	/**
	 * mutator method for cardHeight
	 *
	 * @param int $newCardHeight value of cardHeight
	 * @throws \RangeException if $newCardHeight is positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardHeight($newCardHeight): void {
		if($newCardHeight === null) {
			$this->cardHeight = null;
			return;
		}
		// verify the company city is secure
		$newCardHeight = trim($newCardHeight);
		$newCardHeight = filter_var($newCardHeight, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardHeight) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardHeight = $newCardHeight;
	}

	/**
	 * accessor method for cardNeck
	 *
	 * @return int for cardNeck
	 **/
	public function getCardNeck(): int {
		return ($this->cardNeck);
	}

	/**
	 * mutator method for cardNeck
	 *
	 * @param int $newCardNeck value of cardNeck
	 * @throws \RangeException if $newCardNeck is positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardNeck($newCardNeck): void {
		if($newCardNeck === null) {
			$this->cardNeck = null;
			return;
		}
		// verify the company city is secure
		$newCardNeck = trim($newCardNeck);
		$newCardNeck = filter_var($newCardNeck, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardNeck) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardNeck = $newCardNeck;
	}

	/**
	 * accessor method for cardOutseam
	 *
	 * @return int for cardOutseam
	 **/
	public function getCardOutseam(): int {
		return ($this->cardOutseam);
	}

	/**
	 * mutator method for cardOutseam
	 *
	 * @param int $newCardOutseam value of cardOutseam
	 * @throws \RangeException if $newCardOutseam is positive
	 *  @throws \TypeError if the input is not correct type
	 **/
	public function setCardOutseam($newCardOutseam): void {
		if($newCardOutseam === null) {
			$this->cardOutseam = null;
			return;
		}
		// verify the company city is secure
		$newCardOutseam = trim($newCardOutseam);
		$newCardOutseam = filter_var($newCardOutseam, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardOutseam) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardOutseam = $newCardOutseam;
	}

	/**
	 * accessor method for cardPant
	 *
	 * @return int for cardPant
	 **/
	public function getCardPant(): int {
		return ($this->cardPant);
	}

	/**
	 * mutator method for cardPant
	 *
	 * @param int $newCardPant value of cardPant
	 * @throws \RangeException if $newCardPant is positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardPant($newCardPant): void {
		if($newCardPant === null) {
			$this->cardPant = null;
			return;
		}
		// verify the company city is secure
		$newCardPant = trim($newCardPant);
		$newCardPant = filter_var($newCardPant, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardPant) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardPant = $newCardPant;
	}

	/**
	 * accessor method for cardReviewed
	 *
	 * @return boolean for cardReviewed
	 **/
	public function getCardReviewed(): boolean {
		return ($this->cardReviewed);
	}

	/**
	 * mutator method for cardReviewed
	 *
	 * @param int $newCardShirt value of cardReviewed
	 * @throws \RangeException if $newCardReviewed is positive
	 *  @throws \TypeError if the input is not correct type
	 **/
	public function setCardReviewed($newCardReviewed): void {
		if($newCardReviewed === null) {
			$this->cardReviewed = null;
			return;
		}
		// verify the company city is secure
		$newCardReviewed = trim($newCardReviewed);
		$newCardReviewed = filter_var($newCardReviewed, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardReviewed) > 255) {
			throw(new \RangeException("Card string is too long"));
		}
		// store the id
		$this->cardReviewed = $newCardReviewed;
	}

	/**
	 * accessor method for cardShirt
	 *
	 * @return int for cardShirt
	 **/
	public function getCardShirt(): int {
		return ($this->cardShirt);
	}

	/**
	 * mutator method for cardShirt
	 *
	 * @param int $newCardShirt value of cardShirt
	 * @throws \RangeException if $newCardShirt is positive
	 *  @throws \TypeError if the input is not correct type
	 **/
	public function setCardShirt($newCardShirt): void {
		if($newCardShirt === null) {
			$this->cardShirt = null;
			return;
		}
		// verify the company city is secure
		$newCardShirt = trim($newCardShirt);
		$newCardShirt = filter_var($newCardShirt, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardShirt) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardShirt = $newCardShirt;
	}


	/**
	 * accessor method for cardShoeSize
	 *
	 * @return int for cardShoeSize
	 **/
	public function getCardShoeSize(): int {
		return ($this->cardShoeSize);
	}

	/**
	 * mutator method for cardShoeSize
	 *
	 * @param int $newCardShoeSize value of cardShoeSize
	 * @throws \RangeException if $newCardShoeSize is positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardShoeSize($newCardShoeSize): void {
		if($newCardShoeSize === null) {
			$this->cardShoeSize = null;
			return;
		}
		// verify the company city is secure
		$newCardShoeSize = trim($newCardShoeSize);
		$newCardShoeSize = filter_var($newCardShoeSize, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardShoeSize) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardShoeSize = $newCardShoeSize;
	}

	/**
	 * accessor method for cardSleeve
	 *
	 * @return int for cardSleeve
	 **/
	public function getCardSleeve(): int {
		return ($this->cardSleeve);
	}

	/**
	 * mutator method for cardSleeve
	 *
	 * @param int $newCardSleeve value of cardSleeve
	 * @throws \RangeException if $newCardSleeve is positive
	 *  @throws \TypeError if the input is not correct type
	 **/
	public function setCardSleeve($newCardSleeve): void {
		if($newCardSleeve === null) {
			$this->cardSleeve = null;
			return;
		}
		// verify the company city is secure
		$newCardSleeve = trim($newCardSleeve);
		$newCardSleeve = filter_var($newCardSleeve, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardSleeve) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardSleeve = $newCardSleeve;
	}

	/**
	 * accessor method for cardUnderarm
	 *
	 * @return int for cardUnderarm
	 **/
	public function getCardUnderarm(): int {
		return ($this->cardUnderarm);
	}

	/**
	 * mutator method for cardUnderarm
	 *
	 * @param int $newCardUnderarm value of cardUnderarm
	 * @throws \RangeException if $newCardUnderarm is positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardUnderarm($newCardUnderarm): void {
		if($newCardUnderarm === null) {
			$this->cardUnderarm = null;
			return;
		}
		// verify the company city is secure
		$newCardUnderarm = trim($newCardUnderarm);
		$newCardUnderarm = filter_var($newCardUnderarm, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardUnderarm) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardUnderarm = $newCardUnderarm;
	}

	/**
	 * accessor method for cardWeight
	 *
	 * @return int for cardWeight
	 **/
	public function getCardWeight(): int {
		return ($this->cardWeight);
	}

	/**
	 * mutator method for cardWeight
	 *
	 * @param int $newCardWeight value of cardWeight
	 * @throws \RangeException if $newCardWeight is positive
	 * @throws \TypeError if the input is not correct type
	 **/
	public function setCardWeight($newCardWeight): void {
		if($newCardWeight === null) {
			$this->cardWeight = null;
			return;
		}
		// verify the company city is secure
		$newCardWeight = trim($newCardWeight);
		$newCardWeight = filter_var($newCardWeight, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_NO_ENCODE_QUOTES);
		// verify the company city will fit in the database
		if(strlen($newCardWeight) > 255) {
			throw(new \RangeException("Chest Size number is too large"));
		}
		// store the id
		$this->cardWeight = $newCardWeight;
	}

	/**
	 * inserts this Card into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO card(cardId, cardProfileId, cardWeddingId, cardChest, cardCoat, cardComplete, cardHeight, cardNeck, cardOutseam, cardPant, cardReviewed, cardShirt, cardShoeSize, cardSleeve, cardUnderarm, cardWeight) VALUES (:cardId, :cardProfileId, :cardWeddingId, :cardChest, :cardCoat, :cardComplete, :cardHeight, :cardNeck, :cardOutseam, :cardPant, :cardReviewed, :cardShirt, :cardShoeSize, :cardSleeve, :cardUnderarm, :cardWeight)";
		$statement = $pdo->prepare($query);
		$parameters = ["cardId" => $this->cardId->getBytes(), "cardProfileId" => $this->cardProfileId->getBytes(), "cardWeddingId" => $this->cardWeddingId->getBytes(), "cardChest" => $this->cardChest, "cardCoat" => $this->cardCoat, "cardComplete" => $this->cardComplete, "cardHeight" => $this->cardHeight, "cardNeck" => $this->cardNeck, "cardOutseam" => $this->cardOutseam, "cardPant" => $this->cardPant, "cardReviewed" => $this->cardReviewed, "cardShirt" => $this->cardShirt, "cardShoeSize" => $this->cardShoeSize, "cardSleeve" => $this->cardSleeve, "cardUnderarm" => $this->cardUnderarm, "cardWeight" => $this->cardWeight];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Card from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM card WHERE cardId = :cardId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["cardId" => $this->cardId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Card from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE card SET cardId = :cardId, cardProfileId = :cardProfileId, cardWeddingId = :cardWeddingId, cardChest = :cardChest, cardCoat= :cardCoat, cardComplete = :cardComplete, cardHeight = :cardHeight, cardNeck = :cardNeck, cardOutseam = :cardOutseam, cardPant = :cardPant, cardReviewed = :cardReviewed cardShirt = :cardShirt, cardShoeSize = :cardShoeSize, cardSleeve = :cardSleeve, cardUnderarm = :cardUnderarm, cardWeight = :cardWeight WHERE cardId = :cardId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["cardId" => $this->cardId->getBytes(), "cardProfileId" => $this->cardProfileId->getBytes(), "cardWeddingId" => $this->cardWeddingId->getBytes(), "cardChest" => $this->cardChest, "cardCoat" => $this->cardCoat, "cardComplete" => $this->cardComplete, "cardHeight" => $this->cardHeight, "cardNeck" => $this->cardNeck, "cardOutseam" => $this->cardOutseam, "cardPant" => $this->cardPant, "cardReviewed" => $this->cardReviewed, "cardShirt" => $this->cardShirt, "cardShoeSize" => $this->cardShoeSize, "cardSleeve" => $this->cardSleeve, "cardUnderarm" => $this->cardUnderarm, "cardWeight" => $this->cardWeight];
		$statement->execute($parameters);
	}

	/**
	 * gets the card by card id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param string $cardId profile Id to search for
	 * @return Card|null Card or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getCardByCardId(\PDO $pdo, string $cardId): ?Card {

		// sanitize the card id before searching
		try {
			$cardId = self::validateUuid($cardId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT cardId, cardProfileId, cardWeddingId, cardChest, cardCoat, cardComplete, cardHeight, cardNeck, cardOutseam, cardPant, cardReviewed, cardShirt, cardShoeSize, cardSleeve, cardUnderarm, cardWeight FROM card WHERE cardId = :cardId";
		$statement = $pdo->prepare($query);

		// bind the card id to the place holder in the template
		$parameters = ["cardId" => $cardId->getBytes()];
		$statement->execute($parameters);

		// grab the card from mySQL
		try {
			$card = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$card = new Card($row["cardId"], $row["cardProfileId"], $row["cardWeddingId"], $row["cardChest"], $row["cardCoat"],  $row["cardComplete"], $row["cardHeight"], $row["cardNeck"], $row["cardOutseam"], $row["cardPant"], $row["cardReviewed"], $row["cardShirt"], $row["cardShoeSize"], $row["cardSleeve"], $row["cardUnderarm"], $row["cardWeight"]);
			}
		} catch(\Exception $exception) {

			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($card);
	}

	/**
	 * gets the card by profile id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param string $cardprofileId profile Id to search for
	 * @return \SplFixedArray SplFixedArray of cards found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getCardByProfileId(\PDO $pdo, string $cardProfileId): \SPLFixedArray {
		// sanitize the profile id before searching
		try {
			$cardProfileId = self::validateUuid($cardProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT cardId, cardProfileId, cardWeddingId, cardChest, cardCoat, cardComplete, cardHeight, cardNeck, cardOutseam, cardPant, cardReviewed, cardShirt, cardShoeSize, cardSleeve, cardUnderarm, cardWeight FROM card WHERE cardId = :cardId";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["cardProfileId" => $cardProfileId->getBytes()];
		$statement->execute($parameters);

		// build an array of cards
		$cards = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$card = new Card($row["cardId"], $row["cardProfileId"], $row["cardWeddingId"], $row["cardChest"], $row["cardCoat"],  $row["cardComplete"], $row["cardHeight"], $row["cardNeck"], $row["cardOutseam"], $row["cardPant"], $row["cardReviewed"], $row["cardShirt"], $row["cardShoeSize"], $row["cardSleeve"], $row["cardUnderarm"], $row["cardWeight"]);
				$cards[$cards->key()] = $card;
				$cards->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($cards);
	}

	/**
	 * gets the card by wedding id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param string $cardProfileId profile Id to search for
	 * @return \SplFixedArray SplFixedArray of cards found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getCardByWeddingId(\PDO $pdo, string $cardWeddingId): \SPLFixedArray {
		// sanitize the profile id before searching
		try {
			$cardWeddingId = self::validateUuid($cardWeddingId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT cardId, cardProfileId, cardWeddingId, cardChest, cardCoat, cardComplete, cardHeight, cardNeck, cardOutseam, cardPant, cardReviewed, cardShirt, cardShoeSize, cardSleeve, cardUnderarm, cardWeight FROM card WHERE cardId = :cardId";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["cardWeddingId" => $cardWeddingId->getBytes()];
		$statement->execute($parameters);

		// build an array of cards
		$cards = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$card = new Card($row["cardId"], $row["cardProfileId"], $row["cardWeddingId"], $row["cardChest"], $row["cardCoat"],  $row["cardComplete"], $row["cardHeight"], $row["cardNeck"], $row["cardOutseam"], $row["cardPant"], $row["cardReviewed"], $row["cardShirt"], $row["cardShoeSize"], $row["cardSleeve"], $row["cardUnderarm"], $row["cardWeight"]);
				$cards[$cards->key()] = $card;
				$cards->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($cards);
	}

	/**
	 * gets all Cards
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Cards found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllCards(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT cardId, cardProfileId, cardWeddingId, cardChest, cardCoat, cardComplete, cardHeight, cardNeck, cardOutseam, cardPant, cardShirt, cardShoeSize, cardSleeve, cardUnderarm, cardWeight FROM card";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of cards
		$cards = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$card = new Card($row["cardId"], $row["cardProfileId"], $row["cardWeddingId"], $row["cardChest"], $row["cardCoat"],  $row["cardComplete"], $row["cardHeight"], $row["cardNeck"], $row["cardOutseam"], $row["cardPant"], $row["cardReviewed"], $row["cardShirt"], $row["cardShoeSize"], $row["cardSleeve"], $row["cardUnderarm"], $row["cardWeight"]);
				$cards[$cards->key()] = $card;
				$cards->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($cards);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public
	function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["cardId"] = $this->cardId->toString();
		$fields["cardProfileId"] = $this->cardProfileId->toString();
		$fields["cardWeddingId"] = $this->cardWeddingId->toString();
		return ($fields);
	}
}