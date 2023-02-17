<?php
/**
 * Routes - all Module's specific Routes are defined here.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */


/** Define static routes. */

// The Adminstrations's Dashboard.
Router::get('admin/forms',                                                                                                  ['before' => 'auth', 'uses' => 'App\Modules\Forms\Controllers\Admin\Forms@index']);
Router::get('admin/forms/create',                                                                                           ['before' => 'auth', 'uses' => 'App\Modules\Forms\Controllers\Admin\Forms@create']);


Router::post('admin/forms',                                                                                                 ['before' => 'auth|csrf', 'uses' => 'App\Modules\Forms\Controllers\Admin\Forms@store']);

Router::post('admin/forms/createQuestion/{id}',                                                                             ['before' => 'auth', 'uses' => 'App\Modules\Forms\Controllers\Admin\Forms@questionTemplate']);