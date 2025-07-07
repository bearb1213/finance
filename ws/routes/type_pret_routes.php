<?php
require_once __DIR__ . '/../controllers/TypePretController.php';

Flight::route('GET /type_pret', [TypePretController::class, 'getAll']);
Flight::route('GET /type_pret/@id', [TypePretController::class, 'getById']);
Flight::route('POST /type_pret', [TypePretController::class, 'create']);
Flight::route('PUT /type_pret/@id', [TypePretController::class, 'update']);
Flight::route('DELETE /type_pret/@id', [TypePretController::class, 'delete']);
