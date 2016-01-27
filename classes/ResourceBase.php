<?php namespace Autumn\Tools\Classes;

use League\Fractal\Manager;
use Illuminate\Routing\Controller;
use EllipseSynergie\ApiResponse\Laravel\Response;

class ResourceBase extends Controller
{

    public function __construct()
    {
        // Instantiate the fractal manager
        $manager = new Manager;

        // Instantiate the response object
        $this->response = new Response($manager);
    }

}