<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use DB;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    public function boot()
    {
        parent::boot();

        DB::listen(
            function ($sql, $bindings, $time) {
                dd($sql);
                //  $sql - select * from `ncv_users` where `ncv_users`.`id` = ? limit 1
                //  $bindings - [5]
                //  $time(in milliseconds) - 0.38
            }
        );
    }
}
