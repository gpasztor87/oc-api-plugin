Api plugin
==============

Tools for building RESTful HTTP + JSON APIs for OctoberCMS.
**Note**: this is a work in progress.

### Installation

* Install the [RainLab.User](https://github.com/rainlab/user-plugin) Plugin
* Extract this repository into plugins/autumn/api
* In plugins/autumn/api folder run `composer install`.
* Copy the config/jws.php to the global config folder.

### Usage

To register your API controllers you need to add `registerAPIResources` function to your Plugin.php:

```php

    public function registerAPIResources()
    {
        return [
            'blog/posts' => 'Acme\Blog\Http\Controllers\PostsController'
        ];
    }
```

In your controller you can register your REST API endpoints via `$publicActions` property:

```php

<?php namespace Acme\Blog\Http\Controllers;

use Autumn\Api\Http\Controllers\ApiController;

class PostsController extends ApiController
{
    public $publicActions = ['index'];
    
    public function index()
    {
        // 
    }
}

```