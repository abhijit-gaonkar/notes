CREATE USER 'admin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'yourpass';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost' WITH GRANT OPTION;
CREATE USER 'admin'@'%' IDENTIFIED WITH mysql_native_password BY 'yourpass';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%' WITH GRANT OPTION;
#
CREATE DATABASE IF NOT EXISTS `yourdb` COLLATE 'utf8_general_ci' ;
GRANT ALL ON `yourdb`.* TO 'admin'@'%' ;
FLUSH PRIVILEGES ;

drop database notes_app;
create database notes_app;
use notes_app;

CREATE TABLE user (
  `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  `created` TIMESTAMP DEFAULT now(),
  `updated` TIMESTAMP DEFAULT now() ON UPDATE now()
);

CREATE TABLE notes (
  `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title varchar(50) NOT NULL,
  content varchar(1000) NOT NULL,
  `created` TIMESTAMP DEFAULT now(),
  `updated` TIMESTAMP DEFAULT now() ON UPDATE now(),
  user_id INTEGER,
  INDEX par_ind (user_id),
  FOREIGN KEY (user_id)
  REFERENCES user(id)
  ON DELETE CASCADE
);

ALTER TABLE user
ADD UNIQUE (email);

insert into user (email,password) values ('test@test.com','test');
insert into user (email,password) values ('test@test1.com','test');