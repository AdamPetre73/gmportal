<?php
/**
 * Dasboard - Implements a simple Administration Dashboard.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */

namespace App\Modules\Tickets\Controllers\Admin;

use Core\View;
use Helpers\Url;
use DB;
use Redirect;
use Input;
use Auth;

use App\Core\Controller;


class Tickets extends Controller
{
    protected $template = 'AdminLte';
    protected $layout   = 'backend';


    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $tickets = DB::table('tickets')->get();

        $currentUser = Auth::user()->id;
        $currentRole = Auth::user()->role_id;

        return $this->getView()
            ->shares('title', __d('tickets', 'Tickets'))
            ->with('tickets', $tickets)
            ->with('currentUser', $currentUser)
            ->with('currentRole', $currentRole);
    }

}
