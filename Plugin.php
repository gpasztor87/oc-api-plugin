<?php

namespace Autumn\Api;

use App;
use System\Classes\PluginBase;

/**
 * Api Plugin Information File.
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
            'icon'        => 'icon-paper-plane',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        App::register('Barryvdh\Cors\ServiceProvider');

        $this->registerConsoleCommand('create.api', 'Autumn\Api\Console\CreateApi');
    }
}
