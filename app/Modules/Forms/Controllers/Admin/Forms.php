<?php
/**
 * Dasboard - Implements a simple Administration Dashboard.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */

namespace App\Modules\Forms\Controllers\Admin;

use Core\View;
use Helpers\Url;
use DB;
use Input;
use Redirect;

use App\Core\Controller;


class Forms extends Controller
{
    protected $template = 'AdminLte';
    protected $layout   = 'backend';


    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $forms = DB::table('forms')->get();

        return $this->getView()
            ->shares('title', __d('forms', 'Forms'))
            ->with('forms',$forms);
    }

    public function create(){
        $answerTypes = DB::table('forms_answers_types')->get();

        return $this->getView()
            ->shares('title', __d('forms', 'New Form'))
            ->with('answerTypes', $answerTypes);
    }

    public function store(){
        $input = Input::all();
        echo '<pre>';
        print_r($input);
        echo '</pre>';
        die();
    }

    public function questionTemplate($currentId){

        $answerTypes = DB::table('forms_answer_type')->get();

        $questionTemplate = '<div class="row question-row"><div class="col-md-3 text-right"><label class="control-label" for="question' . ($currentId+1) . '">' . __d('forms', 'Question') . '<font color="#CC0000">*</font></label></div><div class="col-md-6"><input name="questions[]" id="question' . ($currentId+1) . '" type="text" class="form-control" value="" placeholder="' . __d('forms', 'Question') . '"></div></div><div class="row answer-type-row"><div class="col-md-3 text-right"><label class="control-label" for="answer-type">' . __d('forms', 'Answer Type') . '<font color="#CC0000">*</font></label></div><div class="col-md-6"><select name="answer-types[]" id="answer-type-question' . ($currentId+1) . '" class="form-control answer-type" onchange="answerType(event);" required><option value="">' . __d('forms', 'Select Answer Type') . '</option>';
        foreach($answerTypes as $aType){
            $questionTemplate .= '<option value="' . $aType->id . '">' . $aType->answer_type . '</option>';
        }
        $questionTemplate .= '</select></div></div><div class="row answers"></div><div class="row separator-row"><hr></div>';

        return json_encode($questionTemplate);
    }

}
