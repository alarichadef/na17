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

