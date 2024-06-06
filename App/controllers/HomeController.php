<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class HomeController{

    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index()
    {
//        inspectAndDie(Validation::email("amin2@FMIAL.L"));

        $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC LIMIT 6')->fetchAll();
        loadView('home' , [
            'listings' => $listings,
        ]);
    }
}