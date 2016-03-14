<?php namespace Autumn\Api\Console;

use Str;
use Illuminate\Console\Command;
use Autumn\Api\Classes\ApiGenerator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateApiCommand extends Command
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
     * Execute the console command.
     */
    public function fire()
    {
        /*
         * Extract the author and name from the plugin code
         */
        $pluginCode = $this->argument('pluginCode');

        $parts = explode('.', $pluginCode);
        $pluginName = array_pop($parts);
        $authorName = array_pop($parts);

        $destinationPath = base_path('plugins/' . strtolower($authorName) . '/' . strtolower($pluginName));
        $modelName = $this->argument('model');
        $transformerName = $modelName . 'Transformer';

        /*
         * Determine the controller name to use.
         */
        $controllerName = $this->option('controllerName');
        if (!$controllerName) {
            $controllerName = Str::plural($modelName);
        }

        $vars = [
            'model' => $modelName,
            'author' => $authorName,
            'plugin' => $pluginName,
            'controller' => $controllerName,
            'transformer' => $transformerName
        ];

        ApiGenerator::make($destinationPath, $vars, $this->option('force'));

        $this->info(sprintf('Successfully generated Api resources for "%s"', $modelName));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['pluginCode', InputArgument::REQUIRED, 'The name of the plugin to create. Eg: RainLab.Blog'],
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
            ['controllerName', null, InputOption::VALUE_OPTIONAL, 'The name of the controller. Eg: Posts'],
        ];
    }

}