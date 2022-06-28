
<?php

namespace App\Repositories ;


use App\Models\User ;
use GuzzleHttp\Psr7\Request;



class accountRepo {
    public function __construct()
    {
        $this->query = User::query();
    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        $password = md5($request->password);
        if($user->password != $password){ //  !$user || !Hash::check($request->password, $user->password, [])
            return response()->json(
                [
                    'message' => 'User not exist!',
                ],
                404
            );
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(
            [
                'access_token' => $token,
                'type_token' => 'Bearer',
                'message' =>'Login successfully'
            ],
            200
        );

    }
    public function logout(){

        // auth()->user()->tokens()->delete();
        Auth::logout();

        return response()->json(
            [
                'message' => "Logged out!",
            ],
            200
        );
    }
}