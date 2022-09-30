<?php

class Create extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->view->render('create/index');
    }

    function index()
    {
        echo "<p>Executing index function...</p>";
    }
}
