<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;

//Gate::define(...);
//class AppServiceProvider extends ServiceProvider
class AppServiceProvider extends \Illuminate\Foundation\Support\Providers\AuthServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];
    public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
    }
}
