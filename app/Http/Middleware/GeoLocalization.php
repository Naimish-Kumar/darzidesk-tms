<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class GeoLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 0. Skip for bots
        $userAgent = $request->header('User-Agent');
        if (empty($userAgent) || preg_match('/bot|crawl|slurp|spider|mediapartners/i', $userAgent)) {
            return $next($request);
        }

        // 1. Get Geo Location and Currency from IP
        if (!Session::has('geo_location')) {
            $ip = $request->ip();
            
            // For local development, use a sample public IP (India)
            if ($ip == '127.0.0.1' || $ip == '::1') {
                $ip = '103.111.137.35'; 
            }
            
            try {
                $response = Http::get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,currency");
                if ($response->successful() && $response->json('status') == 'success') {
                    Session::put('geo_location', $response->json());
                } else {
                    // Fallback to default
                    Session::put('geo_location', [
                        'country' => 'United States',
                        'countryCode' => 'US',
                        'currency' => 'USD'
                    ]);
                }
            } catch (\Exception $e) {
                // Keep default
            }
        }

        $geo = Session::get('geo_location');

        // 2. Set Language based on Country Code
        if ($geo && !Session::has('lang')) {
            $countryCode = strtoupper($geo['countryCode']);
            $langMapping = [
                'AE' => 'arabic', 'SA' => 'arabic', 'EG' => 'arabic', 'JO' => 'arabic', 'KW' => 'arabic',
                'DK' => 'danish',
                'NL' => 'dutch', 'BE' => 'dutch',
                'FR' => 'french', 'CA' => 'french',
                'DE' => 'german', 'AT' => 'german', 'CH' => 'german',
                'IT' => 'italian',
                'JP' => 'japanese',
                'PL' => 'polish',
                'PT' => 'portuguese', 'BR' => 'portuguese',
                'RU' => 'russian', 'BY' => 'russian', 'KZ' => 'russian',
                'ES' => 'spanish', 'MX' => 'spanish', 'AR' => 'spanish', 'CO' => 'spanish',
            ];

            $lang = $langMapping[$countryCode] ?? 'english';
            
            // Check if language file exists
            if (file_exists(resource_path('lang/' . $lang . '.json')) || is_dir(resource_path('lang/' . $lang))) {
                App::setLocale($lang);
                Session::put('lang', $lang);
            }
        } elseif (Session::has('lang')) {
            App::setLocale(Session::get('lang'));
        }

        // 3. Fetch Currency Exchange Rates
        if (!Cache::has('currency_rates')) {
            // Get base currency from subscription settings (usually USD or INR)
            $subSettings = subscriptionPaymentSettings();
            $baseCurrency = $subSettings['CURRENCY'] ?? 'USD';
            
            try {
                $rateResponse = Http::get("https://api.exchangerate-api.com/v4/latest/{$baseCurrency}");
                if ($rateResponse->successful()) {
                    Cache::put('currency_rates', $rateResponse->json('rates'), 86400); // Cache for 24 hours
                }
            } catch (\Exception $e) {
                // If API fails, we'll use a 1:1 rate as fallback
            }
        }

        return $next($request);
    }
}
