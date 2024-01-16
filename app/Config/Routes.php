<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
// if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
//     require SYSTEMPATH . 'Config/Routes.php';
// }

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('admin', function (RouteCollection $routes) {
$routes->get('/',                                           'Home::index');
$routes->get('login',                                       'Auth::login');
$routes->post('auth/login',                                 'Auth::loginEmail');
$routes->post('login',                                      'Auth::trylogin');
$routes->get('logout',                                      'Auth::logout');
});

$routes->group('admin', ['filter' => 'auth'], function (RouteCollection $routes) {
    $routes->get('dashboard',                               'Home::dashboard');
    $routes->get('user/committe',                           'User::committe');
    $routes->get('user/participant',                        'User::participant');
    $routes->get('user/create',                             'User::create');
    $routes->get('user/import',                             'User::importForm');
    $routes->get('user/check',                              'User::check');
    $routes->get('user/(:segment)',                         'User::edit/$1');
    $routes->post('user/save',                              'User::save');
    $routes->post('user/import',                            'User::import');

    // Tryouts
    $routes->get('tryout',                                  'Tryout::index');
    $routes->get('tryout/create',                           'Tryout::create');
    $routes->post('tryout/save',                            'Tryout::save');
    $routes->get('tryout/(:segment)',                       'Tryout::detail/$1');
    $routes->get('tryout/(:segment)/edit',                  'Tryout::edit/$1');

    // Subtests
    $routes->get('tryout/(:segment)/subtest/create',                'Subtest::create/$1');
    $routes->post('tryout/(:segment)/subtest/save',                 'Subtest::save/$1');
    $routes->get('tryout/(:segment)/subtest/(:segment)',            'Subtest::detail/$1/$2');
    $routes->get('tryout/(:segment)/subtest/(:segment)/edit',       'Subtest::edit/$1/$2');

    $routes->get('tryout/(:segment)/subtest/(:segment)/attempt',      'Attempt::subtest/$1/$2');


    $routes->get('tryout/(:segment)/subtest/(:segment)/question',          'Material::index/$1/$2');
    $routes->post('tryout/(:segment)/subtest/(:segment)/question/add',     'Material::add/$1/$2');
    $routes->post('tryout/(:segment)/subtest/(:segment)/question/import',  'Material::import/$1/$2');

    // Scoring
    $routes->get('tryout/(:segment)/stats',                         'Ranker::stats/$1');
    $routes->get('tryout/(:segment)/rank',                          'Ranker::rankTryout/$1');
    $routes->get('tryout/(:segment)/subtest/(:segment)/rank',       'Ranker::rankSubtest/$1/$2');
    $routes->get('tryout/(:segment)/subtest/(:segment)/scoring',    'Ranker::subtest/$1/$2');

    $routes->post('scoring/preparing/(:segment)',           'Ranker::preparing/$1');
    $routes->post('scoring/weighting/(:segment)',           'Ranker::weighting/$1');
    $routes->post('scoring/distributing/(:segment)',        'Ranker::distributing/$1');
    $routes->post('scoring/summarizing/(:segment)',         'Ranker::summarizing/$1');
    $routes->post('scoring/agregating/(:segment)',          'Ranker::agregating/$1');

    // Participants + Attempt
    $routes->get('tryout/(:segment)/participant',                   'Attempt::index/$1');
    $routes->get('tryout/(:segment)/participant/add',               'Attempt::add/$1');
    $routes->post('tryout/(:segment)/participant/save',             'Attempt::save/$1');
    $routes->get('tryout/(:segment)/participant/(:segment)',        'Attempt::detail/$1/$2');
    $routes->get('tryout/(:segment)/participant/(:segment)/edit',   'Attempt::edit/$1/$2');

    $routes->get('tryout/(:segment)/participant/(:segment)/subattempt/(:segment)',  'Attempt::subattempt/$1/$2/$3');

    // Qbank
    $routes->get('package',                                         'Package::index');
    $routes->get('package/create',                                  'Package::create');
    $routes->post('package/save',                                   'Package::save');
    $routes->get('package/(:segment)/edit',                         'Package::edit/$1');

    $routes->get('package/(:segment)',                              'Question::index/$1');
    $routes->get('package/(:segment)/question',                     'Question::index/$1');
    $routes->get('package/(:segment)/question/create',              'Question::create/$1');
    $routes->get('package/(:segment)/question/create/(:any)',              'Question::create/$1/$2');
    $routes->post('package/(:segment)/question/save',               'Question::save/$1');
    $routes->get('package/(:segment)/question/(:segment)',          'Question::show/$1/$2');
    $routes->get('package/(:segment)/question/(:segment)/edit',     'Question::edit/$1/$2');

    $routes->get('question/(:segment)',                             'Question::view/$1');

    $routes->delete('user/(:segment)',                'User::ajaxDelete/$1');
    $routes->delete('tryout/(:segment)',              'Tryout::ajaxDelete/$1');
    $routes->delete('subtest/(:segment)',             'Subtest::ajaxDelete/$1');
    $routes->delete('package/(:segment)',             'Package::ajaxDelete/$1');
    $routes->delete('attempt/(:segment)',             'Attempt::ajaxDelete/$1');
    $routes->delete('question/(:segment)',            'Question::ajaxDelete/$1');
    $routes->delete('material/(:segment)',            'Material::ajaxDelete/$1');
    $routes->delete('subattempt/(:segment)',          'Attempt::ajaxSubattemptDelete/$1');

    $routes->get('print/result/tryout/(:segment)',      'Ranker::printExamRank/$1');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
