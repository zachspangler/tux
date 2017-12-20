<?php
namespace Zachspangler\Tux\Test;

use Zachspangler\Tux\{
	Company,
	Wedding
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
class WeddingTest extends TuxTest {
	/**
	 * Profile that created the liked the Tweet; this is for foreign key relations
	 * @var  Company $company
	 **/
	protected $company;
	/**
	 * Date of the Wedding
	 * @var int $VALID_WEDDING_DATE
	 **/
	protected $VALID_WEDDING_DATE;
	/**
	 * Wedding Name
	 * @var int $VALID_WEDDING_NAME
	 **/
	protected $VALID_WEDDING_NAME = "Smith";
	/**
	 * Wedding Name 2
	 * @var int $VALID_WEDDING_NAME1
	 **/
	protected $VALID_WEDDING_NAME1 = "Luck";
	/**
	 * Date the card information needs to be returned
	 * @var int $VALID_WEDDING_RETURN_BY_DATE
	 **/
	protected $VALID_WEDDING_RETURN_BY_DATE;
	/**
	 * valid hash to use
	 * @var $VALID_COMPANY_HASH
	 */
	protected $VALID_COMPANY_HASH;
	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_COMPANY_SALT
	 */
	protected $VALID_COMPANY_SALT;
	/**
	 * Date the card information needs to be $VALID_WEDDING_SUNRISE_DATE
	 * @var $VALID_WEDDING_RETURN_BY_DATE
	 **/
	protected $VALID_WEDDING_SUNRISE_DATE;
	/**
	 * Date the card information needs to be $VALID_WEDDING_SUNRISE_DATE
	 * @var $VALID_WEDDING_SUNSET_DATE
	 **/
	protected $VALID_WEDDING_SUNSET_DATE;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();

		// create a salt and hash for the mocked company
		$password = "abc123";
		$this->VALID_COMPANY_SALT = bin2hex(random_bytes(32));
		$this->VALID_COMPANY_HASH = hash_pbkdf2("sha512", $password, $this->VALID_COMPANY_SALT, 262144);

		// create and insert the mocked company
		$this->company = new Company(generateUuidV4(), "123 First Street", "Albuquerque", "company@test.com", $this->VALID_COMPANY_HASH, "Mr. Tux", "5555555555", "87111", $this->VALID_COMPANY_SALT, "NM", "T");
		$this->company->insert($this->getPDO());

		// create the dates for the wedding date
		$this->VALID_WEDDING_DATE = new \DateTime();
		$this->VALID_WEDDING_RETURN_BY_DATE = new \DateTime();
	}

	/**
	 * test inserting a valid Card and verify that the actual mySQL data matches
	 **/
	public function testInsertValidWedding(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("wedding");
		$weddingId = generateUuidV4();

		//create new wedding
		$wedding = new Wedding($weddingId, $this->company->getCompanyId(), $this->VALID_WEDDING_DATE, $this->VALID_WEDDING_NAME, $this->VALID_WEDDING_RETURN_BY_DATE);
		$wedding->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoWedding = Wedding::getWeddingByWeddingId($this->getPDO(), $wedding->getWeddingId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$this->assertEquals($pdoWedding->getWeddingId(), $weddingId);
		$this->assertEquals($pdoWedding->getWeddingCompanyId(), $this->company->getCompanyId());
		$this->assertEquals($pdoWedding->getWeddingDate(), $this->VALID_WEDDING_DATE->getTimestamp());
		$this->assertEquals($pdoWedding->getWeddingName(), $this->VALID_WEDDING_NAME);
		$this->assertEquals($pdoWedding->getWeddingReturnByDate(), $this->VALID_WEDDING_RETURN_BY_DATE->getTimestamp());
	}

	/**
	 * test inserting a Card, editing it, and then updating it
	 **/
	public function testUpdateValidWedding() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("wedding");
		$weddingId = generateUuidV4();

		//create new wedding
		$wedding = new Wedding($weddingId, $this->company->getCompanyId(), $this->VALID_WEDDING_DATE, $this->VALID_WEDDING_NAME, $this->VALID_WEDDING_RETURN_BY_DATE);
		$wedding->insert($this->getPDO());

		//update the wedding
		$wedding->setWeddingName($this->VALID_WEDDING_NAME1);
		$wedding->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoWedding = Wedding::getWeddingByWeddingId($this->getPDO(), $wedding->getWeddingId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$this->assertEquals($pdoWedding->getWeddingId(), $weddingId);
		$this->assertEquals($pdoWedding->getWeddingCompanyId(), $this->company->getCompanyId());
		$this->assertEquals($pdoWedding->getWeddingDate(), $this->VALID_WEDDING_DATE->getTimestamp());
		$this->assertEquals($pdoWedding->getWeddingName(), $this->VALID_WEDDING_NAME);
		$this->assertEquals($pdoWedding->getWeddingReturnByDate(), $this->VALID_WEDDING_RETURN_BY_DATE->getTimestamp());
	}

	/**
	 * test creating a Wedding and then deleting it
	 **/
	public function testDeleteValidProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("wedding");
		$weddingId = generateUuidV4();

		//create new wedding
		$wedding = new Wedding($weddingId, $this->company->getCompanyId(), $this->VALID_WEDDING_DATE, $this->VALID_WEDDING_NAME, $this->VALID_WEDDING_RETURN_BY_DATE);
		$wedding->insert($this->getPDO());

		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$wedding->delete($this->getPDO());

		// grab the data from mySQL and enforce the Profile does not exist
		$pdoWedding = Wedding::getWeddingByWeddingId($this->getPDO(), $wedding->getWeddingId());
		$this->assertNull($pdoWedding);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("wedding"));
	}

	/**
	 * test grabbing a Wedding that does not exist
	 **/
	public function testGetInvalidWeddingByWeddingId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeWeddingId = generateUuidV4();
		$wedding = Wedding::getWeddingByWeddingId($this->getPDO(), $fakeWeddingId);
		$this->assertNull($wedding);
	}

	/**
	 * test grabbing a Card by the Company Id
	 **/
	public function testGetValidWeddingByCompanyId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("wedding");
		$weddingId = generateUuidV4();

		//create new wedding
		$wedding = new Wedding($weddingId, $this->company->getCompanyId(), $this->VALID_WEDDING_DATE, $this->VALID_WEDDING_NAME, $this->VALID_WEDDING_RETURN_BY_DATE);
		$wedding->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Wedding::getWeddingByCompanyId($this->getPDO(), $wedding->getWeddingCompanyId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Wedding", $results);

		// grab the result from the array and validate it
		$pdoWedding = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$this->assertEquals($pdoWedding->getWeddingId(), $weddingId);
		$this->assertEquals($pdoWedding->getWeddingCompanyId(), $this->company->getCompanyId());
		$this->assertEquals($pdoWedding->getWeddingDate(), $this->VALID_WEDDING_DATE->getTimestamp());
		$this->assertEquals($pdoWedding->getWeddingName(), $this->VALID_WEDDING_NAME);
		$this->assertEquals($pdoWedding->getWeddingReturnByDate(), $this->VALID_WEDDING_RETURN_BY_DATE->getTimestamp());
	}

	/**
	 * test grabbing a card by a company that does not exist
	 **/
	public function testGetInvalidWeddingByCompanyId() : void {
		// grab a company by a city that does not exist
		$wedding = Wedding::getWeddingByCompanyId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $wedding);
	}

	/**
	 * test grabbing a Wedding by the Wedding Date
	 **/
	public function testGetValidWeddingByWeddingDate() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("wedding");
		$weddingId = generateUuidV4();

		//create new wedding
		$wedding = new Wedding($weddingId, $this->company->getCompanyId(), $this->VALID_WEDDING_DATE, $this->VALID_WEDDING_NAME, $this->VALID_WEDDING_RETURN_BY_DATE);
		$wedding->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Wedding::getWeddingByWeddingDate($this->getPDO(), $wedding->getWeddingReturnByDate());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Wedding", $results);

		// grab the result from the array and validate it
		$pdoWedding = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$this->assertEquals($pdoWedding->getWeddingId(), $weddingId);
		$this->assertEquals($pdoWedding->getWeddingCompanyId(), $this->company->getCompanyId());
		$this->assertEquals($pdoWedding->getWeddingDate(), $this->VALID_WEDDING_DATE->getTimestamp());
		$this->assertEquals($pdoWedding->getWeddingName(), $this->VALID_WEDDING_NAME);
		$this->assertEquals($pdoWedding->getWeddingReturnByDate(), $this->VALID_WEDDING_RETURN_BY_DATE->getTimestamp());
	}

	/**
	 * test grabbing a card by a date that does not exist
	 **/
	public function testGetInvalidWeddingByWeddingDate() : void {
		// grab a company by a city that does not exist
		$wedding = Wedding::getWeddingByWeddingDate($this->getPDO(),"12/15/17", "12/16/17" );
		$this->assertCount(0, $wedding);
	}

	/**
	 * test grabbing a Wedding by the Wedding Name
	 **/
	public function testGetValidWeddingByName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("wedding");
		$weddingId = generateUuidV4();

		//create new wedding
		$wedding = new Wedding($weddingId, $this->company->getCompanyId(), $this->VALID_WEDDING_DATE, $this->VALID_WEDDING_NAME, $this->VALID_WEDDING_RETURN_BY_DATE);
		$wedding->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Wedding::getWeddingByWeddingName($this->getPDO(), $wedding->getWeddingName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Wedding", $results);

		// grab the result from the array and validate it
		$pdoWedding = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$this->assertEquals($pdoWedding->getWeddingId(), $weddingId);
		$this->assertEquals($pdoWedding->getWeddingCompanyId(), $this->company->getCompanyId());
		$this->assertEquals($pdoWedding->getWeddingDate(), $this->VALID_WEDDING_DATE->getTimestamp());
		$this->assertEquals($pdoWedding->getWeddingName(), $this->VALID_WEDDING_NAME);
		$this->assertEquals($pdoWedding->getWeddingReturnByDate(), $this->VALID_WEDDING_RETURN_BY_DATE->getTimestamp());
	}

	/**
	 * test grabbing a card by a name that does not exist
	 **/
	public function testGetInvalidWeddingByName() : void {
		// grab a company by a city that does not exist
		$wedding = Wedding::getWeddingByWeddingName($this->getPDO(), "Troy");
		$this->assertCount(0, $wedding);
	}

	/**
	 * test grabbing a Wedding by the Wedding Return By Date
	 **/
	public function testGetValidWeddingByReturnDate() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("wedding");
		$weddingId = generateUuidV4();

		//create new wedding
		$wedding = new Wedding($weddingId, $this->company->getCompanyId(), $this->VALID_WEDDING_DATE, $this->VALID_WEDDING_NAME, $this->VALID_WEDDING_RETURN_BY_DATE);
		$wedding->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Wedding::getWeddingByWeddingReturnByDate($this->getPDO(), $wedding->getWeddingReturnByDate());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Wedding", $results);

		// grab the result from the array and validate it
		$pdoWedding = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("wedding"));
		$this->assertEquals($pdoWedding->getWeddingId(), $weddingId);
		$this->assertEquals($pdoWedding->getWeddingCompanyId(), $this->company->getCompanyId());
		$this->assertEquals($pdoWedding->getWeddingDate(), $this->VALID_WEDDING_DATE->getTimestamp());
		$this->assertEquals($pdoWedding->getWeddingName(), $this->VALID_WEDDING_NAME);
		$this->assertEquals($pdoWedding->getWeddingReturnByDate(), $this->VALID_WEDDING_RETURN_BY_DATE->getTimestamp());
	}

	/**
	 * test grabbing a card by a date that does not exist
	 **/
	public function testGetInvalidWeddingByReturnDate() : void {
		// grab a company by a city that does not exist
		$wedding = Wedding::getWeddingByWeddingReturnByDate($this->getPDO(),"12/15/17", "12/16/17");
		$this->assertCount(0, $wedding);
	}
}
