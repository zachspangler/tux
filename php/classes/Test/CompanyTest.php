<?php
namespace Zachspangler\Tux\Test;
use Zachspangler\Tux\Company;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
/**
 * Full PHPUnit test for the Company class
 *
 * This is a complete PHPUnit test of the Company class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Company
 * @author Zach Spangler<zspangler@gmail.com> and Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class CompanyTest extends TuxTest {
	/**
	 * Company address
	 * @var $VALID_COMPANY_ADDRESS
	 **/
	protected $VALID_COMPANY_ADDRESS = "123 Test Drive";
	/**
	 * Company city
	 * @var string $VALID_COMPANY_CITY
	 **/
	protected $VALID_COMPANY_CITY = "test1@phpunit.de";
	/**
	 * Company Email
	 * @var string $VALID_COMPANY_EMAIL
	 **/
	protected $VALID_COMPANY_EMAIL = "test1@phpunit.de";
	/**
	 * Company Email
	 * @var string $VALID_COMPANY_EMAIL
	 **/
	protected $VALID_COMPANY_EMAIL2 = "test2@phpunit.de";
	/**
	 * Company Hash
	 * @var string $VALID_COMPANY_HASH
	 **/
	protected $VALID_COMPANY_HASH = "Ada";
	/**
	 * Company Name
	 * @var $VALID_COMPANY_NAME
	 **/
	protected $VALID_COMPANY_NAME;
	/**
	 * Company Phone
	 * @var $VALID_COMPANY_PHONE
	 **/
	protected $VALID_COMPANY_PHONE = 5055555555;
	/**
	 * Company Postal Code
	 * @var $VALID_COMPANY_POSTAL_CODE
	 **/
	protected $VALID_COMPANY_POSTAL_CODE = 87111;
	/**
	 * Company Salt is used for the Company password
	 * @var $VALID_COMPANY_SALT
	 **/
	protected $VALID_COMPANY_SALT;
	/**
	 * Company State
	 * @var $VALID_COMPANY_STATE
	 **/
	protected $VALID_COMPANY_STATE = 87111;
	/**
	 * Company Notifications
	 * @var $VALID_COMPANY_NOTIFICATIONS
	 **/
	protected $VALID_COMPANY_NOTIFICATIONS = "Y";

	/**
	 * run the default setup operation to create salt and hash.
	 */
	public final function setUp(): void {
		parent::setUp();
		//
		$password = "abc123";
		$this->VALID_COMPANY_SALT = bin2hex(random_bytes(32));
		$this->VALID_COMPANY_HASH = hash_pbkdf2("sha512", $password, $this->VALID_COMPANY_SALT, 262144);
		$this->VALID_COMPANY_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid Company and verify that the actual mySQL data matches
	 **/
	public function testInsertValidCompany(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("company");
		$companyId = generateUuidV4();
		$company = new Company($companyId, $this->VALID_COMPANY_ADDRESS, $this->VALID_COMPANY_CITY, $this->VALID_COMPANY_EMAIL, $this->VALID_COMPANY_HASH, $this->VALID_COMPANY_NAME, $this->VALID_COMPANY_PHONE, $this->VALID_COMPANY_POSTAL_CODE, $this->VALID_COMPANY_SALT, $this->VALID_COMPANY_STATE, $this->VALID_COMPANY_NOTIFICATIONS);
		$company->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCompany = Company::getCompanyByCompanyId($this->getPDO(), $company->getCompanyId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertEquals($pdoCompany->getCompanyId(), $companyId);
		$this->assertEquals($pdoCompany->getCompanyAddress(), $this->VALID_COMPANY_ADDRESS);
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANY_CITY);
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANY_EMAIL);
		$this->assertEquals($pdoCompany->getCompanyHash(), $this->VALID_COMPANY_HASH);
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANY_NAME);
		$this->assertEquals($pdoCompany->getCompanyPhone(), $this->VALID_COMPANY_PHONE);
		$this->assertEquals($pdoCompany->getCompanyPostalCode(), $this->VALID_COMPANY_POSTAL_CODE);
		$this->assertEquals($pdoCompany->getCompanySalt(), $this->VALID_COMPANY_SALT);
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANY_STATE);
		$this->assertEquals($pdoCompany->getCompanyNotifications(), $this->VALID_COMPANY_NOTIFICATIONS);
	}


	/**
	 * test inserting a Company, editing it, and then updating it
	 **/
	public function testUpdateValidCompany() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("company");
		// create a new Company and insert to into mySQL
		$companyId = generateUuidV4();
		$company = new Company($companyId, $this->VALID_COMPANY_ADDRESS, $this->VALID_COMPANY_CITY, $this->VALID_COMPANY_EMAIL, $this->VALID_COMPANY_HASH, $this->VALID_COMPANY_NAME, $this->VALID_COMPANY_PHONE, $this->VALID_COMPANY_POSTAL_CODE, $this->VALID_COMPANY_SALT, $this->VALID_COMPANY_STATE, $this->VALID_COMPANY_NOTIFICATIONS);
		$company->insert($this->getPDO());

		// edit the Company and update it in mySQL
		$company->setCompanyEmail($this->VALID_COMPANY_EMAIL2);
		$company->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCompany = Company::getCompanyByCompanyId($this->getPDO(), $company->getCompanyId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertEquals($pdoCompany->getCompanyId(), $companyId);
		$this->assertEquals($pdoCompany->getCompanyAddress(), $this->VALID_COMPANY_ADDRESS);
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANY_CITY);
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANY_EMAIL2);
		$this->assertEquals($pdoCompany->getCompanyHash(), $this->VALID_COMPANY_HASH);
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANY_NAME);
		$this->assertEquals($pdoCompany->getCompanyPhone(), $this->VALID_COMPANY_PHONE);
		$this->assertEquals($pdoCompany->getCompanyPostalCode(), $this->VALID_COMPANY_POSTAL_CODE);
		$this->assertEquals($pdoCompany->getCompanySalt(), $this->VALID_COMPANY_SALT);
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANY_STATE);
		$this->assertEquals($pdoCompany->getCompanyNotifications(), $this->VALID_COMPANY_NOTIFICATIONS);
	}

	/**
	 * test creating a Company and then deleting it
	 **/

	public function testDeleteValidCompany(): void {
		$numRows = $this->getConnection()->getRowCount("company");
		$companyId = generateUuidV4();
		$company = new Company($companyId, $this->VALID_COMPANY_ADDRESS, $this->VALID_COMPANY_CITY, $this->VALID_COMPANY_EMAIL, $this->VALID_COMPANY_HASH, $this->VALID_COMPANY_NAME, $this->VALID_COMPANY_PHONE, $this->VALID_COMPANY_POSTAL_CODE, $this->VALID_COMPANY_SALT, $this->VALID_COMPANY_STATE, $this->VALID_COMPANY_NOTIFICATIONS);
		$company->insert($this->getPDO());

		// delete the Company from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$company->delete($this->getPDO());

		// grab the data from mySQL and enforce the Tweet does not exist
		$pdoCompany = Company::getCompanyByCompanyId($this->getPDO(), $company->getCompanyId());
		$this->assertNull($pdoCompany);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("company"));
	}

	/**
	 * test grabbing a Company that does not exist
	 **/
	public function testGetInvalidCompany() {
		// grab a company id that d
		$company = Company::getCompanyByCompanyId($this->getPDO(), generateUuidV4());
		$this->assertNull($company);
	}

	/**
	 * test grabbing a Company by city
	 **/
	public function testGetValidCompanyByCompanyCity(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("company");

		// create a new Company and insert to into mySQL
		$companyId = generateUuidV4();
		$company = new Company($companyId, $this->VALID_COMPANY_ADDRESS, $this->VALID_COMPANY_CITY, $this->VALID_COMPANY_EMAIL, $this->VALID_COMPANY_HASH, $this->VALID_COMPANY_NAME, $this->VALID_COMPANY_PHONE, $this->VALID_COMPANY_POSTAL_CODE, $this->VALID_COMPANY_SALT, $this->VALID_COMPANY_STATE, $this->VALID_COMPANY_NOTIFICATIONS);
		$company->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Company::getCompanyByCompanyCity($this->getPDO(), $company->getCompanyCity());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Company", $results);

		// grab the result from the array and validate it
		$pdoCompany = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertEquals($pdoCompany->getCompanyId(), $companyId);
		$this->assertEquals($pdoCompany->getCompanyAddress(), $this->VALID_COMPANY_ADDRESS);
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANY_CITY);
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANY_EMAIL2);
		$this->assertEquals($pdoCompany->getCompanyHash(), $this->VALID_COMPANY_HASH);
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANY_NAME);
		$this->assertEquals($pdoCompany->getCompanyPhone(), $this->VALID_COMPANY_PHONE);
		$this->assertEquals($pdoCompany->getCompanyPostalCode(), $this->VALID_COMPANY_POSTAL_CODE);
		$this->assertEquals($pdoCompany->getCompanySalt(), $this->VALID_COMPANY_SALT);
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANY_STATE);
		$this->assertEquals($pdoCompany->getCompanyNotifications(), $this->VALID_COMPANY_NOTIFICATIONS);
	}

	/**
	 * test grabbing a company by a city that does not exist
	 **/
	public function testGetInvalidCompanyByCompanyCity() : void {
		// grab a company by a city that does not exist
		$company = Company::getCompanyByCompanyCity($this->getPDO(), "Dallas");
		$this->assertCount(0, $company);
	}

	/**
	 * test grabbing a Company by email
	 **/

	public function testGetValidCompanyByCompanyEmail(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("company");

		// create a new Company and insert to into mySQL
		$companyId = generateUuidV4();
		$company = new Company($companyId, $this->VALID_COMPANY_ADDRESS, $this->VALID_COMPANY_CITY, $this->VALID_COMPANY_EMAIL, $this->VALID_COMPANY_HASH, $this->VALID_COMPANY_NAME, $this->VALID_COMPANY_PHONE, $this->VALID_COMPANY_POSTAL_CODE, $this->VALID_COMPANY_SALT, $this->VALID_COMPANY_STATE, $this->VALID_COMPANY_NOTIFICATIONS);
		$company->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
		$pdoCompany = Company::getCompanyByCompanyEmail($this->getPDO(), $company->getCompanyEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertEquals($pdoCompany->getCompanyId(), $companyId);
		$this->assertEquals($pdoCompany->getCompanyAddress(), $this->VALID_COMPANY_ADDRESS);
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANY_CITY);
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANY_EMAIL2);
		$this->assertEquals($pdoCompany->getCompanyHash(), $this->VALID_COMPANY_HASH);
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANY_NAME);
		$this->assertEquals($pdoCompany->getCompanyPhone(), $this->VALID_COMPANY_PHONE);
		$this->assertEquals($pdoCompany->getCompanyPostalCode(), $this->VALID_COMPANY_POSTAL_CODE);
		$this->assertEquals($pdoCompany->getCompanySalt(), $this->VALID_COMPANY_SALT);
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANY_STATE);
		$this->assertEquals($pdoCompany->getCompanyNotifications(), $this->VALID_COMPANY_NOTIFICATIONS);
	}

	/**
	 * test grabbing a company by an email that does not exist
	 **/
	public function testGetInvalidCompanyByCompanyEmail() : void {
		// grab a company by a city that does not exist
		$company = Company::getCompanyByCompanyEmail($this->getPDO(), "hi@me.com");
		$this->assertCount(0, $company);
	}

	/**
	 * test grabbing a company a company name
	 **/
	public function testGetValidCompanyByCompanyName(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("company");

		// create a new Company and insert to into mySQL
		$companyId = generateUuidV4();
		$company = new Company($companyId, $this->VALID_COMPANY_ADDRESS, $this->VALID_COMPANY_CITY, $this->VALID_COMPANY_EMAIL, $this->VALID_COMPANY_HASH, $this->VALID_COMPANY_NAME, $this->VALID_COMPANY_PHONE, $this->VALID_COMPANY_POSTAL_CODE, $this->VALID_COMPANY_SALT, $this->VALID_COMPANY_STATE, $this->VALID_COMPANY_NOTIFICATIONS);
		$company->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Company::getCompanyByCompanyName($this->getPDO(), $company->getCompanyName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Company", $results);

		// grab the result from the array and validate it
		$pdoCompany = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertEquals($pdoCompany->getCompanyId(), $companyId);
		$this->assertEquals($pdoCompany->getCompanyAddress(), $this->VALID_COMPANY_ADDRESS);
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANY_CITY);
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANY_EMAIL2);
		$this->assertEquals($pdoCompany->getCompanyHash(), $this->VALID_COMPANY_HASH);
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANY_NAME);
		$this->assertEquals($pdoCompany->getCompanyPhone(), $this->VALID_COMPANY_PHONE);
		$this->assertEquals($pdoCompany->getCompanyPostalCode(), $this->VALID_COMPANY_POSTAL_CODE);
		$this->assertEquals($pdoCompany->getCompanySalt(), $this->VALID_COMPANY_SALT);
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANY_STATE);
		$this->assertEquals($pdoCompany->getCompanyNotifications(), $this->VALID_COMPANY_NOTIFICATIONS);
	}

	/**
	 * test grabbing a company by a name that does not exist
	 **/
	public function testGetInvalidCompanyByCompanyName() : void {
		// grab a company by a city that does not exist
		$company = Company::getCompanyByCompanyPostalCode($this->getPDO(), "Farm");
		$this->assertCount(0, $company);
	}

	/**
	 * test grabbing a Company by phone
	 **/
	public function testGetValidCompanyByCompanyPhone(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("company");

		// create a new Company and insert to into mySQL
		$companyId = generateUuidV4();
		$company = new Company($companyId, $this->VALID_COMPANY_ADDRESS, $this->VALID_COMPANY_CITY, $this->VALID_COMPANY_EMAIL, $this->VALID_COMPANY_HASH, $this->VALID_COMPANY_NAME, $this->VALID_COMPANY_PHONE, $this->VALID_COMPANY_POSTAL_CODE, $this->VALID_COMPANY_SALT, $this->VALID_COMPANY_STATE, $this->VALID_COMPANY_NOTIFICATIONS);
		$company->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCompany = Company::getCompanyByCompanyPhone($this->getPDO(), $company->getCompanyPhone());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertEquals($pdoCompany->getCompanyId(), $companyId);
		$this->assertEquals($pdoCompany->getCompanyAddress(), $this->VALID_COMPANY_ADDRESS);
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANY_CITY);
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANY_EMAIL2);
		$this->assertEquals($pdoCompany->getCompanyHash(), $this->VALID_COMPANY_HASH);
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANY_NAME);
		$this->assertEquals($pdoCompany->getCompanyPhone(), $this->VALID_COMPANY_PHONE);
		$this->assertEquals($pdoCompany->getCompanyPostalCode(), $this->VALID_COMPANY_POSTAL_CODE);
		$this->assertEquals($pdoCompany->getCompanySalt(), $this->VALID_COMPANY_SALT);
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANY_STATE);
		$this->assertEquals($pdoCompany->getCompanyNotifications(), $this->VALID_COMPANY_NOTIFICATIONS);
	}

	/**
	 * test grabbing a company by an phone that does not exist
	 **/
	public function testGetInvalidCompanyByCompanyPhone() : void {
		// grab a company by a city that does not exist
		$company = Company::getCompanyByCompanyPhone($this->getPDO(), "1231231231");
		$this->assertCount(0, $company);
	}

	/**
	 * test grabbing a Company by postal code
	 **/
	public function testGetValidCompanyByCompanyPostalCode(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("company");

		// create a new Company and insert to into mySQL
		$companyId = generateUuidV4();
		$company = new Company($companyId, $this->VALID_COMPANY_ADDRESS, $this->VALID_COMPANY_CITY, $this->VALID_COMPANY_EMAIL, $this->VALID_COMPANY_HASH, $this->VALID_COMPANY_NAME, $this->VALID_COMPANY_PHONE, $this->VALID_COMPANY_POSTAL_CODE, $this->VALID_COMPANY_SALT, $this->VALID_COMPANY_STATE, $this->VALID_COMPANY_NOTIFICATIONS);
		$company->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Company::getCompanyByCompanyPostalCode($this->getPDO(), $company->getCompanyPostalCode());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Company", $results);

		// grab the result from the array and validate it
		$pdoCompany = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertEquals($pdoCompany->getCompanyId(), $companyId);
		$this->assertEquals($pdoCompany->getCompanyAddress(), $this->VALID_COMPANY_ADDRESS);
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANY_CITY);
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANY_EMAIL2);
		$this->assertEquals($pdoCompany->getCompanyHash(), $this->VALID_COMPANY_HASH);
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANY_NAME);
		$this->assertEquals($pdoCompany->getCompanyPhone(), $this->VALID_COMPANY_PHONE);
		$this->assertEquals($pdoCompany->getCompanyPostalCode(), $this->VALID_COMPANY_POSTAL_CODE);
		$this->assertEquals($pdoCompany->getCompanySalt(), $this->VALID_COMPANY_SALT);
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANY_STATE);
		$this->assertEquals($pdoCompany->getCompanyNotifications(), $this->VALID_COMPANY_NOTIFICATIONS);
	}

	/**
	 * test grabbing a company by a postal code that does not exist
	 **/
	public function testGetInvalidCompanyByCompanyPostalCode() : void {
		// grab a company by a city that does not exist
		$company = Company::getCompanyByCompanyPostalCode($this->getPDO(), "87124");
		$this->assertCount(0, $company);
	}

	/**
	 * test grabbing a Company by state
	 **/
	public function testGetValidCompanyByCompanyState(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("company");

		// create a new Company and insert to into mySQL
		$companyId = generateUuidV4();
		$company = new Company($companyId, $this->VALID_COMPANY_ADDRESS, $this->VALID_COMPANY_CITY, $this->VALID_COMPANY_EMAIL, $this->VALID_COMPANY_HASH, $this->VALID_COMPANY_NAME, $this->VALID_COMPANY_PHONE, $this->VALID_COMPANY_POSTAL_CODE, $this->VALID_COMPANY_SALT, $this->VALID_COMPANY_STATE, $this->VALID_COMPANY_NOTIFICATIONS);
		$company->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Company::getCompanyByCompanyState($this->getPDO(), $company->getCompanyState());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Company", $results);

		// grab the result from the array and validate it
		$pdoCompany = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertEquals($pdoCompany->getCompanyId(), $companyId);
		$this->assertEquals($pdoCompany->getCompanyAddress(), $this->VALID_COMPANY_ADDRESS);
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANY_CITY);
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANY_EMAIL2);
		$this->assertEquals($pdoCompany->getCompanyHash(), $this->VALID_COMPANY_HASH);
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANY_NAME);
		$this->assertEquals($pdoCompany->getCompanyPhone(), $this->VALID_COMPANY_PHONE);
		$this->assertEquals($pdoCompany->getCompanyPostalCode(), $this->VALID_COMPANY_POSTAL_CODE);
		$this->assertEquals($pdoCompany->getCompanySalt(), $this->VALID_COMPANY_SALT);
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANY_STATE);
		$this->assertEquals($pdoCompany->getCompanyNotifications(), $this->VALID_COMPANY_NOTIFICATIONS);
	}

	/**
	 * test grabbing a company by a state that does not exist
	 **/
	public function testGetInvalidCompanyByCompanyState() : void {
		// grab a company by a city that does not exist
		$company = Company::getCompanyByCompanyState($this->getPDO(), "Texas");
		$this->assertCount(0, $company);
	}

	/**
	 * test grabbing all companies
	 **/
	public function testGetAllValidCompanies(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("company");

		// create a new Company and insert to into mySQL
		$companyId = generateUuidV4();
		$company = new Company($companyId, $this->VALID_COMPANY_ADDRESS, $this->VALID_COMPANY_CITY, $this->VALID_COMPANY_EMAIL, $this->VALID_COMPANY_HASH, $this->VALID_COMPANY_NAME, $this->VALID_COMPANY_PHONE, $this->VALID_COMPANY_POSTAL_CODE, $this->VALID_COMPANY_SALT, $this->VALID_COMPANY_STATE, $this->VALID_COMPANY_NOTIFICATIONS);
		$company->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Company::getAllCompanies($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Company", $results);

		// grab the result from the array and validate it
		$pdoCompany = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("company"));
		$this->assertEquals($pdoCompany->getCompanyId(), $companyId);
		$this->assertEquals($pdoCompany->getCompanyAddress(), $this->VALID_COMPANY_ADDRESS);
		$this->assertEquals($pdoCompany->getCompanyCity(), $this->VALID_COMPANY_CITY);
		$this->assertEquals($pdoCompany->getCompanyEmail(), $this->VALID_COMPANY_EMAIL2);
		$this->assertEquals($pdoCompany->getCompanyHash(), $this->VALID_COMPANY_HASH);
		$this->assertEquals($pdoCompany->getCompanyName(), $this->VALID_COMPANY_NAME);
		$this->assertEquals($pdoCompany->getCompanyPhone(), $this->VALID_COMPANY_PHONE);
		$this->assertEquals($pdoCompany->getCompanyPostalCode(), $this->VALID_COMPANY_POSTAL_CODE);
		$this->assertEquals($pdoCompany->getCompanySalt(), $this->VALID_COMPANY_SALT);
		$this->assertEquals($pdoCompany->getCompanyState(), $this->VALID_COMPANY_STATE);
		$this->assertEquals($pdoCompany->getCompanyNotifications(), $this->VALID_COMPANY_NOTIFICATIONS);
	}
}
