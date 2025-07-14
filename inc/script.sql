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

CREATE or REPLACE VIEW view_objet_detail AS
SELECT o.id_objet, o.nom_objet, c.nom_categorie, m.nom AS nom_membre, m.email, i.nom_image
FROM obj_objet o
JOIN obj_categorie_objet c ON o.id_categorie = c.id_categorie
JOIN obj_membre m ON o.id_membre = m.id_membre
LEFT JOIN obj_images_objet i ON o.id_objet = i.id_objet;

