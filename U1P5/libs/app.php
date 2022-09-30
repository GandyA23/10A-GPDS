<?php

require_once 'controllers/errors.php'; // Import (embed PHP code from another file)

class App
{
    function __construct()
    {
        $url = $_GET['url']; // Get value of the $url param (specified in .htaccess)
        $url = rtrim($url, '/'); // Remove characters from the rigth side of a string
        $url = explode('/', $url); // Break a string into an array, separating by slash '/' to get parans

        /*
        The first parameter will be the controller name. 
        So, dynamically generate the path file
        */
        $file_controller = 'controllers/' . $url[0] . '.php';

        if (file_exists($file_controller)) { // Check if controller exists (dynamically path file)
            require_once $file_controller; // Import php controller file
            $controller = new $url[0];

            if (isset($url[1])) { // Check if a function is requested to be executed
                if (isset($controller->{$url[1]})) {  // Check if a function exists in controller
                    $controller->{$url[1]}(); // Call the function
                } else {
                    $controller = new Errors();
                }
            }
        } else {
            $controller = new Errors(); // Controller handles errors when resource does not exist
        }
    }
}
