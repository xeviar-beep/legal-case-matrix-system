# Legal Case Deadline & Reminder System ⚖️📅

A web-based system for tracking legal cases, computing deadlines automatically, and sending daily reminders.

## Features
- ✅ Case Management (CRUD)
- ✅ Automatic Deadline Calculator (e.g., 15 days from filing)
- ✅ Daily Email Reminders
- ✅ Dashboard with Urgent Cases Overview
- ✅ Status Tracking (Active / Due Soon / Overdue)

## Tech Stack
- **Backend:** Laravel 10+
- **Frontend:** Blade Templates + Bootstrap 5
- **Database:** MySQL
- **Notifications:** Laravel Mail + Scheduler

## Installation

### 1. Prerequisites
- PHP 8.1+
- Composer
- MySQL
- Laravel installed globally

### 2. Setup Steps

```bash
# Install dependencies
composer install

# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=case_matrix_system
DB_USERNAME=root
DB_PASSWORD=

# Configure mail settings in .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Case Reminder System"

# Run migrations
php artisan migrate

# Seed default user (optional)
php artisan db:seed

# Start the development server
php artisan serve

# In another terminal, run the scheduler (for reminders)
php artisan schedule:work
```

### 3. Access the System
- URL: http://localhost:8000
- Default Login: admin@law.com / password

## Daily Reminder System

The system automatically sends email reminders for:
- ⏰ Deadlines today
- ⚠️ Deadlines in 3 days
- 📌 Deadlines in 7 days
- 🔴 Overdue cases

Reminders run daily at 8:00 AM.

## Usage

1. **Login** to the system
2. **Add Cases** with filing date and deadline duration
3. **View Dashboard** for urgent cases summary
4. **Receive Email Reminders** automatically

## Dashboard Overview

🔴 **Overdue Cases** - Cases past their deadline
🟡 **Due Within 7 Days** - Urgent cases requiring attention
🟢 **Upcoming Hearings** - Today's scheduled hearings
📊 **Total Active Cases** - All ongoing cases

## Support
For questions or issues, contact your system administrator.
