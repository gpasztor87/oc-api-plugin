<?php namespace Autumn\Api\Classes;

use October\Rain\Auth\AuthException;
use RainLab\User\Classes\AuthManager;
use Tymon\JWTAuth\Providers\Auth\AuthInterface;

class RainAuthAdapter implements AuthInterface
{
    /**
     * @var \RainLab\User\Classes\AuthManager
     */
    protected $auth;

    public function __construct()
    {
        $this->auth = AuthManager::instance();
    }

    /**
     * Check a user's credentials.
     *
     * @param  array $credentials
     * @return mixed
     */
    public function byCredentials(array $credentials = [])
    {
        try {
            $user = $this->auth->findUserByCredentials($credentials);
            $this->auth->setUser($user);

            return $user;
        }
        catch (AuthException $e) {
            return false;
        }
    }

    /**
     * Authenticate a user via the id.
     *
     * @param  mixed $id
     * @return bool
     */
    public function byId($id)
    {
        if (!is_null($user = $this->auth->findUserById($id))) {
            $this->auth->setUser($user);

            return true;
        }

        return false;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \RainLab\User\Models\User
     */
    public function user()
    {
        return $this->auth->getUser();
    }
}