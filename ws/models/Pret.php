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
        $id = $db->lastInsertId();

        $stmt = $db->prepare("INSERT INTO finance_statut_pret (date_in , id_pret ,id_statut) VALUES ( ?, ?, 1)");
        $stmt->execute([$data['date_in'], $id]);

        return $id;
    }
    public static function pretValideOuRefuser($id){
        $db = getDB();
        $stmt = $db->prepare("SELECT count(*) as nb FROM finance_statut_pret WHERE id_pret = ? AND id_statut IN (2,3)");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nb'] > 0; 
    }
    public static function validePret($id) {

        $pret = Pret::getPretById($id);
        if(!$pret) {
            throw new Exception("Pret innexistant");
        }
        if(Pret::pretValideOuRefuser($id)){
            throw new Exception("Pret deja valide ou refuser");
        }
        $now = date_create(); 
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO finance_statut_pret (date_in , id_pret ,id_statut) VALUES ( ?, ?, 2)");
        $stmt->execute([$now->format('Y-m-d'),$id]);

        $table = Pret::getTableRemboursement($id)['table'];
        $stmt = $db->prepare("INSERT INTO finance_remboursement (date_echeance , id_pret , montant_annuite , interet , amortissement , capital_restant , assurance , montant_annuite_total) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($table as $line) {
            extract($line);
            $stmt->execute([$now->format('Y-m-d'), $id, $annuite, $interet, $ammortissement, $capitaux, $assurance, $total]);
            date_add($now, date_interval_create_from_date_string('1 month'));
        }

        return true;
    }
    public static function refuserPret($id) {
        $pret = Pret::getPretById($id);
        if(!$pret) {
            throw new Exception("Pret innexistant");
        }
        if(Pret::pretValideOuRefuser($id)){
            throw new Exception("Pret deja valide ou refuser");
        }
        $now = date_create(); 
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO finance_statut_pret (date_in , id_pret ,id_statut) VALUES ( ?, ?, 3)");
        $stmt->execute([$now->format('Y-m-d'),$id]);
        return true;
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
    public static function getTypeById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM finance_type_pret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public static function getPretByCompte($id_compte) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM finance_pret WHERE id_compte = ?");
        $stmt->execute([$id_compte]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getPretById($id){
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM finance_pret WHERE id = ?");
        $stmt->execute([$id]);
        $retour = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($retour){
            return $retour[0];
        } else {
            return null;
        }
    }

    


    public static function getTableRemboursement($id){
        $pret = Pret::getPretById($id);
        if(!$pret){
            throw new Exception("Pret innexistant");
        } 
        $type = Pret::getTypeById($pret['id_type']);

        $duree = (int) ($type['duree']);
        
        $taux = (((float) ($type['taux'])) / $duree) /100 ;
        
        $annuite = ((float)$pret['montant']) * (($taux)/(1 - pow(1 + $taux , -$duree)));
        
        $tauxAssurance = ($type['assurance'] / 100) / 12;
        $assurance = $pret['montant'] * $tauxAssurance;
        
        $annuiteTotal = $annuite + $assurance;  

        
        $montant = $pret['montant'] ;
        $retour = [];
        for ($i=0; $i < $duree ; $i++) { 
            $interet = $montant * $taux;
            $ammortissement = $annuite - $interet ;
            $montant = $montant - $ammortissement ;
            $mois = ['annuite' => round($annuite,2) , 'interet' => round($interet,2) , 'ammortissement' => round($ammortissement,2) , 'capitaux' => round($montant,2) , 'assurance' => round($assurance,2) , 'total' => round($annuiteTotal,2) ]; ;
            $retour [] = $mois;
        }
        return ['table'=>$retour , 'pret' => $pret['montant'] ,'taux' => $type['taux'] ,'durer' => $duree  ];
    }
    

}