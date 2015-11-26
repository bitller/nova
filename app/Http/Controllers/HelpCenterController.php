<?php

namespace App\Http\Controllers;
use App\HelpCenterArticle;
use App\HelpCenterCategory;
use App\Http\Requests\HelpCenter\AskQuestionRequest;
use App\Http\Requests\HelpCenter\GetCategoryDataRequest;
use App\Http\Requests\AdminCenter\UsersManager\GetIndexDataRequest;
use App\Helpers\AjaxResponse;
use App\Helpers\AdminCenter\HelpCenterManagerHelper;
use App\Http\Requests\HelpCenter\GetQuestionCategoriesRequest;
use App\Question;
use App\QuestionCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Handle help center.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class HelpCenterController extends BaseController {

    /**
     * Allow only logged in users.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render help center index.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('help-center.index');
    }

    /**
     * @param GetIndexDataRequest $request
     * @return mixed
     */
    public function get(GetIndexDataRequest $request) {

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('common.success'));
        $response->addExtraFields(['categories' => HelpCenterManagerHelper::getHelpCenterCategories()]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Render category page.
     *
     * @param $categoryId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($categoryId) {
        return view('help-center.category')->with('categoryId', $categoryId);
    }

    /**
     * Get category page data.
     *
     * @param int $categoryId
     * @param GetCategoryDataRequest $request
     * @return mixed
     */
    public function getCategory($categoryId, GetCategoryDataRequest $request) {

        $category = DB::table('help_center_categories')->where('id', $categoryId)->first();
        $category->articles = HelpCenterArticle::where('category_id', $categoryId)->get();

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('common.success'));
        $response->addExtraFields(['category' => $category]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Get question categories.
     *
     * @param GetQuestionCategoriesRequest $request
     * @return mixed
     */
    public function getQuestionCategories(GetQuestionCategoriesRequest $request) {
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('common.success'));
        $response->addExtraFields(['question_categories' => QuestionCategory::all()]);
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Allow user to ask questions.
     *
     * @param AskQuestionRequest $request
     * @return mixed
     */
    public function askQuestion(AskQuestionRequest $request) {

        $question = new Question();
        $question->title = $request->get('question_title');
        $question->content = $request->get('question_content');
        $question->question_category_id = $request->get('question_category_id');
        $question->user_id = Auth::user()->id;
        $question->save();

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('help_center.question_sent'));

        return response($response->get())->header('Content-Type', 'application/json');
    }

}