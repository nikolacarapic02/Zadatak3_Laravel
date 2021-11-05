<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Review;
use App\Models\Assignment;
use App\Policies\UserPolicy;
use App\Policies\GroupPolicy;
use App\Policies\InternPolicy;
use App\Policies\MentorPolicy;
use App\Policies\ReviewPolicy;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use App\Policies\AssignmentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Intern::class => InternPolicy::class,
        Group::class => GroupPolicy::class,
        Assignment::class => AssignmentPolicy::class,
        User::class => UserPolicy::class,
        Review::class => ReviewPolicy::class,
        Mentor::class => MentorPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-action', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('create', function ($user) {
            return $user->isRecruiter() || $user->isAdmin();
        });

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();
    }
}
