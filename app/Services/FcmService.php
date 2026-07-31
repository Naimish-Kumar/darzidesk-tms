<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    protected static ?string $cachedAccessToken = null;
    protected static int $tokenExpiresAt = 0;

    /**
     * Get Google OAuth2 Access Token using Service Account Private Key (FCM v1 API)
     */
    public static function getAccessToken(): ?string
    {
        if (self::$cachedAccessToken && time() < (self::$tokenExpiresAt - 60)) {
            return self::$cachedAccessToken;
        }

        $serviceAccountPath = storage_path('app/firebase_service_account.json');

        if (!file_exists($serviceAccountPath)) {
            Log::error('FCM Service Account JSON not found at: ' . $serviceAccountPath);
            return null;
        }

        $json = json_decode(file_get_contents($serviceAccountPath), true);
        if (!$json || empty($json['private_key']) || empty($json['client_email'])) {
            Log::error('Invalid FCM Service Account JSON format.');
            return null;
        }

        $now = time();
        $header = base64UrlEncode(json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT',
        ]));

        $claims = base64UrlEncode(json_encode([
            'iss' => $json['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now,
        ]));

        $signatureInput = $header . '.' . $claims;
        $binarySignature = '';

        $privateKey = $json['private_key'];
        if (!openssl_sign($signatureInput, $binarySignature, $privateKey, OPENSSL_ALGO_SHA256)) {
            Log::error('OpenSSL signature creation failed for FCM token generation.');
            return null;
        }

        $jwt = $signatureInput . '.' . base64UrlEncode($binarySignature);

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            self::$cachedAccessToken = $data['access_token'] ?? null;
            self::$tokenExpiresAt = $now + ($data['expires_in'] ?? 3600);
            return self::$cachedAccessToken;
        }

        Log::error('Failed to get FCM Access Token: ' . $response->body());
        return null;
    }

    /**
     * Send FCM Push Notification via HTTP v1 API
     */
    public static function sendNotification(string $fcmToken, string $title, string $body, array $data = []): bool
    {
        if (empty($fcmToken)) {
            return false;
        }

        $accessToken = self::getAccessToken();
        if (!$accessToken) {
            return false;
        }

        $serviceAccountPath = storage_path('app/firebase_service_account.json');
        $json = json_decode(file_get_contents($serviceAccountPath), true);
        $projectId = $json['project_id'] ?? 'darzidesk';

        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $formattedData = [];
        foreach ($data as $k => $v) {
            $formattedData[(string)$k] = (string)$v;
        }

        $payload = [
            'message' => [
                'token' => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $formattedData,
                'android' => [
                    'priority' => 'HIGH',
                    'notification' => [
                        'sound' => 'default',
                        'channel_id' => 'darzidesk_notifications',
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'default',
                            'badge' => 1,
                        ],
                    ],
                ],
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        if ($response->successful()) {
            Log::info("FCM Push notification sent successfully to token: {$fcmToken}");
            return true;
        }

        Log::error("FCM Send Notification failed: " . $response->body());
        return false;
    }

    /**
     * Helper to send notification directly to a User instance or user ID
     */
    public static function sendToUser($user, string $title, string $body, array $data = []): bool
    {
        if (is_numeric($user)) {
            $user = \App\Models\User::find($user);
        }

        if (!$user || empty($user->fcm_token)) {
            return false;
        }

        return self::sendNotification($user->fcm_token, $title, $body, $data);
    }
}

function base64UrlEncode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
