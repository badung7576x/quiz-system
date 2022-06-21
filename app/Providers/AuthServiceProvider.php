<?php

namespace App\Providers;

use App\Models\Subject;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerGates();
    }

    public function registerGates()
    {
        Gate::define('is_admin', function ($user) {
            return $user->role === ROLE_ADMIN;
        });

        Gate::define('is_teacher', function ($user) {
            return $user->role === ROLE_TEACHER;
        });

        Gate::define('is_subject_teacher', function ($user) {
            return $user->role === ROLE_SUBJECT_TEACHER;
        });

        Gate::define('is_specialist_teacher', function ($user) {
            return $user->role === ROLE_SPECIALIST_TEACHER;
        });

        Gate::define('is_pro_chief', function ($user) {
            return $user->role === ROLE_PRO_CHIEF;
        });

        Gate::define('can-access', function ($user, $model) {
            if ($model instanceof Subject) {
                return $user->role === ROLE_ADMIN || $model->id === $user->subject_id;
            } else {
                return $user->role === ROLE_ADMIN || $model->subject_id === $user->subject_id;
            }
        });

        Gate::define('can-update-question', function ($user, $question) {
            return $question->created_by === $user->id;
        });
    }
}
