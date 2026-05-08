@extends('layouts.app')

@section('content')
<div style="max-width:860px; margin:0 auto; padding:0 24px;">

    <!-- HEADER -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#1e293b; letter-spacing:-0.02em; margin:0 0 4px;">
                <i class="fa-solid fa-plus-circle" style="color:var(--hc-green); margin-right:10px;"></i>
                Nuevo Producto
            </h1>
            <p style="font-size:13px; color:#64748b; margin:0;">Agrega un producto al catálogo</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Volver al catálogo
        </a>
    </div>

    @if($errors->any())
        <div class="hc-alert-error" style="margin-bottom:20px;">
            <i class="fa-solid fa-circle-exclamation"></i>
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM CARD -->
    <div class="hc-card">
        <div class="hc-card-header">
            <i class="fa-solid fa-cube" style="color:var(--hc-green); margin-right:8px;"></i>
            Información del producto
        </div>
        <div class="hc-card-body">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">

                    <!-- Nombre -->
                    <div style="grid-column:1/-1;">
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                            Nombre del producto <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="text" name="name" class="hc-input"
                               value="{{ old('name') }}"
                               placeholder="Ej. Caja de cartón mediana" required>
                    </div>

                    <!-- Precio -->
                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                            Precio <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="number" name="price" class="hc-input" step="0.01" min="0"
                               value="{{ old('price') }}"
                               placeholder="0.00" required>
                    </div>

                    <!-- Stock actual -->
                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                            Stock actual <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="number" name="current_stock" class="hc-input" min="0"
                               value="{{ old('current_stock', 0) }}"
                               placeholder="0" required>
                    </div>

                    <!-- Stock mínimo -->
                    <div>
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                            Stock mínimo <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="number" name="minimum_stock" class="hc-input" min="0"
                               value="{{ old('minimum_stock', 0) }}"
                               placeholder="0" required>
                    </div>

                    <!-- Descripción -->
                    <div style="grid-column:1/-1;">
                        <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                            Descripción
                        </label>
                        <textarea name="description" class="hc-input" rows="3"
                                  placeholder="Descripción opcional del producto...">{{ old('description') }}</textarea>
                    </div>

                </div>

                <!-- ACTIONS -->
                <div style="display:flex; gap:12px; padding-top:8px; border-top:1px solid #e2e8f0;">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-plus"></i> Crear producto
                    </button>
                    <a href="{{ route('products.index') }}" class="btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
