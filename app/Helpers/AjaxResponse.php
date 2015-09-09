<?php

namespace App\Helpers;

/**
 * Create responses for ajax requests
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AjaxResponse {

    /**
     * Response type
     *
     * @var bool
     */
    private $success;

    /**
     * Response title
     *
     * @var string
     */
    private $title = '';

    /**
     * Response message
     *
     * @var string
     */
    private $message = '';

    /**
     * Unprocessable Entity code
     *
     * @var int
     */
    private $defaultErrorCode = 422;

    /**
     * @param string $type
     */
    public function __construct($type = 'success') {

        if ($type === 'success') {
            $this->success = true;
        } else {
            $this->success = false;
        }

    }

    /**
     * Set given $title
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Set success message and default success title
     *
     * @param string $message
     */
    public function setSuccessMessage($message) {
        $this->success = true;
        $this->setDefaultSuccessTitle();
        $this->message = $message;
    }

    /**
     * Set fail message and default fail title
     *
     * @param string $message
     */
    public function setFailMessage($message) {
        $this->success = false;
        $this->setDefaultFailTitle();
        $this->message = $message;
    }

    /**
     * Set response status to success
     */
    public function setSuccess() {
        $this->success = true;
    }

    /**
     * Set response status to fail
     */
    public function setFail() {
        $this->success = false;
    }

    /**
     * Set default success title
     */
    public function setDefaultSuccessTitle() {
        $this->title = trans('common.success');
    }

    /**
     * Set default fail title
     */
    public function setDefaultFailTitle() {
        $this->title = trans('common.fail');
    }

    /**
     * Return response array
     *
     * @return array
     */
    public function get() {
        return [
            'success' => $this->success,
            'title' => $this->title,
            'message' => $this->message
        ];
    }

    /**
     * Return
     *
     * @return int
     */
    public function getDefaultErrorResponseCode() {
        return $this->defaultErrorCode;
    }

}