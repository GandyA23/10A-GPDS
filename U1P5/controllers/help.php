<?php

// Herencia
class Help extends Controller
{
    function __construct()
    {
        // Llamar funciones desde el hijo desde el padre
        parent::__construct();

        // $this->view = Instancia de la clase View()
        $this->view->render('help/index');
    }

}