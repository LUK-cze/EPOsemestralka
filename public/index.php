<?php 

session_start();

require_once '../config/db.php';
require_once '../controller/AuthController.php';

$authController = new AuthController($pdo);

// Jednoduché směrování: pokud posíláme formulář s přihlášením
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['akce_login'])) {
    $authController->login();
} else {
    $authController->zobrazFormular();
}

?>