<?php

namespace App\Http\Controllers\AdminCenter;

use App\HelpCenterCategory;
use App\Helpers\AdminCenter\HelpCenterManagerHelper;
use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\HelpCenterManager\AddCategoryRequest;
use App\Http\Requests\AdminCenter\HelpCenterManager\DeleteCategoryRequest;
use App\Http\Requests\AdminCenter\HelpCenterManager\EditCategoryRequest;
use App\Http\Requests\AdminCenter\HelpCenterManager\GetHelpCenterCategoriesRequest;

/**
 * Edit help center section.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class HelpCenterManagerController extends BaseController {

    /**
     * Allow logged in users only.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin-center.help-center-manager.index');
    }

    /**
     * @param GetHelpCenterCategoriesRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function get(GetHelpCenterCategoriesRequest $request) {

        $response = new AjaxResponse();
        $response->setSuccessMessage('success');
        $response->addExtraFields(['categories' => HelpCenterManagerHelper::getHelpCenterCategories()]);

        return response($response->get());
    }

    /**
     * Add new category.
     *
     * @param AddCategoryRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function addCategory(AddCategoryRequest $request) {

        // Insert new category
        $helpCenterCategory = new HelpCenterCategory();
        $helpCenterCategory->name = $request->get('category_name');
        $helpCenterCategory->save();

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('category_added'));
        $response->addExtraFields(['categories' => HelpCenterManagerHelper::getHelpCenterCategories()]);

        return response($response->get());
    }

    /**
     * Delete category.
     *
     * @param DeleteCategoryRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteCategory(DeleteCategoryRequest $request) {

        HelpCenterCategory::where('id', $request->get('category_id'))->delete();

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('category_deleted'));
        $response->addExtraFields(['categories' => HelpCenterManagerHelper::getHelpCenterCategories()]);

        return response($response->get());
    }

    /**
     * Update category.
     *
     * @param EditCategoryRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editCategory(EditCategoryRequest $request) {

        HelpCenterCategory::where('id', $request->get('category_id'))->update(['name' => $request->get('new_name')]);

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('category_updated'));
        $response->addExtraFields(['categories' => HelpCenterManagerHelper::getHelpCenterCategories()]);

        return response($response->get());
    }

    public function category() {
        return view('admin-center.help-center-manager.category');
    }

    public function getCategory() {
        //
    }
}