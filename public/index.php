
<?php

// Define the base directory
define('BASE_PATH', '/pharmacy_management/public');

require __DIR__ . '/../vendor/autoload.php';// Composer autoload to load classes
require_once __DIR__ . '/../bootstrap.php';// Load initial configurations

use core\App;

// Example of accessing the DB connection via the container
$db = App::getContainer()->resolve('DB');

if ($db === null) {
    exit("Database connection is not available.");
}

// Define the views directory
define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
// Create an instance of the AltoRouter router
$router = new AltoRouter();

// Set the base path for routes
$router->setBasePath(BASE_PATH);

// Include the routes from the routes file
require_once __DIR__ . '/../config/routes.php';

// Execute routing
$match = $router->match();
//var_dump($match);
//die();
// Retrieve the corresponding route
if ($match) {
   // Check if the "target" is a string in the format 'Controller@method'
    if (is_string($match['target']) && strpos($match['target'], '@') !== false) {
        list($controllerName, $method) = explode('@', $match['target']);
        
        // Use the service container to get an instance of the controller
        $controller = $container->resolve($controllerName);

         // Check if the method exists in the controller
        if (method_exists($controller, $method)) {
          // Call the controller method with the route parameters
            call_user_func_array([$controller, $method], $match['params']);
        } else {
            throw new Exception("La méthode $method n'existe pas dans le contrôleur $controllerName.");
        }
    } elseif (is_callable($match['target'])) {
        // Handle the case where the "target" is a callback function
        call_user_func_array($match['target'], $match['params']);
    } else {
          // If no router is found, return a 404 error
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        echo "La page demandée est introuvable.";
    }
}