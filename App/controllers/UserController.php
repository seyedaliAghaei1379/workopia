<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

class UserController {

    protected $db;
    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Show the Login page
     * @return void
     */
    public function login()
    {
        loadView('users/login');

    }


    /**
     * Show the Register page
     * @return void
     */
    public function create()
    {
        loadView('users/register');
    }

    /**
     * Store user in database
     * @return void
     */
    public function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];


        $errors = [];

        // Validation
        if(!Validation::email($email)){
            $errors['email'] = 'please enter a valid email Address';
        }

        if(!Validation::string($name,2,50)){
            $errors['name'] = 'Name must be between 2 and 50 characters';
        }

        if(!Validation::string($password,6,50)){
            $errors['password'] = 'password must be between 6 and 50 characters';
        }

        if(!Validation::match($password,$password_confirmation)){
            $errors['password_confirmation'] = 'password not matched';
        }

        if(!empty($errors)){
            loadView('users/register' , [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'city' => $city,
                    'state' => $state,
                ]
            ]);
            exit;
        }

        // check email exist

        $params = [
            'email' => $email
        ];
//        inspect($params);

        $user = $this->db->query('SELECT * FROM users WHERE email = :email' , $params)->fetch();
//        inspect($user);

        if($user){
            $errors['email'] = "email is already exist";
            loadView('users/register' , [
                'errors' => $errors
            ]);
            exit;
        }

        // create user Account
        $params = [
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'password' => password_hash($password , PASSWORD_DEFAULT),
        ];
        
//        inspectAndDie($params);
        $this->db->query('INSERT INTO users (name,email,city,state,password) VALUES (:name,:email,:city,:state,:password)',$params);

        // Get new user id
        $userId = $this->db->conn->lastInsertId();
        // set user Session
        Session::set('user' , [
            'id' => $userId,
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state
        ]);

//        inspectAndDie($userId);

        redirect('/');

    }

    /**
     * Log out a user and kill session
     * @return void
     */
    public function logout()
    {
        Session::clearAll();

        $params = session_get_cookie_params();
//        inspectAndDie($params);

        setcookie('PHPSESSID' , '' , time() - 86400 ,$params['path']  , $params['domain']);

        redirect('/');
    }

    /**
     * Authenticate a user with email and password
     *
     * @return void
     */
    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        // Validation
        if(!Validation::email($email)){
            $errors['email'] = 'Please enter a valid email';
        }
        if(!Validation::string($password , 6)){
            $errors['email'] = 'Please enter a valid password';
        }

        // check for errors
        if(!empty($errors)){
            loadView('users/login' , [
                'errors' => $errors
            ]);
            exit;
        }

        // check for email
        $params = [
           'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email ' , $params)->fetch();


        if(!$user){
            $errors['email'] = 'Incorrect email';
            loadView('users/login' , [
                'errors' => $errors
            ]);
            exit;
        }

        // check if password is correct
        if(!password_verify($password,$user->password)){
            $errors['email'] = 'incorect credentials';
            loadView('users/login' , [
                'errors' => $errors
            ]);
            exit;
        }
        // set user Session
        Session::set('user' , [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'city' => $user->city,
            'state' => $user->state
        ]);
        redirect('/');

    }

}