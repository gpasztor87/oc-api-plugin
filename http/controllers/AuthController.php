<?php namespace Autumn\Api\Http\Controllers;

use JWTAuth;
use Validator;
use Illuminate\Http\Request;
use RainLab\User\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiController
{
    use \Autumn\Api\Traits\AdditionalRoutes;

    public function __construct()
    {
        $this->addAdditionalRoute('authenticate', 'authenticate', 'post');
        $this->addAdditionalRoute('register', 'register', 'post');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->setStatusCode(401)->respondWithError('invalid_credentials');
            }
        }
        catch (JWTException $ex) {
            return $this->setStatusCode(500)->respondWithError('could_not_create_token');
        }

        return $this->respond(compact('token'));
    }

    public function register(Request $request)
    {
        $data = $request->all();

        if (!array_key_exists('password_confirmation', $request->all())) {
            $data['password_confirmation'] = $request->get('password');
        }

        $validator = $this->validator($data);

        if ($validator->fails()) {
            return $this->setStatusCode(400)->respondWithError($validator->getMessageBag());
        }

        $user = User::create($data);
        $token = JWTAuth::fromUser($user);

        return $this->respond(compact('token'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|between:3,64|unique:users',
            'email' => 'required|between:3,64|email|unique:users',
            'password' => 'required|between:4,64|confirmed',
        ]);
    }

}