USE contacts_app;

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(255) NOT NULL
);

DESCRIBE contacts;

INSERT INTO contacts (name, phone_number) VALUES ('Juanja', '555-1234');
INSERT INTO contacts (name, phone_number) VALUES ('Bob', '5553424');
INSERT INTO contacts (name, phone_number) VALUES ('Dogo', '555-9876');

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
