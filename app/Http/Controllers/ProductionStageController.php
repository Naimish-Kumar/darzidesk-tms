<?php

namespace App\Http\Controllers;

use App\Models\ProductionStage;
use Illuminate\Http\Request;

class ProductionStageController extends Controller
{
    public function index()
    {
        $stages = ProductionStage::orderBy('order_index', 'asc')->get();

        if ($stages->isEmpty()) {
            $defaults = ProductionStage::getDefaultStages();
            foreach ($defaults as $default) {
                ProductionStage::create([
                    'name' => $default['name'],
                    'slug' => $default['slug'],
                    'order_index' => $default['order_index'],
                    'color_code' => $default['color_code'],
                    'is_default' => true,
                ]);
            }
            $stages = ProductionStage::orderBy('order_index', 'asc')->get();
        }

        return view('production_stages.index', compact('stages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:10',
        ]);

        $maxOrder = ProductionStage::max('order_index') ?? 0;

        ProductionStage::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'order_index' => $maxOrder + 1,
            'color_code' => $request->color_code ?? '#3B82F6',
            'is_default' => false,
        ]);

        return redirect()->back()->with('success', __('Production stage created successfully.'));
    }

    public function update(Request $request, $id)
    {
        $stage = ProductionStage::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:10',
            'order_index' => 'nullable|integer',
        ]);

        $stage->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'color_code' => $request->color_code ?? $stage->color_code,
            'order_index' => $request->order_index ?? $stage->order_index,
        ]);

        return redirect()->back()->with('success', __('Production stage updated successfully.'));
    }

    public function destroy($id)
    {
        $stage = ProductionStage::findOrFail($id);

        // Reassign any orders in this stage to the first stage
        $fallbackStage = ProductionStage::where('id', '!=', $id)->orderBy('order_index', 'asc')->first();
        if ($fallbackStage) {
            \App\Models\Order::where('production_stage_id', $id)
                ->update(['production_stage_id' => $fallbackStage->id]);
        }

        $stage->delete();

        return redirect()->back()->with('success', __('Production stage deleted successfully.'));
    }
}
