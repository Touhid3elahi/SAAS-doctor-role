<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json(['roles' => $roles]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $role = Role::create(['name' => $request->input('name')]);

        return response()->json(['message' => 'Role created successfully', 'role' => $role], JsonResponse::HTTP_CREATED);
    }

    public function edit(Role $role)
    {
        return response()->json(['role' => $role]);
    }

    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $role->update(['name' => $request->input('name')]);

        return response()->json(['message' => 'Role updated successfully', 'role' => $role], JsonResponse::HTTP_OK);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully'], JsonResponse::HTTP_NO_CONTENT);
    }
}
