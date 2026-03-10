<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushNotificationController extends Controller
{
    /**
     * Subscribe to push notifications
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'endpoint' => 'required|string',
            'keys' => 'required|array',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        $subscription = PushSubscription::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'endpoint' => $validated['endpoint'],
            ],
            [
                'public_key' => $validated['keys']['p256dh'],
                'auth_token' => $validated['keys']['auth'],
                'content_encoding' => $request->input('contentEncoding', 'aes128gcm'),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Push notification subscription saved successfully!',
        ]);
    }

    /**
     * Unsubscribe from push notifications
     */
    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'endpoint' => 'required|string',
        ]);

        PushSubscription::where('user_id', Auth::id())
            ->where('endpoint', $validated['endpoint'])
            ->delete();

        return response()->json([
            'success' => true,
            'message' => ' Push notification unsubscribed successfully!',
        ]);
    }

    /**
     * Get VAPID public key for frontend
     */
    public function getPublicKey()
    {
        // Get VAPID public key from config
        $publicKey = config('services.vapid.public_key');
        
        // Validate that the key is configured
        if (empty($publicKey)) {
            return response()->json([
                'error' => 'VAPID public key is not configured',
                'publicKey' => null,
            ], 500);
        }
        
        return response()->json([
            'publicKey' => $publicKey,
        ]);
    }
    
    /**
     * Send test notification (for testing purposes)
     */
    public function sendTest(Request $request)
    {
        $type = $request->input('type', 'general');
        $userId = Auth::id();
        
        // Check if user has subscriptions
        $hasSubscription = PushSubscription::where('user_id', $userId)->exists();
        
        if (!$hasSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'You need to enable push notifications first. Click the bell icon and enable notifications.'
            ], 400);
        }
        
        // Return success - the actual notification will be triggered from the client side
        // since we don't have full server-side Web Push implementation yet
        return response()->json([
            'success' => true,
            'message' => 'Test notification triggered! Check your browser.',
            'data' => [
                'user_id' => $userId,
                'type' => $type,
                'trigger' => 'client' // Indicates client should show the notification
            ]
        ]);
    }
}
