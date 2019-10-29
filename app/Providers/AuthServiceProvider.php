<?php

namespace App\Providers;

use App\Answer;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update', function ($user, $question){
            return $user->id === $question->user_id;
        });

        Gate::define('delete', function ($user, $question){
            return $user->id === $question->user_id;
        });

        Gate::define('accept', function (User $user, Answer $answer){
            return $user->id === $answer->question['user_id'];
        });
    }
}
