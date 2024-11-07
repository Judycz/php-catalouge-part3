
 
CREATE TABLE `cocktail_users` (
cc_id INT(11) NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(25) NOT NULL,
    last_name VARCHAR(25) NOT NULL,
    user_name VARCHAR(25) NOT NULL,
    email VARCHAR(255) NOT NULL,
    pswd VARCHAR(85) NOT NULL,
    PRIMARY KEY (`cc_id`)
);

INSERT INTO cocktail_users (first_name, last_name, user_name, email, pswd) VALUES 
('Admin', 'Admin', 'Admin', 'admin@nait.ca', '$2y$10$18RfFHZ2GrCSLJrsCVZXku64yQ1mikXBRki4UjqkDnrIQBR04NNhS')
-- Password1!

CREATE TABLE cocktails (
`cid` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename` VARCHAR(255) ,
  `uploaded_on` datetime NOT NULL,
  cocktail_name VARCHAR(255),
  origin_place VARCHAR(255),
  invention_year INT(255),
  base_spirit VARCHAR(255),
  mixer VARCHAR(255),
  'serving_style' VARCHAR(20),
  flavour VARCHAR(255),
  story TEXT
);


/*CREATE TABLE `lab06_cocktail_prep` (
`image_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
`title` VARCHAR(50) NOT NULL,
`flavour` VARCHAR(255) NULL,
`filename` VARCHAR(255) NOT NULL,
`uploaded_on` datetime NOT NULL,
PRIMARY KEY(`image_id`)
);
*/