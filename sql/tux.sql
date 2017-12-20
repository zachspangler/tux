DROP TABLE IF EXISTS card;
DROP TABLE IF EXISTS weddingParty;
DROP TABLE IF EXISTS wedding;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS company;

CREATE TABLE company (
	companyId BINARY(16) NOT NULL,
	companyAddress VARCHAR(255) NOT NULL,
	companyCity VARCHAR(128) NOT NULL,
	companyEmail VARCHAR(128) NOT NULL,
	companyHash CHAR(128) NOT NULL,
	companyName VARCHAR(255) NOT NULL,
	companyPhone VARCHAR(32),
	companyPostalCode VARCHAR(32) NOT NULL,
	companySalt CHAR(64) NOT NULL,
	companyState VARCHAR(32) NOT NULL,
	companyNotifications TINYINT UNSIGNED NOT NULL,
	UNIQUE (companyEmail),
	UNIQUE (companyPhone),
	PRIMARY KEY (companyId)
);

CREATE TABLE profile (
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileName VARCHAR(255) NOT NULL,
	profilePhone VARCHAR(32) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	UNIQUE (profileEmail),
	UNIQUE (profilePhone),
	PRIMARY KEY (profileId)
);

CREATE TABLE wedding (
	weddingId BINARY(16) NOT NULL,
	weddingCompanyId BINARY (16) NOT NULL,
	weddingDate DATETIME(6) NOT NULL,
	weddingName VARCHAR(255) NOT NULL,
	weddingReturnByDate DATETIME(6) NOT NULL,
	INDEX (weddingCompanyId),
	FOREIGN KEY (weddingCompanyId) REFERENCES company(companyId),
	PRIMARY KEY (weddingId)
);

CREATE TABLE weddingParty (
	weddingPartyId BINARY(16) NOT NULL,
	weddingPartyProfileId BINARY(16) NOT NULL,
	weddingPartyWeddingId BINARY (16),
	weddingPartyAdmin TINYINT UNSIGNED NOT NULL,
	INDEX (weddingPartyProfileId),
	INDEX (weddingPartyWeddingId),
	FOREIGN KEY (weddingPartyProfileId) REFERENCES profile(profileId),
	FOREIGN KEY (weddingPartyWeddingId) REFERENCES wedding(weddingId),
	PRIMARY KEY (weddingPartyId)
);


CREATE TABLE card (
	cardId BINARY(16) NOT NULL,
	cardProfileId BINARY(16) NOT NULL,
	cardWeddingId BINARY(16) NOT NULL,
	cardChest DECIMAL(4,2) NOT NULL,
	cardCoat DECIMAL(4,2) NOT NULL,
	cardComplete TINYINT UNSIGNED NOT NULL,
	cardHeight DECIMAL(4,2) NOT NULL,
	cardNeck DECIMAL(4,2) NOT NULL,
	cardOutseam DECIMAL(4,2) NOT NULL,
	cardPant DECIMAL(4,2) NOT NULL,
	cardReviewed VARCHAR(255) NOT NULL,
	cardShirt DECIMAL(4,2) NOT NULL,
	cardShoeSize DECIMAL(4,2) NOT NULL,
	cardSleeve DECIMAL(4,2) NOT NULL,
	cardUnderarm DECIMAL(4,2) NOT NULL,
	cardWeight TINYINT UNSIGNED NOT NULL,
	INDEX (cardProfileId),
	INDEX (cardWeddingId),
	FOREIGN KEY (cardProfileId) REFERENCES profile(profileId),
	FOREIGN KEY (cardWeddingId) REFERENCES wedding(weddingId),
	PRIMARY KEY (cardId)
);