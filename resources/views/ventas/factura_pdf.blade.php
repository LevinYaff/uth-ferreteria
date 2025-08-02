<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura de Venta #{{ $venta->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h2 {
            font-size: 16px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .info-item label {
            font-weight: bold;
            display: block;
            color: #666;
            margin-bottom: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #f5f5f5;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .total-row {
            margin-bottom: 5px;
        }
        .total-row label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
            text-align: right;
            margin-right: 10px;
        }
        .total-row.final {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>FerreSys</h1>
            <p>Sistema de Administración de Ferretería</p>
            <h2>Factura de Venta #{{ $venta->id }}</h2>
        </div>

        <div class="info-section">
            <h2>Información de la Venta</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Fecha:</label>
                    <div>{{ $venta->created_at->format('d/m/Y H:i') }}</div>

                    <label>Estado:</label>
                    <div>
                        @if($venta->estado === 'completada')
                            Completada
                        @elseif($venta->estado === 'pendiente')
                            Pendiente
                        @else
                            Cancelada
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <label>Vendedor:</label>
                    <div>{{ $venta->user->name }}</div>

                    <label>Número de Factura:</label>
                    <div>{{ $venta->id }}</div>
                </div>
            </div>
        </div>

        @if($venta->observaciones)
            <div class="info-section">
                <h2>Observaciones</h2>
                <p>{{ $venta->observaciones }}</p>
            </div>
        @endif

        <div class="info-section">
            <h2>Productos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>${{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <div class="total-row final">
                    <label>TOTAL:</label>
                    <span>${{ number_format($venta->total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Este documento es generado automáticamente por el sistema FerreSys.</p>
            <p>Fecha de impresión: {{ date('d/m/Y H:i:s') }}</p>
            <p>¡Gracias por su compra!</p>
        </div>
    </div>
</body>
</html>
