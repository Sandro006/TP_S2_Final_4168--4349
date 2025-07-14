-- SQL schema for the database
CREATE DATABASE Obj_emp;
use Obj_emp;
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
('James bond', '1990-05-15', 'M', 'alice.dupont@example.com', 'Paris', 'password1', 'alice.jpg'),
('Bob Martin', '1985-08-22', 'M', 'bob.martin@example.com', 'Lyon', 'password2', 'bob.jpg'),
('Claire Ement', '1992-12-03', 'F', 'claire.bernard@example.com', 'Marseille', 'password3', 'claire.jpg'),
('Jean Mange', '1988-03-10', 'M', 'david.moreau@example.com', 'Toulouse', 'password4', 'david.jpg');

INSERT INTO obj_categorie_objet (nom_categorie) VALUES
('esthétique'),
('bricolage'),
('mécanique'),
('cuisine');

-- Insert 10 objects per member (40 objects total), distributed across categories
INSERT INTO obj_objet (nom_objet, id_categorie, id_membre) VALUES
('Objet 1', 1, 1),
('Objet 2', 2, 1),
('Objet 3', 3, 1),
('Objet 4', 4, 1),
('Objet 5', 1, 1),
('Objet 6', 2, 1),
('Objet 7', 3, 1),
('Objet 8', 4, 1),
('Objet 9', 1, 1),
('Objet 10', 2, 1),

('Objet 11', 1, 2),
('Objet 12', 2, 2),
('Objet 13', 3, 2),
('Objet 14', 4, 2),
('Objet 15', 1, 2),
('Objet 16', 2, 2),
('Objet 17', 3, 2),
('Objet 18', 4, 2),
('Objet 19', 1, 2),
('Objet 20', 2, 2),

('Objet 21', 1, 3),
('Objet 22', 2, 3),
('Objet 23', 3, 3),
('Objet 24', 4, 3),
('Objet 25', 1, 3),
('Objet 26', 2, 3),
('Objet 27', 3, 3),
('Objet 28', 4, 3),
('Objet 29', 1, 3),
('Objet 30', 2, 3),

('Objet 31', 1, 4),
('Objet 32', 2, 4),
('Objet 33', 3, 4),
('Objet 34', 4, 4),
('Objet 35', 1, 4),
('Objet 36', 2, 4),
('Objet 37', 3, 4),
('Objet 38', 4, 4),
('Objet 39', 1, 4),
('Objet 40', 2, 4);

-- Insert 10 emprunts for testing date_retour display
INSERT INTO obj_emprunt (id_objet, id_membre, date_emprunt, date_retour) VALUES
(1, 2, '2023-01-01', '2023-01-10'),
(2, 3, '2023-01-05', '2023-01-15'),
(3, 4, '2023-01-10', NULL),
(4, 1, '2023-01-12', '2023-01-20'),
(5, 2, '2023-01-15', NULL),
(6, 3, '2023-01-18', '2023-01-25'),
(7, 4, '2023-01-20', NULL),
(8, 1, '2023-01-22', '2023-01-30'),
(9, 2, '2023-01-25', NULL),
(10, 3, '2023-01-28', '2023-02-05');

-- View for objects with category and member info (Part 2)
CREATE OR REPLACE VIEW view_objet_detail AS
SELECT o.id_objet, o.nom_objet, c.nom_categorie, m.nom AS nom_membre, m.email
FROM obj_objet o
JOIN obj_categorie_objet c ON o.id_categorie = c.id_categorie
JOIN obj_membre m ON o.id_membre = m.id_membre;

-- View for emprunts with object and member info (Part 3)
CREATE OR REPLACE VIEW view_emprunt_detail AS
SELECT e.id_emprunt, o.nom_objet, m.nom AS nom_membre_emprunteur, e.date_emprunt, e.date_retour
FROM obj_emprunt e
JOIN obj_objet o ON e.id_objet = o.id_objet
JOIN obj_membre m ON e.id_membre = m.id_membre;

