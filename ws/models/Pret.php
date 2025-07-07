<?php
require_once __DIR__ . '/../db.php';

class Pret {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM finance_pret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM finance_pret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO finance_pret (montant , date_in , motif , id_compte , id_type ) VALUES (?, ?, ?, ? ,? )");

        $stmt->execute([$data['montant'], $data['date_in'], $data['motif'],  $data['id_compte'], $data['id_type']]);
        return $db->lastInsertId();
    }

    public static function getTypePret() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM finance_type_pret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAccount($numero) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM finance_compte WHERE numero = ?");
        $stmt->execute([$numero]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllPret(){
        $db = getDB();
        $stmt = $db->query("SELECT p.id, p.montant, p.motif, c.numero AS compte_numero, t.duree as duree , t.taux as taux 
                            FROM finance_pret p
                            JOIN finance_compte c ON p.id_compte = c.id
                            JOIN finance_type_pret t ON p.id_type = t.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}