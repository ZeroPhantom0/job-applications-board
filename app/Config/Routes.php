<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// Public routes (Applicant)
$routes->get('/', 'Application::form');
$routes->get('apply', 'Application::form');
$routes->post('submit', 'Application::submit');
$routes->get('success', 'Application::success');

// Admin routes
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/doLogin', 'Admin::doLogin');
$routes->get('admin/logout', 'Admin::logout');
$routes->get('admin/applications', 'Admin::applications');
$routes->get('admin/view/(:any)', 'Admin::view/$1');
$routes->get('admin/delete/(:num)', 'Admin::delete/$1');
$routes->get('admin/download/(:any)', 'Admin::download/$1');
$routes->get('admin/shortlist/(:num)', 'Admin::shortlist/$1');
$routes->get('admin/reject/(:num)', 'Admin::reject/$1');

$routes->get('test-email', 'Application::testEmail');
