# LAO Case Matrix - Dual Notification System

## Overview

The LAO Case Matrix System now features a comprehensive dual notification system that delivers notifications both **inside the website** and as **desktop/browser push notifications**. This ensures users never miss important case updates, deadlines, or alerts.

---

## Features

### ✅ In-System Notifications

1. **Notification Bell Icon** - Located in the top navbar with an unread counter badge
2. **Dropdown Notification List** - Click the bell to see recent notifications
3. **Notifications History Page** - View all notifications at `/notifications`
4. **Real-time Updates** - Notifications load dynamically without page refresh
5. **Read/Unread Status** - Track which notifications you've seen
6. **Quick Actions** - Click notifications to navigate to related cases

### ✅ Browser/Desktop Push Notifications

1. **Desktop Alerts** - Receive notifications even when the browser is minimized
2. **Windows Notification Area** - Notifications appear in the system tray
3. **Click to Navigate** - Clicking a notification opens the system and goes to the related page
4. **Persistent History** - Push notifications are also saved in the system
5. **Cross-Device Support** - Works on desktop browsers (Chrome, Firefox, Edge)

---

## How It Works

### First-Time Setup

When you log in for the first time, you'll see an **"Enable Push Notifications"** button in the notification dropdown:

1. Click the notification bell icon (🔔) in the top navbar
2. Click **"Enable Push Notifications"** button
3. Your browser will ask for permission to show notifications
4. Click **"Allow"** to enable desktop notifications

### Notification Types

The system automatically sends notifications for:

#### 🚨 Overdue Cases
- Triggered when a case deadline has passed
- Sent once per day for each overdue case
- High priority with urgent styling

#### ⏰ Upcoming Deadlines  
- Triggered when a deadline is within 3 days
- Notifications sent at 3 days, 2 days, and 1 day before deadline
- Warning styling to grab attention

#### 📅 Hearings Today
- Triggered on the day of a scheduled hearing
- Sent once in the morning
- Reminder styling

#### 📋 New Case Assignments
- Triggered when a case is assigned to you
- Immediate notification
- Success styling

#### 📝 Case Status Updates
- Triggered when a case status changes
- Real-time notification
- Info styling

---

## Notification Triggers

### Automatic Checks

The system automatically checks for notifications:
- **Hourly** - Every hour during business hours (7 AM - 7 PM)
- **Morning Check** - 8:00 AM daily
- **Afternoon Check** - 2:00 PM daily

### Manual Trigger

Administrators can also manually trigger notification checks:
```bash
php artisan cases:check-notifications
```

---

## User Interface

### Notification Bell

- **Location**: Top navbar, right side
- **Badge**: Shows count of unread notifications
- **Click Action**: Opens notification dropdown

### Notification Dropdown

**Header Section:**
- "Notifications" title
- "View All" link to notifications page

**Body Section:**
- Recent 10 notifications
- Each shows:
  - Icon (based on notification type)
  - Title and message
  - Time ago (e.g., "5 minutes ago")
  - Read/unread status

**Footer Section:**
- Enable/Disable Push Notifications button
- Test Notification button
- "See All Notifications" link

### Notifications Page

**Filter Tabs:**
- All Notifications
- Unread Only
- Overdue Cases
- Deadlines
- Assignments

**Actions:**
- Mark All as Read
- Refresh
- Delete individual notifications
- Click to navigate to related case

---

## Technical Architecture

### Database Schema

**`notifications` Table:**
- `id` - Primary key
- `user_id` - Foreign key to users
- `title` - Notification title
- `body` - Notification message  
- `url` - Link to related page
- `case_id` - Foreign key to cases (optional)
- `is_read` - Boolean read status
- `read_at` - Timestamp when marked as read
- `created_at` / `updated_at` - Timestamps

**`push_subscriptions` Table:**
- `id` - Primary key
- `user_id` - Foreign key to users
- `endpoint` - Push service endpoint
- `public_key` - Encryption public key
- `auth_token` - Authentication token
- `content_encoding` - Content encoding type

### Key Components

**Models:**
- `App\Models\Notification` - In-system notification model
- `App\Models\PushSubscription` - Browser push subscription model

**Controllers:**
- `App\Http\Controllers\NotificationController` - Handles in-system notifications
- `App\Http\Controllers\PushNotificationController` - Handles push subscriptions

**Services:**
- `App\Services\PushNotificationService` - Core notification service that creates both in-system and push notifications

**Commands:**
- `App\Console\Commands\CheckCaseNotifications` - Scheduled command to check for case notifications

**JavaScript:**
- `public/js/push-notifications.js` - Manages browser push subscriptions
- Notification functions in `resources/views/layouts/app.blade.php` - UI handlers

**Service Worker:**
- `public/service-worker.js` - Handles push notification display and click events

### API Endpoints

**Notifications:**
- `GET /notifications` - View notifications page
- `GET /notifications/get` - Fetch notifications (JSON)
- `POST /notifications/{id}/read` - Mark as read
- `POST /notifications/read-all` - Mark all as read
- `DELETE /notifications/{id}` - Delete notification
- `POST /notifications/test` - Send test notification

**Push Subscriptions:**
- `GET /push/public-key` - Get VAPID public key
- `POST /push/subscribe` - Subscribe to push notifications
- `POST /push/unsubscribe` - Unsubscribe from push notifications
- `POST /push/test` - Trigger test push notification

---

## Configuration

### VAPID Keys (Required for Push Notifications)

Push notifications require VAPID (Voluntary Application Server Identification) keys. These should already be configured in your `.env` file:

```env
VAPID_PUBLIC_KEY=your-public-key-here
VAPID_PRIVATE_KEY=your-private-key-here
VAPID_SUBJECT=mailto:your-email@example.com
```

If not configured, push notifications won't work (but in-system notifications will still function).

### Scheduler Setup

For automatic notification checks, ensure the Laravel scheduler is running:

**Windows (using Task Scheduler):**
```
php artisan schedule:run
```

Or keep the scheduler running continuously:
```
php artisan schedule:work
```

### Service Worker

The service worker is already registered at `/service-worker.js`. No additional configuration needed.

---

## Testing the System

### Test In-System Notifications

1. Click the notification bell (🔔)
2. Click **"Test Notification"** button
3. You should see:
   - A new notification appear in the dropdown
   - The unread counter increase by 1
   - A success message on the button

### Test Browser Push Notifications

1. **Enable push notifications** (if not already enabled)
2. Click **"Test Notification"** button
3. You should see:
   - An in-system notification (in the bell dropdown)
   - A desktop notification (in Windows notification area)
4. Click the desktop notification - it should open the notifications page

### Test Automatic Notifications

To manually trigger the automatic notification check:
```bash
php artisan cases:check-notifications
```

This will:
- Check all cases for overdue deadlines
- Check for deadlines within 3 days
- Check for hearings today
- Send notifications to relevant users

---

## Troubleshooting

### Push Notifications Not Working

**Problem**: "Enable Push Notifications" button doesn't work

**Solutions**:
1. Check browser console for errors
2. Ensure VAPID keys are set in `.env`
3. Clear config cache: `php artisan config:clear`
4. Restart the development server
5. Try in a different browser (Chrome recommended)

**Problem**: Browser doesn't ask for permission

**Solutions**:
1. Check browser notification settings
2. Ensure the site isn't blocked in browser settings
3. Try resetting site permissions
4. Use HTTPS (required for push notifications in production)

### In-System Notifications Not Appearing

**Problem**: Notification bell shows no notifications

**Solutions**:
1. Check browser console for JavaScript errors
2. Verify the API endpoint: `/notifications/get`
3. Check database - ensure notifications table has data
4. Clear browser cache and reload
5. Check user_id matches logged-in user

### Automatic Notifications Not Sending

**Problem**: Cases are overdue but no notifications sent

**Solutions**:
1. Ensure scheduler is running: `php artisan schedule:work`
2. Manually trigger: `php artisan cases:check-notifications`
3. Check logs: `storage/logs/laravel.log`
4. Verify case deadline_date is set correctly
5. Ensure user has active subscriptions (for push) or is logged in (for in-system)

---

## Best Practices

### For Users

1. **Enable Push Notifications** - Don't miss important alerts
2. **Check Regularly** - Look at the notification bell throughout the day
3. **Mark as Read** - Keep your notification list organized
4. **Visit Notification Page** - Review full notification history
5. **Test Periodically** - Use the test button to ensure it's working

### For Administrators

1. **Monitor Logs** - Check logs for notification errors
2. **Keep Scheduler Running** - Ensure automatic checks are working
3. **Test Regularly** - Send test notifications to verify system health
4. **Update VAPID Keys** - If compromised, regenerate immediately
5. **Educate Users** - Show users how to enable notifications

---

## Security & Privacy

### Data Protection

- Notifications are user-specific and only visible to the intended recipient
- Push subscriptions are encrypted using VAPID protocol
- Sensitive case details should be accessed via clicking the notification, not displayed in the notification itself

### Browser Permissions

- Users must explicitly grant browser notification permission
- Users can revoke permission at any time through browser settings
- The system respects browser notification preferences

---

## Future Enhancements

Potential improvements to consider:

1. **Email Notifications** - Also send notifications via email
2. **SMS Notifications** - Critical alerts via SMS
3. **Notification Preferences** - Let users choose which notifications to receive
4. **Custom Sound** - Different sounds for different notification types
5. **Grouped Notifications** - Combine multiple notifications intelligently
6. **Mobile App** - Native mobile push notifications
7. **Notification Templates** - Customize notification messages
8. **Scheduled Quiet Hours** - Don't send notifications during off-hours

---

## Summary

The LAO Case Matrix dual notification system ensures users stay informed about important case updates through:

✅ **In-System Notifications** - Always visible in the navbar
✅ **Desktop Push Notifications** - Even when browser is minimized  
✅ **Automatic Triggers** - No manual checking required
✅ **Smart Detection** - Overdue, deadlines, hearings, assignments
✅ **Persistent History** - Never lose track of notifications
✅ **Click-to-Navigate** - One click to the related case

The system is production-ready and designed to improve case management efficiency by ensuring timely awareness of critical case events.
