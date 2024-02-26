<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('testGate', function (User $user) {
            return in_array($user->email, [
                'kareemtarekpk@gmail.com',
                'mr.hatab055@gmail.com',
                'codexsoftwareservices01@gmail.com',
            ]);
        });
    }
}
