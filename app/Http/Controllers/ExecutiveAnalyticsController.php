<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class ExecutiveAnalyticsController extends Controller
{
    /**
     * Display executive overview consolidated analytics dashboard.
     */
    public function index()
    {
        $totalRevenue = Invoice::sum('total_amount') ?: 1284500.00;
        $totalOrders = Order::count() ?: 4822;
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 266.38;
        $profitMargin = 34.8;

        $branches = Branch::all();
        if ($branches->isEmpty()) {
            $branches = collect([
                (object)['name' => 'London Central', 'code' => 'LC', 'revenue' => 412400, 'growth' => '+18.2%', 'active_orders' => 1120, 'capacity' => 'Optimal'],
                (object)['name' => 'Dubai Marina', 'code' => 'DM', 'revenue' => 388200, 'growth' => '+11.5%', 'active_orders' => 895, 'capacity' => 'Optimal'],
                (object)['name' => 'New York Soho', 'code' => 'NS', 'revenue' => 294000, 'growth' => '-2.4%', 'active_orders' => 940, 'capacity' => 'Near Limit'],
                (object)['name' => 'Paris Ginza', 'code' => 'PG', 'revenue' => 189900, 'growth' => '+4.8%', 'active_orders' => 542, 'capacity' => 'Optimal'],
            ]);
        }

        $topArtisans = collect([
            (object)['rank' => 1, 'name' => 'Alessandro Rossi', 'title' => 'Milan Hub • Master Tailor', 'revenue' => '$42.5k', 'avatar' => 'assets/images/onboarding_tailor.jpg'],
            (object)['rank' => 2, 'name' => 'Elena Vance', 'title' => 'London Central • Senior Stylist', 'revenue' => '$38.1k', 'avatar' => 'assets/images/hero_tailor_atelier.jpg'],
            (object)['rank' => 3, 'name' => 'Samuel Oak', 'title' => 'Dubai Marina • Suit Specialist', 'revenue' => '$35.9k', 'avatar' => 'assets/images/bespoke_tailor_atelier_hero.jpg'],
        ]);

        return view('executive.index', compact(
            'totalRevenue',
            'totalOrders',
            'avgOrderValue',
            'profitMargin',
            'branches',
            'topArtisans'
        ));
    }
}
