<?php


namespace App\Controllers;

use Framework\Database;

class ListingController
{

    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index()
    {
        $listings = $this->db->query('SELECT * FROM listings LIMIT 2')->fetchAll();
        loadView('listings/index', [
            'listings' => $listings,
        ]);
    }

    public function create()
    {
        loadView("listings/create");
    }

    public function show()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "";

        if($id === ""){
            http_response_code(404);
            loadView('error/404');
            exit();
        }

        $params = [
            'id' => $id
        ];
        $listing = $this->db->query('SELECT * FROM `listings` WHERE id = :id' , $params)->fetch();

        loadView('listings/show' , [
            'listing' =>  $listing
        ]);
    }
}