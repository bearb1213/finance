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
            
            Flight::json(['message' =>  $data]);
            $account = Pret::getAccount($numero);
            if (!$account) {
                throw new Exception('Compte non trouver');
            }
            $data['id_compte'] = $account['id'];
            $type = Pret::getTypeById($data['id_type']);
            if(!$type){
                throw new Exception('Type de pret innexistant');
            }
            $id = Pret::create($data);
            if (!$id) {
                throw new Exception('Echec de l\'enregistrement du pret');
            }



            Flight::json(['status'=> 'success','message' => 'Prêt enregistré avec succès'], 200);
        } catch (\Throwable $th) {
            Flight::json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public static function getAllPret(){
        Flight::json(Pret::getAllPret());
    }

    public static function simulationRemboursement(){
        try {
            $id = Flight::request()->query['id'];
            $pret = Pret::getPretById($id);
            if (!$pret) {
                throw new Exception("Pret innexistant");
            }
            $data = Pret::getTableRemboursement($id);
            Flight::json(['status'=> 'success' , 'message' => 'simulation reussi' , 'data' => $data ]);

        } catch (\Throwable $th) {
            Flight::json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }

    }

    public static function validePret(){
        try {
            $id = Flight::request()->data->id;
            $pret = Pret::getPretById($id);
            if (!$pret) {
                throw new Exception("Pret innexistant");
            }
            $result = Pret::validePret($id);
            if ($result) {
                Flight::json(['status' => 'success', 'message' => 'Prêt validé avec succès']);
            } else {
                throw new Exception("Echec de la validation du prêt");
            }
        } catch (\Throwable $th) {
            Flight::json(['status' => 'error', 'message' => $th->getMessage()], 200);
        }
    }

    public static function refusePret(){
        try {
            $id = Flight::request()->data->id;
            $pret = Pret::getPretById($id);
            if (!$pret) {
                throw new Exception("Pret innexistant");
            }
            $result = Pret::refuserPret($id);
            if ($result) {
                Flight::json(['status' => 'success', 'message' => 'Prêt refusé avec succès']);
            } else {
                throw new Exception("Echec du refus du prêt");
            }
        } catch (\Throwable $th) {
            Flight::json(['status' => 'error', 'message' => $th->getMessage()], 200);
            
        }
    }


}
