# Script para iniciar servidor Laravel y túnel LocalTunnel

# Verifica si los puertos están en uso
Write-Host "Verificando puertos..." -ForegroundColor Cyan

$port8000 = (netstat -ano | Select-String ":8000" | Measure-Object).Count
if ($port8000 -gt 0) {
    Write-Host "⚠️  Puerto 8000 ya está en uso. Liberando..." -ForegroundColor Yellow
    # Opcional: matar los procesos existentes
}

# Mostrar instrucciones en dos terminales
Write-Host "`n=====================================" -ForegroundColor Green
Write-Host "     SERVIDOR LARAVEL + TÚNEL       " -ForegroundColor Green
Write-Host "=====================================" -ForegroundColor Green

Write-Host "`n📱 Para acceder desde tu TELÉFONO:" -ForegroundColor Cyan
Write-Host "   Espera a que aparezca la URL del túnel" -ForegroundColor Cyan
Write-Host "   Ejemplo: https://xxxx-xxxx-xxxx.loca.lt" -ForegroundColor Cyan

Write-Host "`n🖥️  Para acceder LOCALMENTE:" -ForegroundColor Cyan
Write-Host "   http://127.0.0.1:8000" -ForegroundColor Cyan
Write-Host "   http://localhost:8000" -ForegroundColor Cyan

Write-Host "`n📋 COMANDOS A EJECUTAR:" -ForegroundColor Yellow
Write-Host "   Terminal 1: php artisan serve --host=0.0.0.0 --port=8000" -ForegroundColor White
Write-Host "   Terminal 2: lt --port 8000" -ForegroundColor White

Write-Host "`n=====================================" -ForegroundColor Green
Write-Host "Presiona ENTER para continuar..." -ForegroundColor Cyan
Read-Host
