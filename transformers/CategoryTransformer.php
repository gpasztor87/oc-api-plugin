<?php namespace Autumn\Tools\Transformers;

use League\Fractal\TransformerAbstract;
use RainLab\Blog\Models\Category;

class CategoryTransformer extends TransformerAbstract
{

    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug
        ];
    }
}