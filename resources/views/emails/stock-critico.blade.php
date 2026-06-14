<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; background: #f3f4f6; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="background: #dc2626; padding: 24px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 22px;">Stock Crítico - NeusPhone</h1>
        </div>
        <div style="padding: 32px 28px;">
            <h2 style="color: #1f2937; margin: 0 0 12px;">El producto <strong>{{ $producto->nombre }}</strong> tiene stock bajo</h2>
            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 16px; margin: 16px 0;">
                <p style="margin: 4px 0; color: #374151;"><strong>Marca:</strong> {{ $producto->marca }}</p>
                <p style="margin: 4px 0; color: #374151;"><strong>Stock actual:</strong> <span style="color: #dc2626; font-weight: bold;">{{ $producto->stock }} unidades</span></p>
                <p style="margin: 4px 0; color: #374151;"><strong>Precio:</strong> ${{ number_format($producto->precio, 0, ',', '.') }}</p>
            </div>
            <div style="text-align: center; margin-top: 28px;">
                <a href="{{ route('admin.productos.edit', $producto->id) }}" style="background: #2563eb; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">Gestionar producto</a>
            </div>
        </div>
        <div style="background: #f9fafb; padding: 16px 28px; text-align: center; color: #9ca3af; font-size: 12px;">
            &copy; {{ date('Y') }} NeusPhone &mdash; Este es un mensaje automático del sistema.
        </div>
    </div>
</body>
</html>
