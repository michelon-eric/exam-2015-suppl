DROP DATABASE IF EXISTS exam_2015_suppl;
CREATE DATABASE IF NOT EXISTS exam_2015_suppl;
use exam_2015_suppl;

CREATE TABLE Users (
    USR_Id INTEGER PRIMARY KEY AUTO_INCREMENT,

    USR_FirstName VARCHAR(255) NOT NULL,
    USR_LastName VARCHAR(255) NOT NULL,
    USR_Email VARCHAR(255) NOT NULL UNIQUE,
    USR_Password VARCHAR(255) NOT NULL
)

CREATE TABLE Centres (
    CTR_Id INTEGER PRIMARY KEY AUTO_INCREMENT,

    CTR_Name VARCHAR(255) NOT NULL,
    CTR_Address VARCHAR(255) NOT NULL,
    CTR_City VARCHAR(255) NOT NULL,
    CTR_PostalCode VARCHAR(255) NOT NULL,
    CTR_Phone VARCHAR(255) NOT NULL
)

CREATE TABLE Categories (
    CAT_Id INTEGER PRIMARY KEY AUTO_INCREMENT,

    CAT_Name VARCHAR(255) NOT NULL,
    CAT_Type ENUM('Hardware', 'Software') NOT NULL
)

CREATE TABLE Resources (
    RES_Id INTEGER PRIMARY KEY AUTO_INCREMENT,

    RES_Name VARCHAR(255) NOT NULL,
    RES_Description TEXT NOT NULL,

    RES_Status ENUM('Available', 'Booked', 'Broken') DEFAULT 'Available',

    RES_IdCentre INTEGER NOT NULL,
    FOREIGN KEY (RES_IdCentre) REFERENCES Centres(CTR_Id),
    RES_IdCategory INTEGER NOT NULL,
    FOREIGN KEY (RES_IdCategory) REFERENCES Categories(CAT_Id)
)

CREATE TABLE CentreCategories (
    CCA_Id INTEGER PRIMARY KEY AUTO_INCREMENT,
    CCA_IdCentre INTEGER NOT NULL,
    FOREIGN KEY (CCa_IdCentre) REFERENCES Centres(CTR_Id),
    CCA_IdCategory INTEGER NOT NULL,
    FOREIGN KEY (CCA_IdCategory) REFERENCES Categories(CAT_Id)
)

CREATE TABLE Bookings (
    BOK_Id INTEGER PRIMARY KEY AUTO_INCREMENT,
    BOK_IdResource INTEGER NOT NULL,
    FOREIGN KEY (BOK_IdResource) REFERENCES Resources(RES_Id),
    BOK_IdUser INTEGER NOT NULL,
    FOREIGN KEY (BOK_IdUser) REFERENCES Users(USR_Id),

    BOK_StartDate DATE NOT NULL,
    BOK_EndDate DATE,
    BOK_ReturnDate DATE,

    BOK_Status ENUM('Active', 'Waiting', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Active',

    CONSTRAINT BOK_StartDate CHECK (BOK_StartDate < BOK_EndDate),
    CONSTRAINT BOK_ReturnDate CHECK (BOK_ReturnDate IS NULL or BOK_ReturnDate >= BOK_StartDate)
)

CREATE TABLE UserRole (
    ROL_Id INTEGER PRIMARY KEY AUTO_INCREMENT,

    ROL_IdUser INTEGER NOT NULL,
    FOREIGN KEY (ROL_IdUser) REFERENCES Users(USR_Id),

    ROL_IdCentre INTEGER NOT NULL,
    FOREIGN KEY (ROL_IdCentre) REFERENCES Centres(CTR_Id),

    ROL_Role ENUM('Regular', 'Moderator', 'Administrator', 'Root') DEFAULT 'Regular' NOT NULL
)

CREATE TRIGGER booking_added
AFTER INSERT ON Bookings
FOR EACH ROW
BEGIN
   IF DATE(NEW.BOK_StartDate) = CURDATE() THEN
      UPDATE Resources
      SET RES_Status = 'Booked'
      WHERE RES_Id = NEW.BOK_IdResource;
   END IF;
END;

CREATE TRIGGER booking_completed
AFTER UPDATE ON Bookings
FOR EACH ROW
BEGIN
   IF NEW.BOK_Status = 'Completed' THEN
      UPDATE Resources
      SET RSC_Status = 'Available'
      WHERE RSC_ID = NEW.BOK_IdResource;
   END IF;
END;

CREATE TRIGGER resource_broken
AFTER UPDATE ON Resources
FOR EACH ROW
BEGIN
   IF NEW.RES_Status = 'Broken' THEN
      UPDATE Bookings
      SET BOK_Status = 'Cancelled'
      WHERE BOK_IdRes = NEW.RES_Id AND BOK_Status = 'Active';
   END IF;
END;