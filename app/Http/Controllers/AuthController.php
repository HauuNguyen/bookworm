<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\hash ;
use App\Models\User  ;
use Illuminate\Support\Facades\Validator;

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
    // public function login(Request $request){
    //     $request ->validate([
    //         'email'     =>'required',
    //         'password'  =>'required|string'
    //     ]);
        
    //     $credentials = request(['email','password']);
    //     if (!Auth::attempt($credentials)){
    //         return response()->json(['message'=>'UnAuthorized'],401);
    //     }
    //     $user = $request->user();
    //     $tokenResult = $user ->createToken('Personal Access Token')->plainTextToken;
    //     $token = $tokenResult->token ;
    //     $token->save() ;
    //     return response()->json(['data'=>[
    //         'user'          => Auth::user(),
    //         'access_token'  => $tokenResult->accessToken,
    //         'token_type'    =>'Bearer',
    //                 ]]);
    // }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user  = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'          => Auth::user(),
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }


    // public function login(Request $request) {
    //     $fields = $request->validate([
    //         'email' => 'required|string',
    //         'password' => 'required|string'
    //     ]);

    //     // Check email
    //     $user = User::where('email', $fields['email'])->first();

    //     // Check password
    //     if(!$user || !Hash::check($fields['password'], $user->password)) {
    //         return response([
    //             'message' => 'Email or Password Incorrect'
    //         ], 401);
    //     }

    //     $token = $user->createToken('myapptoken')->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];

    //     return response($response, 201);
    // }
    public function logout(Request $request) {
        $request->Auth::user()->token()->revoke();
        return response()->json([
            'message'   =>  'Successfully logged out.'
        ]);
    }
    public function me()
    {
        return  Auth::user();
    }

}
