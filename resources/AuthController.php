<?php namespace Autumn\Api\Resources;

use Autumn\Api\Classes\ApiController;

class AuthController extends ApiController
{
    use \Autumn\Api\Traits\AdditionalRoutes;

    public function __construct()
    {
        $this->addAdditionalRoute('authenticate', 'authenticate', 'post');
        $this->addAdditionalRoute('register', 'register', 'post');
    }

    public function authenticate()
    {

    }

    public function register()
    {

    }

}