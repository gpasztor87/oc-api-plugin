<?php namespace Autumn\Tools\Transformers;

use RainLab\Blog\Models\Post;
use League\Fractal\TransformerAbstract;

class BlogPostTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
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
            'published_at' => $post->published_at->toDateTimeString(),
        ];
    }

    public function includeFeaturedImages(Post $post)
    {
        return $this->collection($post->featured_images, new SystemFileTransformer, 'featured_images');
    }
}