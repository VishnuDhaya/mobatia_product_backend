<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiLoginController extends Controller
{

    public function login(Request $req){

        $validator = Validator::make($req->all(), [
            'name' => 'required|max:30',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);
        
        if ($validator->stopOnFirstFailure()->fails()) {

            $val = $validator->messages()->toArray();
            if(array_key_exists('name', $val)){
                $msg = implode('',$val['name']);
                return $msg;
            }else{
                $msg = implode('',$val['password']); 
                return $msg;
            }
            
        }
        $user = User::where('name', $req->name)->first();
        
        if(!$user || !Hash::check($req->password, $user->password)){
            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect'],
            ]);
        }
        $token = $user->createToken("admin-acces")->plainTextToken;

        return ["message" => "Login successfully", "token" => $token];
    } 

    public function logout(Request $req){

        $req->user()->tokens()->delete();

        return ["message" => "logout successfully"];
    }
}
