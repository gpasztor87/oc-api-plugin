<?php namespace Autumn\Api\Http\Controllers;

use JWTAuth;
use Validator;
use Illuminate\Http\Request;
use RainLab\User\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends BaseController
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
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        }
        catch (JWTException $ex) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $data = $request->all();

        if (! array_key_exists('password_confirmation', $request->all())) {
            $data['password_confirmation'] = $request->get('password');
        }

        $validator = $this->validator($data);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 400);
        }

        $user = User::create($data);
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
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