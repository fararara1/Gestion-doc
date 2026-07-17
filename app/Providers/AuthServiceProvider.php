<?php

namespace App\Providers;

use App\Models\Document;
use App\Models\Meeting;
use App\Policies\DocumentPolicy;
use App\Policies\MeetingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Document::class => DocumentPolicy::class,
        Meeting::class => MeetingPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
