<?php

namespace App\Providers;

use App\Models\LocalEvent;
use App\Policies\LocalEventPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        LocalEvent::class => LocalEventPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
