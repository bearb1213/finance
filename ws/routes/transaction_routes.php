<?php
require_once __DIR__ . '/../controllers/TransactionController.php';


Flight::route('POST /transaction/crediter', ['TransactionController', 'crediter']);

Flight::route('POST /transaction/debiter', ['TransactionController', 'debiter']);
