<?php namespace Autumn\Api;

use App;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

/**
 * Api Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Api',
            'description' => 'Tools for building RESTful HTTP + JSON APIs.',
            'author'      => 'Autumn',
            'icon'        => 'icon-paper-plane'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $alias = AliasLoader::getInstance();
        $alias->alias('Fractal', 'Spatie\Fractal\FractalFacade');

        App::register('Spatie\Fractal\FractalServiceProvider');
    }

    public function registerAPIResources()
    {
        return [
            'auth' => 'Autumn\Api\Resources\AuthController',
        ];
    }
}
