-- Tables et vues de la classe Personne et de ses classes Filles

DROP TABLE Personne CASCADE;
DROP TABLE Employe_de_contact CASCADE;
DROP TABLE Membre_du_projet CASCADE;
DROP TABLE Contributeur_externe CASCADE;
DROP TABLE Membre_du_laboratoire CASCADE;
DROP TABLE Comite CASCADE;
DROP TABLE Entite_juridique CASCADE;
DROP TABLE Financeur CASCADE;
DROP TABLE Organisme_de_projet CASCADE;
DROP TABLE Assoc_Financeur_Organisme CASCADE;
DROP TABLE Proposition_de_projet CASCADE;
DROP TABLE Donne_Label CASCADE;
DROP TABLE Ligne_budgetaire CASCADE;
DROP TABLE Projet CASCADE;
DROP TABLE Validateur CASCADE;
DROP TABLE Demandeur CASCADE;
DROP TABLE Depense CASCADE;
DROP TABLE Appel_a_projet;
DROP TYPE Type_financement;
DROP TYPE Type_Membre_du_laboratoire;
DROP TYPE Etat_type;
DROP VIEW vMembre_du_projet;
DROP VIEW vEnseignant_chercheur;
DROP VIEW vDoctorant;
DROP VIEW vFinanceur;
DROP VIEW vContributeur_externe;
DROP VIEW vIngenieur_de_recherche;
DROP VIEW vEmploye_de_contact;

BEGIN;

CREATE TABLE Comite (nom VARCHAR(30) PRIMARY KEY);

CREATE TABLE Personne(
	mail VARCHAR(30) PRIMARY KEY,
	nom VARCHAR(30),
	comite VARCHAR(30) REFERENCES Comite(nom));

CREATE TABLE Employe_de_contact(
	mail VARCHAR(30) PRIMARY KEY, 
	telephone INTEGER UNIQUE NOT NULL,
	titre VARCHAR(30),
	FOREIGN KEY (mail) REFERENCES Personne(mail));

CREATE VIEW vEmploye_de_contact AS 
	SELECT * FROM Personne P JOIN Employe_de_contact E using(mail);


CREATE TABLE Membre_du_projet(
	mail VARCHAR(30) PRIMARY KEY,
	fonction VARCHAR(30),
	FOREIGN KEY (mail) REFERENCES Personne(mail));

CREATE VIEW vMembre_du_projet AS
	SELECT * FROM Personne P JOIN Membre_du_projet M using(mail);

CREATE TABLE Entite_juridique(
	nom VARCHAR(30) PRIMARY KEY,
	type VARCHAR(30));

CREATE TABLE Contributeur_externe (
	mail VARCHAR(30) PRIMARY KEY,
	entite_juridique VARCHAR(30) REFERENCES Entite_juridique(nom) NOT NULL,
	FOREIGN KEY (mail) REFERENCES Membre_du_projet(mail)
	);

-- AJOUT
CREATE VIEW vContributeur_externe AS 
	SELECT * FROM vMembre_du_projet V JOIN Contributeur_externe C using(mail);
-- FIN AJOUT

CREATE TYPE Type_Membre_du_laboratoire AS ENUM ('IR', 'EC', 'D');

-- MODIF: sujet UNIQUE et pas NOT NULL, sinon clef candidate et les  classes filles IR et EC seraient obligées de le posséder, alors que seule D la détient.

CREATE TABLE Membre_du_laboratoire (
	mail VARCHAR(30) PRIMARY KEY,
	type Type_Membre_du_laboratoire NOT NULL,
	domaine VARCHAR(30),
	quotite INTEGER,
	etablissement VARCHAR(30),
	sujet VARCHAR(30) UNIQUE,
	debut DATE NOT NULL,
	fin DATE,
	FOREIGN KEY (mail) REFERENCES Membre_du_projet(mail));

-- MODIF: vue en fonction de la vue vMembre_du_projet pour récupérer les attributs de Personne, et pas en fonction de Membre_du_projet sinon il manquera des informations.

CREATE VIEW vMembre_du_laboratoire AS
	SELECT * FROM vMembre_du_projet V JOIN Membre_du_laboratoire M using(mail);

CREATE VIEW vIngenieur_de_recherche AS
	SELECT * FROM vMembre_du_laboratoire V
	WHERE V.type = 'IR';

CREATE VIEW vEnseignant_chercheur AS
	SELECT * FROM vMembre_du_laboratoire V
	WHERE V.type = 'EC';

CREATE VIEW vDoctorant AS
	SELECT * FROM vMembre_du_laboratoire V
	WHERE V.type = 'D';	


-- Tables et Vues de la 

CREATE TABLE Financeur(
	nom VARCHAR(30) PRIMARY KEY,
	contact VARCHAR(30) NOT NULL REFERENCES Employe_de_contact(mail),
	debut DATE,
	fin DATE,
	FOREIGN KEY (nom) REFERENCES Entite_juridique);

CREATE VIEW vFinanceur AS
	SELECT * FROM Entite_juridique E JOIN Financeur F using(nom);

CREATE TYPE Etat_type AS ENUM('actif', 'disparu');

CREATE TABLE Organisme_de_projet (
	nom VARCHAR(30) PRIMARY KEY,
	creation DATE,
	duree INTEGER, 
	etat Etat_type);

CREATE TABLE Assoc_Financeur_Organisme(
	financeur VARCHAR(30) REFERENCES Financeur,
	organisme VARCHAR(30) REFERENCES Organisme_de_projet,
	PRIMARY KEY (financeur, organisme));

-- MODIF AJOUT DE id EN PRIMARY KEY
CREATE TABLE Appel_a_projet (
	id SERIAL PRIMARY KEY,
	lancement DATE NOT NULL,
	duree DATE NOT NULL,
	theme VARCHAR(30),
	description VARCHAR(100),
	publieur VARCHAR(30) NOT NULL REFERENCES Organisme_de_projet(nom),
	comite VARCHAR(30) NOT NULL REFERENCES Comite(nom),
	CONSTRAINT u_contraint UNIQUE (lancement, duree));

-- modif: BUDGET SUPPRIMEE, GREFFE DE LIGNES BUDGETAIRES DIRECTEMENT A PROPOSITION DE PROJET 

CREATE TABLE Proposition_de_projet(
	id SERIAL PRIMARY KEY,
	reponse DATE,
	acceptation BOOLEAN,
	appel_a_projet INTEGER REFERENCES Appel_a_projet(id));

CREATE TABLE Donne_Label(
	entite_juridique VARCHAR(30) REFERENCES Entite_juridique(nom),
	proposition_de_projet INTEGER REFERENCES Proposition_de_projet(id),
	label VARCHAR(30) NOT NULL,
	PRIMARY KEY (entite_juridique, proposition_de_projet));


CREATE TYPE Type_financement AS ENUM('fonctionnement', 'materiel');

-- MODIF: REF vers le projet à la place du budget

CREATE TABLE Ligne_budgetaire (
	projet INTEGER REFERENCES Proposition_de_projet(id),
	montant DECIMAL NOT NULL, 
	objet_global VARCHAR(30) NOT NULL,
	financement Type_financement NOT NULL,
	PRIMARY KEY (projet, montant, objet_global, financement));


CREATE TABLE Projet(
	id SERIAL PRIMARY KEY, 
	debut DATE,
	fin DATE,
	proposition INTEGER UNIQUE NOT NULL REFERENCES Proposition_de_projet(id));

-- MODIF: Projet est composé de dépenses

CREATE TABLE Depense(
	projet INTEGER PRIMARY KEY REFERENCES Projet(id),
	date DATE NOT NULL,
	montant DECIMAL NOT NULL,
	financement Type_financement NOT NULL);

-- AJOUT: 

CREATE TABLE Validateur(
	projet INTEGER REFERENCES Depense(projet),
	membre VARCHAR(30) REFERENCES Membre_du_projet(mail),
	PRIMARY KEY (projet, membre));

CREATE TABLE Demandeur(
	projet INTEGER REFERENCES Depense(projet),
	membre VARCHAR(30) REFERENCES Membre_du_projet(mail),
	PRIMARY KEY (projet, membre));

 COMMIT;
