<?php

namespace App\Http\Controllers\AdminCenter;

use App\HelpCenterArticle;
use App\HelpCenterCategory;
use App\Helpers\AdminCenter\HelpCenterManagerHelper;
use App\Helpers\AjaxResponse;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\HelpCenterManager\AddArticleRequest;
use App\Http\Requests\AdminCenter\HelpCenterManager\AddCategoryRequest;
use App\Http\Requests\AdminCenter\HelpCenterManager\DeleteArticleRequest;
use App\Http\Requests\AdminCenter\HelpCenterManager\DeleteCategoryRequest;
use App\Http\Requests\AdminCenter\HelpCenterManager\EditArticleRequest;
use App\Http\Requests\AdminCenter\HelpCenterManager\EditCategoryRequest;
use App\Http\Requests\AdminCenter\HelpCenterManager\GetCategoryRequest;
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

    /**
     * Render category page.
     *
     * @param $categoryId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($categoryId) {
        return view('admin-center.help-center-manager.category')->with('categoryId', $categoryId);
    }

    /**
     * Get category data.
     *
     * @param int $categoryId
     * @param GetCategoryRequest $request
     * @return mixed
     */
    public function getCategory($categoryId, GetCategoryRequest $request) {

        $response = new AjaxResponse();
        $category = HelpCenterCategory::where('id', $categoryId)->first();

        if (!$category) {
            $response->setFailMessage(trans('help_center.category_not_found'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        $extraFields = [
            'category' => $category
        ];
        $articles = HelpCenterManagerHelper::getCategoryArticles($categoryId);
        if (count($articles)) {
            $extraFields['articles'] = $articles;
        }

        $response->setSuccessMessage(trans('common.success'));
        $response->addExtraFields($extraFields);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Add article.
     *
     * @param int $categoryId
     * @param AddArticleRequest $request
     * @return mixed
     */
    public function addArticle($categoryId, AddArticleRequest $request) {

        $response = new AjaxResponse();
        $category = HelpCenterCategory::where('id', $categoryId)->first();

        if (!$category) {
            $response->setFailMessage(trans('help_center.category_not_found'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        // Insert new article
        $article = new HelpCenterArticle();
        $article->title = $request->get('article_title');
        $article->content = $request->get('article_content');
        $article->category_id = $categoryId;
        $article->save();

        $extraFields = [];
        $articles = HelpCenterManagerHelper::getCategoryArticles($categoryId);
        if (count($articles)) {
            $extraFields['articles'] = $articles;
        }

        $response->setSuccessMessage(trans('help_center.article_added'));
        $response->addExtraFields($extraFields);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Delete article.
     *
     * @param int $categoryId
     * @param DeleteArticleRequest $request
     * @return mixed
     */
    public function deleteArticle($categoryId, DeleteArticleRequest $request) {

        $response = new AjaxResponse();
        $category = HelpCenterCategory::where('id', $categoryId)->first();

        if (!$category) {
            $response->setFailMessage(trans('help_center.category_not_found'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        // Delete article
        HelpCenterArticle::where('id', $request->get('article_id'))->delete();

        // Get remaining articles
        $extraFields = [];
        $articles = HelpCenterManagerHelper::getCategoryArticles($categoryId);
        if (count($articles)) {
            $extraFields['articles'] = $articles;
        }

        $response->setSuccessMessage(trans('help_center.article_deleted'));
        $response->addExtraFields($extraFields);
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Edit article title and content.
     *
     * @param int $categoryId
     * @param EditArticleRequest $request
     * @return mixed
     */
    public function editArticle($categoryId, EditArticleRequest $request) {

        $response = new AjaxResponse();
        $category = HelpCenterCategory::where('id', $categoryId)->first();

        if (!$category) {
            $response->setFailMessage(trans('help_center.category_not_found'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        // Edit article
        $article = HelpCenterArticle::find($request->get('article_id'));
        $article->title = $request->get('article_title');
        $article->content = $request->get('article_content');
        $article->save();

        // Get updated version of articles
        $extraFields = [];
        $articles = HelpCenterManagerHelper::getCategoryArticles($categoryId);
        if (count($articles)) {
            $extraFields['articles'] = $articles;
        }

        $response->setSuccessMessage(trans('help_center.article_updated'));
        $response->addExtraFields($extraFields);
        return response($response->get())->header('Content-Type', 'application/json');
    }
}