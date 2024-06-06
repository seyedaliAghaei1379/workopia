<?php


//$router->get("/" , 'controllers/home.php');
//$router->get("/listings" , 'controllers/listings/index.php');
//$router->get("/listings/create" , 'controllers/listings/create.php');
//$router->get("/listing" , 'controllers/listings/show.php');


$router->get("/" , 'HomeController@index');

$router->get("/search" , 'ListingController@search');

$router->get("/listings" , 'ListingController@index');
$router->get("/listings/create" , 'ListingController@create' , ['auth']);
$router->get("/listings/{id}" , 'ListingController@show' );
$router->post("/listings" , 'ListingController@store' , ['auth']);

$router->post("/listings/reserved" , 'reservedController@store' , ['auth']);

$router->delete("/listings/{id}" , 'ListingController@destroy' , ['auth']);

$router->get("/listings/edit/{id}" , 'ListingController@edit' , ['auth']);
$router->put("/listings/{id}" , 'ListingController@update' , ['auth']);

$router->get('/auth/register' , 'UserController@create' , ['guest']);
$router->get('/auth/login' , 'UserController@login' , ['guest']);


$router->post('/auth/register' , 'UserController@store', ['guest']);
$router->post('/auth/logout' , 'UserController@logout', ['auth']);
$router->post('/auth/login' , 'UserController@authenticate', ['guest']);
