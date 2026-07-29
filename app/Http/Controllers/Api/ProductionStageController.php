<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductionStage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductionStageController extends Controller
{
    public function index()
    {
        $stages = ProductionStage::where('parent_id', parentId())
            ->orderBy('order_index', 'asc')
            ->get();

        if ($stages->isEmpty()) {
            $defaults = ProductionStage::getDefaultStages();
            foreach ($defaults as $default) {
                ProductionStage::create([
                    'name' => $default['name'],
                    'slug' => $default['slug'],
                    'order_index' => $default['order_index'],
                    'color_code' => $default['color_code'],
                    'is_default' => true,
                    'parent_id' => parentId(),
                ]);
            }
            $stages = ProductionStage::where('parent_id', parentId())
                ->orderBy('order_index', 'asc')
                ->get();
        }

        return response()->json(['success' => true, 'stages' => $stages]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:10',
        ]);

        $maxOrder = ProductionStage::where('parent_id', parentId())->max('order_index') ?? 0;

        $stage = ProductionStage::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'order_index' => $maxOrder + 1,
            'color_code' => $request->color_code ?? '#3B82F6',
            'is_default' => false,
            'parent_id' => parentId(),
        ]);

        return response()->json(['success' => true, 'message' => 'Production stage created', 'stage' => $stage]);
    }

    public function update(Request $request, $id)
    {
        $stage = ProductionStage::where('parent_id', parentId())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:10',
        ]);

        $stage->name = $request->name;
        $stage->slug = Str::slug($request->name);
        if ($request->has('color_code')) {
            $stage->color_code = $request->color_code;
        }
        $stage->save();

        return response()->json(['success' => true, 'message' => 'Production stage updated', 'stage' => $stage]);
    }

    public function destroy($id)
    {
        $stage = ProductionStage::where('parent_id', parentId())->findOrFail($id);
        $stage->delete();

        return response()->json(['success' => true, 'message' => 'Production stage deleted']);
    }
}
