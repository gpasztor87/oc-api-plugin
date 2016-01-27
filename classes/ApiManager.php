<?php namespace Autumn\Tools\Classes;

use App;
use Route;
use System\Classes\PluginManager;

class ApiManager
{
    use \October\Rain\Support\Traits\Singleton;

    /**
     * Internal use. Keep record of all register resources of the API
     *
     * @var array
     */
    private $resources = [];

    /**
     * @var \System\Classes\PluginManager
     */
    protected $pluginManager;

    /**
     * Initialize this singleton.
     */
    protected function init()
    {
        $this->pluginManager = PluginManager::instance();
    }

    public function loadResources()
    {
        /*
         * Load plugin items
         */
        $plugins = $this->pluginManager->getPlugins();

        foreach ($plugins as $id => $plugin) {
            if(!method_exists($plugin, 'registerAPIResources')) {
                continue;
            }

            $resources = $plugin->registerAPIResources();
            if (!is_array($resources)) {
                continue;
            }


            $this->registerResources($resources);
        }
    }

    public function registerResources(array $resources)
    {
        $this->resources = array_merge($this->resources, $resources);
    }

    public function getRoutes()
    {
        $this->loadResources();
        foreach($this->resources as $url => $class) {
            $resource = App::make($class);
            $publicActions = $resource->publicActions ?:[];

            Route::resource($url, $class, ['only' => $publicActions]);
        }
    }
}