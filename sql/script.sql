DROP DATABASE IF EXISTS ETU003298;
CREATE DATABASE ETU003298;
USE ETU003298;

CREATE TABLE finance_utilisateur(
   id INT AUTO_INCREMENT,
   nom VARCHAR(255),
   prenom VARCHAR(255),
   email VARCHAR(255),
   numero VARCHAR(12),
   PRIMARY KEY(id)
);

CREATE TABLE finance_client(
   id INT AUTO_INCREMENT,
   nom VARCHAR(255),
   prenom VARCHAR(255),
   date_naissance DATE,
   contact VARCHAR(255),
   date_in DATETIME,
   PRIMARY KEY(id)
);

CREATE TABLE finance_type_compte(
   id INT AUTO_INCREMENT,
   libelle VARCHAR(50),
   PRIMARY KEY(id)
);

CREATE TABLE finance_type_transaction(
   id INT AUTO_INCREMENT,
   libelle VARCHAR(50),
   PRIMARY KEY(id)
);

CREATE TABLE finance_type_pret(
   id INT AUTO_INCREMENT,
   duree INT,
   taux DECIMAL(4,2),
   PRIMARY KEY(id)
);

CREATE TABLE finance_fond(
   id INT AUTO_INCREMENT,
   date_in DATETIME,
   montant_actuel DECIMAL(19,2),
   PRIMARY KEY(id)
);

CREATE TABLE finance_compte(
   id INT AUTO_INCREMENT,
   date_in DATETIME,
   solde DECIMAL(15,2),
   id_client INT NOT NULL,
   id_type INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_client) REFERENCES finance_client(id),
   FOREIGN KEY(id_type) REFERENCES finance_type_compte(id)
);

CREATE TABLE finance_transaction(
   id INT AUTO_INCREMENT,
   montant DECIMAL(15,2),
   date_in DATETIME,
   id_compte INT NOT NULL,
   id_type INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_compte) REFERENCES finance_compte(id),
   FOREIGN KEY(id_type) REFERENCES finance_type_transaction(id)
);

CREATE TABLE finance_pret(
   id INT AUTO_INCREMENT,
   montant DECIMAL(15,2),
   date_in DATETIME,
   motif TEXT,
   id_compte INT NOT NULL,
   id_type INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_compte) REFERENCES finance_compte(id),
   FOREIGN KEY(id_type) REFERENCES finance_type_pret(id)
);

CREATE TABLE finance_remboursement(
   id INT AUTO_INCREMENT,
   montant DECIMAL(15,2),
   date_in DATETIME,
   reste DECIMAL(15,2),
   id_pret INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(id_pret) REFERENCES finance_pret(id)
);
