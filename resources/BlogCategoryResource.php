<?php namespace Autumn\Tools\Resources;

use Autumn\Tools\Classes\ResourceBase;
use Autumn\Tools\Transformers\BlogCategoryTransformer;
use RainLab\Blog\Models\Category;

class BlogCategoryResource extends ResourceBase
{
    /**
     * @var array
     */
    public $publicActions = ['index', 'show'];

    public function index()
    {
        $categories = Category::all();

        return $this->response->withCollection($categories, new BlogCategoryTransformer);
    }

    public function show($id)
    {
        $category = Category::find($id);

        return $this->response->withItem($category, new BlogCategoryTransformer);
    }
}