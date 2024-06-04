<?php
// Include necessary files
require_once '../includes/functions.php';
require_once '../config/config.php';
require_once '../vendor/autoload.php';


// Use Route::view() to define routes
// view('/', 'index');
Route::get('/', 'HomeController@index');
// view('/login', 'login');
// view('/signup', 'signup');
// view('/dashboard', 'dashboard');
// view('/account_management', 'account_management');
// view('/a', 'a/a');

// Handle 404 Not Found
http_response_code(404);
include '../public/404.php';
