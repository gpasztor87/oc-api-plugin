<?php namespace Autumn\Tools\Transformers;

use RainLab\Blog\Models\Post;
use League\Fractal\TransformerAbstract;

class BlogPostTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'featured_images',
    ];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'content' => $post->content,
            'published' => $post->published,
            'published_at' => $post->published_at,
            'categories' => $post->categories
        ];
    }

    public function includeFeaturedImages(Post $post)
    {
        $images = $post->featured_images;

        return $this->collection($images, new SystemFileTransformer);
    }
}