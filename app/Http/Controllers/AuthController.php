<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens, HasFactory, Notifiable;

    public function register(Request $request): JsonResponse
    {
//        $validator = $request->validate([
//            'name'=>'required|string',
//            'email'=>'required|email',
//            'password' => 'required|min:6',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'message' => 'Validations fails',
//                'errors' => $validator->errors()
//            ], 422);
//        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('Laravel')->accessToken;
        $user->reg_token = $token;

        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = $request->validate([
            'email'=>'required|email',
            'password' => 'required|min:6',
        ]);

        if (!$validator) return response()->json($validator->error());

        $user = User::query()->where('email', $request->email)->first();
        if(!$user) return response()->json(["message" =>'User does not exist'], 422);

        if (Hash::check($request->password, $user->password))
        {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['token' => $token];

            return response()->Json($response);
        } else {
            $response = ["message" => "Password mismatch"];

            return response()->json($response, 422);
        }
    }
    public function authUser(): JsonResponse
    {
//        return response()->json([ 'valid' => auth()->check() ]);

        return response()->json(['user' => auth()->user()]);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $user = User::query()->where('email', $request->email,)->first();
        $user->password ='';

        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json($user);
    }
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
