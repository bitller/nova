<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        'App\Events\UserLoggedIn' => [
            'App\Listeners\LogUserNewSession'
        ],

        'App\Events\UserLoggedOut' => [
            'App\Listeners\LogUserSessionEnd'
        ],

        'App\Events\FailedLogIn' => [
            'App\Listeners\LogFailedLogin'
        ],

        'App\Events\UserCreatedNewBill' => [
            'App\Listeners\LogCreationOfNewBill'
        ],

        'App\Events\HomepageAccessed' => [
            'App\Listeners\LogGetBillsRequest'
        ],

        'App\Events\UserDeletedBill' => [
            'App\Listeners\LogBillDeletion'
        ],

        'App\Events\UserAccessedNotAllowedPage' => [
            'App\Listeners\LogAccessToNotAllowedPage'
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
