<?php
require_once __DIR__ . '/../models/Compte.php';
require_once __DIR__ . '/../models/Transaction.php';

class TransactionController {

    // Créditer un compte
    public static function crediter() {
        $data = Flight::request()->data;
        $id_compte = $data->id_compte ?? null;
        $montant = floatval($data->montant ?? 0);

        if (!$id_compte || $montant <= 0) {
            Flight::halt(400, json_encode(['error' => 'Paramètres invalides']));
        }

        try {
            Transaction::crediter($id_compte, $montant);
            Flight::json(['message' => "Crédit de $montant effectué avec succès"]);
        } catch (Exception $e) {
            Flight::halt(400, json_encode(['error' => $e->getMessage()]));
        }
    }

    // Débiter un compte
    public static function debiter() {
        $data = Flight::request()->data;
        $id_compte = $data->id_compte ?? null;
        $montant = floatval($data->montant ?? 0);

        if (!$id_compte || $montant <= 0) {
            Flight::halt(400, json_encode(['error' => 'Paramètres invalides']));
        }

        try {
            Transaction::debiter($id_compte, $montant);
            Flight::json(['message' => "Débit de $montant effectué avec succès"]);
        } catch (Exception $e) {
            Flight::halt(400, json_encode(['error' => $e->getMessage()]));
        }
    }
}
