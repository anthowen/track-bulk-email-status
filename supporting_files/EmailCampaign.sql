-- Email Campaign table

CREATE TABLE email_test (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    campaignID int(10),
    subscriptionID int(10),
    timestamp TIMESTAMP DEFAULT NOW(),
    PRIMARY KEY (id)
);

