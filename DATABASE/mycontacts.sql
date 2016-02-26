
CREATE DATABASE mycontacts;
use mycontacts;

CREATE TABLE users
(
	user_id int AUTO_INCREMENT PRIMARY KEY,
	username varchar(32) NOT NULL,
	password varchar(255) NOT NULL,
	name varchar(64) NOT NULL,
	email varchar(255) NOT NULL,
	UNIQUE(username, email)
);
CREATE TABLE contacts
(
	contact_id int AUTO_INCREMENT ,
	user_id int NOT NULL,
	time_added timestamp NOT NULL default CURRENT_TIMESTAMP,
	name varchar(128) NOT NULL,
	phone_number varchar(128) NOT NULL,
	email varchar(128) NOT NULL,
	contact_public bit NOT NULL default 0,
	PRIMARY KEY (contact_id),
	CONSTRAINT fk_contacts_user_id FOREIGN KEY (user_id) REFERENCES users(user_id)
		ON DELETE RESTRICT 
		ON UPDATE CASCADE
);


INSERT INTO `mycontacts`.`users` (`user_id`, `username`, `password`, `name`, `email`) VALUES (NULL, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'email@email.com');


















