# MySQL Auto-Start Configuration Script
# Run this script as Administrator

Write-Host "Configuring MySQL to start automatically..." -ForegroundColor Cyan

try {
    # Set MySQL to start automatically
    Set-Service -Name MySQL80 -StartupType Automatic
    Write-Host "✓ MySQL80 set to start automatically on system boot" -ForegroundColor Green
    
    # Start MySQL now if it's not running
    $service = Get-Service -Name MySQL80
    if ($service.Status -ne 'Running') {
        Write-Host "Starting MySQL80 service..." -ForegroundColor Yellow
        Start-Service MySQL80
        Write-Host "✓ MySQL80 service started successfully" -ForegroundColor Green
    } else {
        Write-Host "✓ MySQL80 is already running" -ForegroundColor Green
    }
    
    # Verify status
    $service = Get-Service -Name MySQL80
    Write-Host "`nCurrent Status:" -ForegroundColor Cyan
    Write-Host "  Service: $($service.DisplayName)" -ForegroundColor White
    Write-Host "  Status: $($service.Status)" -ForegroundColor White
    Write-Host "  StartType: $($service.StartType)" -ForegroundColor White
    
    Write-Host "`n✓ Configuration complete! MySQL will now start automatically with Windows." -ForegroundColor Green
    
} catch {
    Write-Host "✗ Error: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "`nMake sure you're running this script as Administrator." -ForegroundColor Yellow
}

Write-Host "`nPress any key to exit..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
