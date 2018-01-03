<?php

namespace App\Http\Controllers;

use App\Account;
use App\Project;
use Illuminate\Http\Request;

class ProjectController extends ApiController
{
    public function login(Request $request){
      $user = $request->input('username');
      $password = $request->input('password');

        $appUser = explode(',', config('keuangan.username'));
        $appPass = explode(',', config('keuangan.password'));
        if( in_array($user , $appUser) && in_array($password, $appPass)) {
             return [
                "data" => [
                    "message" => "success",
                    "status_code" => 1,
                    "username" => $user,
                ]
             ];
        } else {
            return $this->response->errorInternal($e->getMessage());
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
