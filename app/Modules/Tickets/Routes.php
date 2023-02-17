<?php
/**
 * Routes - all Module's specific Routes are defined here.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */


/** Define static routes. */

// The Adminstrations's Dashboard.
Router::get('admin/tickets',                                                            ['before' => 'auth', 'uses' => 'App\Modules\Tickets\Controllers\Admin\Tickets@index']);
