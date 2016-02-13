<?php namespace Autumn\Api;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMiddleware('jwt.auth', 'Tymon\JWTAuth\Middleware\GetUserFromToken');
        $this->registerMiddleware('jwt.refresh', 'Tymon\JWTAuth\Middleware\RefreshToken');
    }

    /**
     * Helper method to quickly setup middleware.
     *
     * @param string $alias
     * @param string $class
     */
    protected function registerMiddleware($alias, $class)
    {
        $this->app['router']->middleware($alias, $class);
    }
}