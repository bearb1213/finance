
INSERT INTO finance_type_compte (libelle) VALUES
('Courant'),
('Épargne'),
('Investissement');
INSERT INTO finance_type_transaction (libelle) VALUES
('Dépôt'),
('Retrait'),
('Virement');

INSERT INTO finance_type_pret (duree, taux,assurance) VALUES
(12, 12 ,0.3 ),
(24, 4.0 , 0.5),
(36, 4.5 , 1);

INSERT INTO finance_statut (libelle) VALUES
('En Attente'),
('Valide'),
('Refuse');


INSERT INTO finance_fond(date_in, montant_actuel) VALUES
(NOW(), 1000000.00);

INSERT INTO finance_client (nom , prenom, date_naissance, contact, date_in) VALUES
('Dupont', 'Jean', '1980-01-01', '0123456789', NOW()),
('Martin', 'Claire', '1990-02-02', '0987654321', NOW()),
('Durand', 'Pierre', '1985-03-03', '0147258369', NOW());

INSERT INTO finance_compte (date_in, solde, id_client, id_type) VALUES
(NOW(), 1500.00, 1, 1),
(NOW(), 2500.00, 2, 2),
(NOW(), 3000.00, 3, 1);

update finance_compte set numero = 't9n' where id= 3;
update finance_compte set numero = 'i9n' where id= 1;
update finance_compte set numero = 'i9u' where id= 2;

