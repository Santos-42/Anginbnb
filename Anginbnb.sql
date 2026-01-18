-- Database
CREATE DATABASE IF NOT EXISTS anginbnb;
USE anginbnb;

-- Tabel MsUser
CREATE TABLE MsUser (
    UserID INT(10) NOT NULL AUTO_INCREMENT,
    UserName VARCHAR(100) NOT NULL,
    UserEmail VARCHAR(100) NOT NULL,
    UserPassword VARCHAR(20) NOT NULL, 
    UserRole VARCHAR(10) NOT NULL,
    PRIMARY KEY (UserID)
);

-- Tabel MsPaymentType
CREATE TABLE MsPaymentType (
    PaymentTypeID INT(10) NOT NULL AUTO_INCREMENT,
    PaymentTypeName VARCHAR(20) NOT NULL,
    PRIMARY KEY (PaymentTypeID)
);

-- Tabel MsCategory
CREATE TABLE MsCategory (
    CategoryID INT(10) NOT NULL AUTO_INCREMENT,
    CategoryName VARCHAR(20) NOT NULL,
    PRIMARY KEY (CategoryID)
);

-- Tabel MsProperty
CREATE TABLE MsProperty (
    PropertyID INT(10) NOT NULL AUTO_INCREMENT,
    PropertyName VARCHAR(100) NOT NULL,
    PropertyLocation VARCHAR(100) NOT NULL,
    PropertyPrice INT(10) NOT NULL,
    PropertyDescription VARCHAR(200) NOT NULL,
    PropertyRating DECIMAL(3, 1) NOT NULL,
    CategoryID INT(10) NOT NULL,
    PRIMARY KEY (PropertyID),
    FOREIGN KEY (CategoryID) REFERENCES MsCategory(CategoryID) 
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- Tabel MsTransaction
CREATE TABLE MsTransaction (
    TransactionID INT(10) NOT NULL AUTO_INCREMENT,
    CheckIn DATE NOT NULL,
    CheckOut DATE NOT NULL,
    PaymentTypeID INT(10) NOT NULL,
    UserID INT(10) NOT NULL,
    PropertyID INT(10) NOT NULL,
    TotalPrice INT(10) NOT NULL,
    PRIMARY KEY (TransactionID),
    FOREIGN KEY (PaymentTypeID) REFERENCES MsPaymentType(PaymentTypeID)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (UserID) REFERENCES MsUser(UserID)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (PropertyID) REFERENCES MsProperty(PropertyID)
        ON UPDATE CASCADE ON DELETE CASCADE
);




-- ==========================================
-- DUMMY DATA
-- ==========================================

-- Data MsUser
INSERT INTO MsUser (UserName, UserEmail, UserPassword, UserRole) VALUES 
('Admin Anginbnb', 'admin@anginbnb.com', 'Admin123!', 'Admin'),
('Rio Santoso', 'rio@gmail.com', 'Member123!', 'Member'),
('Teodorus Elvian', 'teodorus@gmail.com', 'Member123!', 'Member');

-- Data MsCategory
INSERT INTO MsCategory (CategoryName) VALUES 
('Hotel'), 
('Apartment'), 
('Villa'), 
('Resort');

-- Data MsPaymentType
INSERT INTO MsPaymentType (PaymentTypeName) VALUES 
('Credit Card'), 
('Debit Card'), 
('Cash'), 
('PayBuddy');

-- Data MsProperty
INSERT INTO MsProperty (PropertyName, PropertyLocation, PropertyPrice, PropertyDescription, PropertyRating, CategoryID) VALUES 
('Grand Plaza Hotel', 'New York City, USA', 450, 'Luxury hotel in the heart of NYC.', 9.0, 1),
('Ocean Breeze Resort', 'Bali, Indonesia', 320, 'Beautiful resort with ocean view.', 8.0, 4),
('Alpine Lodge', 'Swiss Alps, Switzerland', 580, 'Cozy lodge in the mountains.', 10.0, 1),
('Royal Heritage', 'London, UK', 525, 'Historic hotel near Buckingham Palace.', 9.0, 1),
('Desert Oasis', 'Dubai, UAE', 700, 'Luxury stay in the desert.', 9.7, 1),
('Metropolitan Lofts', 'Berlin, Germany', 220, 'Modern apartment in the city center.', 8.0, 2);

-- Data MsTransaction
INSERT INTO MsTransaction (CheckIn, CheckOut, PaymentTypeID, UserID, PropertyID, TotalPrice) VALUES 
('2025-07-12', '2025-07-16', 1, 2, 3, 2320);