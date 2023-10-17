<?php
namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return response()->json(['permissions' => $permissions]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $request->input('name')]);

        return response()->json([
            'message' => 'Permission created successfully',
            'permission' => $permission,
        ], JsonResponse::HTTP_CREATED);
    }

    public function edit(Permission $permission)
    {
        return response()->json(['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->input('name')]);

        return response()->json([
            'message' => 'Permission updated successfully',
            'permission' => $permission,
        ], JsonResponse::HTTP_OK);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully'], JsonResponse::HTTP_NO_CONTENT);
    }
}
