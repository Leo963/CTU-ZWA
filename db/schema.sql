DROP DATABASE IF EXISTS kaufmlu1;
CREATE DATABASE IF NOT EXISTS kaufmlu1;

USE kaufmlu1;

CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255),
  `uname` varchar(255) NOT NULL,
  `pass` varchar(255),
  `dob` date NOT NULL,
  `role` int NOT NULL
);

CREATE TABLE `roles` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

CREATE TABLE `subjects` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `code` varchar(255)
);

CREATE TABLE `subjectDetails` (
  `id` int UNIQUE,
  `anotation` TEXT,
  `description` TEXT,
  `length` int,
  `lectures` int,
  `practicals` int,
  `labs` int
);

CREATE TABLE `usersToSubjects` (
  `user` int,
  `subject` int
);

CREATE TABLE `usersToClasses` (
  `user` int,
  `class` int
);

CREATE TABLE `classes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `subjectId` int,
  `type` int,
  `timeOfDay` time,
  `dayOfWeek` int,
  `location` varchar(15),
  `teacher` int
);

CREATE TABLE `classTypes` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255)
);



ALTER TABLE `users` ADD FOREIGN KEY (`role`) REFERENCES `roles` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

ALTER TABLE `classes` ADD FOREIGN KEY (`type`) REFERENCES `classTypes` (`id`)
    ON UPDATE CASCADE
    ON DELETE SET NULL;

ALTER TABLE `usersToSubjects` ADD FOREIGN KEY (`user`) REFERENCES `users` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

ALTER TABLE `usersToSubjects` ADD FOREIGN KEY (`subject`) REFERENCES `subjects` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

ALTER TABLE `usersToClasses` ADD FOREIGN KEY (`user`) REFERENCES `users` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

ALTER TABLE `usersToClasses` ADD FOREIGN KEY (`class`) REFERENCES `classes` (`id`)
    ON UPDATE CASCADE
    ON DELETE SET NULL;

ALTER TABLE `classes` ADD FOREIGN KEY (`subjectId`) REFERENCES `subjects` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

ALTER TABLE `subjectDetails` ADD FOREIGN KEY (`id`) REFERENCES `subjects` (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE `classes` ADD FOREIGN KEY (`teacher`) REFERENCES `users` (id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

ALTER TABLE `usersToClasses` ADD CONSTRAINT `uniqueCombo` UNIQUE(`user`,`class`);

CREATE TRIGGER `createDetail` AFTER INSERT ON subjects
    FOR EACH ROW INSERT INTO subjectDetails (id) VALUES (NEW.id);