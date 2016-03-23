<?php namespace Autumn\Api\Console;

use Str;
use October\Rain\Scaffold\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateApi extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'create:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create api controller and transformer for a given model.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'API';

    /**
     * A mapping of stub to generated file.
     *
     * @var array
     */
    protected $stubs = [
        'api/controller.stub'  => 'http/controllers/{{studly_controller}}.php',
        'api/transformer.stub' => 'http/transformers/{{studly_transformer}}.php',
    ];

    /**
     * Prepare variables for stubs.
     *
     * return @array
     */
    protected function prepareVars()
    {
        $pluginCode = $this->argument('plugin');

        $parts = explode('.', $pluginCode);
        $plugin = array_pop($parts);
        $author = array_pop($parts);

        $model = $this->argument('model');
        $transformer = $model . 'Transformer';

        /*
         * Determine the controller name to use.
         */
        $controller = $this->option('controller');
        if (!$controller) {
            $controller = Str::plural($model);
        }

        return [
            'model' => $model,
            'author' => $author,
            'plugin' => $plugin,
            'controller' => $controller,
            'transformer' => $transformer
        ];

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of the plugin to create. Eg: RainLab.Blog'],
            ['model', InputArgument::REQUIRED, 'The name of the model. Eg: Post'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Overwrite existing files with generated ones.'],
            ['controller', null, InputOption::VALUE_OPTIONAL, 'The name of the controller. Eg: Posts'],
        ];
    }

}