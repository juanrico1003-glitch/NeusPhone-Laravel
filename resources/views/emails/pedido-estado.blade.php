<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; background: #f3f4f6; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="background: #2563eb; padding: 24px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 22px;">NeusPhone</h1>
        </div>
        <div style="padding: 32px 28px;">
            <h2 style="color: #1f2937; margin: 0 0 12px;">Tu pedido #{{ $pedido->id }} fue actualizado</h2>
            <p style="color: #6b7280; margin: 0 0 20px;">Hola <strong>{{ $pedido->usuario?->nombres ?? 'cliente' }}</strong>, el estado de tu pedido cambió a:</p>
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 16px; text-align: center;">
                <span style="font-size: 18px; font-weight: bold; color: #2563eb; text-transform: uppercase;">{{ $pedido->estado }}</span>
            </div>
            <p style="color: #6b7280; margin: 20px 0 0; font-size: 14px;">Total: <strong>${{ number_format($pedido->total, 0, ',', '.') }}</strong></p>
            <div style="text-align: center; margin-top: 28px;">
                <a href="{{ route('pedidos.show', $pedido->id) }}" style="background: #2563eb; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">Ver mi pedido</a>
            </div>
        </div>
        <div style="background: #f9fafb; padding: 16px 28px; text-align: center; color: #9ca3af; font-size: 12px;">
            &copy; {{ date('Y') }} NeusPhone &mdash; Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
