CREATE DATABASE IF NOT EXISTS exam_2015_suppl;

CREATE TABLE IF NOT EXISTS Users (
    USR_Id INTEGER PRIMARY KEY AUTOINCREMENT,
    USR_FirstName VARCHAR(255) NOT NULL,
    USR_LastName VARCHAR(255) NOT NULL,
    USR_Email VARCHAR(255) NOT NULL,
    USR_Password VARCHAR(255) NOT NULL,
    USR_Role ENUM('Regular', 'Moderator', 'Administrator') NOT NULL DEFAULT 'Regular',
    USR_IdCentre INTEGER,

    CONSTRAINT USR_Centre_Role CHECK ((USR_IdCenter IS NULL AND USR_Role = 'Regular') or (USR_IdCentre IS NOT NULL AND NOT USR_Role = 'Regular')),
);

CREATE TABLE IF NOT EXISTS Centres {
    CTR_Id INTEGER PRIMARY KEY AUTOINCREMENT,
    CTR_Address VARCHAR(255) NOT NULL,
    CTR_City VARCHAR(255) NOT NULL,
    CTR_PostalCode VARCHAR(255) NOT NULL,
    CTR_Phone VARCHAR(255),
    CTR_Email VARCHAR(255),
}

CREATE TABLE IF NOT EXISTS Resources (
    RES_Id INTEGER PRIMARY KEY AUTOINCREMENT,
    RES_Name VARCHAR(255) NOT NULL,
    RES_Description TEXT,
    RES_Status ENUM('Available', 'Unavailable'),
    RES_IdCentre INTEGER NOT NULL,
    RES_IdCategory INTEGER NOT NULL,
);

CREATE TABLE IF NOT EXISTS Categories (
    CAT_Id INTEGER PRIMARY KEY AUTOINCREMENT,
    CAT_Name VARCHAR(255) NOT NULL,
    CAT_Type ENUM('Hardware', 'Software') NOT NULL,
);

CREATE TABLE IF NOT EXISTS CentreCategories (
    CCA_IdCentre INTEGER NOT NULL,
    CCA_IdCategory INTEGER NOT NULL,
    PRIMARY KEY (CCA_IdCentre, CCA_IdCategory),
    FOREIGN KEY (CCA_IdCentre) REFERENCES Centres(CTR_Id),
    FOREIGN KEY (CCA_IdCategory) REFERENCES Categories(CAT_Id),
);

CREATE TABLE IF NOT EXISTS CentreResources (
    CRE_IdCentre INTEGER NOT NULL,
    CRE_IdResource INTEGER NOT NULL,
    PRIMARY KEY (CRE_IdCentre, CRE_IdResource),
    FOREIGN KEY (CRE_IdCentre) REFERENCES Centres(CTR_Id),
    FOREIGN KEY (CRE_IdResource) REFERENCES Resources(RES_Id),
);

CREATE TABLE IF NOT EXISTS Borrowed (
    BOR_Id INTEGER PRIMARY KEY AUTOINCREMENT,
    BOR_IdUser INTEGER NOT NULL,
    BOR_IdResource INTEGER NOT NULL,
    BOR_StartDate DATE NOT NULL,
    BOR_EndDate DATE NOT NULL,
    BOR_ReturnDate DATE,
    FOREIGN KEY (BOR_IdUser) REFERENCES Users(USR_Id),
    FOREIGN KEY (BOR_IdResource) REFERENCES Resources(RES_Id),
    CHECK (BOR_StartDate < BOR_EndDate),
    CHECK (BOR_ReturnDate IS NULL OR BOR_ReturnDate > BOR_EndDate),
);

CREATE TABLE IF NOT EXISTS Booked (
    BOK_Id INTEGER PRIMARY KEY AUTOINCREMENT,
    BOK_IdUser INTEGER NOT NULL,
    BOK_IdResource INTEGER NOT NULL,
    BOK_StartDate DATE NOT NULL,
    BOK_EndDate DATE NOT NULL,
    BOK_Status ENUM ('Active', 'Expired', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Active',
    FOREIGN KEY (BOO_IdUser) REFERENCES Users(USR_Id),
    FOREIGN KEY (BOO_IdResource) REFERENCES Resources(RES_Id),
    CHECK (BOO_StartDate < BOO_EndDate),
);

ALTER TABLE Users
ADD FOREIGN KEY (USR_IdCentre) REFERENCES Centres(CTR_Id);

ALTER TABLE Resources
ADD FOREIGN KEY (RES_IdCentre) REFERENCES Centres(CTR_Id),
ADD FOREIGN KEY (RES_IdCategory) REFERENCES Categories(CAT_Id);

ALTER TABLE CentreCategories
ADD FOREIGN KEY (CCA_IdCentre) REFERENCES Centres(CTR_Id),
ADD FOREIGN KEY (CCA_IdCategory) REFERENCES Categories(CAT_Id);

ALTER TABLE CentreResources
ADD FOREIGN KEY (CRE_IdCentre) REFERENCES Centres(CTR_Id),
ADD FOREIGN KEY (CRE_IdResource) REFERENCES Resources(RES_Id);

ALTER TABLE Borrowed
ADD FOREIGN KEY (BOR_IdUser) REFERENCES Users(USR_Id),
ADD FOREIGN KEY (BOR_IdResource) REFERENCES Resources(RES_Id);

ALTER TABLE Booked
ADD FOREIGN KEY (BOK_IdUser) REFERENCES Users(USR_Id),
ADD FOREIGN KEY (BOK_IdResource) REFERENCES Resources(RES_Id);

CREATE TRIGGER trg_borrowed_before_insert
BEFORE INSERT ON Borrowed
FOR EACH ROW
BEGIN
   SELECT CASE WHEN ((SELECT RES_Status FROM Resources WHERE RES_Id = NEW.BOR_IdResource) = 'Unavailable')
   THEN RAISE(ABORT, 'Resource is unavailable') END;
END;

CREATE TRIGGER trg_borrowed_after_insert
AFTER INSERT ON Borrowed
FOR EACH ROW
BEGIN
   UPDATE Resources SET RES_Status = 'Unavailable' WHERE RES_Id = NEW.BOR_IdResource;
END;

CREATE TRIGGER trg_borrowed_after_update
AFTER UPDATE OF BOR_ReturnDate ON Borrowed
FOR EACH ROW
BEGIN
   UPDATE Resources SET RES_Status = 'Available' WHERE RES_Id = NEW.BOR_IdResource;
END;

CREATE TRIGGER trg_booked_after_update
AFTER UPDATE OF BOK_Status ON Booked
FOR EACH ROW
WHEN NEW.BOK_Status = 'Completed'
BEGIN
   INSERT INTO Borrowed (BOR_IdBooking, BOR_IdResource, BOR_IdUser, BOR_StartDate, BOR_EndDate)
   VALUES (NEW.BOK_Id, NEW.BOK_IdResource, NEW.BOK_IdUser, NEW.BOK_StartDate, NEW.BOK_EndDate);
END;

CREATE TRIGGER trg_booked_check_expiry
AFTER UPDATE OF BOK_StartDate ON Booked
FOR EACH ROW
WHEN NEW.BOK_StartDate < CURRENT_DATE AND NEW.BOK_Status = 'Active' AND NOT EXISTS (
    SELECT 1 FROM Borrowed
    WHERE BOR_IdBooking = NEW.BOK_Id
)
BEGIN
   UPDATE Booked SET BOK_Status = 'Expired' WHERE BOK_Id = NEW.BOK_Id;
END;

CREATE TRIGGER trg_booked_after_update
AFTER UPDATE OF BOK_Status ON Booked
FOR EACH ROW
WHEN NEW.BOK_Status = 'Completed'
BEGIN
   INSERT INTO Borrowed (BOR_IdBooking, BOR_IdResource, BOR_IdUser, BOR_StartDate, BOR_EndDate)
   VALUES (NEW.BOK_Id, NEW.BOK_IdResource, NEW.BOK_IdUser, NEW.BOK_StartDate, NEW.BOK_EndDate);
END;

CREATE TRIGGER trg_booked_after_update_expired
AFTER UPDATE OF BOK_Status ON Booked
FOR EACH ROW
WHEN OLD.BOK_Status = 'Active' AND NEW.BOK_Status = 'Expired'
BEGIN
   UPDATE Resources SET RES_Status = 'Available' WHERE RES_Id = NEW.BOK_IdResource;
END;

CREATE TRIGGER trg_borrowed_after_update_returned
AFTER UPDATE OF BOR_ReturnDate ON Borrowed
FOR EACH ROW
WHEN NEW.BOR_ReturnDate IS NOT NULL
BEGIN
   UPDATE Resources SET RES_Status = 'Available' WHERE RES_Id = NEW.BOR_IdResource;
END;

CREATE TRIGGER trg_booked_before_insert_overlap
BEFORE INSERT ON Booked
FOR EACH ROW
BEGIN
   SELECT CASE WHEN EXISTS (
       SELECT 1 FROM Booked
       WHERE BOK_IdResource = NEW.BOK_IdResource
       AND ((BOK_StartDate BETWEEN NEW.BOK_StartDate AND NEW.BOK_EndDate)
       OR (BOK_EndDate BETWEEN NEW.BOK_StartDate AND NEW.BOK_EndDate))
   )
   THEN RAISE(ABORT, 'Resource is already booked for the same time period') END;
END;

CREATE TRIGGER trg_users_before_insert_update_admin
BEFORE INSERT OR UPDATE OF USR_Role, USR_IdCentre ON Users
FOR EACH ROW
WHEN NEW.USR_Role = 'Administrator'
BEGIN
   SELECT CASE WHEN EXISTS (
       SELECT 1 FROM Users
       WHERE USR_IdCentre = NEW.USR_IdCentre
       AND USR_Role = 'Administrator'
       AND USR_Id != NEW.USR_Id
   )
   THEN RAISE(ABORT, 'There can only be one Administrator per centre') END;
END;

CREATE TRIGGER trg_borrowed_after_update_early_return
AFTER UPDATE OF BOR_ReturnDate ON Borrowed
FOR EACH ROW
WHEN NEW.BOR_ReturnDate < OLD.BOR_EndDate
BEGIN
   UPDATE Resources SET RES_Status = 'Available' WHERE RES_Id = NEW.BOR_IdResource;
END;

CREATE TRIGGER trg_booked_after_update_cancelled
AFTER UPDATE OF BOK_Status ON Booked
FOR EACH ROW
WHEN NEW.BOK_Status = 'Cancelled'
BEGIN
   UPDATE Resources SET RES_Status = 'Available' WHERE RES_Id = NEW.BOK_IdResource;
END;