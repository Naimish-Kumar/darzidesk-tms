<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClothType;
use Illuminate\Http\Request;

class ClothTypeController extends Controller
{
    public function index()
    {
        $clothTypes = ClothType::where('parent_id', parentId())->get();
        return response()->json(['success' => true, 'data' => $clothTypes]);
    }
}
