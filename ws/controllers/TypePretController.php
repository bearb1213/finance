<?php
require_once __DIR__ . '/../models/TypePret.php';
require_once __DIR__ . '/../helpers/Utils.php';



class TypePretController {
    public static function getAll() {
        $typePrets = TypePret::getAll();
        Flight::json($typePrets);
    }

    public static function getById($id) {
        $typePret = TypePret::getById($id);
        Flight::json($typePret);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = TypePret::create($data);
        Flight::json(['message' => 'Type prêt ajouté', 'id' => $id]);
    }

    public static function update($id) {
        // Pour les requêtes PUT, lire manuellement le corps
        parse_str(file_get_contents("php://input"), $putData);

        // Sécurité : valider les données
        $duree = isset($putData['duree']) ? $putData['duree'] : null;
        $taux = isset($putData['taux']) ? $putData['taux'] : null;

        // Appeler le modèle avec un tableau propre
        TypePret::update($id, (object)[
            'duree' => $duree,
            'taux' => $taux
        ]);

        Flight::json(['message' => 'Type prêt modifié']);
    }


    public static function delete($id) {
        TypePret::delete($id);
        Flight::json(['message' => 'Type prêt supprimé']);
    }
}
