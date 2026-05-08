@extends('layouts.app')

@section('content')

@php
$statusMap = [
    'Ordered'    => ['class'=>'badge-ordered',    'label'=>'Ordenado',   'icon'=>'fa-box'],
    'In process' => ['class'=>'badge-in-process', 'label'=>'En proceso', 'icon'=>'fa-gear'],
    'In route'   => ['class'=>'badge-in-route',   'label'=>'En ruta',    'icon'=>'fa-truck'],
    'Delivered'  => ['class'=>'badge-delivered',  'label'=>'Entregado',  'icon'=>'fa-circle-check'],
];
@endphp

<div style="max-width:1280px; margin:0 auto; padding:0 24px;">

    <!-- ── HEADER ─────────────────────────────────────────────────────────── -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#1e293b; letter-spacing:-0.02em; margin:0 0 4px;">
                <i class="fa-solid fa-box-archive" style="color:var(--hc-orange); margin-right:10px;"></i>
                Pedidos Archivados
            </h1>
            <p style="font-size:13px; color:#64748b; margin:0;">
                Total archivados:
                <span style="background:rgba(234,88,12,0.1); border:1px solid rgba(234,88,12,0.3); color:var(--hc-orange); border-radius:20px; padding:2px 10px; font-weight:700; font-size:12px; margin-left:4px;">
                    {{ $orders->count() }}
                </span>
            </p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Volver a pedidos activos
        </a>
    </div>

    @if(session('success'))
        <div class="hc-alert-success" style="margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <!-- ── TABLA DE ARCHIVADOS ────────────────────────────────────────────── -->
    <div class="hc-card" style="overflow:hidden; padding:0;">

        @if($orders->isEmpty())
            <div style="text-align:center; padding:64px 24px;">
                <div style="font-size:56px; color:#cbd5e1; margin-bottom:16px;">
                    <i class="fa-solid fa-inbox"></i>
                </div>
                <p style="font-size:16px; font-weight:600; color:#475569; margin:0 0 8px;">Sin pedidos archivados</p>
                <p style="font-size:14px; color:#94a3b8; margin:0;">Cuando archives un pedido aparecerá aquí y podrás restaurarlo.</p>
            </div>

        @else
            <div style="overflow-x:auto;">
                <table class="hc-table">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag" style="margin-right:5px;"></i>Factura</th>
                            <th><i class="fa-solid fa-user" style="margin-right:5px;"></i>Cliente</th>
                            <th><i class="fa-solid fa-calendar" style="margin-right:5px;"></i>Fecha</th>
                            <th><i class="fa-solid fa-circle-dot" style="margin-right:5px;"></i>Estado</th>
                            <th style="text-align:center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @php
                                $sc = $statusMap[$order->status] ?? ['class'=>'badge-archived','label'=>$order->status,'icon'=>'fa-circle'];
                            @endphp
                            <tr style="opacity:0.75;">
                                <td>
                                    <span style="font-weight:700; color:var(--hc-green); font-size:13px;">
                                        {{ $order->invoice_number }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#1e293b;">{{ $order->customer_name }}</div>
                                    <div style="font-size:12px; color:#64748b;">{{ $order->customer_number }}</div>
                                </td>
                                <td style="font-size:13px; color:#475569; white-space:nowrap;">
                                    {{ $order->order_datetime ? $order->order_datetime->format('d/m/Y') : '—' }}
                                </td>
                                <td>
                                    <!-- Badge con opacidad reducida para reflejar estado "archivado" -->
                                    <span class="badge {{ $sc['class'] }}" style="opacity:0.6;">
                                        <i class="fa-solid {{ $sc['icon'] }}"></i>
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex; align-items:center; justify-content:center; gap:10px; flex-wrap:wrap;">

                                        <!-- Restaurar -->
                                        <form action="{{ route('orders.restore', $order->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-success btn-sm">
                                                <i class="fa-solid fa-rotate-left"></i> Restaurar
                                            </button>
                                        </form>

                                        <!-- Editar -->
                                        <a href="{{ route('orders.edit', $order->id) }}" class="btn-warning btn-sm">
                                            <i class="fa-solid fa-pen"></i> Editar
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

    <!-- Nota informativa -->
    <div style="margin-top:20px; padding:14px 18px; background:rgba(234,88,12,0.05); border:1px solid rgba(234,88,12,0.2); border-radius:12px; font-size:13px; color:#64748b; display:flex; align-items:center; gap:12px;">
        <i class="fa-solid fa-circle-info" style="color:var(--hc-orange); font-size:18px; flex-shrink:0;"></i>
        <span>
            Los pedidos archivados <strong style="color:#1e293b;">no se eliminan de la base de datos</strong>.
            Al restaurar un pedido, vuelve a aparecer en el listado activo con todos sus datos intactos.
        </span>
    </div>

</div>
@endsection
