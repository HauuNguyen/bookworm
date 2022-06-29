<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\hash ;
use Carbon\Carbon;
use App\Models\User  ;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->query = User::query();
    }
    public function register(Request $request)
    {

        $request->validate([
            'first_name'    =>'required|string',
            'last_name'     =>'required|string',
            'email'         =>'required|string',
            'password'      =>'required|string',      
        ]);
        $user = new User([
            'first_name'    => $request -> first_name ,
            'last_name'     => $request -> last_name ,
            'email'         => $request -> email,
            'password'      => Hash::make($request ->password)
        ]);
        $user->save();
        return response()->json(['message'=>'User has been registered'],200);
    }
    // public function login(Request $request){
    //     $user = User::where('email', $request->email)->first();
    //     $password = md5($request->password);
    //     if($user->password != $password){ //  !$user || !Hash::check($request->password, $user->password, [])
    //         return response()->json(
    //             [
    //                 'message' => 'User not exist!',
    //             ],
    //             404
    //         );
    //     }
    //     $token = $user->createToken('authToken')->plainTextToken;
    //     return response()->json(
    //         [
    //             'access_token' => $token,
    //             'type_token' => 'Bearer',
    //             'message' =>'Login successfully'
    //         ],
    //         200
    //     );

    // }
    public function login(Request $request){
        $request ->validate([
            'email'     =>'required',
            'password'  =>'required|string'
        ]);
        
        $credentials = request(['email','password']);
        if (!Auth::attempt($credentials)){
            return response()->json(['message'=>'UnAuthorized'],401);
        }
        $user = $request->user();
        $tokenResult = $user ->createToken('Personal Access Token');
        $token = $tokenResult->token ;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save() ;
        return response()->json(['data'=>[
            'user'          => Auth::user(),
            'access_token'  => $tokenResult->accessToken,
            'token_type'    =>'Bearer',
            'expires_at'    => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]]);
    }
}
