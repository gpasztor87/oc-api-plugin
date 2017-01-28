<?php

namespace Autumn\Api\Providers;

use Autumn\Api\Http\Middleware\ThrottleRequests;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->middleware('throttle', ThrottleRequests::class);
    }
}
