DROP DATABASE IF EXISTS kaufmlu1;
CREATE DATABASE IF NOT EXISTS kaufmlu1;

USE kaufmlu1;

CREATE TABLE `users`
(
    `id`    int PRIMARY KEY AUTO_INCREMENT,
    `fname` varchar(255) NOT NULL,
    `lname` varchar(255) NOT NULL,
    `email` varchar(255),
    `uname` varchar(255) NOT NULL,
    `pass`  varchar(255),
    `dob`   date         NOT NULL,
    `role`  int          NOT NULL
);

CREATE TABLE `roles`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255)
);

CREATE TABLE `subjects`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255),
    `code` varchar(255)
);

CREATE TABLE `subjectDetails`
(
    `id`          int PRIMARY KEY,
    `anotation`   TEXT,
    `description` TEXT,
    `length`      int default(14),
    `lectures`    int default(0),
    `practicals`  int default(0),
    `labs`        int default(0)
);

CREATE TABLE `usersToSubjects`
(
    `user`    int,
    `subject` int
);

CREATE TABLE `usersToClasses`
(
    `user`  int,
    `class` int
);

CREATE TABLE `classes`
(
    `id`        int PRIMARY KEY AUTO_INCREMENT,
    `subjectId` int,
    `type`      int,
    `timeOfDay` time,
    `dayOfWeek` int,
    `location`  varchar(15),
    `teacher`   int
);

CREATE TABLE `classTypes`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255)
);



ALTER TABLE `users`
    ADD FOREIGN KEY (`role`) REFERENCES `roles` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT;

ALTER TABLE `classes`
    ADD FOREIGN KEY (`type`) REFERENCES `classTypes` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL;

ALTER TABLE `usersToSubjects`
    ADD FOREIGN KEY (`user`) REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT;

ALTER TABLE `usersToSubjects`
    ADD FOREIGN KEY (`subject`) REFERENCES `subjects` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT;

ALTER TABLE `usersToClasses`
    ADD FOREIGN KEY (`user`) REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT;

ALTER TABLE `usersToClasses`
    ADD FOREIGN KEY (`class`) REFERENCES `classes` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE;

ALTER TABLE `classes`
    ADD FOREIGN KEY (`subjectId`) REFERENCES `subjects` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT;

ALTER TABLE `subjectDetails`
    ADD FOREIGN KEY (`id`) REFERENCES `subjects` (id)
        ON UPDATE CASCADE
        ON DELETE CASCADE;

ALTER TABLE `classes`
    ADD FOREIGN KEY (`teacher`) REFERENCES `users` (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT;

ALTER TABLE `usersToClasses`
    ADD CONSTRAINT `uniqueCombo` UNIQUE (`user`, `class`);

CREATE TRIGGER `createDetail`
    AFTER INSERT
    ON subjects
    FOR EACH ROW INSERT INTO subjectDetails (id)
                 VALUES (NEW.id);

CREATE TRIGGER `updateDetails`
    AFTER INSERT
    ON classes
    FOR EACH ROW
BEGIN
    UPDATE subjectDetails
    SET lectures   = CASE
                         WHEN NEW.type = 1 THEN lectures + 1
                         ELSE lectures
        END
      , practicals = CASE
                         WHEN NEW.type = 2 THEN practicals + 1
                         ELSE practicals
        END
      , labs       = CASE
                         WHEN NEW.type = 3 THEN labs + 1
                         ELSE labs
        END
    WHERE id = NEW.subjectId;
END;

CREATE TRIGGER `updateOnDeleteDetails`
    AFTER DELETE
    ON classes
    FOR EACH ROW
BEGIN
    UPDATE subjectDetails
    SET lectures   = CASE
                         WHEN OLD.type = 1 THEN lectures - 1
                         ELSE lectures
        END
      , practicals = CASE
                         WHEN OLD.type = 2 THEN practicals - 1
                         ELSE practicals
        END
      , labs       = CASE
                         WHEN OLD.type = 3 THEN labs - 1
                         ELSE labs
        END
    WHERE id = OLD.subjectId;
END;