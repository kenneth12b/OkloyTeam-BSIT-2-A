<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth', 'Auth::auth');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');

// User Acounts routes
$routes->get('/users', 'Users::index');
$routes->post('users/save', 'Users::save');
$routes->get('users/edit/(:segment)', 'Users::edit/$1');
$routes->post('users/update', 'Users::update');
$routes->delete('users/delete/(:num)', 'Users::delete/$1');
$routes->post('users/fetchRecords', 'Users::fetchRecords');

// Person routes
$routes->get('/person', 'Person::index');
$routes->post('person/save', 'Person::save');
$routes->get('person/edit/(:segment)', 'Person::edit/$1');
$routes->post('person/update', 'Person::update');
$routes->delete('person/delete/(:num)', 'Person::delete/$1');
$routes->post('person/fetchRecords', 'Person::fetchRecords');

// Profiling routes
$routes->get('/profiling', 'Profiling::index');
$routes->post('profiling/save', 'Profiling::save');
$routes->get('profiling/edit/(:segment)', 'Profiling::edit/$1');
$routes->post('profiling/update', 'Profiling::update');
$routes->delete('profiling/delete/(:num)', 'Profiling::delete/$1');
$routes->post('profiling/fetchRecords', 'Profiling::fetchRecords');

// Student routes
$routes->get('/student', 'Student::index');
$routes->post('student/save', 'Student::save');
$routes->get('student/edit/(:segment)', 'Student::edit/$1');
$routes->post('student/update', 'Student::update');
$routes->delete('student/delete/(:num)', 'Student::delete/$1');
$routes->post('student/fetchRecords', 'Student::fetchRecords');

$routes->get('product', 'Product::index');

$routes->get('product/getAll', 'Product::getAll');
$routes->post('product/save', 'Product::save');
$routes->get('product/edit/(:num)', 'Product::edit/$1');
$routes->post('product/update', 'Product::update');
$routes->post('product/delete/(:num)', 'Product::delete/$1');


$routes->get('categories', 'Category::index');
$routes->post('categories/save', 'Category::save');
$routes->get('categories/edit/(:num)', 'Category::edit/$1');
$routes->post('categories/update', 'Category::update');
$routes->delete('categories/delete/(:num)', 'Category::delete/$1');
$routes->post('categories/fetchRecords', 'Category::fetchRecords');

$routes->get('product/getAll', 'Product::getAll');
$routes->post('product/save', 'Product::save');
$routes->get('product/edit/(:num)', 'Product::edit/$1');
$routes->post('product/update', 'Product::update');
$routes->post('product/delete/(:num)', 'Product::delete/$1');

$routes->get('tables', 'Tables::index');
$routes->post('tables/save', 'Tables::save');
$routes->get('tables/start/(:num)', 'Tables::start/$1');
$routes->get('tables/end/(:num)', 'Tables::end/$1');
$routes->get('tables/reserve/(:num)', 'Tables::reserve/$1');
$routes->get('tables/reset/(:num)', 'Tables::reset/$1');

$routes->get('reservation', 'Reservation::index');
$routes->post('reservation/save', 'Reservation::save');

$routes->get('reservation/approve/(:num)', 'Reservation::approve/$1');
$routes->get('reservation/cancel/(:num)', 'Reservation::cancel/$1');
$routes->get('reservation/edit/(:num)', 'Reservation::edit/$1');
$routes->post('reservation/update/(:num)', 'Reservation::update/$1');
$routes->get('reservation/delete/(:num)', 'Reservation::delete/$1');


$routes->get('/dashboard', 'Dashboard::index');
// Logs routes for admin
$routes->get('/log', 'Logs::log');