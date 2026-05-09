@extends('layouts.app')

@section('content')
<div style="max-width:1280px; margin:0 auto; padding:0 24px;">

    <!-- HEADER -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#1e293b; letter-spacing:-0.02em; margin:0 0 4px;">
                <i class="fa-solid fa-boxes-stacked" style="color:var(--hc-green); margin-right:10px;"></i>
                Catálogo de Productos
            </h1>
            <p style="font-size:13px; color:#64748b; margin:0;">
                Total: <span style="background:#f0fdf4; border:1px solid #bbf7d0; color:var(--hc-green); border-radius:20px; padding:2px 10px; font-weight:700; font-size:12px; margin-left:4px;">{{ $products->count() }}</span>
            </p>
        </div>
        @if(Auth::user()->hasRole('Sales') || Auth::user()->hasRole('Admin'))
        <a href="{{ route('products.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Nuevo Producto
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="hc-alert-success" style="margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <!-- TABLA -->
    <div class="hc-card" style="overflow:hidden; padding:0;">
        <div style="overflow-x:auto;">
            <table class="hc-table">
                <thead>
                    <tr>
                        <th><i class="fa-solid fa-hashtag" style="margin-right:5px;"></i>ID</th>
                        <th><i class="fa-solid fa-cube" style="margin-right:5px;"></i>Producto</th>
                        <th><i class="fa-solid fa-align-left" style="margin-right:5px;"></i>Descripción</th>
                        <th><i class="fa-solid fa-tag" style="margin-right:5px;"></i>Precio</th>
                        <th><i class="fa-solid fa-warehouse" style="margin-right:5px;"></i>Stock actual</th>
                        <th><i class="fa-solid fa-triangle-exclamation" style="margin-right:5px;"></i>Stock mínimo</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td style="font-size:13px; color:#94a3b8;">{{ $product->id }}</td>
                            <td style="font-weight:600; color:#1e293b;">{{ $product->name }}</td>
                            <td style="font-size:13px; color:#475569;">{{ $product->description ?? '—' }}</td>
                            <td style="font-weight:600; color:var(--hc-green);">${{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->current_stock <= $product->minimum_stock)
                                    <span class="badge" style="background:#fef2f2; color:#dc2626; border-color:#fca5a5;">
                                        <i class="fa-solid fa-triangle-exclamation"></i> {{ $product->current_stock }}
                                    </span>
                                @else
                                    <span class="badge badge-delivered">{{ $product->current_stock }}</span>
                                @endif
                            </td>
                            <td style="color:#64748b; font-size:13px;">{{ $product->minimum_stock }}</td>
                            <td>
                                <div style="display:flex; align-items:center; justify-content:center; gap:8px;">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn-secondary btn-sm">
                                        <i class="fa-solid fa-eye"></i> Ver
                                    </a>
                                    @if(Auth::user()->hasRole('Sales') || Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Warehouse'))
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn-warning btn-sm">
                                        <i class="fa-solid fa-pen"></i> Editar
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
