DROP TABLE Adopted;
DROP TABLE OwnedAnimal;
DROP TABLE NotOwnedAnimal;
DROP TABLE AnimalMedicalHistory;
DROP TABLE VeterinarianWorkInfo;
DROP TABLE VeterinarianVolunteerInfo;
DROP TABLE BranchServiceInfo;
DROP TABLE AnimalHelpedAdopt2;
DROP TABLE WorkerWorksAt2;
DROP TABLE AnimalHelpedAdopt1;
DROP TABLE ShelterBranchInfo;
DROP TABLE WorkerWorksAt1;
DROP TABLE ShelterCorporation;
DROP TABLE AnimalHospital;
DROP TABLE VeterinarianInfo;
DROP TABLE Owner1;
DROP TABLE Owner2;


CREATE TABLE Owner2(
	address varchar(200) PRIMARY KEY,
	postalCode char(6)
);

INSERT INTO Owner2 (address, postalCode) 
VALUES ('123 Maple Street, Willowdale, CA', 'A1B2C3');

INSERT INTO Owner2 (address, postalCode) 
VALUES ('456 Oak Ave, Pinecrest, NY', 'X0Y1Z2');

INSERT INTO Owner2 (address, postalCode) 
VALUES ('789 Elm Lane, Cedar Springs, TX', 'H3I4J5');

INSERT INTO Owner2 (address, postalCode) 
VALUES ('101 Pine Street, Birch Wood, FL', 'K6L7M8');

INSERT INTO Owner2 (address, postalCode) 
VALUES ('912 Steven Street, Spruceville, AZ', 'N9O0P1');


CREATE TABLE VeterinarianInfo(
	vetSIN char(8),
	specialty varchar(200),
	name varchar(200),
	PRIMARY KEY (vetSIN)
);

INSERT INTO VeterinarianInfo(vetSIN, specialty, name)
VALUES ('11111111', 'Emergency', 'Dr. Grace Wellness');

INSERT INTO VeterinarianInfo(vetSIN, specialty, name)
VALUES ('22222222', 'Infectious Diseases', 'Dr. Grace Wellness');

INSERT INTO VeterinarianInfo(vetSIN, specialty, name)
VALUES ('33333333', 'Pediatrics', 'Dr. Michael Healing');

INSERT INTO VeterinarianInfo(vetSIN, specialty, name)
VALUES ('44444444', 'Parasitology', 'Dr. Emily Healthwise');

INSERT INTO VeterinarianInfo(vetSIN, specialty, name)
VALUES ('55555555', 'Orthopedics', 'Dr. Robert Renewal');


CREATE TABLE AnimalHospital(
	hospitalAddress varchar(200),
	name varchar(200),
	PRIMARY KEY (hospitalAddress)
);

INSERT INTO AnimalHospital (hospitalAddress, name)
VALUES ('123 Main Street, Cityville', 'CityVet Clinic');

INSERT INTO AnimalHospital (hospitalAddress, name)
VALUES ('456 Oak Avenue, Suburbia', 'Suburb Paws Veterinary Hospital');

INSERT INTO AnimalHospital (hospitalAddress, name)
VALUES ('789 Pine Road, Rural Town', 'RuralCare Animal Clinic');

INSERT INTO AnimalHospital (hospitalAddress, name)
VALUES ('101 Maple Lane, Seaside City', 'Seaside Veterinary Center');

INSERT INTO AnimalHospital (hospitalAddress, name)
VALUES ('555 Elm Street, Metroville', 'MetroVet Care');


CREATE TABLE ShelterCorporation(
	name varchar(200),
	dateFounded varchar(200) NOT NULL,
	PRIMARY KEY (name)
);

INSERT INTO ShelterCorporation (Name, dateFounded)
VALUES ('Pet Haven Corporation', '2000-05-15');

INSERT INTO ShelterCorporation (Name, dateFounded)
VALUES ('Animal Care Services', '1995-08-20');

INSERT INTO ShelterCorporation (Name, dateFounded)
VALUES ('Compassionate Pets Inc', '2003-03-10');

INSERT INTO ShelterCorporation (Name, dateFounded)
VALUES ('Happy Tails Corp', '1998-11-25');

INSERT INTO ShelterCorporation (Name, dateFounded)
VALUES ('Wildlife Guardians Ltd', '2005-07-03');


CREATE TABLE ShelterBranchInfo(
	corporationName varchar(200),
	branchName varchar(200) NOT NULL,
	branchAddress varchar(200), 
	PRIMARY KEY (corporationName, branchName),
	FOREIGN KEY (corporationName) REFERENCES ShelterCorporation
		ON DELETE CASCADE
);

INSERT INTO ShelterBranchInfo (corporationName, branchName, branchAddress)
VALUES ('Pet Haven Corporation', 'City Animal Rescue', '123 Main Street, Cityville');

INSERT INTO ShelterBranchInfo (corporationName, branchName, branchAddress)
VALUES ('Animal Care Services', 'Suburb Pet Sanctuary', '456 Oak Avenue, Suburbia');

INSERT INTO ShelterBranchInfo (corporationName, branchName, branchAddress)
VALUES ('Compassionate Pets Inc', 'Rural Animal Shelter', '789 Pine Road, Rural Town');

INSERT INTO ShelterBranchInfo (corporationName, branchName, branchAddress)
VALUES ('Happy Tails Corp', 'Coastal Animal Rescue', '101 Seaside Boulevard, Seaside City');

INSERT INTO ShelterBranchInfo (corporationName, branchName, branchAddress)
VALUES ('Wildlife Guardians Ltd', 'Mountain Pet Haven', '555 Mountain View, Mountain Town');


CREATE TABLE WorkerWorksAt1(
	branchName varchar(200),
	corporationName varchar(200),
	PRIMARY KEY (branchName)
);

INSERT INTO WorkerWorksAt1 (corporationName, branchName)
VALUES ('Pet Haven Corporation', 'City Animal Rescue');

INSERT INTO WorkerWorksAt1 (corporationName, branchName)
VALUES ('Animal Care Services', 'Suburb Pet Sanctuary');

INSERT INTO WorkerWorksAt1 (corporationName, branchName)
VALUES ('Compassionate Pets Inc', 'Rural Animal Shelter');

INSERT INTO WorkerWorksAt1 (corporationName, branchName)
VALUES ('Happy Tails Corp', 'Coastal Animal Rescue');

INSERT INTO WorkerWorksAt1 (corporationName, branchName)
VALUES ('Wildlife Guardians Ltd', 'Mountain Pet Haven');


CREATE TABLE WorkerWorksAt2(
	branchName varchar(200),
	sin char(8),
	name varchar(200),
	role varchar(200) NOT NULL,
	PRIMARY KEY (sin),
	FOREIGN KEY (branchName) REFERENCES WorkerWorksAt1
);

INSERT INTO WorkerWorksAt2 (branchName, sin, name, role)
VALUES ('City Animal Rescue', '12345678', 'John Doe', 'Veterinarian');

INSERT INTO WorkerWorksAt2 (branchName, sin, name, role)
VALUES ('Suburb Pet Sanctuary', '87654321', 'Jane Smith', 'Animal Care Technician');

INSERT INTO WorkerWorksAt2 (branchName, sin, name, role)
VALUES ('Rural Animal Shelter', '23456789', 'Sam Johnson', 'Administrator');

INSERT INTO WorkerWorksAt2 (branchName, sin, name, role)
VALUES ('Coastal Animal Rescue', '98765432', 'Emily Davis', 'Receptionist');

INSERT INTO WorkerWorksAt2 (branchName, sin, name, role)
VALUES ('Mountain Pet Haven', '34567890', 'Chris Miller', 'Groomer');

INSERT INTO WorkerWorksAt2 (branchName, sin, name, role)
VALUES ('Mountain Pet Haven', '11112233', 'Chris Miller', 'Groomer');


CREATE TABLE AnimalHelpedAdopt1(
	breed varchar(200),
	species varchar(200),
	PRIMARY KEY (breed)
);

INSERT
INTO	AnimalHelpedAdopt1(breed, species)
VALUES ('German Shepherd', 'Dog');

INSERT
INTO	AnimalHelpedAdopt1(breed, species)
VALUES ('American Short Hair', 'Cat');

INSERT
INTO	AnimalHelpedAdopt1(breed, species)
VALUES ('Golden Retriever', 'Dog');

INSERT
INTO	AnimalHelpedAdopt1(breed, species)
VALUES ('Tibetan Mastiff', 'Dog');

INSERT
INTO	AnimalHelpedAdopt1(breed, species)
VALUES ('Maine Coon', 'Cat');


CREATE TABLE AnimalHelpedAdopt2(
	name varchar(200),
	age int,
	adoptionProcessDate varchar(200),
	breed varchar(200),
	workerSIN char(8),
	corporationName varchar(200),
	branchName varchar(200) NOT NULL,
	animalBranchTag char(9),
	PRIMARY KEY (name),
	FOREIGN KEY (breed) REFERENCES AnimalHelpedAdopt1
		ON DELETE CASCADE,
	FOREIGN KEY (workerSIN) REFERENCES WorkerWorksAt2
		ON DELETE CASCADE,
	FOREIGN KEY (corporationName, branchName) REFERENCES ShelterBranchInfo
		ON DELETE CASCADE
);

INSERT INTO AnimalHelpedAdopt2(name, age, adoptionProcessDate, breed, workerSIN, corporationName, branchName, animalBranchTag)
VALUES ('Snoopy', '1', '2022-11-20', 'German Shepherd', '12345678', 'Pet Haven Corporation', 'City Animal Rescue', 'qwertyuio');

INSERT INTO AnimalHelpedAdopt2(name, age, adoptionProcessDate, breed, workerSIN, corporationName, branchName, animalBranchTag)
VALUES ('Buddy', '3', '2020-11-20', 'American Short Hair', '87654321', 'Animal Care Services', 'Suburb Pet Sanctuary', 'plokijuhy');

INSERT INTO AnimalHelpedAdopt2(name, age, adoptionProcessDate, breed, workerSIN, corporationName, branchName, animalBranchTag)
VALUES ('Felix', '5', '2018-11-20', 'Golden Retriever', '23456789', 'Compassionate Pets Inc', 'Rural Animal Shelter', 'mnbvcxzas');

INSERT INTO AnimalHelpedAdopt2(name, age, adoptionProcessDate, breed, workerSIN, corporationName, branchName, animalBranchTag)
VALUES ('Bowen', '7', '2016-11-20', 'Tibetan Mastiff', '98765432', 'Happy Tails Corp', 'Coastal Animal Rescue', 'rtyeudjfh');

INSERT INTO AnimalHelpedAdopt2(name, age, adoptionProcessDate, breed, workerSIN, corporationName, branchName, animalBranchTag)
VALUES ('Haad', '9', '2014-11-20', 'Maine Coon', '34567890', 'Wildlife Guardians Ltd', 'Mountain Pet Haven', 'jguriekdj');

INSERT INTO AnimalHelpedAdopt2(name, age, adoptionProcessDate, breed, workerSIN, corporationName, branchName, animalBranchTag)
VALUES ('Scoopy', '9', '2014-11-20', 'Maine Coon', '34567890', 'Wildlife Guardians Ltd', 'Mountain Pet Haven', 'jguriekdj');

INSERT INTO AnimalHelpedAdopt2(name, age, adoptionProcessDate, breed, workerSIN, corporationName, branchName, animalBranchTag)
VALUES ('Duck', '9', '2014-11-20', 'Maine Coon', '34567890', 'Wildlife Guardians Ltd', 'Mountain Pet Haven', 'jguriekdj');

INSERT INTO AnimalHelpedAdopt2(name, age, adoptionProcessDate, breed, workerSIN, corporationName, branchName, animalBranchTag)
VALUES ('Penny', '9', '2014-11-20', 'Maine Coon', '34567890', 'Wildlife Guardians Ltd', 'Mountain Pet Haven', 'jguriekdj');

INSERT INTO AnimalHelpedAdopt2(name, age, adoptionProcessDate, breed, workerSIN, corporationName, branchName, animalBranchTag)
VALUES ('Ryan', '9', '2014-11-20', 'Maine Coon', '34567890', 'Wildlife Guardians Ltd', 'Mountain Pet Haven', 'jguriekdj');

INSERT INTO AnimalHelpedAdopt2(name, age, adoptionProcessDate, breed, workerSIN, corporationName, branchName, animalBranchTag)
VALUES ('Mango', '9', '2014-11-20', 'Maine Coon', '34567890', 'Wildlife Guardians Ltd', 'Mountain Pet Haven', 'jguriekdj');


CREATE TABLE NotOwnedAnimal(
	animalName varchar(200),
	isVaccinated NUMBER(1, 0),
	regionFoundIn varchar(200),
	PRIMARY KEY (animalName),
	FOREIGN KEY (animalName) REFERENCES AnimalHelpedAdopt2
		ON DELETE CASCADE
);

INSERT INTO NotOwnedAnimal(animalName, isVaccinated, regionFoundIn)
VALUES ('Snoopy', '1', 'White Rock');

INSERT INTO NotOwnedAnimal(animalName, isVaccinated, regionFoundIn)
VALUES ('Buddy', '1', 'Burnaby');

INSERT INTO NotOwnedAnimal(animalName, isVaccinated, regionFoundIn)
VALUES ('Felix', '0', 'Seattle');

INSERT INTO NotOwnedAnimal(animalName, isVaccinated, regionFoundIn)
VALUES ('Bowen', '1', 'Vancouver');

INSERT INTO NotOwnedAnimal(animalName, isVaccinated, regionFoundIn)
VALUES ('Haad', '0', 'UBC');


CREATE TABLE OwnedAnimal(
	animalName varchar(200),
	ownershipStartDate varchar(200),
	PRIMARY KEY (animalName),
	FOREIGN KEY (animalName) REFERENCES AnimalHelpedAdopt2
		ON DELETE CASCADE
);

INSERT INTO OwnedAnimal(animalName, ownershipStartDate)
VALUES ('Scoopy', '2020-11-30');

INSERT INTO OwnedAnimal(animalName, ownershipStartDate)
VALUES ('Duck', '2018-11-30');

INSERT INTO OwnedAnimal(animalName, ownershipStartDate)
VALUES ('Penny', '2016-11-30');

INSERT INTO OwnedAnimal(animalName, ownershipStartDate)
VALUES ('Ryan', '2014-11-30');

INSERT INTO OwnedAnimal(animalName, ownershipStartDate)
VALUES ('Mango', '2012-11-30');


CREATE TABLE BranchServiceInfo(
	branchName varchar(200),
	corporationName varchar(200),
	ownerSIN char(8),
	serviceStartDate varchar(200),
	PRIMARY KEY (ownerSIN, branchName, corporationName),
	FOREIGN KEY (corporationName, branchName) REFERENCES ShelterBranchInfo
		ON DELETE CASCADE
);

INSERT INTO BranchServiceInfo (branchName, corporationName, ownerSIN, serviceStartDate)
VALUES ('City Animal Rescue', 'Pet Haven Corporation', '12345678', '2023-01-15');

INSERT INTO BranchServiceInfo (branchName, corporationName, ownerSIN, serviceStartDate)
VALUES ('Suburb Pet Sanctuary', 'Animal Care Services', '87654321', '2023-02-01');

INSERT INTO BranchServiceInfo (branchName, corporationName, ownerSIN, serviceStartDate)
VALUES ('Rural Animal Shelter', 'Compassionate Pets Inc', '98765432', '2023-03-10');

INSERT INTO BranchServiceInfo (branchName, corporationName, ownerSIN, serviceStartDate)
VALUES ('Coastal Animal Rescue', 'Happy Tails Corp', '23456789', '2023-04-20');

INSERT INTO BranchServiceInfo (branchName, corporationName, ownerSIN, serviceStartDate)
VALUES ('Mountain Pet Haven', 'Wildlife Guardians Ltd', '34567890', '2023-05-05');


CREATE TABLE AnimalMedicalHistory(
	medicalRecordNumber char(9),
	animalName varchar(200),
	administeringHospital varchar(200),
	yearOfRecord int,
PRIMARY KEY (medicalRecordNumber),
FOREIGN KEY (animalName) REFERENCES AnimalHelpedAdopt2
	ON DELETE CASCADE
);

INSERT INTO AnimalMedicalHistory(medicalRecordNumber, animalName, administeringHospital, yearOfRecord) 
VALUES ('111111111', 'Scoopy', 'Vancouver Animal Hospital', '2013');

INSERT INTO AnimalMedicalHistory(medicalRecordNumber, animalName, administeringHospital, yearOfRecord) 
VALUES ('222222222', 'Duck', 'Vancouver Animal Hospital', '2014');

INSERT INTO AnimalMedicalHistory(medicalRecordNumber, animalName, administeringHospital, yearOfRecord) 
VALUES ('333333333', 'Penny', 'Surrey Animal Hospital', '1999');

INSERT INTO AnimalMedicalHistory(medicalRecordNumber, animalName, administeringHospital, yearOfRecord) 
VALUES ('444444444', 'Ryan', 'Burnaby Animal Hospital', '2000');

INSERT INTO AnimalMedicalHistory(medicalRecordNumber, animalName, administeringHospital, yearOfRecord) 
VALUES ('555555555', 'Mango', 'Vancouver Animal Hospital', '2023');


CREATE TABLE VeterinarianVolunteerInfo(
	vetSIN char(8),
	branchName varchar(200),
	corporationName varchar(200),
	PRIMARY KEY (vetSIN, branchName, corporationName),
	FOREIGN KEY (vetSIN) REFERENCES VeterinarianInfo
		ON DELETE CASCADE,
	FOREIGN KEY (corporationName, branchName) REFERENCES ShelterBranchInfo
		ON DELETE CASCADE
);

INSERT INTO VeterinarianVolunteerInfo (vetSIN, branchName, corporationName)
VALUES ('11111111', 'Coastal Animal Rescue', 'Happy Tails Corp');

INSERT INTO VeterinarianVolunteerInfo (vetSIN, branchName, corporationName)
VALUES ('22222222', 'Mountain Pet Haven', 'Wildlife Guardians Ltd');

INSERT INTO VeterinarianVolunteerInfo (vetSIN, branchName, corporationName)
VALUES ('33333333', 'City Animal Rescue', 'Pet Haven Corporation');

INSERT INTO VeterinarianVolunteerInfo (vetSIN, branchName, corporationName)
VALUES ('44444444', 'Suburb Pet Sanctuary', 'Animal Care Services');

INSERT INTO VeterinarianVolunteerInfo (vetSIN, branchName, corporationName)
VALUES ('55555555', 'Rural Animal Shelter', 'Compassionate Pets Inc');


CREATE TABLE VeterinarianWorkInfo(
	vetSIN char(8),
	hospitalAddress varchar(200),
	PRIMARY KEY (vetSIN, hospitalAddress),
	FOREIGN KEY (hospitalAddress) REFERENCES AnimalHospital
		ON DELETE CASCADE,
	FOREIGN KEY (vetSIN) REFERENCES VeterinarianInfo
		ON DELETE CASCADE
);

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('11111111', '123 Main Street, Cityville'); 

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('11111111', '789 Pine Road, Rural Town'); 

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('22222222', '456 Oak Avenue, Suburbia');

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('22222222', '101 Maple Lane, Seaside City');

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('33333333', '789 Pine Road, Rural Town');

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('44444444', '101 Maple Lane, Seaside City');

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('55555555', '555 Elm Street, Metroville');


-- These are added for vet with id 55555555 to be displayed in the division result
INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('55555555', '123 Main Street, Cityville');

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('55555555', '456 Oak Avenue, Suburbia');

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('55555555', '789 Pine Road, Rural Town');

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('55555555', '101 Maple Lane, Seaside City');

-- These are added for vet with id 44444444 to be displayed in the division result
INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('44444444', '123 Main Street, Cityville');

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('44444444', '456 Oak Avenue, Suburbia');

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('44444444', '789 Pine Road, Rural Town');

INSERT INTO VeterinarianWorkInfo (vetSIN, hospitalAddress)
VALUES ('44444444', '555 Elm Street, Metroville');














CREATE TABLE Owner1(
	sin char(8),
	name varchar(200),
	phone_num char(10),
	address varchar(200) NOT NULL,
	PRIMARY KEY (sin),
	FOREIGN KEY (address) REFERENCES Owner2
		ON DELETE CASCADE
);

INSERT INTO Owner1(sin, name, phone_num, address)
VALUES ('12345678', 'Zephyr Evergreen', '6040987654', '123 Maple Street, Willowdale, CA');

INSERT INTO Owner1(sin, name, phone_num, address)
VALUES ('87654321', 'Seraphina Nightingale', '6041234567', '456 Oak Ave, Pinecrest, NY');

INSERT INTO Owner1(sin, name, phone_num, address)
VALUES ('98765432', 'Orion Wilder', '6047986756', '789 Elm Lane, Cedar Springs, TX');

INSERT INTO Owner1(sin, name, phone_num, address)
VALUES ('23456789', 'Juniper Frost', '7780987654', '101 Pine Street, Birch Wood, FL');

INSERT INTO Owner1(sin, name, phone_num, address)
VALUES ('34567890', 'Phoenix Rain', '7786758456', '912 Steven Street, Spruceville, AZ');


CREATE TABLE Adopted(
	ownerSIN char(8),
	animalName varchar(200),
	adoptionDate varchar(200),
	petName varchar(200),
	PRIMARY KEY (ownerSIN, animalName),
	FOREIGN KEY (ownerSIN) REFERENCES Owner1
		ON DELETE CASCADE,
	FOREIGN KEY (animalName) REFERENCES AnimalHelpedAdopt2
		ON DELETE CASCADE
);

INSERT INTO Adopted (ownerSIN, animalName, adoptionDate, petName)
VALUES ('12345678', 'Scoopy', '2023-01-15', 'Whiskers');

INSERT INTO Adopted (ownerSIN, animalName, adoptionDate, petName)
VALUES ('87654321', 'Duck', '2023-02-01', 'Buddy');

INSERT INTO Adopted (ownerSIN, animalName, adoptionDate, petName)
VALUES ('98765432', 'Penny', '2023-03-10', 'Tweety');

INSERT INTO Adopted (ownerSIN, animalName, adoptionDate, petName)
VALUES ('23456789', 'Ryan', '2023-04-20', 'Splash');

INSERT INTO Adopted (ownerSIN, animalName, adoptionDate, petName)
VALUES ('34567890', 'Mango', '2023-05-05', 'Thumper');














