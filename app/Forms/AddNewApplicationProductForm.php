<?php

namespace App\Forms;

use App\ApplicationProduct;
use App\Helpers\AjaxResponse;

class AddNewApplicationProductForm {

    /**
     * @var null
     */
    protected $response = null;

    /**
     * @var null
     */
    protected $applicationProduct = null;

    /**
     * @var array
     */
    protected $inputs = [];

    /**
     * AddNewApplicationProductForm constructor.
     *
     * @param $inputs
     */
    public function __construct($inputs) {

        $this->response = new AjaxResponse();
        $this->applicationProduct = new ApplicationProduct();
        $this->inputs = $inputs;
    }

    public function add() {

        $this->applicationProduct->name = $this->inputs['product_name'];
        $this->applicationProduct->code = $this->inputs['product_code'];

        // If product code is used, update with new one (that is not used)
        if (ApplicationProduct::where('code', $this->applicationProduct->code)->count()) {

            // Make sure the code used to replace already used code is not also used
            if(ApplicationProduct::where('code',  $this->inputs['not_used_code'])->count()) {
                $this->response->setFailMessage(trans('products_manager.code_already_used'));
                return response($this->response->get());
            }

            ApplicationProduct::where('code', $this->applicationProduct->code)->update(['code' => $this->inputs['not_used_code']]);
            // todo Fire notification to the users
        }

        $this->applicationProduct->save();
        $this->response->setSuccessMessage(trans('products_manager.product_added'));

        return response($this->response->get())->header('Content-Type', 'application/json');
    }

}