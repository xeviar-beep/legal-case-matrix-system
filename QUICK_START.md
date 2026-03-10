# ⚡ QUICK START GUIDE
## Get Your System Running in 10 Minutes

---

## 🚀 FASTEST WAY TO START

### 1️⃣ Open PowerShell in this folder
Right-click folder > "Open in Terminal" or "Open PowerShell here"

### 2️⃣ Run these commands ONE BY ONE:

```powershell
# Install dependencies
composer install

# Setup environment
copy .env.example .env
php artisan key:generate

# Setup database (make sure MySQL is running!)
php artisan migrate
php artisan db:seed

# Start the server
php artisan serve
```

### 3️⃣ Open browser and go to:
```
http://localhost:8000
```

### 4️⃣ Login with:
```
Email: admin@law.com
Password: password
```

---

## ✅ CHECKLIST BEFORE RUNNING

- [ ] XAMPP/WAMP is running (MySQL)
- [ ] Composer is installed
- [ ] PHP 8.1+ is installed
- [ ] Created database named `case_matrix_system`

---

## 📧 EMAIL SETUP (For Reminders)

Edit `.env` file:

```env
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
REMINDER_EMAIL_TO=attorney@law.com
```

**Get Gmail App Password:**
1. Google Account > Security
2. Enable 2-Step Verification
3. Create App Password
4. Use that password in `.env`

---

## 🔔 ENABLE DAILY REMINDERS

In a **NEW PowerShell window**, run:

```powershell
php artisan schedule:work
```

Keep this terminal open to receive reminders at 8 AM daily.

---

## 🧪 TEST EVERYTHING

```powershell
# Test email reminders
php artisan reminders:send --test

# Check database connection
php artisan migrate:status
```

---

## 🆘 COMMON FIXES

### "Class not found" error:
```powershell
composer dump-autoload
```

### Database connection error:
1. Check MySQL is running
2. Check database name in `.env` matches created database
3. Check username/password in `.env`

### Migration error:
```powershell
php artisan migrate:fresh --seed
```
⚠️ This deletes all data!

---

## 📱 DEFAULT ACCOUNTS

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@law.com | password |
| Attorney | attorney@law.com | password |
| Staff | staff@law.com | password |

---

## 🎯 DEMO FLOW

1. **Login** → Dashboard (show overview)
2. **Create Case** → Auto-deadline calculation
3. **View Dashboard** → Color-coded urgency
4. **Check Email** → Daily reminder sample
5. **Search** → Quick case finding

---

## 📞 NEED HELP?

Check these files:
- `README.md` - Full documentation
- `INSTALLATION_GUIDE.md` - Detailed setup
- `ATTORNEY_PRESENTATION_GUIDE.md` - Presentation tips

---

## 🎉 YOU'RE READY!

Once `php artisan serve` is running, your system is LIVE at:
**http://localhost:8000**

**Time to impress your attorney! 💪⚖️**
