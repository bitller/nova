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
    public static function remainingSubscription() {
        // Check if trial is expired
        $userTrial = UserTrialPeriod::where('user_id', \Auth::user()->id)
            ->select('user_trial_periods.created_at as start', 'trial_periods.validity_days as validity_days')
            ->leftJoin('trial_periods', 'user_trial_periods.trial_period_id', '=', 'trial_periods.id')
            ->groupBy('trial_periods.id')
            ->first();

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

}