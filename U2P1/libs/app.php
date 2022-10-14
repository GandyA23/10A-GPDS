<?php
require_once 'controllers/errors.php'; // Import (embed PHP code from another file)
class App
{
    function __construct()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null; // Get value of the $url param (specified in .htaccess)
        $url = rtrim($url, '/'); // Remove characters from the rigth side of a string
        $url = explode('/', $url); // Break a string into an array, separating by slash '/' to get parans

        if(empty($url[0])){ // If params are empty
            $file_controller = 'controllers/main.php'; // Render view /main/index.php
            require_once $file_controller;
            $controller = new Main();
            return false;
        }

        /*
        The first parameter will be the controller name. 
        So, dynamically generate the path file
        */
        $file_controller = 'controllers/' . $url[0] . '.php';

        if (file_exists($file_controller)) { // Check if controller exists (dynamically path file)
            require_once $file_controller; // Import php controller file
            $controller = new $url[0];

            if (isset($url[1])) { // Check if a function is requested to be executed
                try {
                    $controller->{$url[1]}(); // Call the function
                } catch (Exception $e) {
                    $controller = new Errors();
                }
            }
        } else {
            $controller = new Errors(); // Controller handles errors, resource does not exist
        }
    }
}
