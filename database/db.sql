CREATE DATABASE IF NOT EXISTS exam_2015_suppl;

CREATE TABLE IF NOT EXISTS Users (
   USR_Id INTEGER PRIMARY KEY AUTOINCREMENT,

   USR_FirstName VARCHAR(255) NOT NULL,
   USR_LastName VARCHAR(255) NOT NULL,
   USR_Email VARCHAR(255) NOT NULL,
   USR_Password VARCHAR(255) NOT NULL,
   
   USR_Role ENUM('Regular', 'Moderator', 'Administrator') NOT NULL DEFAULT 'Regular',
   USR_IdCentre INTEGER,
   
   CONSTRAINT USR_CentreRole CHECK (
      (
         USR_IdCenter IS NULL
         AND USR_Role = 'Regular'
      )
      or (
         USR_IdCentre IS NOT NULL
         AND NOT USR_Role = 'Regular'
      )
   ),
);

CREATE TABLE IF NOT EXISTS Centres (
   CTR_Id INTEGER PRIMARY KEY AUTOINCREMENT,
   
   CTR_Address VARCHAR(255) NOT NULL,
   CTR_City VARCHAR(255) NOT NULL,

   CTR_Phone VARCHAR(255),
   CTR_Email VARCHAR(255),
);

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


CREATE TABLE Bookings (
   BOK_Id INTEGER PRIMARY KEY AUTO INCREMENT,
   BOK_IdResource INTEGER NOT NULL,
   BOK_IdUser INTEGER NOT NULL,

   BOK_StartDate DATE NOT NULL,
   BOK_EndDate DATE,
    DATE,

    ENUM('Active', 'Waiting', 'Returned', 'Cancelled') NOT NULL DEFAULT 'Active',

   FOREIGN KEY (BOK_IdResource) REFERENCES Resources(RES_Id),
   FOREIGN KEY (BOK_IdUser) REFERENCES Users(USR_Id),

   CONSTRAINT BOK_StartDate CHECK (BOK_StartDate < BOK_EndDate),
   CONSTRAINT BOK_ReturnDate CHECK (BOK_ReturnDate IS NULL or BOK_ReturnDate >= BOK_StartDate),
);