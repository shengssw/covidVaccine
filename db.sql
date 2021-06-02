CREATE TABLE PriorityGroup(
	groupId int NOT NULL PRIMARY KEY,
    qualifyTime date NOT NULL
);

CREATE TABLE Address(
	address varchar(255) NOT NULL PRIMARY KEY,
    longitude FLOAT NOT NULL,
    latitude FLOAT NOT NULL,
	CONSTRAINT UNIQUE(address)
);

CREATE TABLE Patient(
	patientId int NOT NULL PRIMARY KEY,
    name varchar(255) NOT NULL,
    birthday date NOT NULL,
    ssn varchar(255),
    address varchar(255),
    phone varchar(255),
    email varchar(255) NOT NULL,
    groupId int,
    distancepreference decimal,
    addtionalInfo varchar(255), 
    FOREIGN KEY (groupId) 
		REFERENCES PriorityGroup(groupId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (address) 
		REFERENCES Address(address) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Provider(
	providerId int NOT NULL PRIMARY KEY,
    name varchar(255) NOT NULL,
    address varchar(255) NOT NULL,
    phone  varchar(255) NOT NULL,
    providerType varchar(255),
    FOREIGN KEY (address)
		REFERENCES Address(address) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Admin(
	adminId int NOT NULL PRIMARY KEY,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL
);

CREATE TABLE Role(
	roleId int NOT NULL PRIMARY KEY,
    patientId int,
    providerId int,
    CONSTRAINT UNIQUE (patientId, providerId),
    CONSTRAINT CHECK (patientId IS NOT NULL OR providerId IS NOT NULL),
    FOREIGN KEY (patientId) REFERENCES Patient(patientId) ON DELETE CASCADE,
    FOREIGN KEY (providerId) REFERENCES Provider(providerId) ON DELETE CASCADE
);

CREATE TABLE Account(
	username varchar(255) NOT NULL PRIMARY KEY,
    password varchar(255) NOT NULL,
    roleId int NOT NULL,
    CONSTRAINT UNIQUE (username),
    FOREIGN KEY (roleId) REFERENCES Role(roleId) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE TimePreference(
	patientId int NOT NULL,
    timeblock int NOT NULL,
    day int NOT NULL,
    Primary Key (patientId, timeblock, day),
    FOREIGN KEY (patientId) REFERENCES Patient(patientId) ON DELETE CASCADE
);

CREATE TABLE Appointment(
	appointId int NOT NULL PRIMARY KEY,
    providerId int NOT NULL,
    date date NOT NULL,
    timeblock int NOT NULL,
    availability int NOT NULL,
    FOREIGN KEY (providerId) REFERENCES Provider(providerId) 
		ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE PatientAppointment(
	appointId int NOT NULL,
    patientId int NOT NULL,
    sendTime timestamp NOT NULL,
    deadline timestamp NOT NULL,
    replyTime timestamp,
    status varchar(255) NOT NULL,
    PRIMARY KEY (appointId, patientId),
    FOREIGN KEY (appointId) REFERENCES Appointment(appointId) ON DELETE CASCADE,
    FOREIGN KEY (patientId) REFERENCES Patient(patientId) ON DELETE CASCADE 
);