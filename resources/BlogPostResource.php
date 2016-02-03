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
        $query = Post::isPublished();

        $query->with([
            'user' => function($user) {
                $user->select('id', 'first_name', 'last_name', 'email');

            },
            'categories' => function($category) {
                $category->select('name', 'slug');
            },
            'featured_images'
        ]);

        return $query->find($id);

        //return $this->response->withItem($post, new BlogPostTransformer);
    }
}