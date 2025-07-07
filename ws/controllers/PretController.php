<?php
require_once __DIR__ . '/../models/Pret.php';
require_once __DIR__ . '/../helpers/Utils.php';


class  PretController {
    
    public static function getType(){
        $types = Pret::getTypePret();
        Flight::json($types);
    }

    public static function save(){
        $numero= Flight::request()->data->numero;
        $data['montant'] = Flight::request()->data->montant;
        $data['date_in'] = date('Y-m-d H:i:s');
        $data['motif'] = Flight::request()->data->motif;
        $data['id_type'] = Flight::request()->data->type;
        try {
            
            
            $account = Pret::getAccount($numero);
            if (!$account) {
                throw new Exception('Compte non trouver');
                
            }
            $data['id_compte'] = $account['id'];
            
            Pret::create($data);
            
            Flight::json(['status'=> 'success','message' => 'Prêt enregistré avec succès'], 200);
        } catch (\Throwable $th) {
            Flight::json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public static function getAllPret(){
        Flight::json(Pret::getAllPret());
    }

}
