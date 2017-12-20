<?php
namespace Zachspangler\Tux\Test;
use Zachspangler\Tux\{
	Profile,
	Wedding,
	WeddingParty
};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
/**
 * Full PHPUnit test for the Wedding Party class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Zach Spangler<zspangler@gmail.com> and Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class WeddingParyTest extends TuxTest {
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
	protected $VALID_WEDDING_PARTY_ADMIN = "true";
	/**
	 * Card Size - Chest
	 * @var int $VALID_CARD_CHEST
	 **/
	protected $VALID_WEDDING_PARTY_ADMIN1 = "false";
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
	public final function setUp(): void {

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
		$numRows = $this->getConnection()->getRowCount("weddingParty");
		$weddingPartyId = generateUuidV4();

		//create new wedding party
		$weddingParty = new WeddingParty(generateUuidV4(), $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_WEDDING_PARTY_ADMIN);
		$weddingParty->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoWeddingParty = $weddingParty::getWeddingPartyByWeddingPartyId($this->getPDO(), $weddingParty->getWeddingPartyId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("weddingParty"));
		$this->assertEquals($pdoWeddingParty->getWeddingPartyId(), $weddingPartyId);
		$this->assertEquals($pdoWeddingParty->getWeddingPartyProfileId(),$this->profile->getProfileId());
		$this->assertEquals($pdoWeddingParty->getWeddingPartyWeddingId(),$this->wedding->getWeddingId());
		$this->assertEquals($pdoWeddingParty->getWeddingPartyAdmin(), $this->VALID_WEDDING_PARTY_ADMIN);
	}

	/**
	* test inserting a Card, editing it, and then updating it
	**/

	public function testUpdateValidWeddingParty() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("weddingParty");
			$weddingPartyId = generateUuidV4();

			//create new wedding party
			$weddingParty = new WeddingParty(generateUuidV4(), $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_WEDDING_PARTY_ADMIN);
			$weddingParty->insert($this->getPDO());

			//update wedding party
			$weddingParty->setWeddingPartyAdmin($this->VALID_WEDDING_PARTY_ADMIN1);
			$weddingParty->update($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$pdoWeddingParty = $weddingParty::getWeddingPartyByWeddingPartyId($this->getPDO(), $weddingParty->getWeddingPartyId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("weddingParty"));
			$this->assertEquals($pdoWeddingParty->getWeddingPartyId(), $weddingPartyId);
			$this->assertEquals($pdoWeddingParty->getWeddingPartyProfileId(),$this->profile->getProfileId());
			$this->assertEquals($pdoWeddingParty->getWeddingPartyWeddingId(),$this->wedding->getWeddingId());
			$this->assertEquals($pdoWeddingParty->getWeddingPartyAdmin(), $this->VALID_WEDDING_PARTY_ADMIN1);
	}

		/**
		 * test creating a Card and then deleting it
		 **/
	public function testDeleteValidWeddingParty() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("weddingParty");

		//create new wedding party
		$weddingParty = new WeddingParty(generateUuidV4(), $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_WEDDING_PARTY_ADMIN);
		$weddingParty->insert($this->getPDO());

		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("weddingParty"));
		$weddingParty->delete($this->getPDO());

		// grab the data from mySQL and enforce the Profile does not exist
		$pdoWeddingParty = WeddingParty::getWeddingPartyByWeddingPartyId($this->getPDO(), $weddingParty->getWeddingPartyWeddingId());
		$this->assertNull($pdoWeddingParty);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("weddingParty"));
	}

	/**
	 * test grabbing a Wedding Party that does not exist
	 **/
	public function testGetInvalidWeddingPartyByWeddingPartyId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeWeddingPartyId = generateUuidV4();
		$weddingParty = WeddingParty::getWeddingPartyByWeddingPartyId($this->getPDO(), $fakeWeddingPartyId);
		$this->assertNull($weddingParty);
	}

	/**
	 * test grabbing a Card by the Profile Id
	 **/
	public function testGetValidWeddingPartyByProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("weddingParty");
		$weddingPartyId = generateUuidV4();

		//create new wedding party
		$weddingParty = new WeddingParty(generateUuidV4(), $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_WEDDING_PARTY_ADMIN);
		$weddingParty->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = WeddingParty::getWeddingPartyByWeddingPartyProfileId($this->getPDO(), $weddingParty->getWeddingPartyProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("weddingParty"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\WeddingParty", $results);

		// grab the result from the array and validate it
		$pdoWeddingParty = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("weddingParty"));
		$this->assertEquals($pdoWeddingParty->getWeddingPartyId(), $weddingPartyId);
		$this->assertEquals($pdoWeddingParty->getWeddingPartyProfileId(),$this->profile->getProfileId());
		$this->assertEquals($pdoWeddingParty->getWeddingPartyWeddingId(),$this->wedding->getWeddingId());
		$this->assertEquals($pdoWeddingParty->getWeddingPartyAdmin(), $this->VALID_WEDDING_PARTY_ADMIN1);
	}

	/**
	 * test grabbing a Wedding Party by profile id that does not exist
	 **/
	public function testGetInvalidWeddingPartyByProfileId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeWeddingPartyProfileId = generateUuidV4();
		$weddingParty = WeddingParty::getWeddingPartyByWeddingPartyId($this->getPDO(), $fakeWeddingPartyProfileId);
		$this->assertNull($weddingParty);
	}

	/**
	 * test grabbing a Card by the Wedding Id
	 **/
	public function testGetValidWeddingPartyByWeddingId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("weddingParty");
		$weddingPartyId = generateUuidV4();

		//create new wedding party
		$weddingParty = new WeddingParty(generateUuidV4(), $this->profile->getProfileId(), $this->wedding->getWeddingId(), $this->VALID_WEDDING_PARTY_ADMIN);
		$weddingParty->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = WeddingParty::getWeddingPartyByWeddingPartyWeddingId($this->getPDO(), $weddingParty->getWeddingPartyWeddingId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("weddingParty"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\WeddingParty", $results);

		// grab the result from the array and validate it
		$pdoWeddingParty = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("weddingParty"));
		$this->assertEquals($pdoWeddingParty->getWeddingPartyId(), $weddingPartyId);
		$this->assertEquals($pdoWeddingParty->getWeddingPartyProfileId(),$this->profile->getProfileId());
		$this->assertEquals($pdoWeddingParty->getWeddingPartyWeddingId(),$this->wedding->getWeddingId());
		$this->assertEquals($pdoWeddingParty->getWeddingPartyAdmin(), $this->VALID_WEDDING_PARTY_ADMIN1);
	}

	/**
	 * test grabbing a Wedding Party by wedding id that does not exist
	 **/
	public function testGetInvalidWeddingPartyByWeddingId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeWeddingPartyWeddingId = generateUuidV4();
		$weddingParty = WeddingParty::getWeddingPartyByWeddingPartyId($this->getPDO(), $fakeWeddingPartyWeddingId);
		$this->assertNull($weddingParty);
	}
}
