<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $pedido->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; padding: 40px; }
        h1 { color: #2563eb; margin: 0 0 5px; }
        .header { border-bottom: 2px solid #2563eb; padding-bottom: 20px; margin-bottom: 20px; }
        .header .info { float: right; text-align: right; }
        .clearfix::after { content: ""; display: table; clear: both; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f3f4f6; font-weight: bold; }
        .total { text-align: right; margin-top: 20px; font-size: 16px; font-weight: bold; }
        .envio { margin-top: 20px; padding: 12px; background: #f9fafb; border-radius: 6px; }
        .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; text-align: center; color: #9ca3af; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header clearfix">
        <div style="float: left;">
            <h1>NeusPhone</h1>
            <p style="margin: 2px 0; color: #6b7280;">Factura de venta</p>
        </div>
        <div class="info">
            <p style="margin: 2px 0;"><strong>Factura #{{ $pedido->id }}</strong></p>
            <p style="margin: 2px 0;">{{ $pedido->created_at->format('d/m/Y h:i A') }}</p>
            <p style="margin: 2px 0;">Estado: <strong>{{ ucfirst($pedido->estado) }}</strong></p>
        </div>
    </div>

    <p><strong>Cliente:</strong> {{ $pedido->usuario?->nombres ?? '' }} {{ $pedido->usuario?->apellidos ?? '' }}</p>
    <p><strong>Correo:</strong> {{ $pedido->usuario?->correo ?? '' }}</p>

    @if($pedido->envio)
    <div class="envio">
        <h3 style="margin: 0 0 8px;">Dirección de envío</h3>
        <p style="margin: 2px 0;">{{ $pedido->envio->nombre_contacto }} - {{ $pedido->envio->telefono_contacto }}</p>
        <p style="margin: 2px 0;">{{ $pedido->envio->direccion }}, {{ $pedido->envio->municipio }}, {{ $pedido->envio->departamento }}</p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->detalles as $detalle)
            <tr>
                <td>
                    {{ $detalle->producto->nombre ?? 'Producto eliminado' }}
                    @if($detalle->variante)
                        <br><small>{{ $detalle->variante->procesador ? 'CPU: ' . $detalle->variante->procesador : '' }}{{ $detalle->variante->tarjeta_grafica ? ($detalle->variante->procesador ? ' / ' : 'GPU: ') . $detalle->variante->tarjeta_grafica : '' }}</small>
                    @endif
                </td>
                <td>{{ $detalle->cantidad }}</td>
                <td>${{ number_format($detalle->precio, 0, ',', '.') }}</td>
                <td>${{ number_format($detalle->precio * $detalle->cantidad, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total: ${{ number_format($pedido->total, 0, ',', '.') }}
    </div>

    <div class="footer">
        NeusPhone &mdash; Gracias por tu compra<br>
        {{ date('Y') }} Todos los derechos reservados.
    </div>
</body>
</html>
