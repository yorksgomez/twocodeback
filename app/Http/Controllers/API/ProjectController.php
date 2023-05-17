<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Code;
use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectController extends BaseController
{
    
    public function create(Request $request) {
        $user = auth()->user();
        Gate::authorize('create');

        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'prohibited',
            'name' => 'required|string|max:250'
        ]);

        $data['user_id'] = $user->id;

        if($validator->fails())
            return $this->sendError('Error de validación', $validator->errors(), 400);

        $project = Project::create($data);
        return $this->sendResponse($project, "OK");
    }

    public function showAll() {
        $user = auth()->user();
        Gate::authorize('viewAny', $user);
        return Project::where('user_id', $user->id)->get();
    }

    public function generateCode(int $project_id) {
        $user = auth()->user();
        $project = Project::find($project_id);

        Gate::authorize('generateCode', $user, $project);

        $html = Code::where('type', 'HTML')->where('project_id', $project->id);
        $css = Code::where('type', 'CSS')->where('project_id', $project->id);
        $js = Code::where('type', 'js')->where('project_id', $project->id);

        return `
            <html>
            <head>
                <style>
                    $css
                </style>
            </head>
            <body>
                $html
                $js
            </body>
            </html>
        `;
    }

}
