<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    
    public function create(Request $request) {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email',
            'email_verified_at' => 'prohibited',
            'password' => 'required',
        ]);

        if($validator->fails())
            return $this->sendError('Error de validación', $validator->errors(), 400);

        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return $this->sendResponse("OK", "OK");
    }

    public function login(Request $request) {
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            
            $success['token'] = $user->createToken('usuario')->plainTextToken;
            $success['user'] = $user;
        
            return $this->sendResponse($success, 'OK');
        } else {
            return $this->sendError('No autorizado', ['error' => 'No autorizado']);
        }

    }

    public function current(Request $request) {
        return $this->sendResponse(auth()->user(), 'OK');
    }

}
