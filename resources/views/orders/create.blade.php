@extends('layouts.app')

@section('content')
<div style="max-width:900px; margin:0 auto; padding:0 24px;">

    <!-- ── HEADER ─────────────────────────────────────────────────────────── -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#1e293b; letter-spacing:-0.02em; margin:0 0 4px;">
                <i class="fa-solid fa-plus-circle" style="color:var(--hc-green); margin-right:10px;"></i>
                Crear Pedido
            </h1>
            <p style="font-size:13px; color:#64748b; margin:0;">Registra un nuevo pedido para el cliente</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Volver a pedidos
        </a>
    </div>

    <!-- ── FORMULARIO ─────────────────────────────────────────────────────── -->
    <div class="hc-card" style="padding:0; overflow:hidden;">

        <div class="hc-card-header">
            <div style="display:flex; align-items:center; gap:12px;">
                <i class="fa-solid fa-file-circle-plus" style="font-size:20px;"></i>
                <div>
                    <div style="font-size:16px; font-weight:700;">Datos del Pedido</div>
                    <div style="font-size:12px; opacity:0.8;">Todos los campos marcados con * son obligatorios</div>
                </div>
            </div>
        </div>

        <div class="hc-card-body">

            @if ($errors->any())
                <div class="hc-alert-error" style="margin-bottom:24px;">
                    <p style="font-weight:700; margin:0 0 8px; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-triangle-exclamation"></i> Por favor corrige los siguientes errores:
                    </p>
                    <ul style="margin:0; padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li style="font-size:13px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:20px;">

                    <!-- Número de factura (informativo) -->
                    <div style="grid-column: 1 / -1;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-hashtag" style="margin-right:4px; color:var(--hc-green);"></i>
                            Número de Factura
                        </label>
                        <input type="text" value="Se generará automáticamente (HAL-XXXXXX)" readonly
                               class="hc-input" style="background:#f8fafc; color:#94a3b8; cursor:not-allowed;">
                        <p style="font-size:12px; color:#94a3b8; margin:5px 0 0;">El sistema asigna el número consecutivo al guardar.</p>
                    </div>

                    <!-- Nombre del cliente -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-user" style="margin-right:4px; color:var(--hc-green);"></i>
                            Nombre / Razón Social *
                        </label>
                        <input type="text" name="customer_name" required
                               value="{{ old('customer_name') }}"
                               placeholder="Ej: Construcciones García S.A."
                               class="hc-input @error('customer_name') border-red-400 @enderror">
                        @error('customer_name')
                            <p style="color:#dc2626; font-size:12px; margin:5px 0 0;"><i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Número de cliente -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-id-card" style="margin-right:4px; color:var(--hc-green);"></i>
                            Número de Cliente *
                        </label>
                        <input type="text" name="customer_number" required
                               value="{{ old('customer_number') }}"
                               placeholder="Ej: CL-00123"
                               class="hc-input @error('customer_number') border-red-400 @enderror">
                        @error('customer_number')
                            <p style="color:#dc2626; font-size:12px; margin:5px 0 0;"><i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Datos fiscales (RFC) -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-file-invoice" style="margin-right:4px; color:var(--hc-green);"></i>
                            Datos Fiscales (RFC) *
                        </label>
                        <input type="text" name="fiscal_data" required
                               value="{{ old('fiscal_data') }}"
                               placeholder="Ej: GARP850212XY3"
                               class="hc-input @error('fiscal_data') border-red-400 @enderror">
                        @error('fiscal_data')
                            <p style="color:#dc2626; font-size:12px; margin:5px 0 0;"><i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha y hora del pedido -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-clock" style="margin-right:4px; color:var(--hc-green);"></i>
                            Fecha y Hora del Pedido *
                        </label>
                        <input type="datetime-local" name="order_datetime" required
                               value="{{ old('order_datetime', now()->format('Y-m-d\TH:i')) }}"
                               class="hc-input @error('order_datetime') border-red-400 @enderror">
                        @error('order_datetime')
                            <p style="color:#dc2626; font-size:12px; margin:5px 0 0;"><i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dirección de entrega -->
                    <div style="grid-column: 1 / -1;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-location-dot" style="margin-right:4px; color:var(--hc-green);"></i>
                            Dirección de Entrega *
                        </label>
                        <input type="text" name="delivery_address" required
                               value="{{ old('delivery_address') }}"
                               placeholder="Ej: Av. Reforma 123, Col. Centro, CDMX"
                               class="hc-input @error('delivery_address') border-red-400 @enderror">
                        @error('delivery_address')
                            <p style="color:#dc2626; font-size:12px; margin:5px 0 0;"><i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado inicial (solo lectura) -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-circle-dot" style="margin-right:4px; color:var(--hc-green);"></i>
                            Estado Inicial
                        </label>
                        <div class="hc-input" style="background:#f8fafc; cursor:not-allowed; display:flex; align-items:center; gap:10px;">
                            <span class="badge badge-ordered">
                                <i class="fa-solid fa-box"></i> Ordenado
                            </span>
                            <span style="font-size:12px; color:#94a3b8;">Asignado automáticamente</span>
                        </div>
                    </div>

                    <!-- Notas adicionales -->
                    <div style="grid-column: 1 / -1;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-note-sticky" style="margin-right:4px; color:var(--hc-green);"></i>
                            Notas Adicionales
                        </label>
                        <textarea name="notes" rows="4" class="hc-input" style="resize:vertical;"
                                  placeholder="Instrucciones especiales, observaciones, etc.">{{ old('notes') }}</textarea>
                    </div>

                </div>

                <hr class="hc-divider">

                <div style="display:flex; gap:14px; flex-wrap:wrap;">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Pedido
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn-secondary">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
