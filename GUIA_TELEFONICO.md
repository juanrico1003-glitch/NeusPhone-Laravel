# 📱 Guía Completa: NeusPhone en Teléfono Local

## ⚡ RESUMEN RÁPIDO

Debes ejecutar **DOS comandos en DOS terminales diferentes**:

### Terminal 1 - Servidor Laravel
```powershell
php artisan serve --host=0.0.0.0 --port=8000
```

### Terminal 2 - Túnel (LocalTunnel)
```powershell
lt --port 8000
```

---

## 📋 PASO A PASO DETALLADO

### 1️⃣ Abre una PRIMERA terminal en VS Code
- Press `Ctrl + ` (backtick) o menú Terminal → New Terminal
- Asegúrate de estar en: `C:\Users\JUAN\NeusPhone-Laravel`
- Ejecuta:
```powershell
php artisan serve --host=0.0.0.0 --port=8000
```

Deberías ver:
```
INFO  Server running on http://127.0.0.1:8000
Press Ctrl+C to quit
```

### 2️⃣ Abre una SEGUNDA terminal (nueva)
- Click en el ícono `+` en la terminal o `Ctrl + Shift + ` `
- Asegúrate de estar en: `C:\Users\JUAN\NeusPhone-Laravel`
- Ejecuta:
```powershell
lt --port 8000
```

Deberías ver:
```
your url is: https://loose-moments-sort.loca.lt
```

### 3️⃣ Abre desde tu TELÉFONO
- Abre el navegador en tu móvil
- Copia la URL que aparece en la Terminal 2
- Ejemplo: `https://loose-moments-sort.loca.lt`
- ¡LISTO! Ya puedes ver la app desde el teléfono

---

## 🔧 COMANDOS ÚTILES

**Si algo falla, ejecuta esto:**
```powershell
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Para ver si el servidor funciona:**
```powershell
curl http://127.0.0.1:8000
```

**Para ver si el túnel funciona:**
```powershell
curl -I https://loose-moments-sort.loca.lt
```

---

## ✅ VERIFICACIÓN

Si ves esta URL cuando accedes desde teléfono:
```
href="/build/assets/app-..."
href="/favicon.svg"
```

✅ **CORRECTO** - Los assets van a cargar bien

Si ves esto:
```
href="http://127.0.0.1:8000/build/assets/app-..."
```

❌ **PROBLEMA** - Los assets no van a cargar

---

## ⚠️ PROBLEMAS CONOCIDOS

### ❌ "503 - Tunnel Unavailable"
**Solución:** El túnel se cerró. Ejecuta en Terminal 2:
```powershell
lt --port 8000
```

### ❌ El servidor no inicia
**Solución:** El puerto 8000 está ocupado. Ejecuta:
```powershell
netstat -ano | Select-String ":8000"
```

### ❌ Falla el login/registro
**Solución:** Estamos investigando esto. Por ahora:
1. Cierra sesión y limpia cookies del navegador
2. Intenta en modo incógnito
3. Verifica que `POST /register` responda correctamente

---

## 📝 NOTAS

- **Local**: `http://127.0.0.1:8000` o `http://localhost:8000`
- **Teléfono en LAN**: `https://[url-del-túnel]`
- **Ambos usan los mismos assets** (relativos con `/build/`)
- Los datos se guardan en la **misma base de datos**
