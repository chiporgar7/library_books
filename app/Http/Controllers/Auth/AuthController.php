<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    
    /**
     * @param Request Request [Email, Password]
     * @return TokenUserAccount
     */

    public function login(AuthLoginRequest $request){
        try{
            
            $credentials['email'] = $request['email'];
            $credentials['password'] = $request['password'];

            if (!Auth::attempt($credentials)) {
                return response()->json(
                    [
                        'status_code' => 500,
                        'message' => 'Unauthorized'
                    ]
                );
            }
            $user = User::where('email',$request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }

            return response()->json(
                [
                    'status_code'     =>  200,
                    'access_token'    =>  $user->createToken('authToken')->plainTextToken,
                    'token_type'      =>  'Bearer',
                    'user'            =>  $user,
                ]
            );
        } catch (\Exception $error) {
         $this->generateErrorLogin($error);
      }
    }

    /**
     * @param Request Request [Name, password, Email, phone]
     * @return User
     */

    public function register(Request $request){
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->all());
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(
            [
                'status_code' => 200,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user'  => $user,
            ]
        );
    }
}