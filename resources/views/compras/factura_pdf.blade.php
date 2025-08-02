<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura de Compra #{{ $compra->id }}</title>
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
            grid-template-columns: 1fr 1fr 1fr;
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
            <h2>Factura de Compra #{{ $compra->id }}</h2>
        </div>

        <div class="info-section">
            <h2>Información de la Compra</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Proveedor:</label>
                    <div>{{ $compra->proveedor->nombre }}</div>

                    <label>Contacto:</label>
                    <div>{{ $compra->proveedor->contacto ?? 'N/A' }}</div>

                    <label>Teléfono:</label>
                    <div>{{ $compra->proveedor->telefono }}</div>

                    <label>Email:</label>
                    <div>{{ $compra->proveedor->email ?? 'N/A' }}</div>
                </div>

                <div class="info-item">
                    <label>Fecha de Compra:</label>
                    <div>{{ $compra->fecha_compra->format('d/m/Y') }}</div>

                    <label>Fecha de Recepción:</label>
                    <div>{{ $compra->fecha_recepcion ? $compra->fecha_recepcion->format('d/m/Y') : 'Pendiente' }}</div>

                    <label>Estado:</label>
                    <div>{{ $compra->estado_formateado }}</div>
                </div>

                <div class="info-item">
                    <label>Número de Factura:</label>
                    <div>{{ $compra->numero_factura ?? 'N/A' }}</div>

                    <label>Número de Orden:</label>
                    <div>{{ $compra->numero_orden ?? 'N/A' }}</div>

                    <label>Registrado por:</label>
                    <div>{{ $compra->user->name }}</div>
                </div>
            </div>
        </div>

        @if($compra->observaciones)
            <div class="info-section">
                <h2>Observaciones</h2>
                <p>{{ $compra->observaciones }}</p>
            </div>
        @endif

        <div class="info-section">
            <h2>Productos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Cantidad Recibida</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compra->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>{{ $detalle->cantidad_recibida }}</td>
                            <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>${{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <div class="total-row">
                    <label>Subtotal:</label>
                    <span>${{ number_format($compra->subtotal, 2) }}</span>
                </div>

                @if($compra->impuestos > 0)
                    <div class="total-row">
                        <label>Impuestos:</label>
                        <span>${{ number_format($compra->impuestos, 2) }}</span>
                    </div>
                @endif

                @if($compra->descuento > 0)
                    <div class="total-row">
                        <label>Descuento:</label>
                        <span>${{ number_format($compra->descuento, 2) }}</span>
                    </div>
                @endif

                <div class="total-row final">
                    <label>TOTAL:</label>
                    <span>${{ number_format($compra->total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Este documento es generado automáticamente por el sistema FerreSys.</p>
            <p>Fecha de impresión: {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
