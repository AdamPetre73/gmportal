<?php
/**
 * Routes - all Module's specific Routes are defined here.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */


/** Define static routes. */

// The Adminstrations's Dashboard.
Router::get('admin/wiki',                                                                               ['before' => 'auth', 'uses' => 'App\Modules\Wiki\Controllers\Admin\Wiki@index']);
Router::get('admin/wiki/scrapeHeroesPage',                                                              ['before' => 'auth', 'uses' => 'App\Modules\Wiki\Controllers\Admin\Wiki@scrapeHeroesPage']);
Router::get('admin/wiki/heroes/{id}',                                                                   ['before' => 'auth', 'uses' => 'App\Modules\Wiki\Controllers\Admin\Wiki@heroPage']);

Router::get('admin/wiki/getRemainingHeroes',                                                            ['before' => 'auth', 'uses' => 'App\Modules\Wiki\Controllers\Admin\Wiki@getRemainingHeroes']);
Router::get('admin/wiki/getHeroesDataFromArchive',                                                      ['before' => 'auth', 'uses' => 'App\Modules\Wiki\Controllers\Admin\Wiki@getHeroesDataFromArchive']);
Router::get('admin/wiki/getAllHeroMediaFromArchive',                                                    ['before' => 'auth', 'uses' => 'App\Modules\Wiki\Controllers\Admin\Wiki@getAllHeroMediaFromArchive']);