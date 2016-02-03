<?php namespace Autumn\Tools\Transformers;

use RainLab\User\Models\User;
use League\Fractal\TransformerAbstract;

class RainLabUserTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname,
            'username' => $user->username,
            'email' => $user->email
        ];
    }
}