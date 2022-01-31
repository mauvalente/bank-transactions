<?php

// Autoload files using composer
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/autoload.php';

// Use this namespace

use Controller\UserController;
use Steampixel\Route;

// Add your first route
Route::add('/', function() {
  $controller = new UserController();
  $controller->list();
});

Route::add('/', function() {
  $post = urldecode( file_get_contents("php://input") );
  $controller = new UserController();
  $controller->add($post);
}, 'post');

Route::add('/', function() {
  $put = json_decode( file_get_contents("php://input"));
  $controller = new UserController();
  $controller->update($put);
}, 'put');

// Run the router
Route::run('/');
