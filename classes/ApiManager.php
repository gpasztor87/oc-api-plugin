<?php namespace Autumn\Api\Classes;

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
        foreach ($this->getResources() as $url => $class) {
            $resource = App::make($class);
            $options = isset($resource->publicActions)
                ? ['only' => $resource->publicActions]
                : [];

            if (method_exists($resource, 'getAdditionalRoutes')) {
                $routes = $resource->getAdditionalRoutes();
                foreach ($routes as $_url => $args) {
                    if (!$routeName = array_get($args, 'name')) {
                        $routeName = 'api.v1.' . strtolower($url) . '.' . strtolower($args['handler']);
                    }

                    $_url = $url . '/' . $_url;
                    app('router')->{$args['verb']}($_url, [
                        'as' => $routeName,
                        'uses' => $class . '@' . $args['handler']
                    ]);
                }
            }

            Route::resource($url, $class, $options);
        }
    }

    public function getResources()
    {
        $this->loadResources();

        return $this->resources;
    }

}