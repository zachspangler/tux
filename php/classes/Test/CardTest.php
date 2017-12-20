<?php
namespace Zachspangler\Tux\Test;

use Zachspangler\Tux\{
	Profile, Wedding, Card
};
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Card
 * @author Zach Spangler<zspangler@gmail.com> and Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class CardTest extends TuxTest {
	/**
	 * Profile that created the liked the Tweet; this is for foreign key relations
	 * @var  Profile $profile
	 **/
	protected $profile;
	/**
	 * Wedding is the wedding the card is related to; this is for foreign key relations
	 * @var Wedding $wedding
	 **/
	protected $wedding;
	/**
	 * Card Size - Chest
	 * @var int $VALID_CARD_CHEST
	 **/
	protected $VALID_CARD_CHEST = 15;
	/**
	 * Card Size - Coat
	 * @var int $VALID_CARD_COAT
	 **/
	protected $VALID_CARD_COAT = 15;
	/**
	 * indicates whether the card has been completed or not
	 * @var int $VALID_CARD_COMPLETE
	 **/
	protected $VALID_CARD_COMPLETE = "1";
	/**
	 * Card Size - Height
	 * @var int $VALID_CARD_HEIGHT
	 **/
	protected $VALID_CARD_HEIGHT = 125;
	/**
	 * Card Size - Neck
	 * @var int $VALID_CARD_NECK
	 **/
	protected $VALID_CARD_NECK = 10;
	/**
	 * Card Size - Outseam
	 * @var int $VALID_CARD_OUTSEAM
	 **/
	protected $VALID_CARD_OUTSEAM = 78;
	/**
	 * Card Size - Pant
	 * @var int $VALID_CARD_PANT
	 **/
	protected $VALID_CARD_PANT = 10;
	/**
	 * Card Reviewed
	 * @var int $VALID_CARD_REVIEWED
	 **/
	protected $VALID_CARD_REVIEWED = "true";
	/**
	 * Card Size - Shirt
	 * @var int $VALID_CARD_SHIRT
	 **/
	protected $VALID_CARD_SHIRT = 11;
	/**
	 * Card Size - Shoe Size
	 * @var int $VALID_CARD_SHOE_SIZE
	 **/
	protected $VALID_CARD_SHOE_SIZE = 10;
	/**
	 * Card Size - Sleeve
	 * @var int $VALID_CARD_SLEEVE
	 **/
	protected $VALID_CARD_SLEEVE = 53;
	/**
	 * Card Size - Underarm
	 * @var int $VALID_CARD_UNDERARM
	 **/
	protected $VALID_CARD_UNDERARM = 11;
	/**
	 * Card Size - Weight
	 * @var int $VALID_CARD_WEIGHT
	 **/
	protected $VALID_CARD_WEIGHT = 200;
	/**
	 * Card Size - Weight 2
	 * @var int $VALID_CARD_WEIGHT
	 **/
	protected $VALID_CARD_WEIGHT2 = 150;
	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;
	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_PROFILE_SALT;
	/**
	 * valid date of the wedding
	 * @var \DateTime $VALID_WEDDING_DATE
	 */
	protected $VALID_WEDDING_DATE;
	/**
	 * valid date of the date the card should be returned
	 * @var \DateTime $VALID_WEDDING_RETURN_BY_DATE
	 */
	protected $VALID_WEDDING_RETURN_BY_DATE;


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() : void {

		// run the default setUp() method first
		parent::setUp();

		// create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);

		// create and insert the mocked profile
		$this->profile = new Profile(generateUuidV4(), "null", "test@email.com", $this->VALID_PROFILE_HASH, "Zach", "5555555555", $this->VALID_PROFILE_SALT);
		$this->profile->insert($this->getPDO());

	// create the dates for the wedding date
		$this->VALID_WEDDING_DATE = new \DateTime();
		$this->VALID_WEDDING_RETURN_BY_DATE = new \DateTime();

		// create the and insert the mocked wedding
		$this->wedding = new Wedding(generateUuidV4(), $this->profile->getProfileId(), $this->VALID_WEDDING_DATE, "Smith", $this->VALID_WEDDING_RETURN_BY_DATE);
		$this->wedding->insert($this->getPDO());
	}


	/**
	 * test inserting a valid Card and verify that the actual mySQL data matches
	 **/
	public function testInsertValidCard(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("card");
		$cardId = generateUuidV4();

		$card = new Card($cardId, $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_CARD_CHEST, $this->VALID_CARD_COAT,$this->VALID_CARD_COMPLETE,$this->VALID_CARD_HEIGHT, $this->VALID_CARD_NECK, $this->VALID_CARD_OUTSEAM, $this->VALID_CARD_PANT, $this->VALID_CARD_SHIRT, $this->VALID_CARD_SHOE_SIZE, $this->VALID_CARD_SLEEVE, $this->VALID_CARD_UNDERARM, $this->VALID_CARD_WEIGHT);
		$card->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCard = Card::getCardByCardId($this->getPDO(), $card->getCardId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("card"));
		$this->assertEquals($pdoCard->getCardId(), $cardId);
		$this->assertEquals($pdoCard->getCardProfileId(),$this->profile->getProfileId());
		$this->assertEquals($pdoCard->getCardWeddingId(),$this->wedding->getWeddingId());
		$this->assertEquals($pdoCard->getCardChest(), $this->VALID_CARD_CHEST);
		$this->assertEquals($pdoCard->getCardCoat(), $this->VALID_CARD_COAT);
		$this->assertEquals($pdoCard->getCardComplete(), $this->VALID_CARD_COMPLETE);
		$this->assertEquals($pdoCard->getCardHeight(), $this->VALID_CARD_HEIGHT);
		$this->assertEquals($pdoCard->getCardNeck(), $this->VALID_CARD_NECK);
		$this->assertEquals($pdoCard->getCardOutseam(), $this->VALID_CARD_OUTSEAM);
		$this->assertEquals($pdoCard->getCardPant(), $this->VALID_CARD_PANT);
		$this->assertEquals($pdoCard->getCardReviewed(), $this->VALID_CARD_REVIEWED);
		$this->assertEquals($pdoCard->getCardShirt(), $this->VALID_CARD_SHIRT);
		$this->assertEquals($pdoCard->getCardShoeSize(), $this->VALID_CARD_SHOE_SIZE);
		$this->assertEquals($pdoCard->getCardSleeve(), $this->VALID_CARD_SLEEVE);
		$this->assertEquals($pdoCard->getCardUnderarm(), $this->VALID_CARD_UNDERARM);
		$this->assertEquals($pdoCard->getCardWeight(), $this->VALID_CARD_WEIGHT);
	}

/**
 * test inserting a Card, editing it, and then updating it
 **/

	public function testUpdateValidCard() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("card");
		$cardId = generateUuidV4();

		$card = new Card($cardId, $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_CARD_CHEST, $this->VALID_CARD_COAT,$this->VALID_CARD_COMPLETE,$this->VALID_CARD_HEIGHT, $this->VALID_CARD_NECK, $this->VALID_CARD_OUTSEAM, $this->VALID_CARD_PANT, $this->VALID_CARD_SHIRT, $this->VALID_CARD_SHOE_SIZE, $this->VALID_CARD_SLEEVE, $this->VALID_CARD_UNDERARM, $this->VALID_CARD_WEIGHT);
		$card->insert($this->getPDO());

		// edit the Profile and update it in mySQL
		$card->setCardWeight($this->VALID_CARD_WEIGHT2);
		$card->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCard = Card::getCardByCardId($this->getPDO(), $card->getCardId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("card"));
		$this->assertEquals($pdoCard->getCardId(), $cardId);
		$this->assertEquals($pdoCard->getCardProfileId(),$this->profile->getProfileId());
		$this->assertEquals($pdoCard->getCardWeddingId(),$this->wedding->getWeddingId());
		$this->assertEquals($pdoCard->getCardChest(), $this->VALID_CARD_CHEST);
		$this->assertEquals($pdoCard->getCardCoat(), $this->VALID_CARD_COAT);
		$this->assertEquals($pdoCard->getCardComplete(), $this->VALID_CARD_COMPLETE);
		$this->assertEquals($pdoCard->getCardHeight(), $this->VALID_CARD_HEIGHT);
		$this->assertEquals($pdoCard->getCardNeck(), $this->VALID_CARD_NECK);
		$this->assertEquals($pdoCard->getCardOutseam(), $this->VALID_CARD_OUTSEAM);
		$this->assertEquals($pdoCard->getCardPant(), $this->VALID_CARD_PANT);
		$this->assertEquals($pdoCard->getCardReviewed(), $this->VALID_CARD_REVIEWED);
		$this->assertEquals($pdoCard->getCardShirt(), $this->VALID_CARD_SHIRT);
		$this->assertEquals($pdoCard->getCardShoeSize(), $this->VALID_CARD_SHOE_SIZE);
		$this->assertEquals($pdoCard->getCardSleeve(), $this->VALID_CARD_SLEEVE);
		$this->assertEquals($pdoCard->getCardUnderarm(), $this->VALID_CARD_UNDERARM);
		$this->assertEquals($pdoCard->getCardWeight(), $this->VALID_CARD_WEIGHT);
	}

	/**
	 * test creating a Card and then deleting it
	 **/

	public function testDeleteValidProfile(): void {
	// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("card");
		$cardId = generateUuidV4();

		$card = new Card($cardId, $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_CARD_CHEST, $this->VALID_CARD_COAT,$this->VALID_CARD_COMPLETE,$this->VALID_CARD_HEIGHT, $this->VALID_CARD_NECK, $this->VALID_CARD_OUTSEAM, $this->VALID_CARD_PANT, $this->VALID_CARD_SHIRT, $this->VALID_CARD_SHOE_SIZE, $this->VALID_CARD_SLEEVE, $this->VALID_CARD_UNDERARM, $this->VALID_CARD_WEIGHT);
		$card->insert($this->getPDO());

		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("card"));
		$card->delete($this->getPDO());
		// grab the data from mySQL and enforce the Profile does not exist
		$pdoCard = Card::getCardByCardId($this->getPDO(), $card->getCardId());
		$this->assertNull($pdoCard);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("card"));
	}

	/**
	 * test inserting a Card and regrabbing it from mySQL
	 **/

	public function testGetValidCardByCardId(): void {
		$numRows = $this->getConnection()->getRowCount("card");
		$cardId = generateUuidV4();

		$card = new Card($cardId, $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_CARD_CHEST, $this->VALID_CARD_COAT,$this->VALID_CARD_COMPLETE,$this->VALID_CARD_HEIGHT, $this->VALID_CARD_NECK, $this->VALID_CARD_OUTSEAM, $this->VALID_CARD_PANT, $this->VALID_CARD_SHIRT, $this->VALID_CARD_SHOE_SIZE, $this->VALID_CARD_SLEEVE, $this->VALID_CARD_UNDERARM, $this->VALID_CARD_WEIGHT);
		$card->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCard = Card::getCardByCardId($this->getPDO(), $card->getCardId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("card"));
		$this->assertEquals($pdoCard->getCardId(), $cardId);
		$this->assertEquals($pdoCard->getCardProfileId(),$this->profile->getProfileId());
		$this->assertEquals($pdoCard->getCardWeddingId(),$this->wedding->getWeddingId());
		$this->assertEquals($pdoCard->getCardChest(), $this->VALID_CARD_CHEST);
		$this->assertEquals($pdoCard->getCardCoat(), $this->VALID_CARD_COAT);
		$this->assertEquals($pdoCard->getCardComplete(), $this->VALID_CARD_COMPLETE);
		$this->assertEquals($pdoCard->getCardHeight(), $this->VALID_CARD_HEIGHT);
		$this->assertEquals($pdoCard->getCardNeck(), $this->VALID_CARD_NECK);
		$this->assertEquals($pdoCard->getCardOutseam(), $this->VALID_CARD_OUTSEAM);
		$this->assertEquals($pdoCard->getCardPant(), $this->VALID_CARD_PANT);
		$this->assertEquals($pdoCard->getCardReviewed(), $this->VALID_CARD_REVIEWED);
		$this->assertEquals($pdoCard->getCardShirt(), $this->VALID_CARD_SHIRT);
		$this->assertEquals($pdoCard->getCardShoeSize(), $this->VALID_CARD_SHOE_SIZE);
		$this->assertEquals($pdoCard->getCardSleeve(), $this->VALID_CARD_SLEEVE);
		$this->assertEquals($pdoCard->getCardUnderarm(), $this->VALID_CARD_UNDERARM);
		$this->assertEquals($pdoCard->getCardWeight(), $this->VALID_CARD_WEIGHT);
	}

	/**
	 * test grabbing a Card that does not exist
	 **/
	public function testGetInvalidCardByCardId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeCardId = generateUuidV4();
		$card = Card::getCardByCardId($this->getPDO(), $fakeCardId);
		$this->assertNull($card);
	}

	/**
	 * test grabbing a Card by the Profile Id
	 **/

	public function testGetValidCardByProfileId() {
		$numRows = $this->getConnection()->getRowCount("card");
		$cardId = generateUuidV4();

		$card = new Card($cardId, $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_CARD_CHEST, $this->VALID_CARD_COAT,$this->VALID_CARD_COMPLETE,$this->VALID_CARD_HEIGHT, $this->VALID_CARD_NECK, $this->VALID_CARD_OUTSEAM, $this->VALID_CARD_PANT, $this->VALID_CARD_SHIRT, $this->VALID_CARD_SHOE_SIZE, $this->VALID_CARD_SLEEVE, $this->VALID_CARD_UNDERARM, $this->VALID_CARD_WEIGHT);
		$card->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Card::getCardByProfileId($this->getPDO(), $card->getCardProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("card"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Card", $results);

		// grab the result from the array and validate it
		$pdoCard = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("card"));
		$this->assertEquals($pdoCard->getCardId(), $cardId);
		$this->assertEquals($pdoCard->getCardProfileId(),$this->profile->getProfileId());
		$this->assertEquals($pdoCard->getCardWeddingId(),$this->wedding->getWeddingId());
		$this->assertEquals($pdoCard->getCardChest(), $this->VALID_CARD_CHEST);
		$this->assertEquals($pdoCard->getCardCoat(), $this->VALID_CARD_COAT);
		$this->assertEquals($pdoCard->getCardComplete(), $this->VALID_CARD_COMPLETE);
		$this->assertEquals($pdoCard->getCardHeight(), $this->VALID_CARD_HEIGHT);
		$this->assertEquals($pdoCard->getCardNeck(), $this->VALID_CARD_NECK);
		$this->assertEquals($pdoCard->getCardOutseam(), $this->VALID_CARD_OUTSEAM);
		$this->assertEquals($pdoCard->getCardPant(), $this->VALID_CARD_PANT);
		$this->assertEquals($pdoCard->getCardReviewed(), $this->VALID_CARD_REVIEWED);
		$this->assertEquals($pdoCard->getCardShirt(), $this->VALID_CARD_SHIRT);
		$this->assertEquals($pdoCard->getCardShoeSize(), $this->VALID_CARD_SHOE_SIZE);
		$this->assertEquals($pdoCard->getCardSleeve(), $this->VALID_CARD_SLEEVE);
		$this->assertEquals($pdoCard->getCardUnderarm(), $this->VALID_CARD_UNDERARM);
		$this->assertEquals($pdoCard->getCardWeight(), $this->VALID_CARD_WEIGHT);
	}

	/**
	 * test grabbing a card by a profile that does not exist
	 **/
	public function testGetInvalidCardByProfileId() : void {
		// grab a company by a city that does not exist
		$card = Card::getCardByProfileId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $card);
	}

	/**
	 * test getting a valid card by Wedding Id
	 **/

	public function testGetValidCardByWeddingId() {
		$numRows = $this->getConnection()->getRowCount("card");
		$cardId = generateUuidV4();

		$card = new Card($cardId, $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_CARD_CHEST, $this->VALID_CARD_COAT,$this->VALID_CARD_COMPLETE,$this->VALID_CARD_HEIGHT, $this->VALID_CARD_NECK, $this->VALID_CARD_OUTSEAM, $this->VALID_CARD_PANT, $this->VALID_CARD_SHIRT, $this->VALID_CARD_SHOE_SIZE, $this->VALID_CARD_SLEEVE, $this->VALID_CARD_UNDERARM, $this->VALID_CARD_WEIGHT);
		$card->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Card::getCardByWeddingId($this->getPDO(), $card->getCardWeddingId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("card"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Card", $results);

		// grab the result from the array and validate it
		$pdoCard = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("card"));
		$this->assertEquals($pdoCard->getCardId(), $cardId);
		$this->assertEquals($pdoCard->getCardProfileId(),$this->profile->getProfileId());
		$this->assertEquals($pdoCard->getCardWeddingId(),$this->wedding->getWeddingId());
		$this->assertEquals($pdoCard->getCardChest(), $this->VALID_CARD_CHEST);
		$this->assertEquals($pdoCard->getCardCoat(), $this->VALID_CARD_COAT);
		$this->assertEquals($pdoCard->getCardComplete(), $this->VALID_CARD_COMPLETE);
		$this->assertEquals($pdoCard->getCardHeight(), $this->VALID_CARD_HEIGHT);
		$this->assertEquals($pdoCard->getCardNeck(), $this->VALID_CARD_NECK);
		$this->assertEquals($pdoCard->getCardOutseam(), $this->VALID_CARD_OUTSEAM);
		$this->assertEquals($pdoCard->getCardPant(), $this->VALID_CARD_PANT);
		$this->assertEquals($pdoCard->getCardReviewed(), $this->VALID_CARD_REVIEWED);
		$this->assertEquals($pdoCard->getCardShirt(), $this->VALID_CARD_SHIRT);
		$this->assertEquals($pdoCard->getCardShoeSize(), $this->VALID_CARD_SHOE_SIZE);
		$this->assertEquals($pdoCard->getCardSleeve(), $this->VALID_CARD_SLEEVE);
		$this->assertEquals($pdoCard->getCardUnderarm(), $this->VALID_CARD_UNDERARM);
		$this->assertEquals($pdoCard->getCardWeight(), $this->VALID_CARD_WEIGHT);
	}

	/**
	 * test grabbing a card by a profile that does not exist
	 **/
	public function testGetInvalidCardByWeddingId() : void {
		// grab a company by a city that does not exist
		$card = Card::getCardByWeddingId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $card);
	}
}