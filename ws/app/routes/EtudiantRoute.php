<?php
$s = DIRECTORY_SEPARATOR;
require_once 'app'.$s.'controllers'.$s.'EtudiantController.php';

$etudiantController = new EtudiantController();

Flight::route('GET /etudiants', [$etudiantController, 'getAll']);
Flight::route('GET /etudiants/@id', [$etudiantController, 'getById']);
Flight::route('POST /etudiants', [$etudiantController, 'create']);
Flight::route('PUT /etudiants/@id', [$etudiantController, 'update']);
Flight::route('DELETE /etudiants/@id', [$etudiantController, 'delete']);

Flight::route('GET /tay', function() {
    Flight::json(['message' => __DIR__]);
});