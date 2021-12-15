<?php
namespace App\Http\Controllers;
use JWTAuth;
use App\Models\Admin;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;


class AdminController extends Controller
{
    public $loginAfterSignUp = true;
  public function login(Request $request)
   {        //dd($request->all()); 
       $input = $request->only('email', 'password');
       $token = null;
       if (!$token = auth('admin')->attempt($input)) {
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
   
       auth('admin')->logout();
   
}
public function register(Request $request)
   {
       $admin = new Admin();
       $admin->name = $request->name;
       $admin->email = $request->email;
       $admin->password = bcrypt($request->password);
       $admin->save();

       if ($this->loginAfterSignUp) {
           return $this->login($request);
       }

       return response()->json([
           'success'   =>  true,
           'data'      =>  $admin
       ], 200);
   }
}



