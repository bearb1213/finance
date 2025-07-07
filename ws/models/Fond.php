<?php
require_once __DIR__ . '/../db.php';

class Fond {
    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO finance_fond (date_in, montant_actuel) VALUES (?, ?)");

        // Utilise la date fournie ou la date actuelle
        $date = $data->date_in ?? date('Y-m-d H:i:s');
        $montant = $data->montant_actuel ?? 0;

        $stmt->execute([$date, $montant]);

        return $db->lastInsertId();
    }
}
