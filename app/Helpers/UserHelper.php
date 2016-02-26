<?php

namespace App\Helpers;
use App\UserTrialPeriod;

/**
 * Helper methods to handle work with users.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserHelper {

    /**
     * Return a string with information about remaining subscription time.
     *
     * @return string
     */
    public static function remainingSubscriptionFormatted() {
        // Check if trial is expired

        $userTrial = self::_userTrialPeriodQuery(\Auth::user()->id);
        // Calculate trial end date
        $endDate = date('d-m-Y', strtotime("+" . $userTrial['validity_days'] . " days", strtotime($userTrial['start'])));

        $remainingDays = strtotime($endDate) - strtotime($userTrial['start']);
        $remainingDays = floor($remainingDays/(60*60*24));

        // Check if period is expired
        if ($remainingDays < 1) {
            // todo create message for expired period
        }

        // you still have x free days, until date
        return trans('settings.subscription_period_info', ['end' => $endDate, 'remaining_days' => $remainingDays]);

        // todo when paid subscriptions are implemented, check also for them
    }

    /**
     * Return number of subscription left days.
     *
     * @param bool $userId Optional. If not given, id of current logged in user will be used.
     * @return float
     */
    public static function subscriptionLeftDays($userId = false) {
        // Check if an user id was given
        if (!$userId) {
            $userId = \Auth::user()->id;
        }

        $userTrial = self::_userTrialPeriodQuery($userId);

        // Calculate left days
        $endDate = date('d-m-Y', strtotime("+" . $userTrial['validity_days'] . " days", strtotime($userTrial['start'])));
        $remainingDays = strtotime($endDate) - strtotime($userTrial['start']);

        return floor($remainingDays/(60*60*24));
    }

    /**
     * Return subscription left days for given user.
     *
     * @param bool $userId
     * @return float
     */
    public static function subscriptionExpired($userId = false) {
    }

    public static function updateSubscriptionIfExpired($userId = false) {

        if (!$userId) {
            $userId = \Auth::user()->id;
        }
        \Log::info(self::subscriptionLeftDays($userId));
        if (self::subscriptionLeftDays($userId) < 1) {
            UserTrialPeriod::where('user_id', $userId)->update(['expired' => 1]);
            // todo fire SubscriptionExpired event
        }
    }

    /**
     * Return trial period of given user.
     *
     * @param int|bool $userId Optional. If not given the id of current logged in user will be used.
     * @return array
     *      'validity_days' int Number of validity days.
     *      'start' string Trial start date
     */
    private static function _userTrialPeriodQuery($userId = false) {

        if (!$userId) {
            $userId = \Auth::user()->id;
        }

        $userTrial = UserTrialPeriod::where('user_id', $userId)
            ->select('user_trial_periods.created_at as start', 'trial_periods.validity_days as validity_days')
            ->leftJoin('trial_periods', 'user_trial_periods.trial_period_id', '=', 'trial_periods.id')
            ->groupBy('trial_periods.id')
            ->first();

        return $userTrial;
    }
}