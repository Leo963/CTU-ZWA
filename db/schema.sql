DROP DATABASE IF EXISTS kaufmlu1;
CREATE DATABASE IF NOT EXISTS kaufmlu1 COLLATE utf8_czech_ci;

USE kaufmlu1;

CREATE TABLE classtypes
(
    id   int auto_increment
        primary KEY,
    name varchar(255) NULL
);

CREATE TABLE roles
(
    id   int auto_increment
        primary KEY,
    name varchar(255) NULL
);

CREATE TABLE subjects
(
    id   int auto_increment
        primary KEY,
    name varchar(255) NULL,
    code varchar(255) NULL
);

CREATE TABLE subjectdetails
(
    id          int            NOT NULL
                    primary KEY,
    anotation   text           NULL,
    description text           NULL,
    length      int default 14 NULL,
    lectures    int default 0  NULL,
    practicals  int default 0  NULL,
    labs        int default 0  NULL,
    CONSTRAINT subjectdetails_ibfk_1
        FOREIGN KEY (id) references subjects (id)
            ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE users
(
    id    int auto_increment
        primary KEY,
    fname varchar(255) NOT NULL,
    lname varchar(255) NOT NULL,
    email varchar(255) NULL,
    uname varchar(255) NOT NULL,
    pass  varchar(255) NULL,
    dob   date         NOT NULL,
    role  int          NOT NULL,
    CONSTRAINT users_ibfk_1
        FOREIGN KEY (role) references roles (id)
            ON UPDATE CASCADE
);

CREATE TABLE classes
(
    id        int auto_increment
        primary KEY,
    subjectId int         NULL,
    type      int         NULL,
    timeOfDay time        NULL,
    dayOfWeek int         NULL,
    location  varchar(15) NULL,
    teacher   int         NULL,
    CONSTRAINT classes_ibfk_1
        FOREIGN KEY (type) references classtypes (id)
            ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT classes_ibfk_2
        FOREIGN KEY (subjectId) references subjects (id)
            ON UPDATE CASCADE,
    CONSTRAINT classes_ibfk_3
        FOREIGN KEY (teacher) references users (id)
            ON UPDATE CASCADE
);

CREATE TABLE userstoclasses
(
    user  int NULL,
    class int NULL,
    CONSTRAINT uniqueCombo
        unique (user, class),
    CONSTRAINT userstoclasses_ibfk_1
        FOREIGN KEY (user) references users (id)
            ON UPDATE CASCADE,
    CONSTRAINT userstoclasses_ibfk_2
        FOREIGN KEY (class) references classes (id)
            ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE INDEX subjectId
    ON classes (subjectId);

CREATE INDEX teacher
    ON classes (teacher);

CREATE INDEX type
    ON classes (type);

CREATE INDEX role
    ON users (role);

CREATE INDEX class
    ON userstoclasses (class);

CREATE trigger CREATEDetail
    AFTER INSERT
    ON subjects
    FOR EACH ROW
    INSERT INTO subjectdetails (id)
    VALUES (NEW.id);

CREATE trigger updateDetails
    AFTER INSERT
    ON classes
    FOR EACH ROW
    UPDATE subjectdetails
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

CREATE trigger updateOnDeleteDetails
    AFTER DELETE
    ON classes
    FOR EACH ROW
    UPDATE subjectdetails
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