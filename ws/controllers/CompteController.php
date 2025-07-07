<?php
require_once __DIR__ . '/../models/Compte.php';

class CompteController {
    public static function getAll() {
        $comptes = Compte::getAll();
        Flight::json($comptes);
    }
}
