<?php namespace Autumn\Tools\Resources;

use Autumn\Tools\Classes\ApiController;
use Autumn\Tools\Transformers\BlogPostTransformer;
use RainLab\Blog\Models\Post;
use Spatie\Fractal\ArraySerializer;

class BlogPostController extends ApiController
{
    /**
     * @var array
     */
    public $publicActions = ['index', 'show'];

    public function index()
    {
        $posts = Post::all();

        if (!$posts) {
            return $this->respondNoContent();
        }

        return $this->respond(
            fractal()
                ->collection($posts, new BlogPostTransformer())
                ->parseIncludes(['featured_images'])
                ->serializeWith(new ArraySerializer())
                ->toArray()
        );
    }

    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->respondNotFound();
        }

        return $this->respond(
            fractal()
                ->item($post, new BlogPostTransformer())
                ->parseIncludes(['featured_images'])
                ->serializeWith(new ArraySerializer())
                ->toArray()
        );
    }
}