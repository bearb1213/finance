<?php
require_once __DIR__ . '/../controllers/PretController.php';

Flight::route('GET /pret/types', ['PretController', 'getType']);
Flight::route('POST /pret/save', ['PretController', 'save']);
Flight::route('GET /pret/all', ['PretController', 'getAllPret']);