#Api plugin

Tools for building RESTful HTTP + JSON APIs for OctoberCMS.
**Note**: this is a work in progress.

## Introduction

This plugin provides two features

1. Console generator which creates Controller and Fractal Transformer in a single command.

2. Basic REST API skeleton that can be really helpful if you need something standard. It's 100% optional.

If you do not use Fractal for your transformation layer, this plugin is probably not the right choice for you.

## Installation

* Extract this repository into plugins/autumn/api
* In plugins/autumn/api folder run `composer install`.

## Usage

### Generator

The only console command that is added is ```artisan create:api <AuthorName>.<PluginName> <ModelName>```.

Imagine you need to create a rest api to list/create/update etc posts from Acme.Blog plugin. 
To achieve that you need to do lots of boilerplate operations - create controller, transformer, set up needed routes.

```php artisan create:api Acme.Blog Post``` does all the work for you.


1. To register your API resources you need to add `registerAPIResources` function to your Plugin.php:

```php

    public function registerAPIResources()
    {
        return [
            'blog/posts' => 'Acme\Blog\Http\Controllers\Posts'
        ];
    }
```

2) The generator creates a controller that extends base api controller.
In the controller you can register your API endpoints via `$publicActions` property:

```php

<?php namespace Acme\Blog\Http\Controllers;

use Acme\Blog\Models\Post;
use Acme\Blog\Http\Transformers\PostTransformer;
use Autumn\Api\Http\Controllers\ApiController;

class PostsController extends ApiController
{
    public $publicActions = ['index', 'show'];
    
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Post;
    }
    
    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new PostTransformer;
    }
}

```

3) Finally the generator creates a fractal Transformer

```php
<?php namespace Acme\Blog\Http\Transformers;

use Acme\Blog\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{   
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Post $item)
    {
        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }
}

```

The list of routes that are available out of the box:

1. `GET api/v1/blog/posts`
2. `GET api/v1/blog/posts/{id}`