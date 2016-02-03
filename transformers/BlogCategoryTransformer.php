<?php namespace Autumn\Tools\Transformers;

use League\Fractal\TransformerAbstract;
use RainLab\Blog\Models\Category;

class BlogCategoryTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'posts'
    ];

    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug
        ];
    }

    public function includePosts(Category $category)
    {
        return $this->collection($category->posts, new BlogPostTransformer, 'posts');
    }
}