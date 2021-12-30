INSERT INTO kaufmlu1.roles (id,name) VALUES (1,'administrator');
INSERT INTO kaufmlu1.roles (id,name) VALUES (2,'teacher');
INSERT INTO kaufmlu1.roles (id,name) VALUES (3,'student');
INSERT INTO kaufmlu1.roles (id,name) VALUES (4,'new user');

INSERT INTO kaufmlu1.users (id, fname, lname, email, uname, pass, dob, role) VALUES (1, 'Lukáš', 'Kaufmann', null, 'admin1', '$2y$10$qqcwN707A1.Y7YNGVmUKqulzwLjPrd7dPO6z6jOXfQOqkxlFXCwEy', '2001-07-09', 1);
INSERT INTO kaufmlu1.users (id, fname, lname, email, uname, pass, dob, role) VALUES (2, 'Testovaci', 'Ucitel', null, 'TestTeacher', '$2y$10$rEF3mkKYa6WYSzkbmV6cXufIIlbLsS3H/GnMLXruSqF1fsy5Gwl2G', '1980-10-10', 2);
INSERT INTO kaufmlu1.users (id, fname, lname, email, uname, pass, dob, role) VALUES (3, 'Testovaci', 'Student', null, 'TestStudent', '$2y$10$kDR1URvCYC6UcBx8nYUrIezuiMp7j23kQa0jAp.unIHV69aHkmn4S', '2005-10-10', 3);

INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Webové aplikace','B01-WA');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Počítačové sítě','B01-PS');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Programování v C','B01-PC');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Antická literatura','A02-AL');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Právo','A02-PR');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('IT Právo','A02-PIT');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Databáse','B01-DB');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Programování v Java','B01-PJ');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Projekt Programování','B02-PP');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Umělá inteligence','B02-AI');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Návrh uživatelského prostředí','B02-UX');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Telekomunikace','B02-TK');
INSERT INTO kaufmlu1.subjects (name, code) VALUES ('Taktické plánování','A02-TP');
