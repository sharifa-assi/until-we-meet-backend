<?php
namespace App\Http\Controllers;
use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;


class AuthController extends Controller
{
    public $loginAfterSignUp = true;
  public function login(Request $request)
   {
       $input = $request->only('email', 'password');
       $token = null;
       if (!$token = JWTAuth::attempt($input)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid Email or Password',
        ], 401);
    }
    return response()->json([
        'success' => true,
        'token' => $token,
    ]);
}
public function logout(Request $request)
{
   
}
public function register(Request $request)
   {
       $user = new User();
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = bcrypt($request->password);
       $user->save();

       if ($this->loginAfterSignUp) {
           return $this->login($request);
       }

       return response()->json([
           'success'   =>  true,
           'data'      =>  $user
       ], 200);
   }
}



