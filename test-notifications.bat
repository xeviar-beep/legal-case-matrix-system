@echo off
echo ========================================
echo  Auto Notifications Quick Test
echo ========================================
echo.

echo [1/3] Checking MySQL...
net start MySQL80 2>nul
if %errorlevel% equ 0 (
    echo  SUCCESS: MySQL is running
) else (
    echo  MySQL already running or needs admin rights
)
echo.

echo [2/3] Running migrations...
php artisan migrate --force
echo.

echo [3/3] Testing deadline notifications...
php artisan deadlines:check --test
echo.

echo ========================================
echo Test complete! Check output above.
echo.
echo To send REAL notifications, run:
echo   php artisan deadlines:check
echo.
echo To start automatic scheduling:
echo   php artisan schedule:work
echo ========================================
pause
