<?php

class Search extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->view->render('search/index');
    }

    function index()
    {
        echo "<p>Executing index function...</p>";
    }
}
