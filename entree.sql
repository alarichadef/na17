BEGIN;
-- Creation d'un comité
INSERT INTO comite VALUES ('NA17');

-- Création de personnes
INSERT INTO personne VALUES ('antoine.jeannot@etu.utc.fr', 'Antoine Jeannot', 'NA17');
INSERT INTO personne VALUES ('alaric.hadef@etu.utc.fr', 'Alaric Hadef', 'NA17');
INSERT INTO personne VALUES ('adrien.hubner@etu.utc.fr', 'Adrien Hubner', 'NA17');
INSERT INTO personne VALUES ('paul.jenny@etu.utc.fr', 'Paul Jenny', 'NA17');
INSERT INTO personne VALUES ('taha.arbaoui@utc.fr', 'Taha Arbaoui', 'NA17');

-- Création d'employés de contact
INSERT INTO employe_de_contact VALUES ('antoine.jeannot@etu.utc.fr', '0668030900', 'Monsieur');

-- Création de membres du projet
INSERT INTO membre_du_projet VALUES ('alaric.hadef@etu.utc.fr', 'Etudiant Ingénieur');
INSERT INTO membre_du_projet VALUES ('adrien.hubner@etu.utc.fr', 'Etudiant Ingénieur');
INSERT INTO membre_du_projet VALUES ('paul.jenny@etu.utc.fr', 'Etudiant Ingénieur');
INSERT INTO membre_du_projet VALUES ('taha.arbaoui@utc.fr', 'Assistant Professeur');

-- Création de membres du laboratoire
INSERT INTO membre_du_laboratoire (mail, type, domaine) VALUES ('adrien.hubner@etu.utc.fr', 'IR', 'Réseaux');
INSERT INTO membre_du_laboratoire (mail, type, quotite, etablissement) VALUES ('paul.jenny@etu.utc.fr', 'EC', '30', 'UTC');
INSERT INTO membre_du_laboratoire (mail, type, sujet, debut, fin) VALUES ('taha.arbaoui@utc.fr', 'D', 'Systèmes Complexes', '2015-01-01', '2016-01-01');


-- Création d'une entite Juridique
INSERT INTO entite_juridique (nom, type) VALUES ('Picardie', 'region');
INSERT INTO financeur (nom, contact, debut, fin) VALUES ('Picardie', 'antoine.jeannot@etu.utc.fr', '2015-01-01', '2016-01-01');

-- Création de contributeurs externes
INSERT INTO contributeur_externe VALUES ('alaric.hadef@etu.utc.fr', 'Picardie');
COMMIT;

<<<<<<< HEAD
Insert into organisme_de_projet VALUES ('orga1','2015-01-05',150,'actif');
Insert into organisme_de_projet VALUES ('orga2','2014-04-05',100,'inactif');

Insert into appel_a_projet (lancement,duree,theme,description,publieur,comite) VALUES ('2015-02-03',200,'Vaccin','Vaccin ebola','orga1','NA17');
Insert into appel_a_projet (lancement,duree,theme,description,publieur,comite) VALUES ('2015-04-01',200,'Grippe','Grippe ebola','orga2','NA17');


Insert into proposition_de_projet (reponse,acceptation,appel_a_projet) VALUES ('2015-06-06',true,1);
Insert into proposition_de_projet (reponse,acceptation,appel_a_projet) VALUES ('2015-04-06',false,2);

insert into projet(debut,fin,proposition) VALUES ('2015-01-01','2015-08-01',1);
insert into projet(debut,fin,proposition) VALUES ('2015-07-01','2015-08-01',2);

Insert into membre_projet(9,'paul.jenny@etu.utc.fr');
Insert into membre_projet(10,'alaric.hadef@etu.utc.fr');

Insert into depense (projet,date,montant,demandeur,validateur,etat,financement) values (9,'2015-02-02',200,'paul.jenny@etu.utc.fr',NULL,'En cours','fonctionnement');
Insert into depense (projet,date,montant,demandeur,validateur,etat,financement) values (9,'2015-02-02',200,'adrien.hubner@etu.utc.fr','paul.jenny@etu.utc.fr','Valide','fonctionnement');
=======
>>>>>>> c2f6edd71ced7798d8b4c2b283793b14a37c39e2
