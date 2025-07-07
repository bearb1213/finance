<?php
$s = DIRECTORY_SEPARATOR;
require_once 'app'.$s.'models'.$s.'EtudiantModel.php';

class EtudiantController {
    private $model;

    public function __construct() {
        $this->model = new EtudiantModel();
    }

    public function getAll() {
        $etudiants = $this->model->getAll();
        Flight::json($etudiants);
    }

    public function getById($id) {
        $etudiant = $this->model->getById($id);
        if ($etudiant) {
            Flight::json($etudiant);
        } else {
            Flight::halt(404, json_encode(['message' => 'Étudiant non trouvé']));
        }
    }

    public function create() {
        $data = Flight::request()->data->getData();
        $id = $this->model->create($data);
        Flight::json(['message' => 'Étudiant créé', 'id' => $id], 201);
    }

    public function update($id) {
        $data = Flight::request()->data->getData();
        $rows = $this->model->update($id, $data);
        if ($rows > 0) {
            Flight::json(['message' => 'Étudiant mis à jour']);
        } else {
            Flight::halt(404, json_encode(['message' => 'Étudiant non trouvé']));
        }
    }

    public function delete($id) {
        $rows = $this->model->delete($id);
        if ($rows > 0) {
            Flight::json(['message' => 'Étudiant supprimé']);
        } else {
            Flight::halt(404, json_encode(['message' => 'Étudiant non trouvé']));
        }
    }
}