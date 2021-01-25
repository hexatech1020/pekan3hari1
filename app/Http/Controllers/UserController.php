<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('created_at','desc')->get();

        return UserResource::collection($users);
    }


    public function store(Request $request){
        $user = User::create([
            'name' => $request->name,
        ]);

        return new UserResource($user);
    }

    public function delete($id){
        User::destroy($id);
        return 'success';
    }

    public function changeName($id, Request $request){
        $user = User::find($id);

        $user->update([
            'name' => $request->name
        ]);

        return new UserResource($user);
    }


}
