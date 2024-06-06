<?php


namespace App\Controllers;

use Framework\Authorization;
use Framework\Database;
use Framework\Session;
use Framework\Validation;


class ReservedController
{

    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

//    public function index()
//    {
//        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();
//        loadView('listings/index', [
//            'listings' => $listings,
//        ]);
//    }

//    public function create()
//    {
//        loadView("listings/create");
//    }

//    public function show($p)
//    {
//        $id = isset($p['id']) ? $p : "";
//
//        if ($id === "") {
//            ErrorController::notFound();
//            exit();
//        }
//        $params = [
//            'id' => $id
//        ];
//        $listing = $this->db->query('SELECT * FROM `listings` WHERE id = :id', $params['id'])->fetch();
//
//        if (!$listing) {
//            ErrorController::notFound('کتاب پیدا نشد');
//            return;
//        }
//
//        loadView('listings/show', [
//            'listing' => $listing
//        ]);
//    }

    /**
     * Store data in database
     * @return void
     */
    public function store()
    {
        $allowedFields = ['book_id', 'timeStart', 'timeEnd'  ];
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));
//        inspectAndDie($_POST);
        $timeEnd = $newListingData['timeEnd'];
        $newListingData['timeEnd'] = strtotime("+{$timeEnd} day", $newListingData['timeStart']);




        $newListingData['user_id'] = Session::get('user')['id'];

        $newListingData = array_map('sanitize', $newListingData);
//        inspectAndDie($newListingData);

        $requiredFields = ['book_id', 'timeStart' , 'timeEnd'];
        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors [$field] = ucfirst($field) . ' الزامی است';
            }
        }
        if (!empty($errors)) {
            // Reload view  with errors
            loadView('listings/', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        } else {
            //  Submit Data


            $fields = [];

            foreach ($newListingData as $field => $value) {
                $fields[] = $field;
            }

            $fields = implode(', ', $fields);

            $values = [];

            foreach ($newListingData as $field => $value) {
                // Convert empty to null
                if ($value === '') {
                    $newListingData[$field] = null;
                }
//                inspectAndDie($field);
                $values[] = ":" . $field;
            }

            $values = implode(", ", $values);

            $query = "INSERT INTO reserved ({$fields}) VALUES ({$values})";
            $this->db->query($query, $newListingData);

            $_SESSION['success_message'] = "کتاب با موفقیت رزرو شد";
            redirect('/listings/');

        }
    }

    /**
     * Delete a listing
     *
     * @param array $params
     * @return void
     */
    public function destroy($params)
    {
        $id = $params['id'];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id' , $params)->fetch();
//        inspect($listing);

        // Check if listing exists
        if(!$listing){
            ErrorController::notFound('کتاب پیدا نشد');
            return;
        }
        //Authoriztion
        if(!Authorization::isOwner($listing->id)){
            $_SESSION['error_message'] = "شما اجازه حذف این کتاب را ندارید";
            return redirect('/listings/' . $listing->id);
        }

        $this->db->query('DELETE FROM listings WHERE `id` = :id' , $params);


        //Set Flash Message
        $_SESSION['success_message'] = 'کتاب با موفقیت حذف شد ';

        redirect('/listings');
    }

    /**
     * @param array $p
     * @return void
     */
    public function edit($p)
    {
        $id = isset($p['id']) ? $p : "";

        if ($id === "") {
            ErrorController::notFound();
            exit();
        }
        $params = [
            'id' => $id
        ];
        $listing = $this->db->query('SELECT * FROM `listings` WHERE id = :id', $params['id'])->fetch();

        if (!$listing) {
            ErrorController::notFound('کتاب پیدا نشد');
            return;
        }

        loadView('listings/edit', [
            'listing' => $listing
        ]);
    }

    /**
     * Update a listing
     * @param array $params
     * @return void
     */

    public function update($p)
    {
//        inspectAndDie($p);
//        $id = isset($p['id']) ? $p : "";
//        inspectAndDie($p);
        $id = isset($p['id']) ? $p['id'] : "";

        if ($id === "") {
            ErrorController::notFound();
            exit();
        }
//        inspectAndDie($id);
        $params = [
            'id' => $id
        ];


        $listing = $this->db->query('SELECT * FROM `listings` WHERE id = :id', $params)->fetch();
//        inspectAndDie($listing);
//        inspectAndDie($params['id']);

        if (!$listing) {
            ErrorController::notFound('کتاب پیدا نشد');
            return;
        }

        $allowedFields = ['title', 'description', 'count'];

        $updateValues = array_intersect_key($_POST,array_flip($allowedFields));

//        inspectAndDie($updateValues);

        $updateValues = array_map('sanitize' , $updateValues);

        $requireFields = ['title' , 'description'];

        $errors = [];

        foreach ($requireFields as $field){
            if(empty($updateValues[$field]) || !Validation::string($updateValues[$field])){
                $errors[$field] = ucfirst($field) . 'الزامی است';
            }
        }
//        inspectAndDie($errors);
        if(!empty($errors)){
            loadView('listings/edit' , [
                'listing' => $listing,
                'errors' => $errors
            ]);
            exit;
        }else{
            // Submit to database
            $updateFields = [];

            foreach (array_keys($updateValues) as $field){
                $updateFields[] = "{$field} = :{$field}";
            }
//            inspectAndDie($updateFields);
            $updateFields = implode(', ' , $updateFields);
//            inspectAndDie($updateFields);
//inspectAndDie($params);
//            $id = $params['id'];
//            inspectAndDie($params['id']['id']);
            $updateQuery = "UPDATE listings SET {$updateFields} WHERE id = :id";
//            inspectAndDie($id['id']);
            $updateValues['id'] = $id;
            $this->db->query($updateQuery,$updateValues);
            $_SESSION['success_message'] = "کتاب آپدیت شد";
//            inspectAndDie($id);
            redirect('/listings/' . $id);

//            inspect($updateQuery);

        }





//
//        foreach ($allowedFields as $field){
//
//        }

//        inspectAndDie($params);
    }

    public function search()
    {
//        inspectAndDie($_GET['keywords'] . $_GET['location']);

        $keywords = $_GET['keywords'] ?? "";
//        $location = $_GET['location'] ?? "";

//        $query = "SELECT * FROM listings WHERE (title LIKE :keywords OR description LIKE :keywords OR  tags LIKE :keywords OR company LIKE :keywords) AND (city LIKE :location OR state LIKE :location)";
        $query = 'SELECT * FROM listings WHERE title LIKE :keywords OR description LIKE :keywords';
        $params = [
            'keywords' => "%{$keywords}%",
        ];

        $listings = $this->db->query($query,$params)->fetchAll();

//        inspectAndDie($listings);

        loadView('/listings/index' , [
            'listings' => $listings
        ]);
    }
}