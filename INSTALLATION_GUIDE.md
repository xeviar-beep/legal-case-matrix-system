# 🎯 CASE MATRIX SYSTEM - INSTALLATION GUIDE

## 📋 Prerequisites Checklist

Before you start, make sure you have:
- ✅ PHP 8.1 or higher
- ✅ Composer installed
- ✅ MySQL/MariaDB installed
- ✅ XAMPP/WAMP (or any web server)

---

## 🚀 STEP-BY-STEP SETUP

### STEP 1: Install Composer Dependencies

Open PowerShell in this folder and run:

```powershell
composer install
```

If you don't have Laravel installed yet, you can use the existing files.

---

### STEP 2: Setup Environment File

Copy the .env.example to create your .env file:

```powershell
copy .env.example .env
```

Then generate your application key:

```powershell
php artisan key:generate
```

---

### STEP 3: Configure Database

1. Open **phpMyAdmin** or MySQL
2. Create a new database called: `case_matrix_system`

Then edit your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=case_matrix_system
DB_USERNAME=root
DB_PASSWORD=
```

(Leave password blank if using XAMPP default)

---

### STEP 4: Configure Email Settings (For Reminders)

Edit your `.env` file with Gmail SMTP settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Case Reminder System"

# Where to send reminders
REMINDER_EMAIL_TO=attorney@law.com
```

**To get Gmail App Password:**
1. Go to: https://myaccount.google.com/security
2. Enable 2-Step Verification
3. Go to App Passwords
4. Generate password for "Mail"
5. Use that password in MAIL_PASSWORD

---

### STEP 5: Run Database Migrations

```powershell
php artisan migrate
```

This will create all the tables.

---

### STEP 6: Create Default Users

```powershell
php artisan db:seed
```

**Default Login Credentials:**
- 👤 Admin: `admin@law.com` / `password`
- ⚖️ Attorney: `attorney@law.com` / `password`
- 📝 Staff: `staff@law.com` / `password`

---

### STEP 7: Start the Application

```powershell
php artisan serve
```

The system will be available at: **http://localhost:8000**

---

### STEP 8: Setup Daily Reminders

To enable automatic daily email reminders, open another PowerShell window and run:

```powershell
php artisan schedule:work
```

**Keep this terminal running** to send reminders automatically at 8:00 AM every day.

---

## 🧪 TESTING THE REMINDER SYSTEM

To test reminders without waiting for 8 AM:

```powershell
php artisan reminders:send --test
```

To send real emails immediately:

```powershell
php artisan reminders:send
```

---

## 📖 HOW TO USE

1. **Login** at http://localhost:8000
2. **Go to Cases** → Click "New Case"
3. **Fill in the form:**
   - Case Number (e.g., 2024-001)
   - Case Title
   - Client Name
   - Date Filed (today's date)
   - Deadline Period (15 days, 30 days, etc.)
4. **System automatically calculates** the deadline date!
5. **View Dashboard** to see urgent cases

---

## 🎨 FEATURES YOU CAN DEMO TO YOUR ATTORNEY

✅ **Automatic Deadline Calculator**
- Type filing date + period → System computes deadline

✅ **Dashboard Overview**
- See overdue, due soon, and active cases at a glance

✅ **Daily Email Reminders**
- Get reminders for deadlines today, in 3 days, in 7 days

✅ **Status Tracking**
- Color-coded status badges (Red = Overdue, Yellow = Due Soon)

✅ **Search & Filter**
- Quick search by case number, title, or client

---

## 🔧 TROUBLESHOOTING

### Error: "Class not found"
```powershell
composer dump-autoload
```

### Migration Error
```powershell
php artisan migrate:fresh --seed
```
(⚠️ This will delete all data and start fresh)

### Email Not Sending
1. Check Gmail app password
2. Make sure 2-Step Verification is ON
3. Try using port 465 with ssl instead of 587

---

## 💡 TIPS FOR YOUR OJT PRESENTATION

1. **Show the Dashboard first** - attorneys love visual summaries
2. **Demo the auto-calculator** - this impresses them most
3. **Show a sample email reminder** - real-world value
4. **Explain the color coding** - red/yellow/green is intuitive

---

## 📞 NEXT STEPS

If everything works, you can:
- Add more case types
- Create reports/exports
- Add calendar view
- Add SMS notifications (advanced)

---

## ✅ QUICK START CHECKLIST

1. ☐ Run `composer install`
2. ☐ Copy `.env.example` to `.env`
3. ☐ Run `php artisan key:generate`
4. ☐ Create database `case_matrix_system`
5. ☐ Configure `.env` database settings
6. ☐ Run `php artisan migrate`
7. ☐ Run `php artisan db:seed`
8. ☐ Configure email in `.env`
9. ☐ Run `php artisan serve`
10. ☐ Login with `admin@law.com` / `password`

---

🎉 **That's it! Your system is ready!**

If you encounter any issues, check the Laravel logs at:
`storage/logs/laravel.log`
