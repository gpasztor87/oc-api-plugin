<?php namespace Autumn\Tools\Resources;

use Illuminate\Routing\Controller;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Autumn\Tools\Transformers\BlogCategoryTransformer;
use RainLab\Blog\Models\Category;

class BlogCategoryResource extends Controller
{
    /**
     * @var array
     */
    public $publicActions = ['index', 'show'];

    /**
     * @param $response Response
     */
    public function __construct(Response $response = null)
    {
        $this->response = $response;
    }

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