# Automatic Push Notifications Setup ✅

Your system now has **automatic push notifications AND email notifications** for case deadlines!

## 🎯 What's Automated

Notifications are sent automatically (BOTH push + email) when:

1. **🚨 Overdue Cases** - Cases past their deadline (URGENT alerts to lawyer + admins)
2. **⏰ Today's Deadlines** - Cases due today
3. **📅 Tomorrow's Deadlines** - 24-hour advance notice
4. **📌 3-Day Advance** - Early warning for upcoming deadlines
5. **👨‍⚖️ Hearings Today** - Court hearing reminders

## 🕐 When Notifications Run

- **Every hour** during work hours (7 AM - 7 PM)
- **8:00 AM** - Morning briefing
- **12:00 PM** - Lunch time check
- **5:00 PM** - End of day reminder

## 🚀 Quick Start

### Step 1: Start MySQL (Required)
```powershell
# Open PowerShell/CMD as Administrator, then:
net start MySQL80
```

### Step 2: Configure Email (Required for email notifications)
Edit your `.env` file with your email settings:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=your-email@gmail.com
```

See **[EMAIL_NOTIFICATIONS_GUIDE.md](EMAIL_NOTIFICATIONS_GUIDE.md)** for detailed setup.

### Step 3: Run Database Migration
```bash
php artisan migrate
```
This creates the notifications table.

### Step 3: Test the System
```bash
# Test mode (shows what would be sent, doesn't actually send)
php artisan deadlines:check --test

# Real mode (actually sends notifications)
php artisan deadlines:check
```

### Step 4: Start the Laravel Scheduler

**For Development (Manual):**
```bash
php artisan schedule:work
```
This runs the scheduler continuously - keep the terminal open.

**For Production (Windows Task Scheduler):**
Run this command every minute:
```bash
php artisan schedule:run
```

## 🧪 Testing Right Now

Want to test immediately? Here's how:

### Option 1: Manual Test Command
```bash
php artisan deadlines:check
```

### Option 2: Create a Test Case
1. Go to your system and create a new case
2. Set the deadline to **today** or **tomorrow**
3. Run: `php artisan deadlines:check`
4. You'll get a notification! 🔔

### Option 3: Test Specific Notification
```bash
# From PHP:
php artisan tinker

# Then type:
$service = app(\App\Services\PushNotificationService::class);
$service->sendToUser(1, '🔔 Test', 'This is a test notification!', '/dashboard');
```

## ⚙️ Configuration

### VAPID Keys (For Real Push Notifications)

Your `.env` file needs VAPID keys for server-side push:

```env
VAPID_PUBLIC_KEY=your_public_key_here
VAPID_PRIVATE_KEY=your_private_key_here
VAPID_SUBJECT=mailto:admin@yourlaw.com
```

Generate them by running:
```bash
php generate-vapid-keys.php
```

## 📊 View Logs

Check if notifications are being sent:
```bash
# View latest log entries
Get-Content storage\logs\laravel.log -Tail 50
```

Look for entries like:
- "Push notification sent successfully"
- "Overdue notification sent for case"
- "Deadline check completed"

## 🐛 Troubleshooting

### Notifications not working?

1. **Check MySQL is running:**
   ```bash
   Get-Service MySQL80
   ```

2. **Check scheduler is running:**
   ```bash
   php artisan schedule:list
   ```

3.✅ Monitor all case deadlines
- ✅ Send **push notifications** to assigned lawyers
- ✅ Send **email notifications** to assigned lawyers
- ✅ Alert admins about overdue cases (push + email)
- ✅ Send advance warnings before deadlines

**Dual notification system = Zero missed deadlines!** 🚀

📧 For email configuration help, see [EMAIL_NOTIFICATIONS_GUIDE.md](EMAIL_NOTIFICATIONS_GUIDE.md)
   ```bash
   php -r "echo env('VAPID_PUBLIC_KEY') ? 'Keys found' : 'Keys missing';"
   ```

## 🎉 You're All Set!

Your case management system will now automatically:
- Monitor all case deadlines
- Send push notifications to assigned lawyers
- Alert admins about overdue cases
- Send advance warnings before deadlines

**No manual checking needed!** 🚀
