<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura de Compra #{{ $compra->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 15px;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #D72638;
            padding-bottom: 15px;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 10px;
        }

        .logo {
            max-width: 120px;
            height: auto;
        }

        .company-info {
            text-align: center;
        }

        .company-info h1 {
            font-size: 24px;
            margin: 0 0 5px 0;
            color: #D72638;
        }

        .company-info p {
            margin: 2px 0;
            color: #2E2E2E;
        }

        .document-title {
            background-color: #2E2E2E;
            color: white;
            padding: 8px 15px;
            margin: 15px 0;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .info-section h2 {
            font-size: 14px;
            border-bottom: 1px solid #E0E0E0;
            padding-bottom: 3px;
            margin-bottom: 10px;
            color: #2E2E2E;
            text-align: center;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 15px;
        }

        .flex-column {
            flex: 1;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
            align-items: center;
        }

        .info-row label {
            font-weight: bold;
            color: #666;
            width: 120px;
            text-align: right;
            margin-right: 10px;
        }

        .info-row div {
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }

        table th {
            background-color: #2E2E2E;
            color: white;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
        }

        table td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-section {
            margin-top: 15px;
            text-align: right;
            border-top: 1px solid #E0E0E0;
            padding-top: 10px;
        }

        .total-row {
            margin-bottom: 5px;
            font-size: 12px;
        }

        .total-row label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
            text-align: right;
            margin-right: 10px;
        }

        .total-row.final {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            color: #D72638;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #D72638;
            text-align: center;
            color: #666;
            font-size: 9px;
        }

        .footer p {
            margin: 2px 0;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #FFC107;
            color: #333;
        }

        .status-received {
            background-color: #4CAF50;
            color: white;
        }

        .status-partial {
            background-color: #007BFF;
            color: white;
        }

        .status-canceled {
            background-color: #D72638;
            color: white;
        }

        .divider {
            height: 1px;
            background-color: #ddd;
            margin: 15px 0;
        }

        .observaciones {
            background-color: #f9f9f9;
            padding: 8px;
            border-left: 3px solid #D72638;
            font-style: italic;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ public_path('ferreteria\public\images\logo.png') }}" alt="FerreSys® Logo" class="logo">
            </div>
            <div class="company-info">
                <h1>FerreSys®</h1>
                <p>Sistema de Administración de Ferretería | Cel: 3380-4567 | info@ferresys.com</p>
                <p>San Pedro Sula</p>
            </div>
        </div>

        <div class="document-title">
            Factura de Compra #{{ str_pad($compra->id, 6, '0', STR_PAD_LEFT) }}
        </div>

        <div class="flex-container">
            <!-- Columna Izquierda: Información de la Compra -->
            <div class="flex-column">
                <div class="info-section">
                    <h2>Información de la Compra</h2>
                    <div class="info-row">
                        <label>Fecha de Compra:</label>
                        <div>{{ $compra->fecha_compra->format('d/m/Y') }}</div>
                    </div>
                    <div class="info-row">
                        <label>Fecha de Recepción:</label>
                        <div>{{ $compra->fecha_recepcion ? $compra->fecha_recepcion->format('d/m/Y') : 'Pendiente' }}</div>
                    </div>
                    <div class="info-row">
                        <label>Estado:</label>
                        <div>
                            @php
                                $statusClass = 'status-pending';
                                if($compra->estado === 'recibida') $statusClass = 'status-received';
                                elseif($compra->estado === 'parcial') $statusClass = 'status-partial';
                                elseif($compra->estado === 'cancelada') $statusClass = 'status-canceled';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($compra->estado_formateado) }}</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <label>Número de Factura:</label>
                        <div>{{ $compra->numero_factura ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <label>Número de Orden:</label>
                        <div>{{ $compra->numero_orden ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <label>Registrado por:</label>
                        <div>{{ $compra->user->name }}</div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Información del Proveedor -->
            <div class="flex-column">
                <div class="info-section">
                    <h2>Información del Proveedor</h2>
                    <div class="info-row">
                        <label>Proveedor:</label>
                        <div>{{ $compra->proveedor->nombre }}</div>
                    </div>
                    <div class="info-row">
                        <label>Contacto:</label>
                        <div>{{ $compra->proveedor->contacto ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <label>Teléfono:</label>
                        <div>{{ $compra->proveedor->telefono }}</div>
                    </div>
                    <div class="info-row">
                        <label>Email:</label>
                        <div>{{ $compra->proveedor->email ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($compra->observaciones)
            <div class="observaciones">
                <strong>Observaciones:</strong> {{ $compra->observaciones }}
            </div>
        @endif

        <div class="info-section">
            <h2>Productos</h2>
            <table>
                <thead>
                    <tr>
                        <th style="width: 35%;">Producto</th>
                        <th style="width: 10%;">Cantidad</th>
                        <th style="width: 15%;">Recibido</th>
                        <th style="width: 20%;">Precio Unit.</th>
                        <th style="width: 20%;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compra->detalles as $detalle)
                        <tr>
                            <td style="text-align: left;">{{ $detalle->producto->nombre }}</td>
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
                        <span>-${{ number_format($compra->descuento, 2) }}</span>
                    </div>
                @endif

                <div class="total-row final">
                    <label>TOTAL:</label>
                    <span>${{ number_format($compra->total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Este documento es una representación impresa de una factura de compra electrónica.</p>
            <p>FerreSys® - Sistema de Administración de Ferretería | Fecha de impresión: {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
