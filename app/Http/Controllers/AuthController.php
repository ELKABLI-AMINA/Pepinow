<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;




class AuthController extends Controller

{
   
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    } 

    public function register(Request $request){
        $this->validate($request,[
            'name'    =>'required',
            'email'   =>'required',
            'password'=>'required'
    
            ] );
           
           $user = User::create([
            
                'name'    =>$request->name,
                'email'   =>$request->email,
                'password'=>Hash::make($request->password)
            ]);
            return response()->json([
                'message'=>'Account created successfully'
            ]);
    }

    public function login()
    {
    

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function reset(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8'
    ]);

    $response = $this->broker()->reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        }
    );

    return $response == Password::PASSWORD_RESET
        ? response()->json(['message' => 'Mot de passe réinitialisé avec succès'], 200)
        : response()->json(['message' => 'La réinitialisation du mot de passe a échoué'], 422);
}


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
     /**
     * Refresh a token.
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
