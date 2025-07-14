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

