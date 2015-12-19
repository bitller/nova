<?php

namespace App\Helpers;

use App\Action;
use App\UserAction;
use Illuminate\Support\Facades\Auth;

/**
 * Handle work with user actions.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserActions {

    /**
     * Save allowed user action.
     *
     * @param int $userId
     * @param string $message
     */
    public static function allowed($userId, $message) {
        self::saveAction($userId, 'allowed', $message);
    }

    /**
     * Save info user action.
     *
     * @param int $userId
     * @param string $message
     */
    public static function info($userId, $message) {
        self::saveAction($userId, 'info', $message);
    }

    /**
     * Save wrong format user action.
     *
     * @param int $userId
     * @param string $message
     */
    public static function wrongFormat($userId, $message) {
        self::saveAction($userId, 'wrong_format', $message);
    }

    /**
     * Save not allowed user action.
     *
     * @param int $userId
     * @param string $message
     */
    public static function notAllowed($userId, $message) {
        self::saveAction($userId, 'not_allowed', $message);
    }

    /**
     * Paginate all actions that match given $userId.
     *
     * @param int $userId
     * @return mixed
     */
    public static function getAll($userId) {
        return self::get($userId);
    }

    /**
     * Paginate all allowed actions that match given $userId.
     *
     * @param int $userId
     * @return mixed
     */
    public static function getAllowed($userId) {
        return self::get($userId, 'allowed');
    }

    /**
     * Paginate all info actions that match given $userId.
     *
     * @param int $userId
     * @return mixed
     */
    public static function getInfo($userId) {
        return self::get($userId, 'info');
    }

    /**
     * Paginate all wrong format actions that match given $userId.
     *
     * @param int $userId
     * @return mixed
     */
    public static function getWrongFormat($userId) {
        return self::get($userId, 'wrong_format');
    }

    /**
     * Paginate all not allowed actions that match given $userId.
     *
     * @param int $userId
     * @return mixed
     */
    public static function getNotAllowed($userId) {
        return self::get($userId, 'not_allowed');
    }

    /**
     * Save user action with given $type and $message.
     *
     * @param int $userId
     * @param string $type
     * @param string $message
     */
    private static function saveAction($userId, $type, $message) {

        $action = Action::where('type', $type)->select('id')->first();

        $userAction = new UserAction();
        $userAction->action_id = $action->id;
        $userAction->message = $message;
        $userAction->user_id = $userId;
        $userAction->save();

    }

    /**
     * Get actions that match given $userId.
     *
     * @param int $userId
     * @param bool $type
     * @return mixed
     */
    private static function get($userId, $type = false) {

        $query = UserAction::where('user_id', $userId)
            ->select('actions.name as name', 'actions.type as type', 'user_actions.id as id',
                'user_actions.message as message', 'user_actions.created_at as created_at')
            ->leftJoin('actions', 'user_actions.action_id', '=', 'actions.id');

        // If $type is given, use in where condition
        if ($type) {
            $action = Action::where('type', $type)->select('id')->first();
            $query->where('user_actions.action_id', $action->id);
        }

        return $query->orderBy('user_actions.created_at', 'desc')->paginate();
    }

}