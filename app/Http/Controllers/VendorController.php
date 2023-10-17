<?php
namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VendorController extends Controller
{

    public function index()
    {
        $vendors = Vendor::all();
        return response()->json($vendors);
    }

    public function show(Vendor $vendor)
    {
        return response()->json($vendor);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $vendor = new Vendor();
        $vendor->name = $request->input('name');

        $vendor->save();

        return response()->json(['message' => 'Vendor created'], Response::HTTP_CREATED);
    }


    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $vendor->name = $request->input('name');

        $vendor->save();

        return response()->json(['message' => 'Vendor updated'], Response::HTTP_OK);
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return response()->json(['message' => 'Vendor deleted'], Response::HTTP_NO_CONTENT);
    }
}
