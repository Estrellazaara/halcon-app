@extends('layouts.app')

@section('content')
<div style="max-width:860px; margin:0 auto; padding:0 24px;">

    <!-- HEADER -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#1e293b; letter-spacing:-0.02em; margin:0 0 4px;">
                <i class="fa-solid fa-cube" style="color:var(--hc-green); margin-right:10px;"></i>
                {{ $product->name }}
            </h1>
            <p style="font-size:13px; color:#64748b; margin:0;">Detalle del producto</p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            @if(Auth::user()->hasRole('Sales') || Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Warehouse'))
            <a href="{{ route('products.edit', $product->id) }}" class="btn-warning btn-sm">
                <i class="fa-solid fa-pen"></i> Editar
            </a>
            @endif
            <a href="{{ route('products.index') }}" class="btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="hc-alert-success" style="margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <!-- DETAIL CARD -->
    <div class="hc-card">
        <div class="hc-card-header">
            <i class="fa-solid fa-info-circle" style="color:var(--hc-green); margin-right:8px;"></i>
            Información del producto
        </div>
        <div class="hc-card-body" style="padding:0;">
            <table class="hc-table">
                <tbody>
                    <tr>
                        <td style="font-weight:600; color:#374151; width:200px;">
                            <i class="fa-solid fa-cube" style="color:#94a3b8; margin-right:8px;"></i>Nombre
                        </td>
                        <td style="font-weight:600; color:#1e293b;">{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight:600; color:#374151;">
                            <i class="fa-solid fa-align-left" style="color:#94a3b8; margin-right:8px;"></i>Descripción
                        </td>
                        <td style="color:#475569;">{{ $product->description ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight:600; color:#374151;">
                            <i class="fa-solid fa-tag" style="color:#94a3b8; margin-right:8px;"></i>Precio
                        </td>
                        <td style="font-weight:700; color:var(--hc-green); font-size:15px;">
                            ${{ number_format($product->price, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight:600; color:#374151;">
                            <i class="fa-solid fa-warehouse" style="color:#94a3b8; margin-right:8px;"></i>Stock actual
                        </td>
                        <td>
                            @if($product->current_stock <= $product->minimum_stock)
                                <span class="badge" style="background:#fef2f2; color:#dc2626; border-color:#fca5a5;">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    {{ $product->current_stock }} — Stock bajo
                                </span>
                            @else
                                <span class="badge badge-delivered">{{ $product->current_stock }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight:600; color:#374151;">
                            <i class="fa-solid fa-triangle-exclamation" style="color:#94a3b8; margin-right:8px;"></i>Stock mínimo
                        </td>
                        <td style="color:#64748b;">{{ $product->minimum_stock }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if(Auth::user()->hasRole('Admin'))
    <!-- DANGER ZONE -->
    <div class="hc-card" style="margin-top:20px; border-color:#fca5a5;">
        <div class="hc-card-header" style="background:#fef2f2; color:#dc2626;">
            <i class="fa-solid fa-triangle-exclamation" style="margin-right:8px;"></i>
            Zona de peligro
        </div>
        <div class="hc-card-body" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <p style="font-size:13px; color:#64748b; margin:0;">
                Eliminar este producto es una acción permanente y no se puede deshacer.
            </p>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                  onsubmit="return confirm('¿Estás seguro de eliminar este producto? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger btn-sm">
                    <i class="fa-solid fa-trash"></i> Eliminar producto
                </button>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection
