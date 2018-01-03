<?php

namespace App\Http\Controllers;

use App\Account;
use App\Project;
use App\Transformers\ProjectTransformer;
use Illuminate\Http\Request;

class ProjectController extends ApiController
{
    public function index(){
        $project = Project::all();

        return $this->response->collection($project , new ProjectTransformer);
    }

    public function login(Request $request){

        $user = $request->input('username');
        $pass = $request->input('password');

        $account = Account::where('username', $user)->where('password', $pass)->first();

        if(isset($account)){
              return [
                "data" => [
                    "message" => "login success",
                    "status_code" => 1,
                    "username" => $user,
                ]
             ];
         } else {
              return [
                "data" => [
                    "message" => "login failed",
                    "status_code" => 0,
                ]
             ];
         }
    }
    public function inputProject(Request $request){

        $input = new Project;
        $input->label = $request->input('label');

        $input->save();

        return [
                "data" => [
                    "message" => "success",
                    "status_code" => 1,
                    "project_label" => $input->label,
                ]
             ];
    }
}
