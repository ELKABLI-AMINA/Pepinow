<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\AuthRequest;




class AuthController extends Controller

{
   
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
       
    } 

    public function register(AuthRequest $request){
      
           
           $user = User::create([
            
                'name'    =>$request->name,
                'email'   =>$request->email,
                'password'=>Hash::make($request->password)
            ]);
            $user->assignRole('user');
            return response()->json([
                'message'=>'Account created successfully'
            ]);
    }

    public function login()
    {
    

        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);
        // if false
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], );
        }

        return $this->respondWithToken($token);
    }

    public function EditProfile(Request $request)
{
    $request->validate([
       
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = Auth::user();
    $user->update([
        'email'=>$request->email,
        'password'=>$request->password
    ]);
    return response()->json(['message'=>'profile updated seccufully']);
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
