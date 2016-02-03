<?php namespace Autumn\Tools\Resources;

use Autumn\Tools\Classes\ApiController;
use Autumn\Tools\Transformers\BlogCategoryTransformer;
use RainLab\Blog\Models\Category;
use Spatie\Fractal\ArraySerializer;

class BlogCategoryController extends ApiController
{
    /**
     * @var array
     */
    public $publicActions = ['index', 'show'];

    public function index()
    {
        $categories = Category::all();

        if (!$categories) {
            return $this->respondNoContent();
        }

        return $this->respond(
            fractal()
                ->collection($categories, new BlogCategoryTransformer())
                ->parseIncludes(['posts'])
                ->serializeWith(new ArraySerializer())
                ->toArray()
        );
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->respondNotFound();
        }

        return $this->respond(
            fractal()
                ->item($category, new BlogCategoryTransformer())
                ->parseIncludes(['posts'])
                ->serializeWith(new ArraySerializer())
                ->toArray()
        );
    }
}