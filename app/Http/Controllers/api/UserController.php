<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(int $id = null) {        
        if( $id ){
            $user = User::find($id);
            return $user;
        }

        $users = User::all();
        return $users;
    }
}
