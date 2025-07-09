<?php
require_once __DIR__ . '/../controllers/PretController.php';

Flight::route('GET /pret/types', ['PretController', 'getType']);
Flight::route('POST /pret/save', ['PretController', 'save']);
Flight::route('GET /pret/all', ['PretController', 'getAllPret']);
Flight::route('GET /pret/simule' , ['PretController' , 'simulationRemboursement']);
Flight::route('POST /pret/valider', ['PretController', 'validePret']);
Flight::route('POST /pret/refuser', ['PretController', 'refusePret']);