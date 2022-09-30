<?php

class Main extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->view->render('main/index');
    }

    function index()
    {
        echo "<p>Executing index function...</p>";
    }
}
