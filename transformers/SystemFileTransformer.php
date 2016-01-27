<?php namespace Autumn\Tools\Transformers;

use System\Models\File;
use League\Fractal\TransformerAbstract;

class SystemFileTransformer extends TransformerAbstract
{

    public function transform(File $file)
    {
        return [
            'thumbnail' => $this->getImageUrl($file, [300, 300]),
            'original' => $this->getImageUrl($file)
        ];
    }

    protected function getImageUrl($file, $size = null)
    {
        if (!is_null($size) && is_array($size)) {
            return $file->getThumb($size[0], $size[1], ['extension' => 'png']);
        }
        else {
            return $file->path;
        }
    }
}