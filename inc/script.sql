-- Create view for objects with category and member info including image
CREATE DATABASE Obj_emp;
USE Obj_emp;
CREATE TABLE obj_membre (
    id_membre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    genre ENUM('M', 'F') NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    ville VARCHAR(100),
    mdp VARCHAR(255) NOT NULL,
    image_profil VARCHAR(255)
);

CREATE TABLE obj_categorie_objet (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(100) NOT NULL
);

CREATE TABLE obj_objet (
    id_objet INT AUTO_INCREMENT PRIMARY KEY,
    nom_objet VARCHAR(255) NOT NULL,
    id_categorie INT NOT NULL,
    id_membre INT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES obj_categorie_objet(id_categorie),
    FOREIGN KEY (id_membre) REFERENCES obj_membre(id_membre)
);

CREATE TABLE obj_images_objet (
    id_image INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT NOT NULL,
    nom_image VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_objet) REFERENCES obj_objet(id_objet)
);

CREATE TABLE obj_emprunt (
    id_emprunt INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT NOT NULL,
    id_membre INT NOT NULL,
    date_emprunt DATE NOT NULL,
    date_retour DATE,
    FOREIGN KEY (id_objet) REFERENCES obj_objet(id_objet),
    FOREIGN KEY (id_membre) REFERENCES obj_membre(id_membre)
);

INSERT INTO obj_membre (nom, date_naissance, genre, email, ville, mdp, image_profil) VALUES
('James bond', '1990-05-15', 'M', 'alice.dupont@example.com', 'Paris', 'password1', '../assets/images/james.jpg'),
('Bob Martin', '1985-08-22', 'M', 'bob.martin@example.com', 'Lyon', 'password2', '../assets/images/bob.jpg'),
('Claire Ement', '1992-12-03', 'F', 'claire.bernard@example.com', 'Marseille', 'password3', '../assets/images/claire.jpg'),
('Jean Mange', '1988-03-10', 'M', 'david.moreau@example.com', 'Toulouse', 'password4', '../assets/images/david.jpg');

INSERT INTO obj_categorie_objet (nom_categorie) VALUES
('esthétique'),
('bricolage'),
('mécanique'),
('cuisine');

INSERT INTO obj_objet (nom_objet, id_categorie, id_membre) VALUES
('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 1),
('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 1),
('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 1),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 1),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 1),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 1),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 1),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 1),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 1),
('cuisine', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'cuisine'), 1),

('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 2),
('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 2),
('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 2),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 2),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 2),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 2),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 2),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 2),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 2),
('cuisine', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'cuisine'), 2),

('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 3),
('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 3),
('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 3),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 3),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 3),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 3),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 3),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 3),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 3),
('cuisine', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'cuisine'), 3),

('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 4),
('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 4),
('mecanique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'mécanique'), 4),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 4),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 4),
('bricolage', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'bricolage'), 4),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 4),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 4),
('esthetique', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'esthétique'), 4),
('cuisine', (SELECT id_categorie FROM obj_categorie_objet WHERE nom_categorie = 'cuisine'), 4);

INSERT INTO obj_images_objet (id_objet, nom_image) VALUES
(1, '../assets/images/mecanique.png'),
(2, '../assets/images/mecanique.png'),
(3, '../assets/images/mecanique.png'),
(4, '../assets/images/bricolage.png'),
(5, '../assets/images/bricolage.png'),
(6, '../assets/images/bricolage.png'),
(7, '../assets/images/esthetique.png'),
(8, '../assets/images/esthetique.png'),
(9, '../assets/images/esthetique.png'),
(10, '../assets/images/cuisine.png'),

(11, '../assets/images/mecanique.png'),
(12, '../assets/images/mecanique.png'),
(13, '../assets/images/mecanique.png'),
(14, '../assets/images/bricolage.png'),
(15, '../assets/images/bricolage.png'),
(16, '../assets/images/bricolage.png'),
(17, '../assets/images/esthetique.png'),
(18, '../assets/images/esthetique.png'),
(19, '../assets/images/esthetique.png'),
(20, '../assets/images/cuisine.png'),

(21, '../assets/images/mecanique.png'),
(22, '../assets/images/mecanique.png'),
(23, '../assets/images/mecanique.png'),
(24, '../assets/images/bricolage.png'),
(25, '../assets/images/bricolage.png'),
(26, '../assets/images/bricolage.png'),
(27, '../assets/images/esthetique.png'),
(28, '../assets/images/esthetique.png'),
(29, '../assets/images/esthetique.png'),
(30, '../assets/images/cuisine.png'),

(31, '../assets/images/mecanique.png'),
(32, '../assets/images/mecanique.png'),
(33, '../assets/images/mecanique.png'),
(34, '../assets/images/bricolage.png'),
(35, '../assets/images/bricolage.png'),
(36, '../assets/images/bricolage.png'),
(37, '../assets/images/esthetique.png'),
(38, '../assets/images/esthetique.png'),
(39, '../assets/images/esthetique.png'),
(40, '../assets/images/cuisine.png');


INSERT INTO obj_emprunt (id_objet, id_membre, date_emprunt, date_retour) VALUES
(1, 2, '2023-01-10', '2023-01-20'),
(1, 3, '2023-02-05', '2023-02-15'),
(2, 1, '2023-03-01', NULL),
(2, 4, '2023-04-10', '2023-04-20'),
(3, 2, '2023-05-05', '2023-05-15'),
(3, 3, '2023-06-01', NULL),
(4, 1, '2023-01-12', '2023-01-22'),
(4, 4, '2023-02-15', '2023-02-25'),
(5, 2, '2023-03-10', NULL),
(5, 3, '2023-04-05', '2023-04-15'),
(6, 1, '2023-05-01', '2023-05-10'),
(6, 4, '2023-06-10', NULL),
(7, 2, '2023-01-20', '2023-01-30'),
(7, 3, '2023-02-25', NULL),
(8, 1, '2023-03-15', '2023-03-25'),
(8, 4, '2023-04-20', '2023-04-30'),
(9, 2, '2023-05-10', NULL),
(9, 3, '2023-06-05', '2023-06-15'),
(10, 1, '2023-01-05', '2023-01-15'),
(10, 4, '2023-02-10', NULL),
(11, 2, '2023-03-12', '2023-03-22'),
(11, 3, '2023-04-15', '2023-04-25'),
(12, 1, '2023-05-20', NULL),
(12, 4, '2023-06-25', '2023-07-05'),
(13, 2, '2023-01-18', '2023-01-28'),
(13, 3, '2023-02-22', NULL),
(14, 1, '2023-03-30', '2023-04-09'),
(14, 4, '2023-04-15', '2023-04-25'),
(15, 2, '2023-05-05', NULL),
(15, 3, '2023-06-10', '2023-06-20'),
(16, 1, '2023-01-08', '2023-01-18'),
(16, 4, '2023-02-12', NULL),
(17, 2, '2023-03-17', '2023-03-27'),
(17, 3, '2023-04-22', '2023-05-02'),
(18, 1, '2023-05-25', NULL),
(18, 4, '2023-06-30', '2023-07-10'),
(19, 2, '2023-01-14', '2023-01-24'),
(19, 3, '2023-02-18', NULL),
(20, 1, '2023-03-23', '2023-04-02'),
(20, 4, '2023-04-28', '2023-05-08'),
(21, 2, '2023-05-12', NULL),
(21, 3, '2023-06-17', '2023-06-27'),
(22, 1, '2023-01-07', '2023-01-17'),
(22, 4, '2023-02-11', NULL),
(23, 2, '2023-03-16', '2023-03-26'),
(23, 3, '2023-04-21', '2023-05-01'),
(24, 1, '2023-05-24', NULL),
(24, 4, '2023-06-29', '2023-07-09'),
(25, 2, '2023-01-13', '2023-01-23'),
(25, 3, '2023-02-17', NULL),
(26, 1, '2023-03-22', '2023-04-01'),
(26, 4, '2023-04-27', '2023-05-07'),
(27, 2, '2023-05-11', NULL),
(27, 3, '2023-06-16', '2023-06-26'),
(28, 1, '2023-01-06', '2023-01-16'),
(28, 4, '2023-02-10', NULL),
(29, 2, '2023-03-15', '2023-03-25'),
(29, 3, '2023-04-20', '2023-04-30'),
(30, 1, '2023-05-23', NULL),
(30, 4, '2023-06-28', '2023-07-08'),
(31, 2, '2023-01-15', '2023-01-25'),
(31, 3, '2023-02-20', NULL),
(32, 1, '2023-03-18', '2023-03-28'),
(32, 4, '2023-04-23', '2023-05-03'),
(33, 2, '2023-05-26', NULL),
(33, 3, '2023-06-30', '2023-07-10'),
(34, 1, '2023-01-11', '2023-01-21'),
(34, 4, '2023-02-15', NULL),
(35, 2, '2023-03-20', '2023-03-30'),
(35, 3, '2023-04-25', '2023-05-05'),
(36, 1, '2023-05-27', NULL),
(36, 4, '2023-06-29', '2023-07-09'),
(37, 2, '2023-01-09', '2023-01-19'),
(37, 3, '2023-02-14', NULL),
(38, 1, '2023-03-19', '2023-03-29'),
(38, 4, '2023-04-24', '2023-05-04'),
(39, 2, '2023-05-28', NULL),
(39, 3, '2023-06-30', '2023-07-10'),
(40, 1, '2023-01-10', '2023-01-20'),
(40, 4, '2023-02-15', NULL);

CREATE or REPLACE VIEW view_objet_detail AS
SELECT o.id_objet, o.nom_objet, c.nom_categorie, m.nom AS nom_membre, m.email, i.nom_image
FROM obj_objet o
JOIN obj_categorie_objet c ON o.id_categorie = c.id_categorie
JOIN obj_membre m ON o.id_membre = m.id_membre
LEFT JOIN obj_images_objet i ON o.id_objet = i.id_objet;
CREATE or REPLACE VIEW view_objet_prop_detail AS
SELECT o.id_objet, o.nom_objet, c.nom_categorie, m.nom AS membre_nom, m.email AS membre_email, m.image_profil AS membre_image, i.nom_image AS objet_image
        FROM obj_objet o
        JOIN obj_categorie_objet c ON o.id_categorie = c.id_categorie
        JOIN obj_membre m ON o.id_membre = m.id_membre
        LEFT JOIN obj_images_objet i ON o.id_objet = i.id_objet;