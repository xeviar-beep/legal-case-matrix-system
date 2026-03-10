# Push Notifications Setup Guide

## Overview
The Case Matrix System now supports browser push notifications using the Web Push API. Users can receive notifications even when the browser is closed.

## Features
- ✅ Browser-based push notifications (no mobile app needed)
- ✅ Service Worker for background notifications
- ✅ Subscription management (enable/disable)
- ✅ Database storage for user subscriptions
- ✅ VAPID authentication for secure push
- ✅ Notification dropdown with enable/disable buttons

## Architecture

### Backend Components
1. **Database Table**: `push_subscriptions`
   - Stores user subscription data (endpoint, keys, auth token)
   - Foreign key relationship with users table

2. **Model**: `app/Models/PushSubscription.php`
   - Manages subscription data
   - Relationship: `belongsTo(User::class)`

3. **Controller**: `app/Http/Controllers/PushNotificationController.php`
   - `subscribe()` - Save push subscription
   - `unsubscribe()` - Remove subscription
   - `getPublicKey()` - Return VAPID public key

4. **Routes**: 
   ```php
   POST /push/subscribe
   POST /push/unsubscribe
   GET /push/public-key
   ```

### Frontend Components
1. **Service Worker**: `public/service-worker.js`
   - Handles 'push' events (incoming notifications)
   - Handles 'notificationclick' events (user interaction)
   - Runs in background, separate from main thread

2. **JavaScript**: `public/js/push-notifications.js`
   - Manages service worker registration
   - Handles subscription/unsubscription
   - Converts keys to proper formats
   - Sends subscription data to backend

3. **UI Controls**: In `resources/views/layouts/app.blade.php`
   - "Enable Push Notifications" button
   - "Disable Push Notifications" button
   - Located in notification dropdown

## Setup Instructions

### 1. Environment Configuration
The following VAPID keys have been added to `.env`:
```env
VAPID_PUBLIC_KEY=qsFeMBKJ2EnCk5Bcz4QHRfHOWs87_5V1jBeHjDAztYCPSAF9RWFAc8ai2o8Hs8rTSC5d6p5X7SeOQglPK5hHIXs
VAPID_PRIVATE_KEY=js470EureLJJy1Wlxypag7WAfJLQdGcY7CL6c85U7Co
VAPID_SUBJECT=mailto:admin@legalaidoffice.gov.ph
```

**Note**: These are test keys. For production, generate proper VAPID keys using:
```bash
php generate-vapid-keys.php
```

### 2. Browser Requirements
Push notifications require:
- Modern browser (Chrome, Firefox, Edge, Safari 16+)
- HTTPS connection (or localhost for testing)
- User permission for notifications

### 3. Testing the System

#### Step 1: Enable Notifications
1. Log in to the system
2. Click the notification bell icon in the top bar
3. Click "Enable Push Notifications" button
4. Browser will prompt for notification permission - click "Allow"
5. Subscription data is saved to database

#### Step 2: Verify Subscription
Check database:
```sql
SELECT * FROM push_subscriptions;
```

Or use the test command:
```bash
php artisan notification:test
```

#### Step 3: Send Test Notification (Browser Console)
Since full Web Push Protocol implementation requires additional libraries, you can test notifications using the browser console:

1. Open DevTools (F12)
2. Go to Console tab
3. Run this code:
```javascript
navigator.serviceWorker.ready.then(registration => {
    registration.showNotification('Test Notification', {
        body: 'This is a test notification from Case Matrix System',
        icon: '/favicon.ico',
        badge: '/favicon.ico',
        tag: 'test-notification',
        requireInteraction: false,
        actions: [
            { action: 'view', title: 'View' },
            { action: 'dismiss', title: 'Dismiss' }
        ]
    });
});
```

4. You should see a notification appear

#### Step 4: Test Notification Click
1. Click on the notification
2. Should open/focus the Case Matrix System tab
3. Check console for debug messages

## How to Send Notifications from Code

### Example 1: When Case is Overdue
```php
use App\Models\PushSubscription;

// In your CaseController or scheduled task
$overdueCases = CaseModel::where('status', 'Overdue')->get();

foreach ($overdueCases as $case) {
    $assignedUser = $case->assignedUser; // Assuming relationship exists
    
    if ($assignedUser) {
        $subscriptions = PushSubscription::where('user_id', $assignedUser->id)->get();
        
        foreach ($subscriptions as $subscription) {
            $this->sendPushNotification($subscription, [
                'title' => 'Case Overdue',
                'body' => "Case #{$case->case_number} is overdue",
                'icon' => '/favicon.ico',
                'url' => route('cases.show', $case->id)
            ]);
        }
    }
}
```

### Example 2: Deadline Reminder
```php
// In scheduled task (app/Console/Kernel.php)
$schedule->call(function () {
    $upcomingDeadlines = CaseModel::whereBetween('deadline_date', [
        now(),
        now()->addDay()
    ])->get();
    
    foreach ($upcomingDeadlines as $case) {
        // Send notification to assigned user
        // ... (similar to Example 1)
    }
})->daily();
```

## Troubleshooting

### Notifications Not Appearing
1. **Check browser permissions**: Settings → Privacy → Notifications
2. **Verify HTTPS**: Push requires secure context (HTTPS or localhost)
3. **Check service worker**: DevTools → Application → Service Workers
4. **Check console**: Look for errors in browser console

### "Enable Notifications" Button Not Showing
1. Clear browser cache
2. Hard refresh page (Ctrl+F5)
3. Check if service worker registered: DevTools → Application → Service Workers
4. Verify push-notifications.js is loaded: DevTools → Network tab

### Subscription Failing
1. Check browser support: `'PushManager' in window`
2. Verify VAPID public key is set in .env
3. Check network tab for failed requests
4. Look for CSRF token issues

### Service Worker Not Registering
1. Check service-worker.js path: `/service-worker.js`
2. Verify file permissions
3. Check for JavaScript errors in console
4. Try unregistering and re-registering:
```javascript
navigator.serviceWorker.getRegistrations().then(registrations => {
    registrations.forEach(reg => reg.unregister());
});
```

## Database Schema

### push_subscriptions Table
```sql
CREATE TABLE push_subscriptions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    endpoint VARCHAR(500) NOT NULL,
    public_key TEXT NOT NULL,
    auth_token TEXT NOT NULL,
    content_encoding VARCHAR(16),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_subscription (user_id, endpoint)
);
```

## Security Considerations

1. **VAPID Keys**: Keep private key secret, never expose in frontend
2. **HTTPS Only**: Push notifications require secure context
3. **User Consent**: Always request permission before subscribing
4. **Subscription Validation**: Verify subscriptions belong to authenticated users
5. **Rate Limiting**: Prevent spam by limiting notification frequency

## Future Enhancements

1. **Notification Preferences**: Let users choose notification types
2. **Notification History**: Store and display notification history
3. **Rich Notifications**: Add images, progress bars, etc.
4. **Action Buttons**: Custom actions on notifications
5. **Silent Notifications**: Background data sync
6. **Notification Groups**: Group related notifications
7. **Custom Sounds**: Different sounds for different notification types

## API Reference

### Subscribe to Push Notifications
```
POST /push/subscribe
Content-Type: application/json

{
    "endpoint": "https://fcm.googleapis.com/fcm/send/...",
    "keys": {
        "p256dh": "base64-encoded-public-key",
        "auth": "base64-encoded-auth-secret"
    }
}

Response: 200 OK
{
    "message": "Subscription saved successfully"
}
```

### Unsubscribe from Push Notifications
```
POST /push/unsubscribe
Content-Type: application/json

{
    "endpoint": "https://fcm.googleapis.com/fcm/send/..."
}

Response: 200 OK
{
    "message": "Subscription removed successfully"
}
```

### Get VAPID Public Key
```
GET /push/public-key

Response: 200 OK
{
    "publicKey": "base64url-encoded-public-key"
}
```

## Resources

- [Web Push API Documentation](https://developer.mozilla.org/en-US/docs/Web/API/Push_API)
- [Service Worker API](https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API)
- [VAPID Protocol](https://datatracker.ietf.org/doc/html/rfc8292)
- [Web Push Libraries](https://github.com/web-push-libs)

## Support

For issues or questions:
1. Check browser console for errors
2. Verify all files are in place
3. Check database for subscriptions
4. Review server logs for backend errors

---

**Status**: System is functional for subscription management. Full push sending requires Web Push Protocol implementation or library installation.

**Last Updated**: February 9, 2026
