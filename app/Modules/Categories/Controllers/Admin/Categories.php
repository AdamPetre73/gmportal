<?php
/**
 * Dasboard - Implements a simple Administration Dashboard.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */

namespace App\Modules\Categories\Controllers\Admin;

use Core\View;
use Helpers\Url;

use App\Core\Controller;


class Categories extends Controller
{
    protected $template = 'AdminLte';
    protected $layout   = 'backend';


    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->getView()
            ->shares('title', __d('categories', 'Categories'));
    }

}
