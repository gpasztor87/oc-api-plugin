<?php namespace Autumn\Tools;

use App;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

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
        $alias = AliasLoader::getInstance();
        $alias->alias('Fractal', 'Spatie\Fractal\FractalFacade');

        App::register('Spatie\Fractal\FractalServiceProvider');
    }

    public function registerAPIResources()
    {
        return [
            'blog/categories' => 'Autumn\Tools\Resources\BlogCategoryController',
            'blog/posts'      => 'Autumn\Tools\Resources\BlogPostController',
        ];
    }
}
