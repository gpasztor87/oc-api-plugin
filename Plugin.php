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
            'description' => 'No description provided yet...',
            'author'      => 'Autumn',
            'icon'        => 'icon-paper-plane'
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        $alias = AliasLoader::getInstance();
        $alias->alias('Fractal', 'Spatie\Fractal\FractalFacade');

        App::register('Spatie\Fractal\FractalServiceProvider');
    }
}
