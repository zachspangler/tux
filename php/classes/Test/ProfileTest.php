<?php
namespace Zachspangler\Tux\Test;
use Zachspangler\Tux\Profile;

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
 * @see Profile
 * @author Zach Spangler<zspangler@gmail.com> and Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class ProfileTest extends TuxTest {
	/**
	 * Profile Activation Token is a the way an account is confirmed, placeholder until account activation is created
	 * @var $VALID_PROFILE_ACTIVATION_TOKEN
	 **/
	protected $VALID_PROFILE_ACTIVATION_TOKEN;
	/**
	 * Profile Email is the email associated with the profile
	 * @var string $VALID_PROFILE_EMAIL
	 **/
	protected $VALID_PROFILE_EMAIL1 = "test1@phpunit.de";
	/**
	 * Profile Email is the email associated with the profile
	 * @var string $VALID_PROFILE_EMAIL
	 **/
	protected $VALID_PROFILE_EMAIL2 = "test2@phpunit.de";
	/**
	 * Profile Fist Name is the first name of the user
	 * @var string $VALID_PROFILE_FIRST_NAME
	 **/
	protected $VALID_PROFILE_NAME = "Ada";
	/**
	 * Profile Hash is used for the profile password
	 * @var $VALID_PROFILE_HASH
	 **/
	protected $VALID_PROFILE_HASH;
	/**
	 * Profile Phone
	 * @var $VALID_PROFILE_PHONE
	 **/
	protected $VALID_PROFILE_PHONE = 5055555555;
	/**
	 * Profile Salt is used for the profile password
	 * @var $VALID_PROFILE_SALT
	 **/
	protected $VALID_PROFILE_SALT;
	/**
	 * run the default setup operation to create salt and hash.
	 */
	public final function setUp(): void {
		parent::setUp();
		//
		$password = "abc123";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);
		$this->VALID_PROFILE_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}
	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_SALT);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail());
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILE_PHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 **/

	public function testUpdateValidProfile() {
	// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_SALT);
		$profile->insert($this->getPDO());

		//edit the profile
		$profile->setProfileEmail($this->VALID_PROFILE_EMAIL2);
		$profile->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail());
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILE_PHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
	}

	/**
	 * test creating a Profile and then deleting it
	 **/

	public function testDeleteValidProfile(): void {
	// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_SALT);
		$profile->insert($this->getPDO());


		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());
		// grab the data from mySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail());
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILE_PHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);

	}

	/**
	 * test inserting a Profile and regrabbing it from mySQL
	 **/
	public function testGetValidProfileByProfileId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_SALT);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail());
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILE_PHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
	}

	/**
	 * test grabbing a Profile that does not exist
	 **/
	public function testGetInvalidProfileByProfileId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeProfileId = generateUuidV4();
		$profile = Profile::getProfileByProfileId($this->getPDO(), $fakeProfileId);
		$this->assertNull($profile);
	}


	/**
	 * test grabbing a profile by its activation token
	 */
	public function testGetValidProfileByProfileActivationToken(): void {
// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_SALT);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail());
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILE_PHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
	}

	/**
	 * test grabbing a Profile by an activation token that does not exists
	 **/
	public function testGetInvalidProfileActivationToken(): void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "5ebc7867885cb8dd25af05b991dd5609");
		$this->assertNull($profile);
	}


	/**
	 * test grabbing a profile by its email
	 */
	public function testGetValidProfileByProfileEmail(): void {
// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_SALT);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail());
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILE_PHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
	}

	/**
	 * test grabbing a Profile by profile email that does not exist
	 **/
	public function testGetInvalidProfileByProfileEmail(): void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileEmail($this->getPDO(), "emailfailing@failing.failing");
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a profile by its profile name
	 */
	public function testGetValidProfileByProfileName(): void {
// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_SALT);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileName($this->getPDO(), $profile->getProfileName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail());
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILE_PHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
	}

	/**
	 * test grabbing a Profile by profile email that does not exist
	 **/
	public function testGetInvalidProfileByProfileName(): void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileName($this->getPDO(), "Frank");
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a profile by its phone number
	 */
	public function testGetValidProfileByProfilePhone(): void {
// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_SALT);
		$profile->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfilePhone($this->getPDO(), $profile->getProfilePhone());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail());
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILE_PHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
	}

	/**
	 * test grabbing a Profile by profile email that does not exist
	 **/
	public function testGetInvalidProfileByProfilePhone(): void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfilePhone($this->getPDO(), "12344566874");
		$this->assertNull($profile);
	}


	/**
	 * test grabbing all profiles
	 */
	public function testGetValidProfileByAllProfiles(): void {
// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL1, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_PHONE, $this->VALID_PROFILE_SALT);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getAllProfiles($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Zachspangler\\Tux\\Profile", $results);

		// grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail());
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILE_PHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
	}
}
