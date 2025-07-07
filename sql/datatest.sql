INSERT INTO finance_type_transaction (id, libelle) VALUES
(1, 'créditer'),
(2, 'débiter'),
(3, 'prêter');


INSERT INTO finance_type_compte (libelle) VALUES
('Compte épargne'),
('Compte courant'),
('Compte bloqué');


INSERT INTO finance_client (nom, prenom, date_naissance, contact, date_in) VALUES
('Rakoto', 'Jean', '1990-05-10', '0341234567', '2023-01-01 10:00:00'),
('Rasoa', 'Lalao', '1985-03-22', '0329876543', '2023-02-15 09:30:00'),
('Randria', 'Fanja', '2000-01-15', '0331122334', '2023-03-20 14:45:00');

INSERT INTO finance_compte (date_in, solde, id_client, id_type, numero) VALUES
('2023-01-01 10:00:00', 1500.50, 1, 1, 'CC10001'),       -- Rakoto Jean, compte courant, solde positif
('2023-01-05 11:00:00', 0.00, 1, 2, 'LE10001'),          -- Rakoto Jean, livret épargne, solde nul
('2023-02-15 09:30:00', -250.75, 2, 1, 'CC10002'),       -- Rasoa Lalao, compte courant, solde négatif (découvert)
('2023-02-20 14:00:00', 5200.00, 2, 3, 'CJ10002'),       -- Rasoa Lalao, compte joint, solde élevé
('2023-03-20 14:45:00', 300.00, 3, 2, 'LE10003'),        -- Randria Fanja, livret épargne, solde modéré
('2023-03-22 10:30:00', 0.00, 3, 1, 'CC10003');

--Requete getInteretsByDate
--1 Prendre tous les remboursement
SELECT * FROM remboursement WHERE date_payee BETWEEN date1 AND date2;

--2 Prendre le taux d'interêt 
