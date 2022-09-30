<?php

class View {

    function __construct()
    {
        
    }

    function render($viewName) 
    {
        require "views/$viewName.php";
    }
}