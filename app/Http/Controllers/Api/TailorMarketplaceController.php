<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TailorService;
use App\Models\ShopReview;
use Illuminate\Http\Request;

class TailorMarketplaceController extends Controller
{
    /**
     * Get categorized tailor shops for marketplace discovery
     */
    public function index(Request $request)
    {
        $city = $request->query('city');
        $search = $request->query('search');
        $category = $request->query('category');

        $query = User::where('type', 'owner')
            ->where('is_active', 1);

        if ($city) {
            $query->where('city', 'like', '%' . $city . '%');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('shop_name', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('city', 'like', '%' . $search . '%');
            });
        }

        if ($category && $category !== 'All') {
            $query->whereHas('tailorServices', function ($q) use ($category) {
                $q->where('category', $category)->where('is_active', true);
            });
        }

        $allShops = $query->get()->map(function ($shop) {
            return $this->formatShopData($shop);
        });

        // Categorized lists
        $featuredShops = $allShops->where('is_featured', true)->values();
        $bestRatedShops = $allShops->sortByDesc('rating')->values();
        $nearbyShops = $city ? $allShops->where('city', $city)->values() : $allShops;

        $categories = [
            'All',
            'Suits',
            'Shirts',
            'Traditional',
            'Alterations',
            'Dresses',
            'Embroidery'
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'featured_tailors' => $featuredShops,
                'nearby_tailors' => $nearbyShops,
                'best_rated_tailors' => $bestRatedShops,
                'all_shops' => $allShops,
                'categories' => $categories,
            ]
        ]);
    }

    /**
     * Get detailed tailor shop profile, services, and reviews
     */
    public function show($id)
    {
        $shop = User::where('id', $id)
            ->where('type', 'owner')
            ->first();

        if (!$shop) {
            return response()->json(['success' => false, 'message' => 'Tailor shop not found'], 404);
        }

        $services = TailorService::where('user_id', $id)
            ->where('is_active', true)
            ->get();

        $reviews = ShopReview::where('shop_id', $id)
            ->with('customer:id,name,profile')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'shop' => $this->formatShopData($shop),
                'services' => $services,
                'reviews' => $reviews,
            ]
        ]);
    }

    /**
     * Get available service categories
     */
    public function categories()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'Suits',
                'Shirts',
                'Traditional',
                'Alterations',
                'Dresses',
                'Embroidery'
            ]
        ]);
    }

    private function formatShopData($shop)
    {
        return [
            'id' => $shop->id,
            'name' => $shop->name,
            'shop_name' => $shop->shop_name ?? $shop->name,
            'email' => $shop->email,
            'phone_number' => $shop->phone_number,
            'whatsapp_number' => $shop->whatsapp_number ?? $shop->phone_number,
            'city' => $shop->city ?? 'Main Branch',
            'address' => $shop->address ?? 'Main Market',
            'profile_photo' => $shop->profile ? asset('/storage/upload/profile/' . $shop->profile) : null,
            'shop_banner' => $shop->shop_banner ? asset('storage/' . $shop->shop_banner) : null,
            'shop_logo' => $shop->shop_logo ? asset('storage/' . $shop->shop_logo) : null,
            'rating' => (float) ($shop->rating ?? 5.0),
            'review_count' => (int) ($shop->review_count ?? 0),
            'is_featured' => (bool) ($shop->is_featured ?? false),
        ];
    }
}
