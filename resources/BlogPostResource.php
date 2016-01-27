<?php namespace Autumn\Tools\Resources;

use Autumn\Tools\Classes\ResourceBase;
use Autumn\Tools\Transformers\BlogPostTransformer;
use RainLab\Blog\Models\Post;

class BlogPostResource extends ResourceBase
{
    /**
     * @var array
     */
    public $publicActions = ['index', 'show'];

    public function index()
    {
        $posts = Post::all();

        return $this->response->withCollection($posts, new BlogPostTransformer);
    }

    public function show($id)
    {
        $post = Post::find($id);

        return $this->response->withItem($post, new BlogPostTransformer);
    }
}