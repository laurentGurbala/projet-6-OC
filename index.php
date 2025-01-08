<?php

require_once "config/_config.php";
require_once "config/autoload.php";

$action = Utils::request("action", "home");

// Try catch global pour gérer les erreurs
try {
    switch ($action) {
        case 'home':
            $homeController = new HomeController();
            $homeController->showHome();
            break;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
