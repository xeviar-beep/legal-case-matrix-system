# Email Notifications Setup Guide 📧

Your system now sends **both Push Notifications AND Email notifications** automatically!

## 🎉 What's Included

When a deadline or hearing occurs, **BOTH** happen automatically:
1. ✅ **Push Notification** - Browser notification
2. ✅ **Email** - Professional HTML email sent to user's email address

## 📧 Email Types

### 1. Overdue Case Email
- 🚨 Red urgent design
- Shows days overdue
- Sent to assigned lawyer + all admins
- Subject: "🚨 URGENT: Case #XXX is X Day(s) Overdue"

### 2. Deadline Upcoming Emails
- ⏰ Today (Yellow/Warning)
- 📅 Tomorrow (Blue/Info)
- 📌 3 Days (Gray/Notice)
- Subject varies by urgency

### 3. Hearing Today Email
- 👨‍⚖️ Purple theme
- Court/hearing details
- Pre-hearing checklist included
- Subject: "👨‍⚖️ Court Hearing Today: Case #XXX"

## ⚙️ Email Configuration

### Step 1: Update `.env` File

Open your `.env` file and configure your email settings:

```env
# Gmail Example (Recommended)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-lao-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-lao-email@gmail.com
MAIL_FROM_NAME="LAO Case Matrix System"
```

### Gmail App Password Setup:
1. Go to Google Account → Security
2. Enable 2-Step Verification
3. Go to App Passwords
4. Generate password for "Mail"
5. Copy the 16-character password
6. Paste into `MAIL_PASSWORD` in `.env`

### Alternative: Outlook/Office 365
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@outlook.com
MAIL_FROM_NAME="LAO Case Matrix System"
```

### Alternative: Any SMTP Server
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@domain.com
MAIL_FROM_NAME="LAO Case Matrix System"
```

## 🧪 Test Email Sending

### Test 1: Check Email Configuration
```bash
php artisan tinker

# Then type:
Mail::raw('Test email from Case Matrix System', function($msg) {
    $msg->to('your-email@example.com')->subject('Test Email');
});

# Check your inbox!
```

### Test 2: Test with Real Case Notification
```bash
# Run the deadline checker in test mode
php artisan deadlines:check --test

# Run for real (will send emails!)
php artisan deadlines:check
```

## 📋 Email Features

Each email includes:
- ✅ Professional HTML design with LAO branding
- ✅ Complete case details (number, title, client, court, etc.)
- ✅ Color-coded urgency (red=overdue, yellow=today, blue=tomorrow)
- ✅ Direct link to view case in system
- ✅ Actionable checklist
- ✅ Automatic timestamps

## 🔍 Troubleshooting

### Emails not sending?

**1. Check email configuration:**
```bash
php artisan config:clear
php artisan tinker

# Type:
config('mail.host')
config('mail.username')
```

**2. Check Laravel logs:**
```bash
Get-Content storage\logs\laravel.log -Tail 50
```

Look for:
- "Email sent to..." (success)
- "Failed to send email..." (error)

**3. Test SMTP connection:**
```bash
php artisan tinker

# Type:
try {
    Mail::raw('Test', fn($msg) => $msg->to('test@example.com')->subject('Test'));
    echo "Email sent successfully!";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

**4. Common Issues:**

- **"Connection refused"** → Check MAIL_HOST and MAIL_PORT
- **"Authentication failed"** → Check MAIL_USERNAME and MAIL_PASSWORD
- **"Gmail: Less secure app"** → Use App Password instead of regular password
- **Nothing happens** → Check `queue` connection in `.env` (should be `sync` for immediate sending)

### Make sure user emails are set

Users need email addresses in the database:
```bash
php artisan tinker

# Check user emails:
User::all()->pluck('email', 'name')

# Add/update email:
$user = User::find(1);
$user->email = 'lawyer@example.com';
$user->save();
```

## 📊 How It Works

When the scheduler runs:
1. ✅ Checks for deadlines/hearings
2. ✅ Finds assigned user
3. ✅ Sends **push notification** to browser
4. ✅ Sends **email** to user's email address
5. ✅ Logs everything to `storage/logs/laravel.log`

## 🚀 Start Receiving Emails

After configuring `.env`:

```bash
# Clear config cache
php artisan config:clear

# Test it
php artisan deadlines:check --test

# Start automatic notifications
php artisan schedule:work
```

Or use the batch file:
- Double-click **[start-auto-notifications.bat](start-auto-notifications.bat)**

## 📱 Dual Notification System

Your users will now receive:
- 🔔 **Browser Push Notification** (instant, no internet needed after subscription)
- 📧 **Email** (detailed, can be forwarded, permanent record)

Perfect for ensuring no deadline is ever missed! 🎯

---

**Note:** Make sure to configure proper "From" email and name to maintain professional communication with your staff and clients.
