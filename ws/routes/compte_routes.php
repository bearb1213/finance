<?php
require_once __DIR__ . '/../controllers/CompteController.php';

Flight::route('GET /comptes', ['CompteController', 'getAll']);
