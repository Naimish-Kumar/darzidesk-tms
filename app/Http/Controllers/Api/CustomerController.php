<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('parent_id', parentId())->where('type', 'customer')->get();
        return response()->json(['success' => true, 'data' => $customers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
        ]);

        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => \Hash::make('customer123'),
            'type' => 'customer',
            'parent_id' => parentId(),
            'lang' => 'en',
        ]);

        return response()->json(['success' => true, 'data' => $customer]);
    }

    public function update(Request $request, $id)
    {
        $customer = User::where('id', $id)->where('parent_id', parentId())->where('type', 'customer')->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $customer->name = $request->name;
        $customer->email = $request->email;
        if ($request->phone_number) $customer->phone_number = $request->phone_number;
        $customer->save();

        return response()->json(['success' => true, 'message' => 'Customer updated successfully', 'data' => $customer]);
    }

    public function destroy($id)
    {
        $customer = User::where('id', $id)->where('parent_id', parentId())->where('type', 'customer')->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }
        $customer->delete();
        return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
    }
}
