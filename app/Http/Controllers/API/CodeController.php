<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Code;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CodeController extends BaseController
{
    
    public function create(Request $request) {
        $user = auth()->user();

        Gate::authorize('create', $user);

        $data = $request->all();

        $validator = Validator::make($data, [
            'type' => 'required|string|in:HTML,CSS,JS',
            'code' => 'required|string',
            'project_id' => 'required'
        ]);

        if($validator->fails())
            return $this->sendError('Error de validación', $validator->errors(), 400);

        $code = Code::create($data);
        return $this->sendResponse($code, "OK");
    }

    public function showProjectCode(int $project_id) {
        $user = auth()->user();

        Gate::authorize('viewAny', $user);

        return Code::where('project_id', $project_id)->get();
    }

    public function update(Request $request, int $project_id) {
        $user = auth()->user();
        $data = $request->all();

        $validator = Validator::make($data, [
            '*.code' => 'required|string'
        ]);

        if($validator->fails())
            return $this->sendError('Error de validación', $validator->errors(), 400);

        foreach ($data as $code) {
            $c = Code::find($code->id);
            Gate::authorize('update', $user, $c);

            $c->code = $code->code;
            $c->update();
        }

        return $this->sendResponse("OK", "OK");
    }

}
