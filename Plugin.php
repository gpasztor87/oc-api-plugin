<?php namespace Autumn\Tools;

use App;
use System\Classes\PluginBase;

/**
 * Tools Plugin Information File
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
            'name'        => 'Tools',
            'description' => 'No description provided yet...',
            'author'      => 'Autumn',
            'icon'        => 'icon-suitcase'
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        App::register('Barryvdh\Cors\ServiceProvider');
        App::register('EllipseSynergie\ApiResponse\Laravel\ResponseServiceProvider');
    }

    public function registerAPIResources()
    {
        return [
            'blog/categories' => 'Autumn\Tools\Resources\BlogCategoryResource'
        ];
    }
}
