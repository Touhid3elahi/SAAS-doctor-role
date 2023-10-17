<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RegistrationController extends Controller
{public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'registration_type' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $roleName = $request->input('registration_type');
        $role = Role::findByName($roleName);

        if ($role) {
            $user->assignRole($role);
            $token = $user->createToken('API Token')->plainTextToken;

            return response([
                'user' => $user,
                'token' => $token,
            ], 201);
        } else {
            return response(['message' => 'Role not found'], 404);
        }
    }

}
