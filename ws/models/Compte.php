<?php
require_once __DIR__ . '/../db.php';

class Compte {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT id, numero, solde FROM finance_compte");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
