<?php
require_once __DIR__ . '/../db.php';

class Transaction
{
    // Créditer un compte : ajouter un montant
    public static function crediter($id_compte, $montant)
    {
        if ($montant <= 0) {
            throw new InvalidArgumentException("Le montant doit être positif.");
        }

        $db = getDB();

        $date_in = date('Y-m-d H:i:s');

        try {
            $db->beginTransaction();

            $stmt = $db->prepare("INSERT INTO finance_transaction (montant, date_in, id_compte, id_type) VALUES (?, ?, ?, 1)");
            $stmt->execute([$montant, $date_in, $id_compte]);

            $stmt = $db->prepare("UPDATE finance_compte SET solde = solde + ? WHERE id = ?");
            $stmt->execute([$montant, $id_compte]);

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e; 
        }
    }


    public static function debiter($id_compte, $montant)
    {
        if ($montant <= 0) {
            throw new InvalidArgumentException("Le montant doit être positif.");
        }

        $db = getDB();

        $date_in = date('Y-m-d H:i:s');

        try {
            $db->beginTransaction();

            $stmt = $db->prepare("SELECT solde FROM finance_compte WHERE id = ?");
            $stmt->execute([$id_compte]);
            $solde = $stmt->fetchColumn();

            if ($solde === false) {
                throw new Exception("Compte non trouvé.");
            }

            if ($solde < $montant) {
                throw new Exception("Solde insuffisant.");
            }

            $stmt = $db->prepare("INSERT INTO finance_transaction (montant, date_in, id_compte, id_type) VALUES (?, ?, ?, 2)");
            $stmt->execute([$montant, $date_in, $id_compte]);

            $stmt = $db->prepare("UPDATE finance_compte SET solde = solde - ? WHERE id = ?");
            $stmt->execute([$montant, $id_compte]);

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
}
