git commit -m "Nieuwe bestanden en updates"<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$controller = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;

if (!$controller) {
    require_once __DIR__ . '/../app/views/keuzemenu.php';
    exit;
}

switch ($controller) {
    case 'medewerker':
        require_once __DIR__ . '/../app/controllers/MedewerkerController.php';
        $controllerObj = new MedewerkerController();
        break;
    case 'ticket':
        require_once __DIR__ . '/../app/controllers/TicketController.php';
        $controllerObj = new TicketController();
        break;
    case 'ticketscan':
    default:
        require_once __DIR__ . '/../app/controllers/TicketscanController.php';
        $controllerObj = new TicketscanController();
        break;
}

if (method_exists($controllerObj, $action ?? 'index')) {
    $controllerObj->{$action ?? 'index'}();
} else {
    echo "Actie '$action' niet gevonden in controller '$controller'.";
}