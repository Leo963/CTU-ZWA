CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `fname` varchar(255),
  `lname` varchar(255),
  `email` varchar(255),
  `uname` varchar(255),
  `pass` varchar(255),
  `dob` date,
  `role` int,
  `subject` int,
  `class` int
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

CREATE TABLE `usersToSubjects` (
  `user` int,
  `subject` int
);

CREATE TABLE `usersToClasses` (
  `user` int,
  `class` int
);

CREATE TABLE `grades` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `student` int,
  `teacher` int,
  `subject` int,
  `grade` int,
  `title` varchar(255)
);

CREATE TABLE `classes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `subjectId` int,
  `type` int,
  `timeOfDay` time,
  `dayOfWeek` int
);

CREATE TABLE `classTypes` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255)
);

ALTER TABLE `users` ADD FOREIGN KEY (`role`) REFERENCES `roles` (`id`);

ALTER TABLE `classes` ADD FOREIGN KEY (`type`) REFERENCES `classTypes` (`id`);

ALTER TABLE `usersToSubjects` ADD FOREIGN KEY (`user`) REFERENCES `users` (`subject`);

ALTER TABLE `usersToSubjects` ADD FOREIGN KEY (`subject`) REFERENCES `subjects` (`id`);

ALTER TABLE `usersToClasses` ADD FOREIGN KEY (`user`) REFERENCES `users` (`class`);

ALTER TABLE `usersToClasses` ADD FOREIGN KEY (`class`) REFERENCES `classes` (`id`);

ALTER TABLE `grades` ADD FOREIGN KEY (`student`) REFERENCES `users` (`id`);

ALTER TABLE `grades` ADD FOREIGN KEY (`teacher`) REFERENCES `users` (`id`);

ALTER TABLE `grades` ADD FOREIGN KEY (`subject`) REFERENCES `subjects` (`id`);

ALTER TABLE `classes` ADD FOREIGN KEY (`subjectId`) REFERENCES `subjects` (`id`);
