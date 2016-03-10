<?php namespace Autumn\Api\Templates;

use October\Rain\Scaffold\TemplateBase;
use Exception;

class Api extends TemplateBase
{
    /**
     * Make a single stub
     *
     * @param string $stubName The source filename for the stub.
     * @return void
     */
    public function makeStub($stubName)
    {
        if (!isset($this->fileMap[$stubName])) {
            return;
        }

        $sourceFile = __DIR__ . '/' . $stubName;
        $destinationFile = $this->targetPath . '/' . $this->fileMap[$stubName];
        $destinationContent = $this->files->get($sourceFile);

        /*
         * Parse each variable in to the destination content and path
         */
        foreach ($this->vars as $key => $var) {
            $destinationContent = str_replace('{{'.$key.'}}', $var, $destinationContent);
            $destinationFile = str_replace('{{'.$key.'}}', $var, $destinationFile);
        }

        /*
         * Destination directory must exist
         */
        $destinationDirectory = dirname($destinationFile);
        if (!$this->files->exists($destinationDirectory)) {
            $this->files->makeDirectory($destinationDirectory, 0777, true);
        }

        /*
         * Make sure this file does not already exist
         */
        if ($this->files->exists($destinationFile) && !$this->overwriteFiles) {
            throw new Exception('Stop everything!!! This file already exists: ' . $destinationFile);
        }

        $this->files->put($destinationFile, $destinationContent);
    }

    /**
     * @var array A mapping of stub to generated file.
     */
    protected $fileMap = [
        'stubs/controller.stub'  => 'http/controllers/{{studly_controller}}.php',
        'stubs/transformer.stub' => 'http/transformers/{{studly_transformer}}.php',
    ];
}